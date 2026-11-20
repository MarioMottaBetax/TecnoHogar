
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_pagos extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('session');
        $this->load->helper(array('url'));

        if (!$this->session->userdata('logueado') ||
            $this->session->userdata('id_rol') != 4) {
            redirect('auth/cliente');
        }

        $this->load->model('Cliente_pago_model');
    }

    public function index() {

        $id_usuario = $this->session->userdata('id_usuario');

        if (!$id_usuario) {
            show_error('No se encontró la sesión del usuario.', 403);
            return;
        }

        $data['nombre'] = $this->session->userdata('nombre');
        $data['pagos'] = $this->Cliente_pago_model
            ->obtener_pagos_cliente($id_usuario);

        $this->load->view('Cliente/layouts/header', $data);
        $this->load->view('Cliente/layouts/sidebar', $data);
        $this->load->view('Cliente/funciones/pagos/index', $data);
        $this->load->view('Cliente/layouts/footer');
    }

    public function detalle($id_pago) {

        $id_usuario = $this->session->userdata('id_usuario');

        if (!$id_usuario) {
            show_error('No se encontró la sesión del usuario.', 403);
            return;
        }

        $data['pago'] = $this->Cliente_pago_model
            ->obtener_pago_cliente($id_pago, $id_usuario);

        if (!$data['pago']) {
            show_404();
            return;
        }

        $data['nombre'] = $this->session->userdata('nombre');

        $this->load->view('Cliente/layouts/header', $data);
        $this->load->view('Cliente/layouts/sidebar', $data);
        $this->load->view('Cliente/funciones/pagos/detalle', $data);
        $this->load->view('Cliente/layouts/footer');
    }
}
