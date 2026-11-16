
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Descuento_model extends CI_Model
{
    /**
     * Obtener cupones registrados.
     * Permite filtrar por estado:
     * 0 = Todos
     * 1 = Vigentes
     * 2 = Usados
     */
    public function obtener_descuentos($estado = 0)
    {
        $this->db
            ->select("
                d.id_descuento,
                d.id_usuario,
                d.cupon,
                d.rango,
                d.estado,
                CONCAT_WS(' ',
                    u.nombre1,
                    u.nombre2,
                    u.apellido1,
                    u.apellido2
                ) AS nombre_usuario,
                u.correo
            ")
            ->from('descuentos d')
            ->join('usuarios u', 'u.id_usuario = d.id_usuario', 'left');

        if ((int) $estado === 1 || (int) $estado === 2) {
            $this->db->where('d.estado', (int) $estado);
        }

        return $this->db
            ->order_by('d.id_descuento', 'DESC')
            ->get()
            ->result();
    }

    /**
     * Obtener un cupón por su identificador.
     */
    public function obtener_descuento($id)
    {
        return $this->db
            ->where('id_descuento', $id)
            ->get('descuentos')
            ->row();
    }

    /**
     * Obtener usuarios disponibles para asignar cupones.
     */
    public function obtener_usuarios()
    {
        return $this->db
            ->select("
                id_usuario,
                CONCAT_WS(' ',
                    nombre1,
                    nombre2,
                    apellido1,
                    apellido2
                ) AS nombre_completo,
                correo
            ")
            ->from('usuarios')
            ->order_by('nombre1', 'ASC')
            ->get()
            ->result();
    }

    /**
     * Registrar un cupón.
     * Todo cupón nuevo inicia vigente (estado 1).
     */
    public function registrar_descuento($id_usuario, $cupon)
    {
        $cupon = (float) $cupon;

        if ($cupon <= 0 || !$this->usuario_existe($id_usuario)) {
            return FALSE;
        }

        $datos = array(
            'id_usuario' => (int) $id_usuario,
            'cupon'      => $cupon,
            'rango'      => $cupon * 10,
            'estado'     => 1
        );

        return $this->db->insert('descuentos', $datos);
    }

    /**
     * Actualizar un cupón.
     * No permite modificar cupones que ya fueron utilizados.
     */
    public function actualizar_descuento($id, $id_usuario, $cupon)
    {
        $cupon = (float) $cupon;

        if ($cupon <= 0 || !$this->usuario_existe($id_usuario)) {
            return FALSE;
        }

        $existente = $this->obtener_descuento($id);

        if (!$existente || (int) $existente->estado !== 1) {
            return FALSE;
        }

        $datos = array(
            'id_usuario' => (int) $id_usuario,
            'cupon'      => $cupon,
            'rango'      => $cupon * 10
        );

        return $this->db
            ->where('id_descuento', $id)
            ->where('estado', 1)
            ->update('descuentos', $datos);
    }

    /**
     * Comprobar si existe un usuario.
     */
    private function usuario_existe($id_usuario)
    {
        return $this->db
            ->where('id_usuario', (int) $id_usuario)
            ->count_all_results('usuarios') > 0;
    }

    /**
     * Validar si un cupón puede aplicarse a una compra.
     */
    public function validar_cupon($id_descuento, $total_compra, $id_usuario)
    {
        $cupon = $this->db
            ->where('id_descuento', $id_descuento)
            ->where('id_usuario', $id_usuario)
            ->where('estado', 1)
            ->get('descuentos')
            ->row();

        if (!$cupon) {
            return array(
                'valido' => FALSE,
                'descuento' => 0,
                'mensaje' => 'El cupón no existe, ya fue utilizado o no pertenece a este usuario.'
            );
        }

        if ((float) $total_compra < (float) $cupon->rango) {
            return array(
                'valido' => FALSE,
                'descuento' => 0,
                'mensaje' => 'La compra no alcanza el valor mínimo para utilizar este cupón.'
            );
        }

        return array(
            'valido' => TRUE,
            'descuento' => (float) $cupon->cupon,
            'mensaje' => 'Cupón aplicado correctamente.'
        );
    }

    /**
     * Comprobar si un cupón ya fue utilizado en algún pedido.
     */
    public function tiene_pedidos_asociados($id)
    {
        return $this->db
            ->where('id_descuento', $id)
            ->count_all_results('pedidos') > 0;
    }
}
