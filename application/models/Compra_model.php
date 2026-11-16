
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Compra_model extends CI_Model
{
    // Obtener todas las compras
    public function obtener_compras()
    {
        $this->db->select('
            compras.*,
            proveedores.nombre_proveedor,
            usuarios.nombre1,
            usuarios.apellido1
        ');
        $this->db->from('compras');
        $this->db->join(
            'proveedores',
            'proveedores.id_proveedor = compras.id_proveedor'
        );
        $this->db->join(
            'usuarios',
            'usuarios.id_usuario = compras.id_usuario'
        );
        $this->db->order_by('compras.id_compra', 'DESC');

        return $this->db->get()->result();
    }

    // Obtener una compra específica
    public function obtener_compra($id)
    {
        return $this->db
            ->where('id_compra', $id)
            ->get('compras')
            ->row();
    }

    // Obtener los detalles de una compra
    public function obtener_detalles($id)
    {
        $this->db->select('
            compra_detalles.*,
            productos.nombre_producto,
            productos.categoria
        ');
        $this->db->from('compra_detalles');
        $this->db->join(
            'productos',
            'productos.id_producto = compra_detalles.id_producto'
        );
        $this->db->where('compra_detalles.id_compra', $id);

        return $this->db->get()->result();
    }

    // Obtener proveedores activos
    public function obtener_proveedores_activos()
    {
        return $this->db
            ->where('estado', 1)
            ->order_by('nombre_proveedor', 'ASC')
            ->get('proveedores')
            ->result();
    }

    // Obtener productos disponibles
    public function obtener_productos()
    {
        return $this->db
            ->order_by('nombre_producto', 'ASC')
            ->get('productos')
            ->result();
    }

    // Registrar una compra y sus detalles
    public function registrar_compra($cabecera, $detalles)
    {
        $this->db->trans_begin();

        $total = 0;

        foreach ($detalles as $detalle) {
            $total += $detalle['cantidad'] * $detalle['costo_unitario'];
        }

        $cabecera['total'] = $total;
        $cabecera['estado'] = 'Pendiente';

        $this->db->insert('compras', $cabecera);

        $id_compra = $this->db->insert_id();

        if (!$id_compra) {
            $this->db->trans_rollback();
            return false;
        }

        foreach ($detalles as $detalle) {
            $detalle['id_compra'] = $id_compra;
            $detalle['subtotal'] =
                $detalle['cantidad'] * $detalle['costo_unitario'];

            $this->db->insert('compra_detalles', $detalle);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }

        $this->db->trans_commit();

        return $id_compra;
    }

    // Recibir compra y actualizar inventario
    public function recibir_compra($id)
    {
        $this->db->trans_begin();

        // Consultar la compra
        $compra = $this->db
            ->where('id_compra', $id)
            ->get('compras')
            ->row();

        // Solo se reciben compras pendientes
        if (!$compra || $compra->estado !== 'Pendiente') {
            $this->db->trans_rollback();
            return false;
        }

        // Obtener los productos de la compra
        $detalles = $this->db
            ->where('id_compra', $id)
            ->get('compra_detalles')
            ->result();

        if (empty($detalles)) {
            $this->db->trans_rollback();
            return false;
        }

        // Aumentar las existencias
        foreach ($detalles as $detalle) {
            $this->db
                ->set('cantidad', 'cantidad + ' . (int) $detalle->cantidad, false)
                ->where('id_producto', $detalle->id_producto)
                ->update('productos');
        }

        // Cambiar estado de la compra
        $this->db
            ->where('id_compra', $id)
            ->update('compras', array(
                'estado' => 'Recibida',
                'fecha_recepcion' => date('Y-m-d H:i:s')
            ));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }

        $this->db->trans_commit();

        return true;
    }

    // Cancelar una compra pendiente
    public function cancelar_compra($id)
    {
        return $this->db
            ->where('id_compra', $id)
            ->where('estado', 'Pendiente')
            ->update('compras', array(
                'estado' => 'Cancelada'
            ));
    }
}
