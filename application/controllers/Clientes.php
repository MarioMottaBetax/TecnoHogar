
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library(array('session', 'form_validation'));
        $this->load->helper(array('url', 'form'));
        $this->load->model('Cliente_model');

        // Verificar sesión
        if (!$this->session->userdata('logueado')) {
            redirect('login');
        }

        // Solo administrador
        if ((int) $this->session->userdata('id_rol') !== 1) {
            show_error('No tienes permisos para acceder a este módulo.', 403);
        }
    }

    // Listado de clientes
    public function index()
    {
        $data['titulo'] = 'Clientes | TecnoHogar';
        $data['nombre'] = $this->session->userdata('nombre');
        $data['clientes'] = $this->Cliente_model->obtener_clientes();

        $this->load->view('Admin/layouts/header', $data);
        $this->load->view('Admin/layouts/sidebar');
        $this->load->view('Admin/funciones/clientes/index', $data);
        $this->load->view('Admin/layouts/footer');
    }

    // Formulario de registro
    public function crear()
    {
        $data['titulo'] = 'Nuevo cliente | TecnoHogar';
        $data['nombre'] = $this->session->userdata('nombre');

        $this->load->view('Admin/layouts/header', $data);
        $this->load->view('Admin/layouts/sidebar');
        $this->load->view('Admin/funciones/clientes/crear', $data);
        $this->load->view('Admin/layouts/footer');
    }

    // Guardar cliente
    public function guardar()
    {
        if ($this->input->method(TRUE) !== 'POST') {
            show_404();
        }

        $this->form_validation->set_rules(
            'nombre1', 'Primer nombre', 'required|trim'
        );

        $this->form_validation->set_rules(
            'apellido1', 'Primer apellido', 'required|trim'
        );

        $this->form_validation->set_rules(
            'cedula', 'Cédula', 'required|trim'
        );

        $this->form_validation->set_rules(
            'correo', 'Correo electrónico', 'required|trim|valid_email'
        );

        $this->form_validation->set_rules(
            'celular', 'Celular', 'required|trim'
        );

        if ($this->form_validation->run() === FALSE) {
            $this->crear();
            return;
        }

        $cedula = trim($this->input->post('cedula'));
        $correo = strtolower(trim($this->input->post('correo')));

        if ($this->Cliente_model->existe_cedula($cedula)) {
            $this->session->set_flashdata('error', 'Esta cédula ya está registrada.');
            redirect('clientes/crear');
            return;
        }

        if ($this->Cliente_model->existe_correo($correo)) {
            $this->session->set_flashdata('error', 'Este correo ya está registrado.');
            redirect('clientes/crear');
            return;
        }

        $datos = array(
            'id_rol' => 4,
            'nombre1' => trim($this->input->post('nombre1')),
            'nombre2' => trim($this->input->post('nombre2')),
            'apellido1' => trim($this->input->post('apellido1')),
            'apellido2' => trim($this->input->post('apellido2')),
            'cedula' => $cedula,
            'correo' => $correo,
            'celular' => trim($this->input->post('celular')),
            'departamento' => trim($this->input->post('departamento')),
            'ciudad' => trim($this->input->post('ciudad')),
            'barrio' => trim($this->input->post('barrio')),
            'direccion' => trim($this->input->post('direccion')),
            'referencia' => trim($this->input->post('referencia')),
            'contrasena' => password_hash(bin2hex(random_bytes(16)), PASSWORD_DEFAULT)
        );

        if ($this->Cliente_model->registrar_cliente($datos)) {
            $this->session->set_flashdata('exito', 'Cliente registrado correctamente.');
        } else {
            $this->session->set_flashdata('error', 'No fue posible registrar el cliente.');
        }

        redirect('clientes');
    }

    // Formulario de edición
    public function editar($id)
    {
        $data['cliente'] = $this->Cliente_model->obtener_cliente($id);

        if (!$data['cliente']) {
            show_404();
        }

        $data['titulo'] = 'Editar cliente | TecnoHogar';
        $data['nombre'] = $this->session->userdata('nombre');

        $this->load->view('Admin/layouts/header', $data);
        $this->load->view('Admin/layouts/sidebar');
        $this->load->view('Admin/funciones/clientes/editar', $data);
        $this->load->view('Admin/layouts/footer');
    }

    // Actualizar cliente
    public function actualizar($id)
    {
        if ($this->input->method(TRUE) !== 'POST') {
            show_404();
        }

        $cliente = $this->Cliente_model->obtener_cliente($id);

        if (!$cliente) {
            show_404();
        }

        $this->form_validation->set_rules('nombre1', 'Primer nombre', 'required|trim');
        $this->form_validation->set_rules('apellido1', 'Primer apellido', 'required|trim');
        $this->form_validation->set_rules('cedula', 'Cédula', 'required|trim');
        $this->form_validation->set_rules('correo', 'Correo electrónico', 'required|trim|valid_email');
        $this->form_validation->set_rules('celular', 'Celular', 'required|trim');

        if ($this->form_validation->run() === FALSE) {
            $this->editar($id);
            return;
        }

        $cedula = trim($this->input->post('cedula'));
        $correo = strtolower(trim($this->input->post('correo')));

        if ($this->Cliente_model->existe_cedula($cedula, $id)) {
            $this->session->set_flashdata('error', 'Esta cédula ya pertenece a otro usuario.');
            redirect('clientes/editar/' . $id);
            return;
        }

        if ($this->Cliente_model->existe_correo($correo, $id)) {
            $this->session->set_flashdata('error', 'Este correo ya pertenece a otro usuario.');
            redirect('clientes/editar/' . $id);
            return;
        }

        $datos = array(
            'nombre1' => trim($this->input->post('nombre1')),
            'nombre2' => trim($this->input->post('nombre2')),
            'apellido1' => trim($this->input->post('apellido1')),
            'apellido2' => trim($this->input->post('apellido2')),
            'cedula' => $cedula,
            'correo' => $correo,
            'celular' => trim($this->input->post('celular')),
            'departamento' => trim($this->input->post('departamento')),
            'ciudad' => trim($this->input->post('ciudad')),
            'barrio' => trim($this->input->post('barrio')),
            'direccion' => trim($this->input->post('direccion')),
            'referencia' => trim($this->input->post('referencia'))
        );

        if ($this->Cliente_model->actualizar_cliente($id, $datos)) {
            $this->session->set_flashdata('exito', 'Cliente actualizado correctamente.');
        } else {
            $this->session->set_flashdata('error', 'No fue posible actualizar el cliente.');
        }

        redirect('clientes');
    }
}
