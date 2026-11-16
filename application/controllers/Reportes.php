
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');
        $this->load->helper(array('url', 'form'));
        $this->load->model('Reportes_model');

        if (!$this->session->userdata('logueado') ||
            $this->session->userdata('id_rol') != 1) {
            redirect('Auth/login_admin');
        }
    }

    public function index()
    {
        $desde = $this->input->get('desde');
        $hasta = $this->input->get('hasta');

        if (!$this->validar_fecha($desde) ||
            !$this->validar_fecha($hasta) ||
            $desde > $hasta) {
            $desde = date('Y-01-01');
            $hasta = date('Y-m-d');
        }

        $data['nombre'] = $this->session->userdata('nombre');
        $data['desde'] = $desde;
        $data['hasta'] = $hasta;

        $data['ingresos'] = $this->Reportes_model
            ->total_ingresos($desde, $hasta);

        $data['egresos'] = $this->Reportes_model
            ->total_egresos($desde, $hasta);

        $data['balance'] = $data['ingresos'] - $data['egresos'];

        $data['inventario'] = $this->Reportes_model
            ->resumen_inventario();

        $data['compras'] = $this->Reportes_model
            ->resumen_compras($desde, $hasta);

        $data['ingresos_mensuales'] = $this->Reportes_model
            ->ingresos_mensuales($desde, $hasta);

        $data['egresos_mensuales'] = $this->Reportes_model
            ->egresos_mensuales($desde, $hasta);

        $data['categorias'] = $this->Reportes_model
            ->productos_por_categoria();

        $data['js_adicional'] = 'public/js/reportes.js';

        $this->load->view('Admin/layouts/header', $data);
        $this->load->view('Admin/layouts/sidebar', $data);
        $this->load->view('Admin/funciones/reportes/index', $data);
        $this->load->view('Admin/layouts/footer');
    }

    private function validar_fecha($fecha)
    {
        if (!$fecha) {
            return false;
        }

        $formato = DateTime::createFromFormat('!Y-m-d', $fecha);

        return $formato && $formato->format('Y-m-d') === $fecha;
    }
}
