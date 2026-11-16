
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contabilidad extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');
        $this->load->helper(array('url', 'form'));
        $this->load->model('Contabilidad_model');

        if (!$this->session->userdata('logueado')) {
            redirect('portal');
            exit;
        }

        if ((int) $this->session->userdata('id_rol') !== 1) {
            show_error('No tienes permisos para acceder.', 403);
            return;
        }
    }

    // Panel principal
    public function index()
    {
        $desde = $this->input->get('desde', TRUE);
        $hasta = $this->input->get('hasta', TRUE);

        if (!$this->validar_fechas($desde, $hasta)) {
            show_error('El periodo seleccionado no es válido.', 400);
            return;
        }

        // Por defecto: mes actual
        if (!$desde && !$hasta) {
            $desde = date('Y-m-01');
            $hasta = date('Y-m-d');
        }

        $ingresos = $this->Contabilidad_model
            ->total_ingresos($desde, $hasta);

        $egresos = $this->Contabilidad_model
            ->total_egresos($desde, $hasta);

        $data['titulo'] = 'Contabilidad y Finanzas';
        $data['nombre'] = $this->session->userdata('nombre');

        $data['desde'] = $desde;
        $data['hasta'] = $hasta;

        $data['total_ingresos'] = $ingresos;
        $data['total_egresos'] = $egresos;
        $data['balance'] = $ingresos - $egresos;

        $data['movimientos'] = $this->Contabilidad_model
            ->obtener_ingresos($desde, $hasta);

        $data['egresos'] = $this->Contabilidad_model
            ->obtener_egresos($desde, $hasta);

        $data['js_adicional'] = 'public/js/contabilidad.js';

        $this->load->view('Admin/layouts/header', $data);
        $this->load->view('Admin/layouts/sidebar', $data);
        $this->load->view('Admin/funciones/contabilidad/index', $data);
        $this->load->view('Admin/layouts/footer', $data);
    }

    // Mostrar formulario de registro de egresos
    public function registrar_egreso()
    {
        $data['titulo'] = 'Registrar egreso';
        $data['nombre'] = $this->session->userdata('nombre');

        $this->load->view('Admin/layouts/header', $data);
        $this->load->view('Admin/layouts/sidebar', $data);
        $this->load->view(
            'Admin/funciones/contabilidad/registrar_egreso',
            $data
        );
        $this->load->view('Admin/layouts/footer', $data);
    }

    // Guardar egreso
    public function guardar_egreso()
    {
        if ($this->input->method() !== 'post') {
            show_404();
            return;
        }

        $concepto = trim($this->input->post('concepto', TRUE));
        $categoria = trim($this->input->post('categoria', TRUE));
        $descripcion = trim($this->input->post('descripcion', TRUE));
        $valor = $this->input->post('valor');
        $fecha = $this->input->post('fecha_egreso', TRUE);
        $metodo = trim($this->input->post('metodo_pago', TRUE));

        $fecha_objeto = DateTime::createFromFormat('Y-m-d', $fecha);

        if (
            $concepto === '' ||
            $categoria === '' ||
            !is_numeric($valor) ||
            $valor <= 0 ||
            !$fecha_objeto ||
            $fecha_objeto->format('Y-m-d') !== $fecha ||
            $fecha > date('Y-m-d') ||
            $metodo === ''
        ) {
            $this->session->set_flashdata(
                'error',
                'Verifica los datos del egreso.'
            );

            redirect('contabilidad/registrar_egreso');
            return;
        }

        $datos = array(
            'id_usuario' => (int) $this->session->userdata('id_usuario'),
            'concepto' => $concepto,
            'categoria' => $categoria,
            'descripcion' => $descripcion,
            'valor' => $valor,
            'fecha_egreso' => $fecha,
            'metodo_pago' => $metodo
        );

        if ($this->Contabilidad_model->registrar_egreso($datos)) {
            $this->session->set_flashdata(
                'exito',
                'Egreso registrado correctamente.'
            );
        } else {
            $this->session->set_flashdata(
                'error',
                'No fue posible registrar el egreso.'
            );
        }

        redirect('contabilidad');
    }

    // Eliminar egreso
    public function eliminar_egreso($id = 0)
    {
        if ($this->input->method() !== 'post') {
            show_404();
            return;
        }

        $id = (int) $id;

        if ($id <= 0 || !$this->Contabilidad_model->obtener_egreso($id)) {
            show_404();
            return;
        }

        if ($this->Contabilidad_model->eliminar_egreso($id)) {
            $this->session->set_flashdata(
                'exito',
                'Egreso eliminado correctamente.'
            );
        } else {
            $this->session->set_flashdata(
                'error',
                'No fue posible eliminar el egreso.'
            );
        }

        redirect('contabilidad');
    }

    // Validar fechas
    private function validar_fechas($desde, $hasta)
    {
        foreach (array($desde, $hasta) as $fecha) {
            if ($fecha !== NULL && $fecha !== '') {
                $objeto = DateTime::createFromFormat('Y-m-d', $fecha);

                if (
                    !$objeto ||
                    $objeto->format('Y-m-d') !== $fecha
                ) {
                    return FALSE;
                }
            }
        }

        if ($desde && $hasta && $desde > $hasta) {
            return FALSE;
        }

        return TRUE;
    }

    public function egresos()
{
    $desde = $this->input->get('desde');
    $hasta = $this->input->get('hasta');

    if (empty($desde) || empty($hasta)) {
        $desde = date('Y-m-01');
        $hasta = date('Y-m-d');
    }

    $data['nombre'] = $this->session->userdata('nombre');
    $data['desde'] = $desde;
    $data['hasta'] = $hasta;

    $data['egresos'] = $this->Contabilidad_model
        ->obtener_egresos($desde, $hasta);

    $data['total_egresos'] = $this->Contabilidad_model
        ->total_egresos($desde, $hasta);

    $data['js_adicional'] = 'public/js/contabilidad.js';

    $this->load->view('Admin/layouts/header', $data);
    $this->load->view('Admin/layouts/sidebar', $data);
    $this->load->view('Admin/funciones/contabilidad/egresos', $data);
    $this->load->view('Admin/layouts/footer');
}

}
