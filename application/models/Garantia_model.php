
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Garantia_model extends CI_Model
{
    public function obtener_garantias_cliente($id_usuario)
    {
        return $this->db->select('g.*, pd.id_producto, pd.cantidad, pd.precio_unitario, p.nombre_producto, pe.fecha AS fecha_venta')
            ->from('garantias g')->join('pedido_detalles pd', 'pd.id_detalle = g.id_detalle')
            ->join('productos p', 'p.id_producto = pd.id_producto')->join('pedidos pe', 'pe.id_pedido = pd.id_pedido')
            ->where('pe.id_usuario', $id_usuario)->order_by('g.id_garantia', 'DESC')->get()->result();
    }

    public function obtener_garantia_cliente($id_garantia, $id_usuario)
    {
        return $this->db->select('g.*, pd.id_producto, pd.cantidad, pd.precio_unitario, p.nombre_producto, pe.fecha AS fecha_venta')
            ->from('garantias g')->join('pedido_detalles pd', 'pd.id_detalle = g.id_detalle')
            ->join('productos p', 'p.id_producto = pd.id_producto')->join('pedidos pe', 'pe.id_pedido = pd.id_pedido')
            ->where('g.id_garantia', $id_garantia)->where('pe.id_usuario', $id_usuario)->get()->row();
    }
    // Obtener todas las garantías con información de la venta y el producto
    public function obtener_garantias()
    {
        return $this->db
            ->select('g.*, pd.id_producto, pd.cantidad, pd.precio_unitario,
                      p.nombre_producto, pe.fecha AS fecha_venta,
                      u.nombre1, u.apellido1, u.cedula')
            ->from('garantias g')
            ->join('pedido_detalles pd', 'pd.id_detalle = g.id_detalle')
            ->join('productos p', 'p.id_producto = pd.id_producto')
            ->join('pedidos pe', 'pe.id_pedido = pd.id_pedido')
            ->join('usuarios u', 'u.id_usuario = pe.id_usuario')
            ->order_by('g.id_garantia', 'DESC')
            ->get()
            ->result();
    }

    // Obtener una garantía específica
    public function obtener_garantia($id)
    {
        return $this->db
            ->select('g.*, pd.id_producto, pd.cantidad, pd.precio_unitario,
                      p.nombre_producto, pe.fecha AS fecha_venta,
                      u.nombre1, u.apellido1, u.cedula, u.correo')
            ->from('garantias g')
            ->join('pedido_detalles pd', 'pd.id_detalle = g.id_detalle')
            ->join('productos p', 'p.id_producto = pd.id_producto')
            ->join('pedidos pe', 'pe.id_pedido = pd.id_pedido')
            ->join('usuarios u', 'u.id_usuario = pe.id_usuario')
            ->where('g.id_garantia', $id)
            ->get()
            ->row();
    }

    // Actualizar estado y observaciones
    public function actualizar_garantia($id, $datos)
    {
        return $this->db
            ->where('id_garantia', $id)
            ->update('garantias', $datos);
    }
}
