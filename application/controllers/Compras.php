
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Compras extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');
        $this->load->helper(array('url', 'form'));
        $this->load->model('Compra_model');

        // Verificar sesión
        if (!$this->session->userdata('logueado')) {
            redirect('auth/administrativo/1');
        }

        // Solo administrador
        if ((int) $this->session->userdata('id_rol') !== 1) {
            show_error('No tienes permisos para acceder a este módulo.', 403);
        }
    }

    // Listado de compras
    public function index()
    {
        $data['titulo'] = 'Compras | TecnoHogar';
        $data['nombre'] = $this->session->userdata('nombre');
        $data['compras'] = $this->Compra_model->obtener_compras();

        $this->load->view('Admin/layouts/header', $data);
        $this->load->view('Admin/layouts/sidebar');
        $this->load->view('Admin/funciones/compras/index', $data);
        $this->load->view('Admin/layouts/footer');
    }

    // Formulario para registrar compra
    public function crear()
    {
        $data['titulo'] = 'Nueva compra | TecnoHogar';
        $data['nombre'] = $this->session->userdata('nombre');

        $data['proveedores'] =
            $this->Compra_model->obtener_proveedores_activos();

        $data['productos'] =
            $this->Compra_model->obtener_productos();

        $this->load->view('Admin/layouts/header', $data);
        $this->load->view('Admin/layouts/sidebar');
        $this->load->view('Admin/funciones/compras/crear', $data);
        $this->load->view('Admin/layouts/footer');
    }

    // Guardar compra
    public function guardar()
    {
        if ($this->input->method(TRUE) !== 'POST') {
            show_404();
        }

        $id_proveedor = (int) $this->input->post('id_proveedor');
        $observaciones = $this->input->post('observaciones', TRUE);

        $productos = $this->input->post('id_producto');
        $cantidades = $this->input->post('cantidad');
        $costos = $this->input->post('costo_unitario');

        if (!$id_proveedor || !is_array($productos) ||
            !is_array($cantidades) || !is_array($costos)) {

            $this->session->set_flashdata(
                'error',
                'Debes seleccionar un proveedor y agregar productos.'
            );

            redirect('compras/crear');
            return;
        }

        // Verificar proveedor activo
        $proveedores = $this->Compra_model->obtener_proveedores_activos();

        $proveedor_valido = false;

        foreach ($proveedores as $proveedor) {
            if ((int) $proveedor->id_proveedor === $id_proveedor) {
                $proveedor_valido = true;
                break;
            }
        }

        if (!$proveedor_valido) {
            $this->session->set_flashdata(
                'error',
                'El proveedor seleccionado no existe o está inactivo.'
            );

            redirect('compras/crear');
            return;
        }

        $detalles = array();
        $productos_vistos = array();

        foreach ($productos as $i => $id_producto) {

            $id_producto = (int) $id_producto;
            $cantidad = isset($cantidades[$i]) ? (int) $cantidades[$i] : 0;
            $costo = isset($costos[$i]) ? $costos[$i] : '';

            if ($id_producto <= 0 || $cantidad <= 0 ||
                !is_numeric($costo) || (float) $costo <= 0 ||
                (float) $costo > 9999999999.99) {

                $this->session->set_flashdata(
                    'error',
                    'Revisa los productos, cantidades y costos ingresados.'
                );

                redirect('compras/crear');
                return;
            }

            if (isset($productos_vistos[$id_producto])) {
                $this->session->set_flashdata(
                    'error',
                    'No agregues el mismo producto dos veces. Ajusta su cantidad.'
                );

                redirect('compras/crear');
                return;
            }

            $productos_vistos[$id_producto] = true;

            $detalles[] = array(
                'id_producto' => $id_producto,
                'cantidad' => $cantidad,
                'costo_unitario' => (float) $costo
            );
        }

        if (empty($detalles)) {
            $this->session->set_flashdata(
                'error',
                'Debes agregar al menos un producto.'
            );

            redirect('compras/crear');
            return;
        }

        $cabecera = array(
            'id_proveedor' => $id_proveedor,
            'id_usuario' => (int) $this->session->userdata('id_usuario'),
            'observaciones' => $observaciones
        );

        $id_compra = $this->Compra_model->registrar_compra(
            $cabecera,
            $detalles
        );

        if ($id_compra) {
            $this->session->set_flashdata(
                'exito',
                'La compra se registró correctamente como pendiente.'
            );
        } else {
            $this->session->set_flashdata(
                'error',
                'No fue posible registrar la compra.'
            );
        }

        redirect('compras');
    }

   
// Ver detalle de compra
public function detalle($id)
{
    $data['compra'] = $this->Compra_model->obtener_compra($id);

    if (!$data['compra']) {
        show_404();
    }

    $data['detalles'] = $this->Compra_model->obtener_detalles($id);

    // Obtener el nombre del proveedor
    $this->db->select('nombre_proveedor');
    $this->db->where('id_proveedor', $data['compra']->id_proveedor);
    $proveedor = $this->db->get('proveedores')->row();

    $data['nombre_proveedor'] = $proveedor
        ? $proveedor->nombre_proveedor
        : 'Proveedor no encontrado';

    $data['titulo'] = 'Detalle de compra | TecnoHogar';
    $data['nombre'] = $this->session->userdata('nombre');

    $this->load->view('Admin/layouts/header', $data);
    $this->load->view('Admin/layouts/sidebar');
    $this->load->view('Admin/funciones/compras/detalle', $data);
    $this->load->view('Admin/layouts/footer');
}


    // Recibir compra
    public function recibir($id)
    {
        if ($this->input->method(TRUE) !== 'POST') {
            show_404();
        }

        $resultado = $this->Compra_model->recibir_compra($id);

        if ($resultado) {
            $this->session->set_flashdata(
                'exito',
                'Compra recibida. El inventario fue actualizado.'
            );
        } else {
            $this->session->set_flashdata(
                'error',
                'No se pudo recibir la compra. Verifica su estado y sus detalles.'
            );
        }

        redirect('compras');
    }

    // Cancelar compra
    public function cancelar($id)
    {
        if ($this->input->method(TRUE) !== 'POST') {
            show_404();
        }

        if ($this->Compra_model->cancelar_compra($id)) {
            $this->session->set_flashdata(
                'exito',
                'La compra fue cancelada.'
            );
        } else {
            $this->session->set_flashdata(
                'error',
                'No se pudo cancelar. Solo se pueden cancelar compras pendientes.'
            );
        }

        redirect('compras');
    }
}
