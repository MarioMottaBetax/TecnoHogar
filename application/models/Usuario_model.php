
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model
{
    // ==========================================
    // FUNCIONES EXISTENTES
    // ==========================================

    // Buscar usuario por correo (login)
    public function obtener_por_correo($correo)
    {
        return $this->db
            ->where('correo', $correo)
            ->limit(1)
            ->get('usuarios')
            ->row();
    }

    // Comprobar si el correo ya existe
    public function existe_correo($correo)
    {
        return $this->db
            ->where('correo', $correo)
            ->count_all_results('usuarios') > 0;
    }

    // Comprobar si la cédula ya existe
    public function existe_cedula($cedula)
    {
        return $this->db
            ->where('cedula', $cedula)
            ->count_all_results('usuarios') > 0;
    }

    // Registrar un nuevo usuario
    public function registrar_usuario($datos)
    {
        return $this->db->insert('usuarios', $datos);
    }

    // Contar clientes registrados
    public function contar_clientes()
    {
        return $this->db
            ->where('id_rol', 4)
            ->count_all_results('usuarios');
    }


    // ==========================================
    // ADMINISTRACIÓN DE USUARIOS
    // ==========================================

    // Obtener todos los usuarios con su respectivo rol
    public function obtener_usuarios()
    {
        return $this->db
            ->select("
                u.id_usuario,
                u.id_rol,
                u.nombre1,
                u.nombre2,
                u.apellido1,
                u.apellido2,
                u.celular,
                u.cedula,
                u.correo,
                u.departamento,
                u.ciudad,
                u.barrio,
                u.direccion,
                r.nombre_rol
            ")
            ->from('usuarios u')
            ->join('roles r', 'r.id_rol = u.id_rol', 'left')
            ->order_by('u.id_usuario', 'DESC')
            ->get()
            ->result();
    }

    // Obtener un usuario específico
    public function obtener_usuario($id)
    {
        return $this->db
            ->where('id_usuario', $id)
            ->get('usuarios')
            ->row();
    }

    // Obtener todos los roles disponibles
    public function obtener_roles()
    {
        return $this->db
            ->order_by('id_rol', 'ASC')
            ->get('roles')
            ->result();
    }

    // Actualizar información de un usuario
    public function actualizar_usuario($id, $datos)
    {
        return $this->db
            ->where('id_usuario', $id)
            ->update('usuarios', $datos);
    }


    // ==========================================
    // VALIDACIONES PARA EDICIÓN
    // ==========================================

    // Comprobar correo excluyendo al usuario actual
    public function correo_existe_edicion($correo, $id)
    {
        return $this->db
            ->where('correo', $correo)
            ->where('id_usuario !=', $id)
            ->count_all_results('usuarios') > 0;
    }

    // Comprobar cédula excluyendo al usuario actual
    public function cedula_existe_edicion($cedula, $id)
    {
        return $this->db
            ->where('cedula', $cedula)
            ->where('id_usuario !=', $id)
            ->count_all_results('usuarios') > 0;
    }

}
