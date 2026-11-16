
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Producto_model extends CI_Model {

    // Obtener todos los productos
    public function obtener_productos()
    {
        return $this->db
            ->order_by('id_producto', 'DESC')
            ->get('productos')
            ->result();
    }

    // Obtener un producto por su ID
    public function obtener_producto($id)
    {
        return $this->db
            ->where('id_producto', $id)
            ->get('productos')
            ->row();
    }

    // Registrar producto
    public function registrar_producto($datos)
    {
        return $this->db->insert('productos', $datos);
    }

    // Actualizar producto
    public function actualizar_producto($id, $datos)
    {
        return $this->db
            ->where('id_producto', $id)
            ->update('productos', $datos);
    }

    // Eliminar producto
    public function eliminar_producto($id)
    {
        return $this->db
            ->where('id_producto', $id)
            ->delete('productos');
    }

    // Contar productos
    public function contar_productos()
    {
        return $this->db->count_all('productos');
    }

    // Contar productos con inventario bajo
    public function contar_inventario_bajo($limite = 5)
    {
        return $this->db
            ->where('cantidad <=', $limite)
            ->count_all_results('productos');
    }
}
