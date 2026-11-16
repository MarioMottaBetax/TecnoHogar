
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedor_model extends CI_Model
{
    public function obtener_proveedores()
    {
        return $this->db
            ->order_by('id_proveedor', 'DESC')
            ->get('proveedores')
            ->result();
    }

    public function obtener_proveedor($id)
    {
        return $this->db
            ->where('id_proveedor', $id)
            ->get('proveedores')
            ->row();
    }

    public function registrar_proveedor($datos)
    {
        return $this->db->insert('proveedores', $datos);
    }

    public function actualizar_proveedor($id, $datos)
    {
        return $this->db
            ->where('id_proveedor', $id)
            ->update('proveedores', $datos);
    }

    public function cambiar_estado($id, $estado)
    {
        return $this->db
            ->where('id_proveedor', $id)
            ->update('proveedores', array('estado' => $estado));
    }

    public function existe_nit($nit, $id = null)
    {
        if (!empty($nit)) {
            $this->db->where('nit', $nit);
        } else {
            return false;
        }

        if ($id !== null) {
            $this->db->where('id_proveedor !=', $id);
        }

        return $this->db->count_all_results('proveedores') > 0;
    }
}
