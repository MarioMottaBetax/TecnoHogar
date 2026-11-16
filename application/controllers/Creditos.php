
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Creditos extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');
        $this->load->helper(array('url', 'form'));
        $this->load->model('Credito_model');

        if (!$this->session->userdata('logueado')) {
            redirect('auth/login');
        }

        if ((int) $this->session->userdata('id_rol') !== 1) {
            show_error('No tienes permisos para acceder a este módulo.', 403);
        }
    }

    // Listado de créditos
    public function index()
    {
        $data['titulo'] = 'Gestión de créditos';
        $data['nombre'] = $this->session->userdata('nombre');
        $data['creditos'] = $this->Credito_model->obtener_creditos();
        $data['js_adicional'] = 'public/js/creditos.js';

        $this->load->view('Admin/layouts/header', $data);
        $this->load->view('Admin/layouts/sidebar');
        $this->load->view('Admin/funciones/creditos/index', $data);
        $this->load->view('Admin/layouts/footer');
    }

    // Detalle de un crédito
    public function detalle($id)
    {
        $credito = $this->Credito_model->obtener_credito((int) $id);

        if (!$credito) {
            show_404();
            return;
        }

        $data['titulo'] = 'Detalle del crédito';
        $data['nombre'] = $this->session->userdata('nombre');
        $data['credito'] = $credito;
        $data['cuotas'] = $this->Credito_model->obtener_cuotas((int) $id);

        $this->load->view('Admin/layouts/header', $data);
        $this->load->view('Admin/layouts/sidebar');
        $this->load->view('Admin/funciones/creditos/detalle', $data);
        $this->load->view('Admin/layouts/footer');
    }
}
