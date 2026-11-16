<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produc_model extends CI_Model
{
    // Obtener productos con búsqueda y filtro por categoría
    public function obtener_productos($busqueda = '', $categoria = '')
    {
        $this->db->select('
            id_producto,
            nombre_producto,
            categoria,
            precio,
            modelo_detalle,
            garantia,
            cantidad
        ');

        $this->db->from('productos');

        if (!empty($busqueda)) {
            $this->db->group_start();
            $this->db->like('nombre_producto', $busqueda);
            $this->db->or_like('categoria', $busqueda);
            $this->db->or_like('modelo_detalle', $busqueda);
            $this->db->group_end();
        }

        if (!empty($categoria)) {
            $this->db->where('categoria', $categoria);
        }

        $this->db->order_by('nombre_producto', 'ASC');

        return $this->db->get()->result();
    }

    // Obtener categorías existentes
    public function obtener_categorias()
    {
        $this->db->distinct();
        $this->db->select('categoria');
        $this->db->from('productos');
        $this->db->order_by('categoria', 'ASC');

        return $this->db->get()->result();
    }

    // Obtener un producto específico
    public function obtener_producto($id_producto)
    {
        return $this->db
            ->where('id_producto', $id_producto)
            ->get('productos')
            ->row();
    }
}