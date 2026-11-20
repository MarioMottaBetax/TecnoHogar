
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_pedidos extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');
        $this->load->helper(['url', 'form']);
        $this->load->model('Carrito_model');

        // Validar sesión del cliente
        if (
            !$this->session->userdata('logueado') ||
            $this->session->userdata('id_rol') != 4
        ) {
            redirect('auth/cliente');
        }
    }

    // Listado de pedidos
    public function index()
    {
        $id_usuario = $this->session->userdata('id_usuario');

        if (!$id_usuario) {
            show_error('No se encontró el usuario de la sesión.', 403);
            return;
        }

        $data['nombre'] = $this->session->userdata('nombre');
        $data['pedidos'] = $this->Carrito_model
            ->obtener_pedidos_cliente($id_usuario);

        $this->load->view('Cliente/layouts/header', $data);
        $this->load->view('Cliente/layouts/sidebar', $data);
        $this->load->view('Cliente/funciones/pedidos/index', $data);
        $this->load->view('Cliente/layouts/footer');
    }

    // Detalle de un pedido
    public function detalle($id_pedido = 0)
    {
        $id_usuario = $this->session->userdata('id_usuario');
        $id_pedido = (int) $id_pedido;

        if (!$id_usuario || $id_pedido <= 0) {
            show_404();
            return;
        }

        // Verificar que el pedido pertenezca al cliente
        $pedido = $this->Carrito_model->obtener_pedido_cliente(
            $id_pedido,
            $id_usuario
        );

        if (!$pedido) {
            show_404();
            return;
        }

        $data['nombre'] = $this->session->userdata('nombre');
        $data['pedido'] = $pedido;
        $data['productos'] = $this->Carrito_model
            ->obtener_detalles_pedido($id_pedido);

        $this->load->view('Cliente/layouts/header', $data);
        $this->load->view('Cliente/layouts/sidebar', $data);
        $this->load->view('Cliente/funciones/pedidos/detalle', $data);
        $this->load->view('Cliente/layouts/footer');
    }
}
