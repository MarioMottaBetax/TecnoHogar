
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');
        $this->load->helper(array('url', 'form'));

        if (!$this->session->userdata('logueado') ||
            $this->session->userdata('id_rol') != 4) {
            redirect('auth/cliente');
        }
    }

    public function index()
    {
        $data['nombre'] = $this->session->userdata('nombre');

        $this->load->view('Cliente/layouts/header', $data);
        $this->load->view('Cliente/layouts/sidebar', $data);
        $this->load->view('Cliente/dashboard/index', $data);
        $this->load->view('Cliente/layouts/footer');
    }
}
