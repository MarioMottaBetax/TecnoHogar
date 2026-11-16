
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Servicio_tecnico extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');
        $this->load->helper(array('url', 'form'));
        $this->load->model('Mantenimiento_model');

        if (!$this->session->userdata('logueado')) {
            redirect('portal');
            exit;
        }

        $rol = (int) $this->session->userdata('id_rol');

        if (!in_array($rol, array(1, 3), true)) {
            show_error('No tienes permisos para acceder.', 403);
        }
    }

    private function es_admin()
    {
        return (int) $this->session->userdata('id_rol') === 1;
    }

    private function es_tecnico()
    {
        return (int) $this->session->userdata('id_rol') === 3;
    }

    // Listado
   public function index()
{
    $data['titulo'] = 'Servicio Técnico';
    $data['nombre'] = $this->session->userdata('nombre');

    if ($this->es_admin()) {

        $data['mantenimientos'] =
            $this->Mantenimiento_model->obtener_mantenimientos();

        $data['tecnicos'] =
            $this->Mantenimiento_model->obtener_tecnicos();

        $data['js_adicional'] = 'public/js/servicio_tecnico.js';

        $this->load->view('Admin/layouts/header', $data);
        $this->load->view('Admin/layouts/sidebar', $data);
        $this->load->view('Admin/funciones/servicio_tecnico/index', $data);
        $this->load->view('Admin/layouts/footer', $data);

    } else {

        $id_tecnico = (int) $this->session->userdata('id_usuario');

        $data['mantenimientos'] =
            $this->Mantenimiento_model->obtener_servicios_tecnico($id_tecnico);

        $this->load->view('Tecnico/servicio_tecnico/index', $data);
    }
}
    // Formulario de registro: solo administrador
   
public function crear()
{
    if (!$this->es_admin()) {
        show_error('No tienes permisos para registrar servicios.', 403);
        return;
    }

    $data['titulo'] = 'Registrar servicio técnico';

    // Nombre completo del usuario
    $data['nombre'] = $this->session->userdata('nombre');

    $data['clientes'] = $this->Mantenimiento_model->obtener_clientes();
    $data['tecnicos'] = $this->Mantenimiento_model->obtener_tecnicos();
    $data['garantias'] = $this->Mantenimiento_model->obtener_garantias_vigentes();
    $data['js_adicional'] = 'public/js/servicio_tecnico.js';

    $this->load->view('Admin/layouts/header', $data);
    $this->load->view('Admin/layouts/sidebar', $data);
    $this->load->view(
        'Admin/funciones/servicio_tecnico/registrar',
        $data
    );
    $this->load->view('Admin/layouts/footer', $data);
}


    // Guardar servicio
    public function guardar()
    {
        if (!$this->es_admin() || $this->input->method() !== 'post') {
            show_error('Acceso no autorizado.', 403);
            return;
        }

        $id_usuario = (int) $this->input->post('id_usuario');
        $tipo = (int) $this->input->post('tipo_servicio');

        if ($id_usuario <= 0 || !in_array($tipo, array(1, 2), true)) {
            $this->session->set_flashdata('error', 'Verifica los datos del servicio.');
            redirect('servicio_tecnico/crear');
            return;
        }

        $cliente = $this->db
            ->where('id_usuario', $id_usuario)
            ->where('id_rol', 4)
            ->get('usuarios')
            ->row();

        if (!$cliente) {
            $this->session->set_flashdata('error', 'El cliente seleccionado no es válido.');
            redirect('servicio_tecnico/crear');
            return;
        }

        $nombre_equipo = trim($this->input->post('nombre_equipo', TRUE));
        $descripcion = trim($this->input->post('descripcion_problema', TRUE));

        if ($nombre_equipo === '' || $descripcion === '') {
            $this->session->set_flashdata('error', 'Completa los datos del equipo y del problema.');
            redirect('servicio_tecnico/crear');
            return;
        }

        $id_tecnico = (int) $this->input->post('id_tecnico');
        $id_garantia = (int) $this->input->post('id_garantia');

        if ($id_tecnico > 0) {
            $tecnico = $this->db
                ->where('id_usuario', $id_tecnico)
                ->where('id_rol', 3)
                ->get('usuarios')
                ->row();

            if (!$tecnico) {
                $this->session->set_flashdata('error', 'El técnico seleccionado no es válido.');
                redirect('servicio_tecnico/crear');
                return;
            }
        } else {
            $id_tecnico = NULL;
        }

        if ($tipo === 1 && (!$id_garantia || !$this->Mantenimiento_model->garantia_pertenece_al_cliente($id_garantia, $id_usuario))) {
            $this->session->set_flashdata('error', 'Selecciona una garantía vigente del cliente.');
            redirect('servicio_tecnico/crear');
            return;
        }

        $datos = array(
            'id_usuario' => $id_usuario,
            'tipo_servicio' => $tipo,
            'id_tecnico' => $id_tecnico,
            'nombre_equipo' => $nombre_equipo,
            'descripcion_problema' => $descripcion,
            'diagnostico' => NULL,
            'mano_obra' => 0,
            'costo_repuestos' => 0,
            'total' => 0,
            'fecha_ingreso' => date('Y-m-d H:i:s'),
            'fecha_entrega' => NULL,
            'garantia' => ($tipo === 1 ? $id_garantia : NULL)
        );

        $this->db->trans_begin();

        $registrado = $this->Mantenimiento_model
            ->registrar_mantenimiento($datos);

        if ($registrado) {
            $id = $this->db->insert_id();

            $this->Mantenimiento_model->registrar_seguimiento(array(
                'id_mantenimiento' => $id,
                'estado' => 'Recibido',
                'detalle' => 'Servicio técnico registrado.',
                'fecha_registro' => date('Y-m-d H:i:s')
            ));
        }

        if (!$registrado || $this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', 'No fue posible registrar el servicio.');
            redirect('servicio_tecnico/crear');
            return;
        }

        $this->db->trans_commit();

        $this->session->set_flashdata('exito', 'Servicio técnico registrado correctamente.');
        redirect('servicio_tecnico');
    }

    // Detalle
    public function detalle($id = 0)
    {
        $id = (int) $id;

        $mantenimiento = $this->Mantenimiento_model
            ->obtener_mantenimiento($id);

        if (!$mantenimiento) {
            show_404();
            return;
        }

        if (
            $this->es_tecnico() &&
            (int) $mantenimiento->id_tecnico !==
            (int) $this->session->userdata('id_usuario')
        ) {
            show_error('No tienes permiso para consultar este servicio.', 403);
            return;
        }

        $data['titulo'] = 'Detalle del servicio';
        $data['nombre'] = $this->session->userdata('nombre');
        $data['mantenimiento'] = $mantenimiento;
        $data['seguimientos'] =
            $this->Mantenimiento_model->obtener_seguimientos($id);

        if ($this->es_admin()) {
            $data['tecnicos'] = $this->Mantenimiento_model->obtener_tecnicos();
            $data['js_adicional'] = 'public/js/servicio_tecnico.js';

            $this->load->view('Admin/layouts/header', $data);
            $this->load->view('Admin/layouts/sidebar', $data);
            $this->load->view(
                'Admin/funciones/servicio_tecnico/detalle',
                $data
            );
            $this->load->view('Admin/layouts/footer', $data);
        } else {
            $this->load->view('Tecnico/servicio_tecnico/detalle', $data);
        }
    }

    // Asignar técnico
    public function asignar_tecnico()
    {
        if (!$this->es_admin() || $this->input->method() !== 'post') {
            show_error('Acceso no autorizado.', 403);
            return;
        }

        $id = (int) $this->input->post('id_mantenimiento');
        $id_tecnico = (int) $this->input->post('id_tecnico');

        $servicio = $this->Mantenimiento_model->obtener_mantenimiento($id);

        $tecnico = $this->db
            ->where('id_usuario', $id_tecnico)
            ->where('id_rol', 3)
            ->get('usuarios')
            ->row();

        if (!$servicio || !$tecnico) {
            $this->session->set_flashdata('error', 'Servicio o técnico no válido.');
            redirect('servicio_tecnico');
            return;
        }

        $resultado = $this->Mantenimiento_model
            ->asignar_tecnico($id, $id_tecnico);

        if ($resultado) {
            $this->Mantenimiento_model->registrar_seguimiento(array(
                'id_mantenimiento' => $id,
                'estado' => 'Técnico asignado',
                'detalle' => 'Se asignó el técnico ' .
                    $tecnico->nombre1 . ' ' . $tecnico->apellido1 . '.',
                'fecha_registro' => date('Y-m-d H:i:s')
            ));

            $this->session->set_flashdata('exito', 'Técnico asignado correctamente.');
        } else {
            $this->session->set_flashdata('error', 'No fue posible asignar el técnico.');
        }

        redirect('servicio_tecnico/detalle/' . $id);
    }

    // Actualizar diagnóstico y costos
    public function actualizar_diagnostico()
    {
        if ($this->input->method() !== 'post') {
            show_404();
            return;
        }

        $id = (int) $this->input->post('id_mantenimiento');
        $servicio = $this->Mantenimiento_model->obtener_mantenimiento($id);

        if (!$servicio) {
            show_404();
            return;
        }

        if (
            $this->es_tecnico() &&
            (int) $servicio->id_tecnico !==
            (int) $this->session->userdata('id_usuario')
        ) {
            show_error('No tienes permiso para modificar este servicio.', 403);
            return;
        }

        $diagnostico = trim($this->input->post('diagnostico', TRUE));
        $mano_obra = $this->input->post('mano_obra');
        $repuestos = $this->input->post('costo_repuestos');

        if (
            !is_numeric($mano_obra) || !is_numeric($repuestos) ||
            $mano_obra < 0 || $repuestos < 0
        ) {
            $this->session->set_flashdata('error', 'Los costos deben ser valores numéricos positivos.');
            redirect('servicio_tecnico/detalle/' . $id);
            return;
        }

        $datos = array(
            'diagnostico' => $diagnostico,
            'mano_obra' => $mano_obra,
            'costo_repuestos' => $repuestos,
            'total' => (float) $mano_obra + (float) $repuestos
        );

        if ($this->Mantenimiento_model->actualizar_diagnostico($id, $datos)) {
            $this->Mantenimiento_model->registrar_seguimiento(array(
                'id_mantenimiento' => $id,
                'estado' => 'Diagnóstico actualizado',
                'detalle' => 'Se actualizó el diagnóstico y los costos del servicio.',
                'fecha_registro' => date('Y-m-d H:i:s')
            ));

            $this->session->set_flashdata('exito', 'Diagnóstico actualizado correctamente.');
        } else {
            $this->session->set_flashdata('error', 'No fue posible actualizar el diagnóstico.');
        }

        redirect('servicio_tecnico/detalle/' . $id);
    }

    // Registrar avance o cambiar estado
   public function actualizar_estado()
{
    if ($this->input->method() !== 'post') {
        show_404();
        return;
    }

    $id = (int) $this->input->post('id_mantenimiento');
    $estado = trim($this->input->post('estado', TRUE));
    $detalle = trim($this->input->post('detalle', TRUE));

    $estados = array(
        'En diagnóstico',
        'Esperando repuestos',
        'En reparación',
        'Reparado',
        'Entregado',
        'No reparable'
    );

    $servicio = $this->Mantenimiento_model->obtener_mantenimiento($id);

    if (!$servicio) {
        show_404();
        return;
    }

    if (
        $this->es_tecnico() &&
        (int) $servicio->id_tecnico !==
        (int) $this->session->userdata('id_usuario')
    ) {
        show_error('No tienes permiso para modificar este servicio.', 403);
        return;
    }

    if (!in_array($estado, $estados, TRUE) || $detalle === '') {
        $this->session->set_flashdata('error', 'Selecciona un estado y escribe el avance.');
        redirect('servicio_tecnico/detalle/' . $id);
        return;
    }

    $resultado = $this->Mantenimiento_model
        ->actualizar_estado($id, $estado, $detalle);

    if ($resultado && $estado === 'Entregado') {
        $this->db->where('id_mantenimiento', $id)
            ->update('mantenimiento', array(
                'fecha_entrega' => date('Y-m-d H:i:s')
            ));
    }

    $this->session->set_flashdata(
        $resultado ? 'exito' : 'error',
        $resultado ? 'Avance registrado correctamente.' : 'No fue posible registrar el avance.'
    );

    redirect('servicio_tecnico/detalle/' . $id);
}

// Gestión de técnicos: solo administrador
public function tecnicos()
{
    if (!$this->es_admin()) {
        show_error('No tienes permisos para acceder.', 403);
        return;
    }

    $data['titulo'] = 'Gestión de técnicos';
    $data['nombre'] = $this->session->userdata('nombre');

    $data['tecnicos'] = $this->Mantenimiento_model
        ->obtener_tecnicos_detalle();

    $data['js_adicional'] = 'public/js/servicio_tecnico.js';

    $this->load->view('Admin/layouts/header', $data);
    $this->load->view('Admin/layouts/sidebar', $data);
    $this->load->view('Admin/funciones/servicio_tecnico/tecnico', $data);
    $this->load->view('Admin/layouts/footer', $data);
}

}
