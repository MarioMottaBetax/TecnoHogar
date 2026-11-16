<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventario extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper(array('url', 'form'));

        // Verificar sesión
        if (
            !$this->session->userdata('logueado') ||
            !$this->session->userdata('id_usuario')
        ) {
            redirect('auth/administrativo/1');
            exit;
        }

        // Solo administrador
        if ((int) $this->session->userdata('id_rol') !== 1) {
            show_error('No tienes permiso para acceder a este módulo.', 403);
            exit;
        }

        $this->load->model('Producto_model');
    }

    // =====================================
    // LISTADO DE PRODUCTOS
    // =====================================

    public function index()
    {
        $data['titulo'] = 'Inventario | TecnoHogar';
        $data['nombre'] = $this->session->userdata('nombre');
        $data['productos'] = $this->Producto_model->obtener_productos();

        $this->load->view('Admin/layouts/header', $data);
        $this->load->view('Admin/layouts/sidebar');
        $this->load->view('Admin/funciones/inventario/index', $data);
        $this->load->view('Admin/layouts/footer');
    }

    // =====================================
    // FORMULARIO DE REGISTRO
    // =====================================

    public function crear()
    {
        $data['titulo'] = 'Registrar producto | TecnoHogar';
        $data['nombre'] = $this->session->userdata('nombre');

        $this->load->view('Admin/layouts/header', $data);
        $this->load->view('Admin/layouts/sidebar');
        $this->load->view('Admin/funciones/inventario/crear');
        $this->load->view('Admin/layouts/footer');
    }

    // =====================================
    // GUARDAR PRODUCTO
    // =====================================

    public function guardar()
    {
        if ($this->input->method(TRUE) !== 'POST') {
            show_404();
            return;
        }

        $this->reglas_producto();

        if ($this->form_validation->run() === FALSE) {
            $this->crear();
            return;
        }

        $datos = array(
            'nombre_producto' => trim($this->input->post('nombre_producto', TRUE)),
            'categoria'       => trim($this->input->post('categoria', TRUE)),
            'precio'          => $this->input->post('precio', TRUE),
            'modelo_detalle'  => trim($this->input->post('modelo_detalle', TRUE)),
            'garantia'        => (int) $this->input->post('garantia'),
            'cantidad'        => (int) $this->input->post('cantidad')
        );

        if ($this->Producto_model->registrar_producto($datos)) {
            $this->session->set_flashdata(
                'exito',
                'Producto registrado correctamente.'
            );
        } else {
            $this->session->set_flashdata(
                'error',
                'No fue posible registrar el producto.'
            );
        }

        redirect('inventario');
    }

    // =====================================
    // FORMULARIO DE EDICIÓN
    // =====================================

    public function editar($id)
    {
        $producto = $this->Producto_model->obtener_producto($id);

        if (!$producto) {
            show_404();
            return;
        }

        $data['titulo'] = 'Editar producto | TecnoHogar';
        $data['nombre'] = $this->session->userdata('nombre');
        $data['producto'] = $producto;

        $this->load->view('Admin/layouts/header', $data);
        $this->load->view('Admin/layouts/sidebar');
        $this->load->view('Admin/funciones/inventario/editar', $data);
        $this->load->view('Admin/layouts/footer');
    }

    // =====================================
    // ACTUALIZAR PRODUCTO
    // =====================================

    public function actualizar($id)
    {
        if ($this->input->method(TRUE) !== 'POST') {
            show_404();
            return;
        }

        $producto = $this->Producto_model->obtener_producto($id);

        if (!$producto) {
            show_404();
            return;
        }

        $this->reglas_producto();

        if ($this->form_validation->run() === FALSE) {
            $this->editar($id);
            return;
        }

        $datos = array(
            'nombre_producto' => trim($this->input->post('nombre_producto', TRUE)),
            'categoria'       => trim($this->input->post('categoria', TRUE)),
            'precio'          => $this->input->post('precio', TRUE),
            'modelo_detalle'  => trim($this->input->post('modelo_detalle', TRUE)),
            'garantia'        => (int) $this->input->post('garantia'),
            'cantidad'        => (int) $this->input->post('cantidad')
        );

        if ($this->Producto_model->actualizar_producto($id, $datos)) {
            $this->session->set_flashdata(
                'exito',
                'Producto actualizado correctamente.'
            );
        } else {
            $this->session->set_flashdata(
                'error',
                'No fue posible actualizar el producto.'
            );
        }

        redirect('inventario');
    }

    // =====================================
    // ELIMINAR PRODUCTO
    // =====================================

    public function eliminar($id)
    {
        if ($this->input->method(TRUE) !== 'POST') {
            show_404();
            return;
        }

        $producto = $this->Producto_model->obtener_producto($id);

        if (!$producto) {
            show_404();
            return;
        }

        if ($this->Producto_model->eliminar_producto($id)) {
            $this->session->set_flashdata(
                'exito',
                'Producto eliminado correctamente.'
            );
        } else {
            $this->session->set_flashdata(
                'error',
                'No fue posible eliminar el producto.'
            );
        }

        redirect('inventario');
    }

    // =====================================
    // REGLAS DE VALIDACIÓN
    // =====================================

    private function reglas_producto()
    {
        $this->form_validation->set_rules(
            'nombre_producto',
            'Nombre del producto',
            'required|trim|max_length[100]'
        );

        $this->form_validation->set_rules(
            'categoria',
            'Categoría',
            'required|trim|max_length[60]'
        );

        $this->form_validation->set_rules(
            'precio',
            'Precio',
            'required|numeric|greater_than[0]'
        );

        $this->form_validation->set_rules(
            'garantia',
            'Garantía',
            'required|integer|greater_than_equal_to[0]'
        );

        $this->form_validation->set_rules(
            'cantidad',
            'Cantidad',
            'required|integer|greater_than_equal_to[0]'
        );

        $this->form_validation->set_rules(
            'modelo_detalle',
            'Detalles del modelo',
            'trim'
        );
    }
}