
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mantenimiento_model extends CI_Model
{
    public function obtener_servicios_cliente($id_usuario)
    {
        return $this->db->select("m.*, t.nombre1 AS tecnico_nombre, t.apellido1 AS tecnico_apellido, (SELECT sm.estado FROM seguimiento_mantenimiento sm WHERE sm.id_mantenimiento = m.id_mantenimiento ORDER BY sm.id_seguimiento DESC LIMIT 1) AS estado_actual")
            ->from('mantenimiento m')->join('usuarios t', 't.id_usuario = m.id_tecnico', 'left')
            ->where('m.id_usuario', $id_usuario)->order_by('m.id_mantenimiento', 'DESC')->get()->result();
    }

    public function obtener_servicio_cliente($id_mantenimiento, $id_usuario)
    {
        return $this->db->select('m.*, t.nombre1 AS tecnico_nombre, t.apellido1 AS tecnico_apellido')
            ->from('mantenimiento m')->join('usuarios t', 't.id_usuario = m.id_tecnico', 'left')
            ->where('m.id_mantenimiento', $id_mantenimiento)->where('m.id_usuario', $id_usuario)->get()->row();
    }

    public function obtener_garantias_cliente($id_usuario)
    {
        return $this->db->select('g.id_garantia, p.nombre_producto, g.fecha_vencimiento')
            ->from('garantias g')
            ->join('pedido_detalles pd', 'pd.id_detalle = g.id_detalle')
            ->join('pedidos pe', 'pe.id_pedido = pd.id_pedido')
            ->join('productos p', 'p.id_producto = pd.id_producto')
            ->where('pe.id_usuario', $id_usuario)
            ->where('g.estado_garantia', 'Vigente')
            ->order_by('g.id_garantia', 'DESC')
            ->get()->result();
    }

    public function garantia_pertenece_al_cliente($id_garantia, $id_usuario)
    {
        return $this->db->from('garantias g')
            ->join('pedido_detalles pd', 'pd.id_detalle = g.id_detalle')
            ->join('pedidos pe', 'pe.id_pedido = pd.id_pedido')
            ->where('g.id_garantia', $id_garantia)
            ->where('pe.id_usuario', $id_usuario)
            ->where('g.estado_garantia', 'Vigente')
            ->count_all_results() > 0;
    }

    public function obtener_garantias_vigentes()
    {
        return $this->db->select('g.id_garantia, p.nombre_producto, u.nombre1, u.apellido1, g.fecha_vencimiento')
            ->from('garantias g')
            ->join('pedido_detalles pd', 'pd.id_detalle = g.id_detalle')
            ->join('pedidos pe', 'pe.id_pedido = pd.id_pedido')
            ->join('usuarios u', 'u.id_usuario = pe.id_usuario')
            ->join('productos p', 'p.id_producto = pd.id_producto')
            ->where('g.estado_garantia', 'Vigente')
            ->order_by('g.id_garantia', 'DESC')
            ->get()->result();
    }
    // Obtener todos los servicios técnicos
    public function obtener_mantenimientos()
    {
        return $this->db
            ->select("
                m.*,
                c.nombre1 AS cliente_nombre,
                c.apellido1 AS cliente_apellido,
                c.cedula AS cliente_cedula,
                t.nombre1 AS tecnico_nombre,
                t.apellido1 AS tecnico_apellido,
                (
                    SELECT sm.estado
                    FROM seguimiento_mantenimiento sm
                    WHERE sm.id_mantenimiento = m.id_mantenimiento
                    ORDER BY sm.id_seguimiento DESC
                    LIMIT 1
                ) AS estado_actual
            ")
            ->from('mantenimiento m')
            ->join('usuarios c', 'c.id_usuario = m.id_usuario')
            ->join('usuarios t', 't.id_usuario = m.id_tecnico', 'left')
            ->order_by('m.id_mantenimiento', 'DESC')
            ->get()
            ->result();
    }

    // Obtener un servicio técnico específico
    public function obtener_mantenimiento($id)
    {
        return $this->db
            ->select("
                m.*,
                c.nombre1 AS cliente_nombre,
                c.apellido1 AS cliente_apellido,
                c.cedula AS cliente_cedula,
                c.correo AS cliente_correo,
                c.celular AS cliente_celular,
                t.nombre1 AS tecnico_nombre,
                t.apellido1 AS tecnico_apellido
            ")
            ->from('mantenimiento m')
            ->join('usuarios c', 'c.id_usuario = m.id_usuario')
            ->join('usuarios t', 't.id_usuario = m.id_tecnico', 'left')
            ->where('m.id_mantenimiento', $id)
            ->get()
            ->row();
    }

    // Registrar un nuevo servicio técnico
    public function registrar_mantenimiento($datos)
    {
        return $this->db->insert('mantenimiento', $datos);
    }

    // Asignar un técnico a un servicio
    public function asignar_tecnico($id, $id_tecnico)
    {
        return $this->db
            ->where('id_mantenimiento', $id)
            ->update('mantenimiento', array(
                'id_tecnico' => $id_tecnico
            ));
    }

    // Obtener los servicios asignados a un técnico
    public function obtener_servicios_tecnico($id_tecnico)
    {
        return $this->db
            ->select("
                m.*,
                c.nombre1 AS cliente_nombre,
                c.apellido1 AS cliente_apellido,
                c.celular AS cliente_celular,
                (
                    SELECT sm.estado
                    FROM seguimiento_mantenimiento sm
                    WHERE sm.id_mantenimiento = m.id_mantenimiento
                    ORDER BY sm.id_seguimiento DESC
                    LIMIT 1
                ) AS estado_actual
            ")
            ->from('mantenimiento m')
            ->join('usuarios c', 'c.id_usuario = m.id_usuario')
            ->where('m.id_tecnico', $id_tecnico)
            ->order_by('m.id_mantenimiento', 'DESC')
            ->get()
            ->result();
    }

    // Actualizar diagnóstico y costos
    public function actualizar_diagnostico($id, $datos)
    {
        return $this->db
            ->where('id_mantenimiento', $id)
            ->update('mantenimiento', $datos);
    }

    // Registrar un avance en el seguimiento
    public function registrar_seguimiento($datos)
    {
        return $this->db->insert('seguimiento_mantenimiento', $datos);
    }

    // Obtener historial de seguimiento
    public function obtener_seguimientos($id)
    {
        return $this->db
            ->select('*')
            ->from('seguimiento_mantenimiento')
            ->where('id_mantenimiento', $id)
            ->order_by('id_seguimiento', 'DESC')
            ->get()
            ->result();
    }

    // Actualizar estado y registrar el cambio en el historial
    public function actualizar_estado($id, $estado, $detalle)
    {
        $this->db->trans_begin();

        $datos = array(
            'id_mantenimiento' => $id,
            'estado' => $estado,
            'detalle' => $detalle,
            'fecha_registro' => date('Y-m-d H:i:s')
        );

        $this->db->insert('seguimiento_mantenimiento', $datos);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        }

        $this->db->trans_commit();
        return TRUE;
    }

    // Obtener técnicos disponibles
    public function obtener_tecnicos()
    {
        return $this->db
            ->select('id_usuario, nombre1, apellido1, cedula')
            ->from('usuarios')
            ->where('id_rol', 3)
            ->order_by('nombre1', 'ASC')
            ->get()
            ->result();
    }

    // Obtener clientes registrados
    public function obtener_clientes()
    {
        return $this->db
            ->select('id_usuario, nombre1, apellido1, cedula, correo, celular')
            ->from('usuarios')
            ->where('id_rol', 4)
            ->order_by('nombre1', 'ASC')
            ->get()
            ->result();
    }

// Obtener técnicos con estadísticas de servicios
public function obtener_tecnicos_detalle()
{
    return $this->db
        ->select("
            u.id_usuario,
            u.nombre1,
            u.nombre2,
            u.apellido1,
            u.apellido2,
            u.cedula,
            u.correo,
            u.celular,
            COUNT(m.id_mantenimiento) AS total_servicios,
            SUM(
                CASE
                    WHEN ultimo.estado IN ('Entregado', 'No reparable')
                    THEN 1 ELSE 0
                END
            ) AS servicios_finalizados,
            SUM(
                CASE
                    WHEN m.id_mantenimiento IS NOT NULL
                    AND (ultimo.estado IS NULL OR ultimo.estado NOT IN ('Entregado', 'No reparable'))
                    THEN 1 ELSE 0
                END
            ) AS servicios_activos
        ")
        ->from('usuarios u')
        ->join('mantenimiento m', 'm.id_tecnico = u.id_usuario', 'left')
        ->join(
            '(SELECT sm1.id_mantenimiento, sm1.estado
              FROM seguimiento_mantenimiento sm1
              INNER JOIN (
                  SELECT id_mantenimiento, MAX(id_seguimiento) AS ultimo
                  FROM seguimiento_mantenimiento
                  GROUP BY id_mantenimiento
              ) sm2 ON sm1.id_seguimiento = sm2.ultimo)',
            'ultimo.id_mantenimiento = m.id_mantenimiento',
            'left',
            FALSE
        )
        ->where('u.id_rol', 3)
        ->group_by('u.id_usuario')
        ->order_by('u.nombre1', 'ASC')
        ->get()
        ->result();
}

}
