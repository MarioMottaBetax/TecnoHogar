<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_creditos extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('Credito_model');
        $this->acceso_cliente();
    }

    private function acceso_cliente()
    {
        if (!$this->session->userdata('logueado') || (int) $this->session->userdata('id_rol') !== 4) {
            redirect('auth/cliente');
            exit;
        }
    }

    private function encabezado($data)
    {
        $data['nombre'] = $this->session->userdata('nombre');
        $this->load->view('Cliente/layouts/header', $data);
        $this->load->view('Cliente/layouts/sidebar', $data);
    }

    public function index()
    {
        $data['creditos'] = $this->Credito_model->obtener_creditos_cliente($this->session->userdata('id_usuario'));
        $this->encabezado($data);
        $this->load->view('Cliente/funciones/creditos/index', $data);
        $this->load->view('Cliente/layouts/footer');
    }

    public function detalle($id_credito)
    {
        $id_usuario = $this->session->userdata('id_usuario');
        $data['credito'] = $this->Credito_model->obtener_credito_cliente((int) $id_credito, $id_usuario);
        if (!$data['credito']) { show_404(); return; }
        $data['cuotas'] = $this->Credito_model->obtener_cuotas((int) $id_credito);
        $this->encabezado($data);
        $this->load->view('Cliente/funciones/creditos/detalle', $data);
        $this->load->view('Cliente/layouts/footer');
    }
}
