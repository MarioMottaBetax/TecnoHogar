
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Garantias extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');
        $this->load->helper(array('url', 'form'));
        $this->load->model('Garantia_model');

        // Verificar sesión
        if (!$this->session->userdata('logueado')) {
            redirect('auth/login');
        }

        // Solo el administrador puede gestionar garantías
        if ((int) $this->session->userdata('id_rol') !== 1) {
            show_error('No tienes permisos para acceder a este módulo.', 403);
        }
    }

    // Listado de garantías
    public function index()
    {
        $data['titulo'] = 'Gestión de garantías';
        $data['garantias'] = $this->Garantia_model->obtener_garantias();
        $data['nombre'] = $this->session->userdata('nombre');

        $this->load->view('Admin/layouts/header', $data);
        $this->load->view('Admin/layouts/sidebar');
        $this->load->view('Admin/funciones/garantias/index', $data);
        $this->load->view('Admin/layouts/footer');
    }

    // Ver detalle de una garantía
    public function detalle($id)
    {
        $garantia = $this->Garantia_model->obtener_garantia($id);

        if (!$garantia) {
            show_404();
            return;
        }

        $data['titulo'] = 'Detalle de garantía';
        $data['garantia'] = $garantia;
        $data['nombre'] = $this->session->userdata('nombre');

        $this->load->view('Admin/layouts/header', $data);
        $this->load->view('Admin/layouts/sidebar');
        $this->load->view('Admin/funciones/garantias/detalle', $data);
        $this->load->view('Admin/layouts/footer');
    }

    // Actualizar estado y observaciones
    public function actualizar()
    {
        if ($this->input->method() !== 'post') {
            show_404();
            return;
        }

        $id = (int) $this->input->post('id_garantia');
        $estado = $this->input->post('estado_garantia', TRUE);
        $observaciones = $this->input->post('observaciones', TRUE);

        $estados_validos = array(
            'Vigente',
            'Vencida',
            'En revisión',
            'Anulada'
        );

        if ($id <= 0 || !in_array($estado, $estados_validos, TRUE)) {
            $this->session->set_flashdata('error', 'Los datos enviados no son válidos.');
            redirect('garantias');
            return;
        }

        $datos = array(
            'estado_garantia' => $estado,
            'observaciones' => $observaciones
        );

        if ($this->Garantia_model->actualizar_garantia($id, $datos)) {
            $this->session->set_flashdata('success', 'Garantía actualizada correctamente.');
        } else {
            $this->session->set_flashdata('error', 'No se pudo actualizar la garantía.');
        }

        redirect('garantias/detalle/' . $id);
    }
}
