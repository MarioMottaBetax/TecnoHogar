
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_model extends CI_Model
{
    // Obtener todos los clientes
    public function obtener_clientes()
    {
        return $this->db
            ->where('id_rol', 4)
            ->order_by('id_usuario', 'DESC')
            ->get('usuarios')
            ->result();
    }

    // Obtener un cliente específico
    public function obtener_cliente($id)
    {
        return $this->db
            ->where('id_usuario', $id)
            ->where('id_rol', 4)
            ->get('usuarios')
            ->row();
    }

    // Registrar cliente
    public function registrar_cliente($datos)
    {
        return $this->db->insert('usuarios', $datos);
    }

    // Actualizar cliente
    public function actualizar_cliente($id, $datos)
    {
        return $this->db
            ->where('id_usuario', $id)
            ->where('id_rol', 4)
            ->update('usuarios', $datos);
    }

    // Verificar si la cédula ya existe
    public function existe_cedula($cedula, $id = null)
    {
        if (empty($cedula)) {
            return false;
        }

        $this->db->where('cedula', $cedula);

        if ($id !== null) {
            $this->db->where('id_usuario !=', $id);
        }

        return $this->db->count_all_results('usuarios') > 0;
    }

    // Verificar si el correo ya existe
    public function existe_correo($correo, $id = null)
    {
        $this->db->where('correo', $correo);

        if ($id !== null) {
            $this->db->where('id_usuario !=', $id);
        }

        return $this->db->count_all_results('usuarios') > 0;
    }

    // Contar clientes
    public function contar_clientes()
    {
        return $this->db
            ->where('id_rol', 4)
            ->count_all_results('usuarios');
    }
}
