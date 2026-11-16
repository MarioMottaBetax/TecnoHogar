
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Usuario_model');
        $this->load->library('session');
        $this->load->helper(array('url', 'form'));
    }

    // Login de clientes
    public function cliente()
    {
        $data['titulo'] = 'Inicio de sesión | TecnoHogar';
        $data['tipo'] = 'cliente';

        $this->load->view('Auth/login_cliente', $data);
    }

    // Mostrar formulario de registro
public function registro()
{
    $data['titulo'] = 'Crear cuenta | TecnoHogar';

    $this->load->view('Auth/registro', $data);
}


// Guardar registro de cliente
public function guardar_registro()
{
    // Obtener y limpiar los datos del formulario
    $datos = array(
        'nombre1'     => trim($this->input->post('nombre1', TRUE)),
        'nombre2'     => trim($this->input->post('nombre2', TRUE)),
        'apellido1'  => trim($this->input->post('apellido1', TRUE)),
        'apellido2'  => trim($this->input->post('apellido2', TRUE)),
        'cedula'     => trim($this->input->post('cedula', TRUE)),
        'celular'    => trim($this->input->post('celular', TRUE)),
        'departamento' => trim($this->input->post('departamento', TRUE)),
        'ciudad'     => trim($this->input->post('ciudad', TRUE)),
        'barrio'     => trim($this->input->post('barrio', TRUE)),
        'direccion'  => trim($this->input->post('direccion', TRUE)),
        'referencia' => trim($this->input->post('referencia', TRUE)),
        'correo'     => strtolower(trim($this->input->post('correo', TRUE)))
    );

    $contrasena = $this->input->post('contrasena');
    $confirmar = $this->input->post('confirmar_contrasena');

    // Validar campos obligatorios
    $obligatorios = array(
        'nombre1', 'apellido1', 'cedula', 'celular',
        'departamento', 'ciudad', 'barrio', 'direccion', 'correo'
    );

    foreach ($obligatorios as $campo) {
        if (empty($datos[$campo])) {
            $this->session->set_flashdata(
                'error',
                'Debes completar todos los campos obligatorios.'
            );
            redirect('auth/registro');
            return;
        }
    }

    // Validar formato del correo
    if (!filter_var($datos['correo'], FILTER_VALIDATE_EMAIL)) {
        $this->session->set_flashdata('error', 'El correo electrónico no es válido.');
        redirect('auth/registro');
        return;
    }

    // Validar contraseña
    if (strlen($contrasena) < 8) {
        $this->session->set_flashdata(
            'error',
            'La contraseña debe tener mínimo 8 caracteres.'
        );
        redirect('auth/registro');
        return;
    }

    if ($contrasena !== $confirmar) {
        $this->session->set_flashdata(
            'error',
            'Las contraseñas no coinciden.'
        );
        redirect('auth/registro');
        return;
    }

    // Comprobar duplicados
    if ($this->Usuario_model->existe_correo($datos['correo'])) {
        $this->session->set_flashdata('error', 'Este correo ya está registrado.');
        redirect('auth/registro');
        return;
    }

    if ($this->Usuario_model->existe_cedula($datos['cedula'])) {
        $this->session->set_flashdata('error', 'Esta cédula ya está registrada.');
        redirect('auth/registro');
        return;
    }

    // Asignar automáticamente el rol de cliente
    $datos['id_rol'] = 4;

    // Guardar contraseña cifrada
    $datos['contrasena'] = password_hash($contrasena, PASSWORD_DEFAULT);

    // Insertar en la base de datos
    if ($this->Usuario_model->registrar_usuario($datos)) {
        $this->session->set_flashdata(
            'exito',
            'Tu cuenta fue creada correctamente. Ya puedes iniciar sesión.'
        );

        redirect('auth/cliente');
        return;
    }

    $this->session->set_flashdata(
        'error',
        'No fue posible crear tu cuenta. Verifica los datos e inténtalo nuevamente.'
    );

    redirect('auth/registro');
}


    // Login administrativo según el cargo seleccionado
    public function administrativo($id_rol = 1)
    {
        if (!in_array((int) $id_rol, array(1, 2, 3), true)) {
            show_404();
            return;
        }

        $data['titulo'] = 'Acceso administrativo | TecnoHogar';
        $data['id_rol'] = (int) $id_rol;

        $roles = array(
            1 => 'Administrador',
            2 => 'Vendedor',
            3 => 'Técnico'
        );

        $data['nombre_rol'] = $roles[(int) $id_rol];

        $this->load->view('Auth/login_admin', $data);
    }

    // Procesar login de cliente
    public function validar_cliente()
    {
        $this->procesar_login(4, 'cliente');
    }

    // Procesar login administrativo
    public function validar_admin($id_rol = 0)
    {
        $id_rol = (int) $id_rol;

        if (!in_array($id_rol, array(1, 2, 3), true)) {
            show_404();
            return;
        }

        $this->procesar_login($id_rol, 'admin');
    }

    // Validación general
    private function procesar_login($id_rol, $tipo)
    {
        $correo = trim($this->input->post('correo', TRUE));
        $contrasena = $this->input->post('contrasena');

        if (empty($correo) || empty($contrasena)) {
            $this->session->set_flashdata(
                'error',
                'Debes ingresar tu correo y contraseña.'
            );

            redirect($tipo === 'cliente'
                ? 'auth/cliente'
                : 'auth/administrativo/' . $id_rol
            );
            return;
        }

        $usuario = $this->Usuario_model->obtener_por_correo($correo);

        if (
            !$usuario ||
            (int) $usuario->id_rol !== (int) $id_rol ||
            !password_verify($contrasena, $usuario->contrasena)
        ) {
            $this->session->set_flashdata(
                'error',
                'El correo, la contraseña o el tipo de cuenta son incorrectos.'
            );

            redirect($tipo === 'cliente'
                ? 'auth/cliente'
                : 'auth/administrativo/' . $id_rol
            );
            return;
        }

        // Evita reutilizar el identificador de sesión anterior
        $this->session->sess_regenerate(TRUE);

        $this->session->set_userdata(array(
            'id_usuario' => $usuario->id_usuario,
            'id_rol' => $usuario->id_rol,
            'nombre' => trim(
                $usuario->nombre1 . ' ' .
                $usuario->nombre2 . ' ' .
                $usuario->apellido1 . ' ' .
                $usuario->apellido2
            ),
            'correo' => $usuario->correo,
            'logueado' => TRUE
        ));

        // Redirección según el tipo de usuario
        if ((int) $usuario->id_rol === 1) {
            redirect('admin/dashboard');
        } elseif ((int) $usuario->id_rol === 2) {
            redirect('vendedor/dashboard');
        } elseif ((int) $usuario->id_rol === 3) {
            redirect('tecnico/dashboard');
        } else {
            redirect('cliente/dashboard');
        }
    } // Cierre de procesar_login()

    // Cerrar sesión
    public function cerrar_sesion()
    {
        $this->session->sess_destroy();
        redirect('portal');
    }
}
