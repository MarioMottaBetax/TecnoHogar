<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_servicio extends CI_Controller
{
    public function __construct()
    {
        parent::__construct(); $this->load->library('session'); $this->load->helper(array('url', 'form')); $this->load->model('Mantenimiento_model');
        if (!$this->session->userdata('logueado') || (int) $this->session->userdata('id_rol') !== 4) { redirect('auth/cliente'); exit; }
    }
    private function render($vista, $data = array()) { $data['nombre'] = $this->session->userdata('nombre'); $this->load->view('Cliente/layouts/header', $data); $this->load->view('Cliente/layouts/sidebar', $data); $this->load->view($vista, $data); $this->load->view('Cliente/layouts/footer'); }
    public function index() { $this->render('Cliente/funciones/servicio_tecnico/index', array('servicios' => $this->Mantenimiento_model->obtener_servicios_cliente($this->session->userdata('id_usuario')))); }
    public function solicitar() { $this->render('Cliente/funciones/servicio_tecnico/solicitar', array('garantias' => $this->Mantenimiento_model->obtener_garantias_cliente($this->session->userdata('id_usuario')))); }
    public function guardar()
    {
        if ($this->input->method(TRUE) !== 'POST') { show_404(); return; }
        $equipo = trim($this->input->post('nombre_equipo', TRUE)); $problema = trim($this->input->post('descripcion_problema', TRUE)); $tipo = (int) $this->input->post('tipo_servicio'); $id_garantia = (int) $this->input->post('id_garantia');
        if ($equipo === '' || $problema === '' || !in_array($tipo, array(1, 2), TRUE)) { $this->session->set_flashdata('error', 'Completa los datos de la solicitud.'); redirect('cliente/servicio_tecnico/solicitar'); return; }
        if ($tipo === 1 && (!$id_garantia || !$this->Mantenimiento_model->garantia_pertenece_al_cliente($id_garantia, $this->session->userdata('id_usuario')))) { $this->session->set_flashdata('error', 'Selecciona una garantía vigente de tu cuenta.'); redirect('cliente/servicio_tecnico/solicitar'); return; }
        $ok = $this->Mantenimiento_model->registrar_mantenimiento(array('id_usuario' => $this->session->userdata('id_usuario'), 'tipo_servicio' => $tipo, 'id_tecnico' => NULL, 'nombre_equipo' => $equipo, 'descripcion_problema' => $problema, 'diagnostico' => NULL, 'mano_obra' => 0, 'costo_repuestos' => 0, 'total' => 0, 'fecha_ingreso' => date('Y-m-d H:i:s'), 'fecha_entrega' => NULL, 'garantia' => $tipo === 1 ? $id_garantia : NULL));
        if ($ok) { $this->Mantenimiento_model->registrar_seguimiento(array('id_mantenimiento' => $this->db->insert_id(), 'estado' => 'Recibido', 'detalle' => 'Solicitud creada por el cliente.', 'fecha_registro' => date('Y-m-d H:i:s'))); $this->session->set_flashdata('exito', 'Solicitud enviada. Te avisaremos cuando sea asignada.'); } else { $this->session->set_flashdata('error', 'No fue posible enviar la solicitud.'); }
        redirect('cliente/servicio_tecnico');
    }
    public function detalle($id) { $data['servicio'] = $this->Mantenimiento_model->obtener_servicio_cliente((int) $id, $this->session->userdata('id_usuario')); if (!$data['servicio']) { show_404(); return; } $data['seguimientos'] = $this->Mantenimiento_model->obtener_seguimientos((int) $id); $this->render('Cliente/funciones/servicio_tecnico/detalle', $data); }
}
