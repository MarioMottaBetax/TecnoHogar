<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_perfil extends CI_Controller
{
    public function __construct()
    {
        parent::__construct(); $this->load->library('session'); $this->load->helper(array('url', 'form')); $this->load->model('Cliente_model');
        if (!$this->session->userdata('logueado') || (int) $this->session->userdata('id_rol') !== 4) { redirect('auth/cliente'); exit; }
    }
    private function render($data) { $data['nombre'] = $this->session->userdata('nombre'); $this->load->view('Cliente/layouts/header', $data); $this->load->view('Cliente/layouts/sidebar', $data); $this->load->view('Cliente/funciones/perfil/index', $data); $this->load->view('Cliente/layouts/footer'); }
    public function index() { $this->render(array('cliente' => $this->Cliente_model->obtener_cliente($this->session->userdata('id_usuario')))); }
    public function actualizar()
    {
        if ($this->input->method(TRUE) !== 'POST') { show_404(); return; }
        $id = (int) $this->session->userdata('id_usuario');
        $correo = strtolower(trim($this->input->post('correo', TRUE))); $cedula = trim($this->input->post('cedula', TRUE));
        $requeridos = array('nombre1', 'apellido1', 'cedula', 'celular', 'departamento', 'ciudad', 'barrio', 'direccion', 'correo');
        foreach ($requeridos as $campo) { if (trim($this->input->post($campo, TRUE)) === '') { $this->session->set_flashdata('error', 'Completa todos los campos obligatorios.'); redirect('cliente/perfil'); return; } }
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) { $this->session->set_flashdata('error', 'El correo electrónico no es válido.'); redirect('cliente/perfil'); return; }
        if ($this->Cliente_model->existe_correo($correo, $id) || $this->Cliente_model->existe_cedula($cedula, $id)) { $this->session->set_flashdata('error', 'El correo o la cédula ya pertenecen a otra cuenta.'); redirect('cliente/perfil'); return; }
        $datos = array(); foreach (array('nombre1','nombre2','apellido1','apellido2','celular','departamento','ciudad','barrio','direccion','referencia') as $campo) { $datos[$campo] = trim($this->input->post($campo, TRUE)); } $datos['correo'] = $correo; $datos['cedula'] = $cedula;
        if ($this->Cliente_model->actualizar_cliente($id, $datos)) { $this->session->set_userdata('nombre', trim($datos['nombre1'].' '.$datos['nombre2'].' '.$datos['apellido1'].' '.$datos['apellido2'])); $this->session->set_userdata('correo', $correo); $this->session->set_flashdata('exito', 'Tu perfil fue actualizado correctamente.'); } else { $this->session->set_flashdata('error', 'No fue posible actualizar el perfil.'); }
        redirect('cliente/perfil');
    }
}
