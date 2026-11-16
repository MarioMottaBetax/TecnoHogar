
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contabilidad_model extends CI_Model
{
    // Obtener ingresos confirmados
    public function obtener_ingresos($desde = NULL, $hasta = NULL)
    {
        $this->db->select('
            p.id_pago,
            p.id_pedido,
            p.id_cuota,
            p.fecha,
            p.monto,
            mp.nombre_metodo AS metodo,
            p.estado
        ');
        $this->db->from('pagos p');
        $this->db->join('metodo_pago mp', 'mp.id_metodo = p.id_metodo', 'left');
        $this->db->where('p.estado', 'Aprobado');

        if ($desde) {
            $this->db->where('DATE(p.fecha) >=', $desde);
        }

        if ($hasta) {
            $this->db->where('DATE(p.fecha) <=', $hasta);
        }

        $this->db->order_by('p.fecha', 'DESC');

        return $this->db->get()->result();
    }

    // Obtener total de ingresos
    public function total_ingresos($desde = NULL, $hasta = NULL)
    {
        $this->db->select_sum('monto', 'total');
        $this->db->from('pagos');
        $this->db->where('estado', 'Aprobado');
        if ($desde) {
            $this->db->where('DATE(fecha) >=', $desde);
        }

        if ($hasta) {
            $this->db->where('DATE(fecha) <=', $hasta);
        }

        $resultado = $this->db->get()->row();

        return $resultado ? (float) $resultado->total : 0;
    }

    // Obtener egresos
    public function obtener_egresos($desde = NULL, $hasta = NULL)
    {
        $this->db->from('egresos');

        if ($desde) {
            $this->db->where('fecha_egreso >=', $desde);
        }

        if ($hasta) {
            $this->db->where('fecha_egreso <=', $hasta);
        }

        $this->db->order_by('fecha_egreso', 'DESC');

        return $this->db->get()->result();
    }

    // Total de egresos
    public function total_egresos($desde = NULL, $hasta = NULL)
    {
        $this->db->select_sum('valor', 'total');
        $this->db->from('egresos');

        if ($desde) {
            $this->db->where('fecha_egreso >=', $desde);
        }

        if ($hasta) {
            $this->db->where('fecha_egreso <=', $hasta);
        }

        $resultado = $this->db->get()->row();

        return $resultado ? (float) $resultado->total : 0;
    }

    // Registrar egreso
    public function registrar_egreso($datos)
    {
        return $this->db->insert('egresos', $datos);
    }

    // Obtener un egreso
    public function obtener_egreso($id)
    {
        return $this->db
            ->where('id_egreso', $id)
            ->get('egresos')
            ->row();
    }

    // Eliminar egreso
    public function eliminar_egreso($id)
    {
        return $this->db
            ->where('id_egreso', $id)
            ->delete('egresos');
    }
}
