
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes_model extends CI_Model
{
    public function total_ingresos($desde, $hasta)
    {
        $this->db->select_sum('monto');
        $this->db->where('estado', 'Aprobado');
        $this->db->where('DATE(fecha) >=', $desde);
        $this->db->where('DATE(fecha) <=', $hasta);

        $resultado = $this->db->get('pagos')->row();

        return $resultado ? (float) $resultado->monto : 0;
    }

    public function total_egresos($desde, $hasta)
    {
        $this->db->select_sum('valor');
        $this->db->where('fecha_egreso >=', $desde);
        $this->db->where('fecha_egreso <=', $hasta);

        $resultado = $this->db->get('egresos')->row();

        return $resultado ? (float) $resultado->valor : 0;
    }

    public function ingresos_mensuales($desde, $hasta)
    {
        $this->db->select("DATE_FORMAT(fecha, '%Y-%m') AS mes", false);
        $this->db->select_sum('monto', 'total');
        $this->db->where('estado', 'Aprobado');
        $this->db->where('DATE(fecha) >=', $desde);
        $this->db->where('DATE(fecha) <=', $hasta);
        $this->db->group_by("DATE_FORMAT(fecha, '%Y-%m')", false);
        $this->db->order_by('mes', 'ASC');

        return $this->db->get('pagos')->result();
    }

    public function egresos_mensuales($desde, $hasta)
    {
        $this->db->select("DATE_FORMAT(fecha_egreso, '%Y-%m') AS mes", false);
        $this->db->select_sum('valor', 'total');
        $this->db->where('fecha_egreso >=', $desde);
        $this->db->where('fecha_egreso <=', $hasta);
        $this->db->group_by("DATE_FORMAT(fecha_egreso, '%Y-%m')", false);
        $this->db->order_by('mes', 'ASC');

        return $this->db->get('egresos')->result();
    }

    public function resumen_inventario()
    {
        $this->db->select('COUNT(*) AS productos');
        $this->db->select_sum('cantidad', 'unidades');
        $this->db->select('SUM(precio * cantidad) AS valor_inventario', false);

        return $this->db->get('productos')->row();
    }

    public function resumen_compras($desde, $hasta)
    {
        $this->db->select('COUNT(*) AS cantidad');
        $this->db->select_sum('total', 'total_compras');
        $this->db->where('fecha_compra >=', $desde);
        $this->db->where('fecha_compra <=', $hasta);

        return $this->db->get('compras')->row();
    }

    public function productos_por_categoria()
    {
        $this->db->select('categoria');
        $this->db->select('COUNT(*) AS cantidad');
        $this->db->group_by('categoria');
        $this->db->order_by('cantidad', 'DESC');

        return $this->db->get('productos')->result();
    }
}
