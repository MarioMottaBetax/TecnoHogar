<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{
    public function obtener_resumen()
    {
        $hoy = date('Y-m-d');
        $inicio_mes = date('Y-m-01');

        return array(
            'ventas_hoy' => $this->sumar_pagos($hoy, $hoy),
            'ventas_mes' => $this->sumar_pagos($inicio_mes, $hoy),
            'total_productos' => (int) $this->db->count_all('productos'),
            'total_clientes' => (int) $this->db->where('id_rol', 4)->count_all_results('usuarios'),
            'inventario_bajo' => (int) $this->db->where('cantidad <=', 5)->count_all_results('productos'),
            'creditos_pendientes' => (int) $this->db->where_in('estado', array(1, 4))->count_all_results('cuotas_credito'),
            'servicios_activos' => (int) $this->db->query("SELECT COUNT(*) AS total FROM mantenimiento m WHERE NOT EXISTS (SELECT 1 FROM seguimiento_mantenimiento s WHERE s.id_mantenimiento = m.id_mantenimiento AND s.estado IN ('Entregado', 'No reparable'))")->row()->total,
            'garantias_vigentes' => (int) $this->db->where('estado_garantia', 'Vigente')->count_all_results('garantias'),
            'actividad_reciente' => $this->actividad_reciente()
        );
    }

    private function sumar_pagos($desde, $hasta)
    {
        $fila = $this->db->select_sum('monto', 'total')->where('estado', 'Aprobado')->where('DATE(fecha) >=', $desde)->where('DATE(fecha) <=', $hasta)->get('pagos')->row();
        return $fila ? (float) $fila->total : 0;
    }

    private function actividad_reciente()
    {
        return $this->db->select('pg.id_pago, pg.fecha, pg.monto, pg.estado, u.nombre1, u.apellido1')
            ->from('pagos pg')->join('pedidos p', 'p.id_pedido = pg.id_pedido')->join('usuarios u', 'u.id_usuario = p.id_usuario')
            ->order_by('pg.fecha', 'DESC')->limit(6)->get()->result();
    }
}
