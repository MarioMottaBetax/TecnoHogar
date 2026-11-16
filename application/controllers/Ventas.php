
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ventas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');
        $this->load->helper(array('url', 'form'));
        $this->load->model('Venta_model');

        if (!$this->session->userdata('logueado')) {
            redirect('auth/login');
        }

        if ((int) $this->session->userdata('id_rol') !== 1) {
            show_error('No tienes permisos para acceder a este módulo.', 403);
        }
    }

    // Listado de ventas
    public function index()
    {
        $data['titulo'] = 'Gestión de ventas';
        $data['nombre'] = $this->session->userdata('nombre');
        $data['ventas'] = $this->Venta_model->obtener_ventas();

        $this->load->view('Admin/layouts/header', $data);
        $this->load->view('Admin/layouts/sidebar');
        $this->load->view('Admin/funciones/ventas/index', $data);
        $this->load->view('Admin/layouts/footer');
    }

    // Formulario de registro
    public function crear()
{
    $data['titulo'] = 'Registrar venta';
    $data['nombre'] = $this->session->userdata('nombre');
    $data['clientes'] = $this->Venta_model->obtener_clientes();
    $data['productos'] = $this->Venta_model->obtener_productos();
    

    $this->load->view('Admin/layouts/header', $data);
    $this->load->view('Admin/layouts/sidebar');
    $this->load->view('Admin/funciones/ventas/crear', $data);
    $this->load->view('Admin/layouts/footer');
}

    // Consultar cupones de un cliente mediante AJAX
   
public function cupones($id_usuario = 0)
{
    $id_usuario = (int) $id_usuario;

    // Consultar directamente los cupones asociados al usuario.
    $cupones = $this->Venta_model->obtener_cupones_usuario($id_usuario);

    $resultado = array();

    foreach ($cupones as $cupon) {

        $resultado[] = array(
            'id_descuento' => (int) $cupon->id_descuento,
            'cupon' => (float) $cupon->cupon,
            'rango' => (float) $cupon->rango
        );
    }

    return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode(array(
            'success' => !empty($resultado),
            'cupones' => $resultado
        )));
}


    // Detalle de venta
    public function detalle($id)
    {
        $venta = $this->Venta_model->obtener_venta($id);

        if (!$venta) {
            show_404();
            return;
        }

        $data['titulo'] = 'Detalle de venta';
        $data['nombre'] = $this->session->userdata('nombre');
        $data['venta'] = $venta;
        $data['detalles'] = $this->Venta_model->obtener_detalles($id);

        $this->load->view('Admin/layouts/header', $data);
        $this->load->view('Admin/layouts/sidebar');
        $this->load->view('Admin/funciones/ventas/detalle', $data);
        $this->load->view('Admin/layouts/footer');
    }

    // Guardar venta
    public function guardar()
    {
        if (strtoupper($this->input->method()) !== 'POST') {
            show_404();
            return;
        }

        $id_usuario = (int) $this->input->post('id_usuario');
        $productos = $this->input->post('productos');
        $cantidades = $this->input->post('cantidades');

        $modalidad = $this->input->post('modalidad_pago', TRUE);
        $cuota_inicial = $this->input->post('cuota_inicial');
        $numero_cuotas = $this->input->post('numero_cuotas');

        // Recibir cupón
        $id_descuento_post = $this->input->post('id_descuento');

        $id_descuento = null;

        if ($id_descuento_post !== null && $id_descuento_post !== '') {

            $id_descuento = filter_var(
                $id_descuento_post,
                FILTER_VALIDATE_INT
            );

            if (!$id_descuento || $id_descuento < 1) {
                $this->session->set_flashdata(
                    'error',
                    'El cupón seleccionado no es válido.'
                );

                redirect('ventas/crear');
                return;
            }
        }

        // Validar modalidad
        if (!in_array($modalidad, array('contado', 'credito'), TRUE)) {
            $this->session->set_flashdata(
                'error',
                'La modalidad de pago no es válida.'
            );

            redirect('ventas/crear');
            return;
        }

        // Validar cliente
        $cliente = $this->db
            ->where('id_usuario', $id_usuario)
            ->where('id_rol', 4)
            ->get('usuarios')
            ->row();

        if (!$cliente) {
            $this->session->set_flashdata(
                'error',
                'Selecciona un cliente válido.'
            );

            redirect('ventas/crear');
            return;
        }

        // Validar productos
        if (
            !is_array($productos) ||
            !is_array($cantidades) ||
            empty($productos) ||
            count($productos) !== count($cantidades)
        ) {
            $this->session->set_flashdata(
                'error',
                'Debes agregar productos válidos.'
            );

            redirect('ventas/crear');
            return;
        }

        $items = array();

        foreach ($productos as $indice => $id_producto) {

            if (!isset($cantidades[$indice])) {
                $this->session->set_flashdata(
                    'error',
                    'Revisa los productos y sus cantidades.'
                );

                redirect('ventas/crear');
                return;
            }

            $id_producto = filter_var(
                $id_producto,
                FILTER_VALIDATE_INT
            );

            $cantidad = filter_var(
                $cantidades[$indice],
                FILTER_VALIDATE_INT
            );

            if (!$id_producto || !$cantidad || $cantidad < 1) {
                $this->session->set_flashdata(
                    'error',
                    'Revisa los productos y sus cantidades.'
                );

                redirect('ventas/crear');
                return;
            }

            $items[] = array(
                'id_producto' => $id_producto,
                'cantidad' => $cantidad
            );
        }

        // Evitar productos repetidos
        $ids = array_column($items, 'id_producto');

        if (count($ids) !== count(array_unique($ids))) {
            $this->session->set_flashdata(
                'error',
                'No agregues el mismo producto más de una vez.'
            );

            redirect('ventas/crear');
            return;
        }

        // Validar datos del crédito
        if ($modalidad === 'credito') {

            if (
                $cuota_inicial === null ||
                !is_numeric($cuota_inicial) ||
                $numero_cuotas === null ||
                filter_var($numero_cuotas, FILTER_VALIDATE_INT) === false
            ) {
                $this->session->set_flashdata(
                    'error',
                    'Verifica la cuota inicial y el número de cuotas.'
                );

                redirect('ventas/crear');
                return;
            }

            $cuota_inicial = (float) $cuota_inicial;
            $numero_cuotas = (int) $numero_cuotas;

            if (
                $cuota_inicial < 0 ||
                $numero_cuotas < 1 ||
                $numero_cuotas > 60
            ) {
                $this->session->set_flashdata(
                    'error',
                    'Los datos de financiación no son válidos.'
                );

                redirect('ventas/crear');
                return;
            }

        } else {

            $cuota_inicial = 0;
            $numero_cuotas = 1;
        }

        // Registrar venta con cupón opcional
        $id_pedido = $this->Venta_model->registrar_venta(
            $id_usuario,
            $items,
            $modalidad,
            $cuota_inicial,
            $numero_cuotas,
            $id_descuento
        );

        if ($id_pedido) {

            $this->session->set_flashdata(
                'success',
                'Venta registrada correctamente.'
            );

            redirect('ventas/detalle/' . $id_pedido);

        } else {

            $mensaje = $id_descuento
                ? 'No se pudo registrar la venta. Verifica que el cupón pertenezca al cliente y que la compra alcance el mínimo requerido. También revisa el inventario y los datos de financiación.'
                : 'No se pudo registrar la venta. Verifica el inventario, la cuota inicial y los datos de financiación.';

            $this->session->set_flashdata('error', $mensaje);

            redirect('ventas/crear');
        }
    }
}
