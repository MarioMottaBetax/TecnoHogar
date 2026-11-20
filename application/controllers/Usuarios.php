
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library(array('session', 'form_validation'));
        $this->load->helper(array('url', 'form'));
        $this->load->model('Usuario_model');

        // Verificar sesión
        if (!$this->session->userdata('logueado')) {
            redirect('auth/administrativo/1');
        }

        // Solo administrador
        if ((int) $this->session->userdata('id_rol') !== 1) {
            show_error('No tienes permisos para acceder a este módulo.', 403);
        }
    }

    // ==========================================
    // LISTADO DE USUARIOS
    // ==========================================

    public function index()
    {
        $data['titulo'] = 'Gestión de usuarios';
        $data['nombre'] = $this->session->userdata('nombre');
        $data['usuarios'] = $this->Usuario_model->obtener_usuarios();
        $data['js_adicional'] = 'public/js/usuarios.js';

        $this->load->view('Admin/layouts/header', $data);
        $this->load->view('Admin/layouts/sidebar');
        $this->load->view('Admin/funciones/usuarios/index', $data);
        $this->load->view('Admin/layouts/footer');
    }

    // ==========================================
    // FORMULARIO DE REGISTRO
    // ==========================================

    public function crear()
    {
        $data['titulo'] = 'Registrar usuario';
        $data['nombre'] = $this->session->userdata('nombre');
        $data['roles'] = $this->Usuario_model->obtener_roles();

        $this->load->view('Admin/layouts/header', $data);
        $this->load->view('Admin/layouts/sidebar');
        $this->load->view('Admin/funciones/usuarios/crear', $data);
        $this->load->view('Admin/layouts/footer');
    }

    // ==========================================
    // GUARDAR USUARIO
    // ==========================================

    public function guardar()
    {
        if ($this->input->method() !== 'post') {
            show_404();
            return;
        }

        $this->form_validation->set_rules(
            'id_rol',
            'Rol',
            'required|integer'
        );

        $this->form_validation->set_rules(
            'nombre1',
            'Primer nombre',
            'required|trim|max_length[50]'
        );

        $this->form_validation->set_rules(
            'apellido1',
            'Primer apellido',
            'required|trim|max_length[50]'
        );

        $this->form_validation->set_rules(
            'celular',
            'Celular',
            'required|trim|max_length[20]'
        );

        $this->form_validation->set_rules(
            'cedula',
            'Cédula',
            'required|trim|max_length[20]'
        );

        $this->form_validation->set_rules(
            'correo',
            'Correo',
            'required|trim|valid_email|max_length[100]'
        );

        $this->form_validation->set_rules(
            'contrasena',
            'Contraseña',
            'required|min_length[8]|max_length[255]'
        );

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata(
                'error',
                validation_errors()
            );

            redirect('usuarios/crear');
            return;
        }

        $id_rol = (int) $this->input->post('id_rol');

        // Verificar que el rol exista
        $roles = $this->Usuario_model->obtener_roles();
        $rol_valido = false;

        foreach ($roles as $rol) {
            if ((int) $rol->id_rol === $id_rol) {
                $rol_valido = true;
                break;
            }
        }

        if (!$rol_valido) {
            $this->session->set_flashdata('error', 'Selecciona un rol válido.');
            redirect('usuarios/crear');
            return;
        }

        $cedula = trim($this->input->post('cedula'));
        $correo = trim($this->input->post('correo'));

        if ($this->Usuario_model->existe_cedula($cedula)) {
            $this->session->set_flashdata('error', 'La cédula ya está registrada.');
            redirect('usuarios/crear');
            return;
        }

        if ($this->Usuario_model->existe_correo($correo)) {
            $this->session->set_flashdata('error', 'El correo ya está registrado.');
            redirect('usuarios/crear');
            return;
        }

        $datos = array(
            'id_rol' => $id_rol,
            'nombre1' => trim($this->input->post('nombre1')),
            'nombre2' => trim($this->input->post('nombre2')),
            'apellido1' => trim($this->input->post('apellido1')),
            'apellido2' => trim($this->input->post('apellido2')),
            'celular' => trim($this->input->post('celular')),
            'cedula' => $cedula,
            'correo' => $correo,
            'contrasena' => password_hash(
                $this->input->post('contrasena'),
                PASSWORD_DEFAULT
            ),
            'departamento' => trim($this->input->post('departamento')),
            'ciudad' => trim($this->input->post('ciudad')),
            'barrio' => trim($this->input->post('barrio')),
            'direccion' => trim($this->input->post('direccion')),
            'referencia' => trim($this->input->post('referencia'))
        );

        if ($this->Usuario_model->registrar_usuario($datos)) {
            $this->session->set_flashdata('success', 'Usuario registrado correctamente.');
            redirect('usuarios');
        } else {
            $this->session->set_flashdata('error', 'No se pudo registrar el usuario.');
            redirect('usuarios/crear');
        }
    }

    // ==========================================
    // FORMULARIO DE EDICIÓN
    // ==========================================

    public function editar($id)
    {
        $usuario = $this->Usuario_model->obtener_usuario((int) $id);

        if (!$usuario) {
            show_404();
            return;
        }

        $data['titulo'] = 'Editar usuario';
        $data['nombre'] = $this->session->userdata('nombre');
        $data['usuario'] = $usuario;
        $data['roles'] = $this->Usuario_model->obtener_roles();

        $this->load->view('Admin/layouts/header', $data);
        $this->load->view('Admin/layouts/sidebar');
        $this->load->view('Admin/funciones/usuarios/editar', $data);
        $this->load->view('Admin/layouts/footer');
    }

    // ==========================================
    // ACTUALIZAR USUARIO
    // ==========================================

    public function actualizar($id)
    {
        if ($this->input->method() !== 'post') {
            show_404();
            return;
        }

        $id = (int) $id;

        $usuario = $this->Usuario_model->obtener_usuario($id);

        if (!$usuario) {
            show_404();
            return;
        }

        $this->form_validation->set_rules('id_rol', 'Rol', 'required|integer');
        $this->form_validation->set_rules('nombre1', 'Primer nombre', 'required|trim|max_length[50]');
        $this->form_validation->set_rules('apellido1', 'Primer apellido', 'required|trim|max_length[50]');
        $this->form_validation->set_rules('celular', 'Celular', 'required|trim|max_length[20]');
        $this->form_validation->set_rules('cedula', 'Cédula', 'required|trim|max_length[20]');
        $this->form_validation->set_rules('correo', 'Correo', 'required|trim|valid_email|max_length[100]');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('usuarios/editar/' . $id);
            return;
        }

        $id_rol = (int) $this->input->post('id_rol');

        $rol_valido = false;

        foreach ($this->Usuario_model->obtener_roles() as $rol) {
            if ((int) $rol->id_rol === $id_rol) {
                $rol_valido = true;
                break;
            }
        }

        if (!$rol_valido) {
            $this->session->set_flashdata('error', 'Selecciona un rol válido.');
            redirect('usuarios/editar/' . $id);
            return;
        }

        $cedula = trim($this->input->post('cedula'));
        $correo = trim($this->input->post('correo'));

        if ($this->Usuario_model->cedula_existe_edicion($cedula, $id)) {
            $this->session->set_flashdata('error', 'La cédula pertenece a otro usuario.');
            redirect('usuarios/editar/' . $id);
            return;
        }

        if ($this->Usuario_model->correo_existe_edicion($correo, $id)) {
            $this->session->set_flashdata('error', 'El correo pertenece a otro usuario.');
            redirect('usuarios/editar/' . $id);
            return;
        }

        $datos = array(
            'id_rol' => $id_rol,
            'nombre1' => trim($this->input->post('nombre1')),
            'nombre2' => trim($this->input->post('nombre2')),
            'apellido1' => trim($this->input->post('apellido1')),
            'apellido2' => trim($this->input->post('apellido2')),
            'celular' => trim($this->input->post('celular')),
            'cedula' => $cedula,
            'correo' => $correo,
            'departamento' => trim($this->input->post('departamento')),
            'ciudad' => trim($this->input->post('ciudad')),
            'barrio' => trim($this->input->post('barrio')),
            'direccion' => trim($this->input->post('direccion')),
            'referencia' => trim($this->input->post('referencia'))
        );

        // Cambiar contraseña solo si se escribió una nueva
        $contrasena = $this->input->post('contrasena');

        if (!empty($contrasena)) {
            if (strlen($contrasena) < 8 || strlen($contrasena) > 255) {
                $this->session->set_flashdata(
                    'error',
                    'La contraseña debe tener entre 8 y 255 caracteres.'
                );
                redirect('usuarios/editar/' . $id);
                return;
            }

            $datos['contrasena'] = password_hash($contrasena, PASSWORD_DEFAULT);
        }

        if ($this->Usuario_model->actualizar_usuario($id, $datos)) {
            $this->session->set_flashdata('success', 'Usuario actualizado correctamente.');
            redirect('usuarios');
        } else {
            $this->session->set_flashdata('error', 'No se pudo actualizar el usuario.');
            redirect('usuarios/editar/' . $id);
        }
    }
}
