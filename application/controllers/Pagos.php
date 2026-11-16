
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pagos extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');
        $this->load->helper(array('url', 'form'));
        $this->load->model('Pago_model');

        // Verificar sesión
        if (!$this->session->userdata('logueado')) {
            redirect('auth/login');
        }

        // Solo administrador
        if ((int) $this->session->userdata('id_rol') !== 1) {
            show_error('No tienes permisos para acceder a este módulo.', 403);
        }
    }

    // Listado de pagos
    public function index()
    {
        $data['titulo'] = 'Gestión de pagos';
        $data['nombre'] = $this->session->userdata('nombre');
        $data['pagos'] = $this->Pago_model->obtener_pagos();
        $data['js_adicional'] = 'public/js/pagos.js';

        $this->load->view('Admin/layouts/header', $data);
        $this->load->view('Admin/layouts/sidebar');
        $this->load->view('Admin/funciones/pagos/index', $data);
        $this->load->view('Admin/layouts/footer');
    }

    // Formulario para registrar un abono
    public function crear()
    {
        $data['titulo'] = 'Registrar abono';
        $data['nombre'] = $this->session->userdata('nombre');
        $data['cuotas'] = $this->Pago_model->obtener_cuotas_pendientes();
        $data['js_adicional'] = 'public/js/pagos.js';

        $this->load->view('Admin/layouts/header', $data);
        $this->load->view('Admin/layouts/sidebar');
        $this->load->view('Admin/funciones/pagos/crear', $data);
        $this->load->view('Admin/layouts/footer');
    }

    // Registrar abono
    public function guardar()
    {
        if ($this->input->method() !== 'post') {
            show_404();
            return;
        }

        $id_cuota = (int) $this->input->post('id_cuota');
        $monto = $this->input->post('monto');
        $metodo = $this->input->post('metodo', TRUE);
        $comprobante = $this->input->post('comprobante', TRUE);

        // Validar cuota
        if ($id_cuota <= 0) {
            $this->session->set_flashdata(
                'error',
                'Selecciona una cuota válida.'
            );

            redirect('pagos/crear');
            return;
        }

        // Validar monto
        if (!is_numeric($monto) || (float) $monto <= 0) {
            $this->session->set_flashdata(
                'error',
                'Ingresa un monto válido.'
            );

            redirect('pagos/crear');
            return;
        }

        // Validar método de pago
        $metodos_validos = array('Efectivo', 'Transferencia / Consignación', 'Débito', 'Crédito');

        if (!in_array($metodo, $metodos_validos, TRUE)) {
            $this->session->set_flashdata(
                'error',
                'Selecciona un método de pago válido.'
            );

            redirect('pagos/crear');
            return;
        }

        // Registrar mediante el modelo
        $id_pago = $this->Pago_model->registrar_pago(
            $id_cuota,
            (float) $monto,
            $metodo,
            $comprobante
        );

        if ($id_pago) {

            $this->session->set_flashdata(
                'success',
                'Abono registrado correctamente.'
            );

            redirect('pagos');

        } else {

            $this->session->set_flashdata(
                'error',
                'No se pudo registrar el abono. Verifica el saldo pendiente de la cuota.'
            );

            redirect('pagos/crear');
        }
    }

    // Ver detalle de un pago
    public function detalle($id)
    {
        $pago = $this->Pago_model->obtener_pago((int) $id);

        if (!$pago) {
            show_404();
            return;
        }

        $data['titulo'] = 'Detalle del pago';
        $data['nombre'] = $this->session->userdata('nombre');
        $data['pago'] = $pago;

        $this->load->view('Admin/layouts/header', $data);
        $this->load->view('Admin/layouts/sidebar');
        $this->load->view('Admin/funciones/pagos/detalle', $data);
        $this->load->view('Admin/layouts/footer');
    }
}
