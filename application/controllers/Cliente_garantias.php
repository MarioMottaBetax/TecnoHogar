<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_garantias extends CI_Controller
{
    public function __construct()
    {
        parent::__construct(); $this->load->library('session'); $this->load->helper('url'); $this->load->model('Garantia_model');
        if (!$this->session->userdata('logueado') || (int) $this->session->userdata('id_rol') !== 4) { redirect('auth/cliente'); exit; }
    }
    private function encabezado(&$data) { $data['nombre'] = $this->session->userdata('nombre'); $this->load->view('Cliente/layouts/header', $data); $this->load->view('Cliente/layouts/sidebar', $data); }
    public function index() { $data['garantias'] = $this->Garantia_model->obtener_garantias_cliente($this->session->userdata('id_usuario')); $this->encabezado($data); $this->load->view('Cliente/funciones/garantias/index', $data); $this->load->view('Cliente/layouts/footer'); }
    public function detalle($id) { $data['garantia'] = $this->Garantia_model->obtener_garantia_cliente((int) $id, $this->session->userdata('id_usuario')); if (!$data['garantia']) { show_404(); return; } $this->encabezado($data); $this->load->view('Cliente/funciones/garantias/detalle', $data); $this->load->view('Cliente/layouts/footer'); }
}
