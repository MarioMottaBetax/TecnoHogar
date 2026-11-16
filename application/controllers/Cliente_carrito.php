
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_carrito extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');
        $this->load->helper(['url', 'form']);
        $this->load->model('Carrito_model');

        // Validar que sea un cliente autenticado
        if (
            !$this->session->userdata('logueado') ||
            $this->session->userdata('id_rol') != 4
        ) {
            redirect('Auth/login_cliente');
        }
    }

  
    // Mostrar carrito
public function index()
{
    $id_usuario = $this->session->userdata('id_usuario');

    if (!$id_usuario) {
        show_error('No se encontró el usuario de la sesión.', 403);
        return;
    }

    $carrito = $this->Carrito_model->obtener_carrito($id_usuario);

    $data['nombre'] = $this->session->userdata('nombre');
    $data['productos'] = array();
    $data['total'] = 0;
    $data['cupones'] = array();

    // Consultar cupones disponibles
    $data['cupones'] = $this->Carrito_model
        ->obtener_cupones_disponibles($id_usuario);

    if ($carrito) {
        $data['productos'] = $this->Carrito_model
            ->obtener_productos_carrito($carrito->id_pedido);

        $data['total'] = $carrito->total;
    }

    $this->load->view('Cliente/layouts/header', $data);
    $this->load->view('Cliente/layouts/sidebar', $data);
    $this->load->view('Cliente/funciones/carrito/index', $data);
    $this->load->view('Cliente/layouts/footer', $data);

}

    // Agregar producto
    public function agregar()
{
    if ($this->input->method(TRUE) !== 'POST') {
        show_404();
        return;
    }

    $id_usuario = $this->session->userdata('id_usuario');
    $id_producto = (int) $this->input->post('id_producto');
    $cantidad = (int) $this->input->post('cantidad');
    $destino = $this->input->post('destino', TRUE);

    if (!$id_usuario || $id_producto <= 0 || $cantidad <= 0) {
        $this->session->set_flashdata(
            'error',
            'Los datos del producto no son válidos.'
        );

        redirect('cliente/productos');
        return;
    }

    $resultado = $this->Carrito_model->agregar_producto(
        $id_usuario,
        $id_producto,
        $cantidad
    );

    if ($resultado['success']) {

        $this->session->set_flashdata('exito', $resultado['mensaje']);

        if ($destino === 'comprar') {
            redirect('cliente/carrito');
        } else {
            redirect('cliente/productos');
        }

    } else {

        $this->session->set_flashdata('error', $resultado['mensaje']);
        redirect('cliente/productos');
    }
}
    // Actualizar cantidad
    public function actualizar()
    {
        if ($this->input->method(TRUE) !== 'POST') {
            show_404();
            return;
        }

        $id_usuario = $this->session->userdata('id_usuario');
        $id_detalle = (int) $this->input->post('id_detalle');
        $cantidad = (int) $this->input->post('cantidad');

        $resultado = $this->Carrito_model->actualizar_cantidad(
            $id_usuario,
            $id_detalle,
            $cantidad
        );

        if ($resultado) {
            $this->session->set_flashdata(
                'exito',
                'La cantidad se actualizó correctamente.'
            );
        } else {
            $this->session->set_flashdata(
                'error',
                'No fue posible actualizar la cantidad. Verifica las existencias.'
            );
        }

        redirect('cliente/carrito');
    }

    // Eliminar producto
    public function eliminar()
    {
        if ($this->input->method(TRUE) !== 'POST') {
            show_404();
            return;
        }

        $id_usuario = $this->session->userdata('id_usuario');
        $id_detalle = (int) $this->input->post('id_detalle');

        $resultado = $this->Carrito_model->eliminar_producto(
            $id_usuario,
            $id_detalle
        );

        if ($resultado) {
            $this->session->set_flashdata(
                'exito',
                'Producto eliminado del carrito.'
            );
        } else {
            $this->session->set_flashdata(
                'error',
                'No se pudo eliminar el producto.'
            );
        }

        redirect('cliente/carrito');
    }


   
    // Confirmar compra y procesar pago
public function confirmar()
{
    if ($this->input->method(TRUE) !== 'POST') {
        show_404();
        return;
    }

    $id_usuario = $this->session->userdata('id_usuario');

    if (!$id_usuario) {
        show_error('No se encontró el usuario de la sesión.', 403);
        return;
    }

    $id_descuento = $this->input->post('id_descuento');
    $metodo = $this->input->post('metodo', TRUE);
    $numero_cuotas = (int) $this->input->post('numero_cuotas');

    // Normalizar cupón vacío
    if (empty($id_descuento)) {
        $id_descuento = NULL;
    } else {
        $id_descuento = (int) $id_descuento;
    }

    // Métodos permitidos
    $metodos_permitidos = array('Efectivo', 'Transferencia / Consignación', 'Débito', 'Crédito');

    if (!in_array($metodo, $metodos_permitidos, TRUE)) {
        $this->session->set_flashdata(
            'error',
            'Selecciona un método de pago válido.'
        );

        redirect('cliente/carrito');
        return;
    }

    if ($metodo === 'Crédito' && ($numero_cuotas < 1 || $numero_cuotas > 60)) {
        $this->session->set_flashdata('error', 'Selecciona un número válido de cuotas para el crédito.');
        redirect('cliente/carrito');
        return;
    }

    $comprobante = NULL;

    // Transferencia y consignación requieren comprobante
    if ($metodo === 'Transferencia / Consignación') {

        if (
            empty($_FILES['comprobante']['name']) ||
            !isset($_FILES['comprobante']['error']) ||
            $_FILES['comprobante']['error'] !== UPLOAD_ERR_OK
        ) {
            $this->session->set_flashdata(
                'error',
                'Debes adjuntar el comprobante de pago.'
            );

            redirect('cliente/carrito');
            return;
        }

        $config['upload_path'] = FCPATH . 'uploads/comprobantes/';

        if (!is_dir($config['upload_path'])) {
            if (!mkdir($config['upload_path'], 0755, TRUE)) {
                $this->session->set_flashdata(
                    'error',
                    'No se pudo preparar la carpeta para los comprobantes.'
                );

                redirect('cliente/carrito');
                return;
            }
        }

        $config['allowed_types'] = 'jpg|jpeg|png|pdf';
        $config['max_size'] = 5120;
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('comprobante')) {

            $this->session->set_flashdata(
                'error',
                strip_tags($this->upload->display_errors('', ''))
            );

            redirect('cliente/carrito');
            return;
        }

        $archivo = $this->upload->data();
        $comprobante = 'uploads/comprobantes/' . $archivo['file_name'];
    }

    // Procesar compra
    $resultado = $this->Carrito_model->confirmar_pedido(
        $id_usuario,
        $id_descuento,
        $metodo,
        $comprobante,
        $numero_cuotas
    );

    if ($resultado['success']) {

        $mensaje = $resultado['mensaje']
            . ' Pedido: #' . $resultado['id_pedido']
            . '. Total: $' . number_format($resultado['total'], 0, ',', '.');

        $this->session->set_flashdata('exito', $mensaje);

        redirect('cliente/pedidos');

    } else {

        // Si el modelo rechazó la operación, eliminar el archivo subido
        if (!empty($comprobante) && file_exists(FCPATH . $comprobante)) {
            unlink(FCPATH . $comprobante);
        }

        $this->session->set_flashdata(
            'error',
            $resultado['mensaje']
        );

        redirect('cliente/carrito');
    }
}


}
