
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');
        $this->load->helper('url');

        if (!$this->session->userdata('logueado')) {
            redirect('auth/administrativo/1');
        }

        if ((int) $this->session->userdata('id_rol') !== 1) {
            show_error('No tienes permiso para acceder a este módulo.', 403);
        }
    }

    public function dashboard()
{
    $this->load->model('Dashboard_model');

    $data['titulo'] = 'Dashboard | TecnoHogar';
    $data['nombre'] = $this->session->userdata('nombre');

    // Indicador de clientes registrados
    $data = array_merge($data, $this->Dashboard_model->obtener_resumen());

    $this->load->view('Admin/layouts/header', $data);
    $this->load->view('Admin/layouts/sidebar');
    $this->load->view('Admin/dashboard', $data);
    $this->load->view('Admin/layouts/footer');
}
}
