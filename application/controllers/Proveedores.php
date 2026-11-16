
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedores extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library(array('session', 'form_validation'));
        $this->load->helper(array('url', 'form'));

        // Verificar sesión
        if (!$this->session->userdata('logueado')) {
            redirect('auth/administrativo/1');
        }

        // Solo administrador
        if ((int)$this->session->userdata('id_rol') !== 1) {
            show_error('No tienes permiso para acceder a este módulo.', 403);
        }

        $this->load->model('Proveedor_model');
    }

    // LISTADO
    public function index()
    {
        $data['titulo'] = 'Proveedores | TecnoHogar';
        $data['proveedores'] = $this->Proveedor_model->obtener_proveedores();
        $data['nombre'] = $this->session->userdata('nombre');

        $this->load->view('Admin/layouts/header', $data);
        $this->load->view('Admin/layouts/sidebar');
        $this->load->view('Admin/funciones/proveedores/index', $data);
        $this->load->view('Admin/layouts/footer');
    }

    // FORMULARIO DE REGISTRO
    public function crear()
    {
        $data['titulo'] = 'Registrar proveedor | TecnoHogar';
        $data['nombre'] = $this->session->userdata('nombre');

        $this->load->view('Admin/layouts/header', $data);
        $this->load->view('Admin/layouts/sidebar');
        $this->load->view('Admin/funciones/proveedores/crear', $data);
        $this->load->view('Admin/layouts/footer');
    }

    // GUARDAR PROVEEDOR
    public function guardar()
    {
        if ($this->input->method() !== 'post') {
            show_404();
        }

        $this->form_validation->set_rules(
            'nombre_proveedor',
            'Nombre del proveedor',
            'required|trim|max_length[120]'
        );

        $this->form_validation->set_rules(
            'correo',
            'Correo',
            'trim|valid_email|max_length[100]'
        );

        $this->form_validation->set_rules(
            'celular',
            'Celular',
            'trim|max_length[20]'
        );

        if ($this->form_validation->run() === FALSE) {
            $this->crear();
            return;
        }

        $nit = trim($this->input->post('nit', TRUE));

        if ($this->Proveedor_model->existe_nit($nit)) {
            $this->session->set_flashdata(
                'error',
                'Ya existe un proveedor registrado con ese NIT.'
            );
            redirect('proveedores/crear');
            return;
        }

        $datos = array(
            'nombre_proveedor' => trim($this->input->post('nombre_proveedor', TRUE)),
            'nit' => $nit !== '' ? $nit : NULL,
            'celular' => trim($this->input->post('celular', TRUE)),
            'correo' => trim($this->input->post('correo', TRUE)),
            'departamento' => trim($this->input->post('departamento', TRUE)),
            'ciudad' => trim($this->input->post('ciudad', TRUE)),
            'direccion' => trim($this->input->post('direccion', TRUE))
        );

        if ($this->Proveedor_model->registrar_proveedor($datos)) {
            $this->session->set_flashdata(
                'success',
                'Proveedor registrado correctamente.'
            );
        } else {
            $this->session->set_flashdata(
                'error',
                'No fue posible registrar el proveedor.'
            );
        }

        redirect('proveedores');
    }

   
        // FORMULARIO DE EDICIÓN
        public function editar($id)
        {
            $data['proveedor'] = $this->Proveedor_model->obtener_proveedor($id);

            if (!$data['proveedor']) {
                show_404();
            }

            $data['titulo'] = 'Editar proveedor | TecnoHogar';
            $data['nombre'] = $this->session->userdata('nombre');

            $this->load->view('Admin/layouts/header', $data);
            $this->load->view('Admin/layouts/sidebar');
            $this->load->view('Admin/funciones/proveedores/editar', $data);
            $this->load->view('Admin/layouts/footer');
        }


    // ACTUALIZAR PROVEEDOR
    public function actualizar($id)
    {
        if ($this->input->method() !== 'post') {
            show_404();
        }

        $proveedor = $this->Proveedor_model->obtener_proveedor($id);

        if (!$proveedor) {
            show_404();
        }

        $this->form_validation->set_rules(
            'nombre_proveedor',
            'Nombre del proveedor',
            'required|trim|max_length[120]'
        );

        $this->form_validation->set_rules(
            'correo',
            'Correo',
            'trim|valid_email|max_length[100]'
        );

        $this->form_validation->set_rules(
            'celular',
            'Celular',
            'trim|max_length[20]'
        );

        if ($this->form_validation->run() === FALSE) {
            $this->editar($id);
            return;
        }

        $nit = trim($this->input->post('nit', TRUE));

        if ($this->Proveedor_model->existe_nit($nit, $id)) {
            $this->session->set_flashdata(
                'error',
                'Ese NIT ya está registrado en otro proveedor.'
            );
            redirect('proveedores/editar/'.$id);
            return;
        }

        $datos = array(
            'nombre_proveedor' => trim($this->input->post('nombre_proveedor', TRUE)),
            'nit' => $nit !== '' ? $nit : NULL,
            'celular' => trim($this->input->post('celular', TRUE)),
            'correo' => trim($this->input->post('correo', TRUE)),
            'departamento' => trim($this->input->post('departamento', TRUE)),
            'ciudad' => trim($this->input->post('ciudad', TRUE)),
            'direccion' => trim($this->input->post('direccion', TRUE))
        );

        if ($this->Proveedor_model->actualizar_proveedor($id, $datos)) {
            $this->session->set_flashdata(
                'success',
                'Proveedor actualizado correctamente.'
            );
        } else {
            $this->session->set_flashdata(
                'error',
                'No fue posible actualizar el proveedor.'
            );
        }

        redirect('proveedores');
    }

    // ACTIVAR / DESACTIVAR
    public function cambiar_estado($id)
    {
        if ($this->input->method() !== 'post') {
            show_404();
        }

        $proveedor = $this->Proveedor_model->obtener_proveedor($id);

        if (!$proveedor) {
            show_404();
        }

        $nuevo_estado = ((int)$proveedor->estado === 1) ? 0 : 1;

        if ($this->Proveedor_model->cambiar_estado($id, $nuevo_estado)) {
            $mensaje = $nuevo_estado === 1
                ? 'Proveedor activado correctamente.'
                : 'Proveedor desactivado correctamente.';

            $this->session->set_flashdata('success', $mensaje);
        } else {
            $this->session->set_flashdata(
                'error',
                'No fue posible cambiar el estado del proveedor.'
            );
        }

        redirect('proveedores');
    }
}
