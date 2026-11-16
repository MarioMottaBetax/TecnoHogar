
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Credito_model extends CI_Model
{
    public function obtener_creditos_cliente($id_usuario)
    {
        return $this->db
            ->select('c.id_credito, c.id_pedido, c.monto_total, c.numero_cuotas, p.fecha, COALESCE(abonos.total_abonado, 0) AS total_abonado, (c.monto_total - COALESCE(abonos.total_abonado, 0)) AS saldo_pendiente', false)
            ->from('creditos c')
            ->join('pedidos p', 'p.id_pedido = c.id_pedido')
            ->join('(SELECT id_pedido, SUM(monto) AS total_abonado FROM pagos WHERE estado = "Aprobado" AND id_cuota IS NOT NULL GROUP BY id_pedido) abonos', 'abonos.id_pedido = c.id_pedido', 'left', false)
            ->where('p.id_usuario', $id_usuario)
            ->order_by('c.id_credito', 'DESC')
            ->get()->result();
    }

    public function obtener_credito_cliente($id_credito, $id_usuario)
    {
        return $this->db
            ->select('c.*, p.fecha, p.total AS total_venta, COALESCE(abonos.total_abonado, 0) AS total_abonado, (c.monto_total - COALESCE(abonos.total_abonado, 0)) AS saldo_pendiente', false)
            ->from('creditos c')
            ->join('pedidos p', 'p.id_pedido = c.id_pedido')
            ->join('(SELECT id_pedido, SUM(monto) AS total_abonado FROM pagos WHERE estado = "Aprobado" AND id_cuota IS NOT NULL GROUP BY id_pedido) abonos', 'abonos.id_pedido = c.id_pedido', 'left', false)
            ->where('c.id_credito', $id_credito)->where('p.id_usuario', $id_usuario)
            ->get()->row();
    }
    // Obtener todos los créditos
    public function obtener_creditos()
    {
        $this->db->select("
            c.id_credito,
            c.id_pedido,
            c.monto_total,
            c.numero_cuotas,
            p.fecha,
            u.nombre1,
            u.apellido1,
            u.cedula,
            COALESCE(abonos.total_abonado, 0) AS total_abonado,
            (c.monto_total - COALESCE(abonos.total_abonado, 0)) AS saldo_pendiente
        ", false);

        $this->db->from('creditos c');
        $this->db->join('pedidos p', 'p.id_pedido = c.id_pedido');
        $this->db->join('usuarios u', 'u.id_usuario = p.id_usuario');

        $this->db->join(
            '(SELECT id_pedido, SUM(monto) AS total_abonado
              FROM pagos
              WHERE estado = "Aprobado"
              AND id_cuota IS NOT NULL
              GROUP BY id_pedido) abonos',
            'abonos.id_pedido = c.id_pedido',
            'left',
            false
        );

        $this->db->order_by('c.id_credito', 'DESC');

        return $this->db->get()->result();
    }

    // Obtener información general de un crédito
    public function obtener_credito($id)
    {
        $this->db->select("
            c.*,
            p.fecha,
            p.total AS total_venta,
            u.nombre1,
            u.apellido1,
            u.cedula,
            u.correo,
            COALESCE(abonos.total_abonado, 0) AS total_abonado,
            (c.monto_total - COALESCE(abonos.total_abonado, 0)) AS saldo_pendiente
        ", false);

        $this->db->from('creditos c');
        $this->db->join('pedidos p', 'p.id_pedido = c.id_pedido');
        $this->db->join('usuarios u', 'u.id_usuario = p.id_usuario');

        $this->db->join(
            '(SELECT id_pedido, SUM(monto) AS total_abonado
              FROM pagos
              WHERE estado = "Aprobado"
              AND id_cuota IS NOT NULL
              GROUP BY id_pedido) abonos',
            'abonos.id_pedido = c.id_pedido',
            'left',
            false
        );

        $this->db->where('c.id_credito', $id);

        return $this->db->get()->row();
    }

    // Obtener las cuotas de un crédito
    public function obtener_cuotas($id_credito)
    {
        $this->db->select("
            cc.*,
            COALESCE(abonos.total_abonado, 0) AS total_abonado,
            (cc.monto_cuota - COALESCE(abonos.total_abonado, 0)) AS saldo_cuota
        ", false);

        $this->db->from('cuotas_credito cc');

        $this->db->join(
            '(SELECT id_cuota, SUM(monto) AS total_abonado
              FROM pagos
              WHERE estado = "Aprobado"
              AND id_cuota IS NOT NULL
              GROUP BY id_cuota) abonos',
            'abonos.id_cuota = cc.id_cuota',
            'left',
            false
        );

        $this->db->where('cc.id_credito', $id_credito);
        $this->db->order_by('cc.numero_cuota', 'ASC');

        return $this->db->get()->result();
    }
}
