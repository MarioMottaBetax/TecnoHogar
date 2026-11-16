
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Descuentos extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library(array('session', 'form_validation'));
        $this->load->helper(array('url', 'form'));
        $this->load->model('Descuento_model');

        // Verificar sesión
        if (!$this->session->userdata('logueado')) {
            redirect('auth/cliente');
        }

        // Solo administrador
        if ((int) $this->session->userdata('id_rol') !== 1) {
            show_error('No tienes permisos para acceder a este módulo.', 403);
        }
    }

   /**
 * Listado de cupones con filtro por estado.
 */
public function index()
{
    $estado = $this->input->get('estado');

    // Validar filtro
    if (!in_array((string) $estado, array('0', '1', '2'), TRUE)) {
        $estado = '0';
    }

    $data['titulo'] = 'Marketing y Descuentos';
    $data['nombre'] = $this->session->userdata('nombre');

    // Filtro seleccionado
    $data['estado_filtro'] = (int) $estado;

    // Obtener cupones según el estado
    $data['descuentos'] = $this->Descuento_model->obtener_descuentos(
        (int) $estado
    );

    $data['js_adicional'] = 'public/js/descuentos.js';

    $this->load->view('Admin/layouts/header', $data);
    $this->load->view('Admin/layouts/sidebar');
    $this->load->view('Admin/funciones/descuentos/index', $data);
    $this->load->view('Admin/layouts/footer');
}

    /**
     * Mostrar formulario de creación.
     */
    public function crear()
    {
        $data['titulo'] = 'Crear cupón';
        $data['nombre'] = $this->session->userdata('nombre');
        $data['usuarios'] = $this->Descuento_model->obtener_usuarios();

        $this->load->view('Admin/layouts/header', $data);
        $this->load->view('Admin/layouts/sidebar');
        $this->load->view('Admin/funciones/descuentos/crear', $data);
        $this->load->view('Admin/layouts/footer');
    }

    /**
     * Guardar un nuevo cupón.
     */
    public function guardar()
    {
        if ($this->input->method(TRUE) !== 'POST') {
            show_404();
            return;
        }

        $id_usuario = (int) $this->input->post('id_usuario');
        $cupon = $this->input->post('cupon');

        if ($id_usuario <= 0 || !is_numeric($cupon) || (float) $cupon <= 0) {
            $this->session->set_flashdata(
                'error',
                'Selecciona un usuario e ingresa un valor de cupón válido.'
            );

            redirect('descuentos/crear');
            return;
        }

        if ($this->Descuento_model->registrar_descuento($id_usuario, $cupon)) {
            $this->session->set_flashdata(
                'exito',
                'El cupón fue registrado correctamente.'
            );
        } else {
            $this->session->set_flashdata(
                'error',
                'No fue posible registrar el cupón.'
            );
        }

        redirect('descuentos');
    }

    /**
     * Mostrar formulario de edición.
     */
    public function editar($id = 0)
    {
        $descuento = $this->Descuento_model->obtener_descuento($id);

        if (!$descuento) {
            show_404();
            return;
        }

        $data['titulo'] = 'Editar cupón';
        $data['nombre'] = $this->session->userdata('nombre');
        $data['descuento'] = $descuento;
        $data['usuarios'] = $this->Descuento_model->obtener_usuarios();

        $this->load->view('Admin/layouts/header', $data);
        $this->load->view('Admin/layouts/sidebar');
        $this->load->view('Admin/funciones/descuentos/editar', $data);
        $this->load->view('Admin/layouts/footer');
    }

    /**
     * Actualizar un cupón existente.
     */
    public function actualizar($id = 0)
    {
        if ($this->input->method(TRUE) !== 'POST') {
            show_404();
            return;
        }

        $descuento = $this->Descuento_model->obtener_descuento($id);

        if (!$descuento) {
            show_404();
            return;
        }

        $id_usuario = (int) $this->input->post('id_usuario');
        $cupon = $this->input->post('cupon');

        if ($id_usuario <= 0 || !is_numeric($cupon) || (float) $cupon <= 0) {
            $this->session->set_flashdata(
                'error',
                'Selecciona un usuario e ingresa un valor de cupón válido.'
            );

            redirect('descuentos/editar/' . $id);
            return;
        }

        if ($this->Descuento_model->actualizar_descuento($id, $id_usuario, $cupon)) {
            $this->session->set_flashdata(
                'exito',
                'El cupón fue actualizado correctamente.'
            );
        } else {
            $this->session->set_flashdata(
                'error',
                'No fue posible actualizar el cupón.'
            );
        }

        redirect('descuentos');
    }
}
