
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pago_model extends CI_Model
{
    // Obtener todos los pagos
   
public function obtener_pagos()
{
    return $this->db
        ->select("
            pg.*,
            mp.nombre_metodo AS metodo,
            CONCAT_WS(' ', u.nombre1, u.nombre2, u.apellido1) AS nombre,
            u.cedula
        ", false)
        ->from('pagos pg')
        ->join('pedidos p', 'p.id_pedido = pg.id_pedido')
        ->join('metodo_pago mp', 'mp.id_metodo = pg.id_metodo', 'left')
        ->join('usuarios u', 'u.id_usuario = p.id_usuario')
        ->order_by('pg.id_pago', 'DESC')
        ->get()
        ->result();
}


    // Obtener un pago específico
  public function obtener_pago($id)
{
    $this->db->select("
        pg.*, mp.nombre_metodo AS metodo,
        CONCAT_WS(' ', u.nombre1, u.nombre2) AS nombre_cliente,
        cc.numero_cuota,
        cc.fecha_vencimiento,
        c.id_credito
    ", FALSE);

    $this->db->from('pagos pg');
    $this->db->join('pedidos p', 'p.id_pedido = pg.id_pedido');
    $this->db->join('metodo_pago mp', 'mp.id_metodo = pg.id_metodo', 'left');
    $this->db->join('usuarios u', 'u.id_usuario = p.id_usuario');
    $this->db->join('cuotas_credito cc', 'cc.id_cuota = pg.id_cuota', 'left');
    $this->db->join('creditos c', 'c.id_credito = cc.id_credito', 'left');

    $this->db->where('pg.id_pago', $id);

    return $this->db->get()->row();
}

    // Obtener cuotas que todavía tienen saldo pendiente
    public function obtener_cuotas_pendientes()
    {
        return $this->db
            ->select("
                cc.id_cuota,
                cc.numero_cuota,
                cc.monto_cuota,
                cc.fecha_vencimiento,
                cc.estado,
                c.id_credito,
                c.id_pedido,
                u.nombre1,
                u.apellido1,
                u.cedula,
                COALESCE(SUM(
                    CASE WHEN pg.estado = 'Aprobado'
                    THEN pg.monto ELSE 0 END
                ), 0) AS total_abonado
            ", false)
            ->from('cuotas_credito cc')
            ->join('creditos c', 'c.id_credito = cc.id_credito')
            ->join('pedidos p', 'p.id_pedido = c.id_pedido')
            ->join('usuarios u', 'u.id_usuario = p.id_usuario')
            ->join('pagos pg', 'pg.id_cuota = cc.id_cuota', 'left')
            ->group_by(array(
                'cc.id_cuota',
                'cc.numero_cuota',
                'cc.monto_cuota',
                'cc.fecha_vencimiento',
                'cc.estado',
                'c.id_credito',
                'c.id_pedido',
                'u.nombre1',
                'u.apellido1',
                'u.cedula'
            ))
            ->having('total_abonado < cc.monto_cuota', null, false)
            ->order_by('cc.fecha_vencimiento', 'ASC')
            ->get()
            ->result();
    }

    // Obtener información de una cuota
    public function obtener_cuota($id_cuota)
    {
        return $this->db
            ->select("
                cc.*,
                c.id_credito,
                c.id_pedido,
                u.nombre1,
                u.apellido1,
                u.cedula,
                COALESCE(SUM(
                    CASE WHEN pg.estado = 'Aprobado'
                    THEN pg.monto ELSE 0 END
                ), 0) AS total_abonado
            ", false)
            ->from('cuotas_credito cc')
            ->join('creditos c', 'c.id_credito = cc.id_credito')
            ->join('pedidos p', 'p.id_pedido = c.id_pedido')
            ->join('usuarios u', 'u.id_usuario = p.id_usuario')
            ->join('pagos pg', 'pg.id_cuota = cc.id_cuota', 'left')
            ->where('cc.id_cuota', $id_cuota)
            ->group_by(array(
                'cc.id_cuota',
                'cc.id_credito',
                'cc.numero_cuota',
                'cc.monto_cuota',
                'cc.fecha_vencimiento',
                'cc.estado',
                'c.id_credito',
                'c.id_pedido',
                'u.nombre1',
                'u.apellido1',
                'u.cedula'
            ))
            ->get()
            ->row();
    }

    // Registrar un abono
   
public function registrar_pago($id_cuota, $monto, $metodo, $comprobante = null)
{
    $this->db->trans_begin();

    // Bloquear cuota durante el registro
    $cuota = $this->db
        ->query(
            'SELECT * FROM cuotas_credito WHERE id_cuota = ? FOR UPDATE',
            array($id_cuota)
        )
        ->row();

    if (!$cuota) {
        $this->db->trans_rollback();
        return false;
    }

    // Calcular abonos aprobados
    $resultado = $this->db
        ->select('COALESCE(SUM(monto), 0) AS abonado', false)
        ->where('id_cuota', $id_cuota)
        ->where('estado', 'Aprobado')
        ->get('pagos')
        ->row();

    $abonado = (float) $resultado->abonado;
    $valor_cuota = (float) $cuota->monto_cuota;
    $monto = round((float) $monto, 2);

    $saldo = round($valor_cuota - $abonado, 2);

    // Validar monto
    if ($monto <= 0 || $monto > $saldo || $saldo <= 0) {
        $this->db->trans_rollback();
        return false;
    }

    // Obtener pedido
    $id_pedido = $this->obtener_pedido_por_cuota($id_cuota);

    if (!$id_pedido) {
        $this->db->trans_rollback();
        return false;
    }

    $id_metodo = $this->obtener_id_metodo($metodo);
    if (!$id_metodo) {
        $this->db->trans_rollback();
        return false;
    }

    // Insertar pago
    $pago = array(
        'id_pedido' => $id_pedido,
        'id_cuota' => $id_cuota,
        'monto' => $monto,
        'id_metodo' => $id_metodo,
        'estado' => 'Aprobado',
        'comprobante' => $comprobante
    );

    $this->db->insert('pagos', $pago);

    if ($this->db->affected_rows() !== 1) {
        $this->db->trans_rollback();
        return false;
    }

    // IMPORTANTE: capturar el ID inmediatamente después del INSERT
    $id_pago = $this->db->insert_id();

    // Actualizar estado de cuota
    $nuevo_abonado = round($abonado + $monto, 2);

    $estado = ($nuevo_abonado >= $valor_cuota) ? 2 : 4;

    $this->db
        ->where('id_cuota', $id_cuota)
        ->update('cuotas_credito', array('estado' => $estado));

    // Verificar transacción
    if ($this->db->trans_status() === false || !$id_pago) {
        $this->db->trans_rollback();
        return false;
    }

    $this->db->trans_commit();

    return $id_pago;
}

    private function obtener_id_metodo($metodo)
    {
        $metodo = trim($metodo);
        return $this->db->select('id_metodo')->where('nombre_metodo', $metodo)->where('estado', 1)->get('metodo_pago')->row('id_metodo');
    }

    public function aprobar_pago_pendiente($id_pago)
    {
        $this->db->trans_begin();
        $pago = $this->db->query('SELECT * FROM pagos WHERE id_pago = ? FOR UPDATE', array($id_pago))->row();
        if (!$pago || $pago->estado !== 'Pendiente' || !empty($pago->id_cuota)) {
            $this->db->trans_rollback();
            return false;
        }

        $this->db->where('id_pago', $id_pago)->where('estado', 'Pendiente')->update('pagos', array('estado' => 'Aprobado'));
        $this->db->where('id_pedido', $pago->id_pedido)->where('estado', 2)->update('pedidos', array('estado' => 4));
        if ($this->db->trans_status() === false || $this->db->affected_rows() !== 1) {
            $this->db->trans_rollback();
            return false;
        }
        $this->db->trans_commit();
        return true;
    }


    // Obtener pedido relacionado con una cuota
    private function obtener_pedido_por_cuota($id_cuota)
    {
        $resultado = $this->db
            ->select('c.id_pedido')
            ->from('cuotas_credito cc')
            ->join('creditos c', 'c.id_credito = cc.id_credito')
            ->where('cc.id_cuota', $id_cuota)
            ->get()
            ->row();

        return $resultado ? $resultado->id_pedido : false;
    }
}
