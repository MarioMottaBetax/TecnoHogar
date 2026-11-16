
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_pago_model extends CI_Model {

    public function obtener_pagos_cliente($id_usuario) {
        $this->db->select('
            pg.id_pago,
            pg.id_pedido,
            pg.id_cuota,
            pg.fecha,
            pg.monto,
            mp.nombre_metodo AS metodo,
            pg.estado,
            pg.comprobante
        ');

        $this->db->from('pagos pg');
        $this->db->join('pedidos p', 'p.id_pedido = pg.id_pedido');
        $this->db->join('metodo_pago mp', 'mp.id_metodo = pg.id_metodo', 'left');
        $this->db->where('p.id_usuario', $id_usuario);
        $this->db->order_by('pg.fecha', 'DESC');

        return $this->db->get()->result();
    }

    public function obtener_pago_cliente($id_pago, $id_usuario) {
        $this->db->select('
            pg.id_pago,
            pg.id_pedido,
            pg.id_cuota,
            pg.fecha,
            pg.monto,
            mp.nombre_metodo AS metodo,
            pg.estado,
            pg.comprobante
        ');

        $this->db->from('pagos pg');
        $this->db->join('pedidos p', 'p.id_pedido = pg.id_pedido');
        $this->db->join('metodo_pago mp', 'mp.id_metodo = pg.id_metodo', 'left');
        $this->db->where('pg.id_pago', $id_pago);
        $this->db->where('p.id_usuario', $id_usuario);

        return $this->db->get()->row();
    }
}
