<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_productos extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');
        $this->load->helper(['url', 'form']);
        $this->load->model('Produc_model');

        // Validar acceso exclusivo para clientes
        if (
            !$this->session->userdata('logueado') ||
            $this->session->userdata('id_rol') != 4
        ) {
            redirect('auth/cliente');
        }
    }

    // Catálogo de productos
    public function index()
    {
        $busqueda = trim($this->input->get('buscar', TRUE));
        $categoria = trim($this->input->get('categoria', TRUE));

        $data['nombre'] = $this->session->userdata('nombre');

        $data['busqueda'] = $busqueda;
        $data['categoria_seleccionada'] = $categoria;

        $data['productos'] = $this->Produc_model->obtener_productos(
            $busqueda,
            $categoria
        );

        $data['categorias'] = $this->Produc_model->obtener_categorias();

        $this->load->view('Cliente/layouts/header', $data);
        $this->load->view('Cliente/layouts/sidebar', $data);
        $this->load->view('Cliente/funciones/productos/index', $data);
        $this->load->view('Cliente/layouts/footer');
    }

    // Detalle de un producto
    public function detalle($id_producto = NULL)
    {
        if (!$id_producto || !is_numeric($id_producto)) {
            show_404();
            return;
        }

        $data['nombre'] = $this->session->userdata('nombre');

        $data['producto'] = $this->Produc_model->obtener_producto(
            $id_producto
        );

        if (!$data['producto']) {
            show_404();
            return;
        }

            $this->load->view('Cliente/layouts/header', $data);
            $this->load->view('Cliente/layouts/sidebar', $data);
            $this->load->view('Cliente/funciones/productos/detalle', $data);
            $this->load->view('Cliente/layouts/footer');
    }

    private function redirigir_despues_agregar()
{
    $destino = $this->input->post('destino', TRUE);

    if ($destino === 'comprar') {
        redirect('cliente/carrito');
    }

    redirect('cliente/productos');
}
}
