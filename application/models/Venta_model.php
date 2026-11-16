
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Venta_model extends CI_Model
{
    public function obtener_ventas()
    {
        return $this->db
            ->select('p.*, u.nombre1, u.apellido1, u.cedula')
            ->from('pedidos p')
            ->join('usuarios u', 'u.id_usuario = p.id_usuario')
            ->order_by('p.id_pedido', 'DESC')
            ->get()
            ->result();
    }

    public function obtener_venta($id)
    {
        return $this->db
            ->select('p.*, u.nombre1, u.apellido1, u.cedula, u.correo')
            ->from('pedidos p')
            ->join('usuarios u', 'u.id_usuario = p.id_usuario')
            ->where('p.id_pedido', $id)
            ->get()
            ->row();
    }

    public function obtener_detalles($id)
    {
        return $this->db
            ->select('d.*, pr.nombre_producto')
            ->from('pedido_detalles d')
            ->join('productos pr', 'pr.id_producto = d.id_producto')
            ->where('d.id_pedido', $id)
            ->get()
            ->result();
    }

    public function obtener_clientes()
    {
        return $this->db
            ->where('id_rol', 4)
            ->order_by('nombre1', 'ASC')
            ->get('usuarios')
            ->result();
    }

    public function obtener_productos()
    {
        return $this->db
            ->where('cantidad >', 0)
            ->order_by('nombre_producto', 'ASC')
            ->get('productos')
            ->result();
    }

    

public function registrar_venta(
    $id_usuario,
    $productos,
    $modalidad = 'contado',
    $cuota_inicial = 0,
    $numero_cuotas = 1,
    $id_descuento = null
) {
    $this->db->trans_begin();

    $total = 0;
    $detalles = array();

    // Consultar productos y calcular total
    foreach ($productos as $item) {

        $id_producto = (int) $item['id_producto'];
        $cantidad = (int) $item['cantidad'];

        if ($cantidad < 1) {
            $this->db->trans_rollback();
            return false;
        }

        $producto = $this->db
            ->where('id_producto', $id_producto)
            ->get('productos')
            ->row();

        if (!$producto || $producto->cantidad < $cantidad) {
            $this->db->trans_rollback();
            return false;
        }

        $precio = (float) $producto->precio;
        $meses_garantia = (int) $producto->garantia;
        $subtotal = $precio * $cantidad;

        $total += $subtotal;

        $detalles[] = array(
            'id_producto' => $id_producto,
            'cantidad' => $cantidad,
            'precio_unitario' => $precio,
            'subtotal' => $subtotal,
            'garantia' => $meses_garantia
        );
    }

    if (empty($detalles)) {
        $this->db->trans_rollback();
        return false;
    }

    $total = round($total, 2);
    $total_original = $total;

    // ==========================================
    // VALIDAR Y APLICAR CUPÓN
    // ==========================================

    $descuento_aplicado = 0;

    $id_descuento = !empty($id_descuento)
        ? (int) $id_descuento
        : null;

    if ($id_descuento !== null) {

        $cupon = $this->db->query(
            "SELECT *
            FROM descuentos
            WHERE id_descuento = ?
            AND id_usuario = ?
            AND estado = 1
            FOR UPDATE",
            array($id_descuento, (int) $id_usuario)
        )->row();

        // Comprobar que el cupón exista y pertenezca al cliente
        if (!$cupon) {
            $this->db->trans_rollback();
            return false;
        }

        // Comprobar valor y compra mínima
        if (
            (float) $cupon->cupon <= 0 ||
            (float) $cupon->rango <= 0 ||
            $total_original < (float) $cupon->rango
        ) {
            $this->db->trans_rollback();
            return false;
        }

        $descuento_aplicado = round((float) $cupon->cupon, 2);

        // El descuento no puede ser igual o superior al total
        if ($descuento_aplicado >= $total_original) {
            $this->db->trans_rollback();
            return false;
        }

        // Aplicar descuento
        $total = round(
            $total_original - $descuento_aplicado,
            2
        );
    }

    $cuota_inicial = round((float) $cuota_inicial, 2);

    // ==========================================
    // VALIDAR FINANCIACIÓN
    // ==========================================

    if ($modalidad === 'credito') {

        if (
            $numero_cuotas < 1 ||
            $numero_cuotas > 60 ||
            $cuota_inicial < 0 ||
            $cuota_inicial >= $total
        ) {
            $this->db->trans_rollback();
            return false;
        }

        $saldo_financiado = round(
            $total - $cuota_inicial,
            2
        );

    } else {

        $modalidad = 'contado';
        $cuota_inicial = $total;
        $numero_cuotas = 0;
        $saldo_financiado = 0;
    }

    $fecha_venta = date('Y-m-d H:i:s');

    // ==========================================
    // REGISTRAR PEDIDO
    // ==========================================

    $venta = array(
        'id_usuario' => $id_usuario,
        'fecha' => $fecha_venta,
        'total' => $total,
        // 4 = Aprobado. El estado del pedido es numérico, no texto.
        'estado' => 4,
        'id_descuento' => $id_descuento,
        'descuento_aplicado' => $descuento_aplicado
    );

    $this->db->insert('pedidos', $venta);

    $id_pedido = $this->db->insert_id();

    if (!$id_pedido) {
        $this->db->trans_rollback();
        return false;
    }

    // ==========================================
// MARCAR CUPÓN COMO USADO
// ==========================================

if ($id_descuento !== null) {

    $this->db
        ->where('id_descuento', $id_descuento)
        ->where('id_usuario', (int) $id_usuario)
        ->where('estado', 1)
        ->update('descuentos', array(
            'estado' => 2
        ));

    if ($this->db->affected_rows() !== 1) {
        $this->db->trans_rollback();
        return false;
    }
}

    // ==========================================
    // REGISTRAR DETALLES, GARANTÍAS E INVENTARIO
    // ==========================================

    foreach ($detalles as $detalle) {

        $detalle['id_pedido'] = $id_pedido;

        $this->db->insert('pedido_detalles', $detalle);

        if ($this->db->affected_rows() !== 1) {
            $this->db->trans_rollback();
            return false;
        }

        $id_detalle = $this->db->insert_id();

        // Generar garantía automáticamente
        if ($detalle['garantia'] > 0) {

            $fecha_inicio = new DateTime($fecha_venta);

            $fecha_vencimiento = clone $fecha_inicio;

            $fecha_vencimiento->modify(
                '+' . (int) $detalle['garantia'] . ' months'
            );

            $garantia = array(
                'id_detalle' => $id_detalle,
                'fecha_compra' => $fecha_inicio->format('Y-m-d'),
                'fecha_inicio' => $fecha_inicio->format('Y-m-d'),
                'fecha_vencimiento' => $fecha_vencimiento->format('Y-m-d'),
                'estado_garantia' => 'Vigente'
            );

            $this->db->insert('garantias', $garantia);

            if ($this->db->affected_rows() !== 1) {
                $this->db->trans_rollback();
                return false;
            }
        }

        // Descontar inventario
        $this->db
            ->set(
                'cantidad',
                'cantidad - ' . (int) $detalle['cantidad'],
                false
            )
            ->where('id_producto', $detalle['id_producto'])
            ->where('cantidad >=', $detalle['cantidad'])
            ->update('productos');

        if ($this->db->affected_rows() !== 1) {
            $this->db->trans_rollback();
            return false;
        }
    }

    // ==========================================
    // REGISTRAR CRÉDITO Y CUOTAS
    // ==========================================

    if ($modalidad === 'credito') {

        $credito = array(
            'id_pedido' => $id_pedido,
            'monto_total' => $saldo_financiado,
            'numero_cuotas' => $numero_cuotas
        );

        $this->db->insert('creditos', $credito);

        $id_credito = $this->db->insert_id();

        if (!$id_credito) {
            $this->db->trans_rollback();
            return false;
        }

        // Distribuir cuotas y ajustar el último valor
        $monto_base = floor(
            ($saldo_financiado / $numero_cuotas) * 100
        ) / 100;

        $acumulado = 0;

        $fecha_vencimiento = new DateTime($fecha_venta);

        for ($i = 1; $i <= $numero_cuotas; $i++) {

            $fecha_vencimiento->modify('+1 month');

            if ($i === $numero_cuotas) {

                $monto_cuota = round(
                    $saldo_financiado - $acumulado,
                    2
                );

            } else {

                $monto_cuota = $monto_base;
                $acumulado += $monto_cuota;
            }

            $cuota = array(
                'id_credito' => $id_credito,
                'numero_cuota' => $i,
                'monto_cuota' => $monto_cuota,
                'fecha_vencimiento' => $fecha_vencimiento->format('Y-m-d'),
                'estado' => 1
            );

            $this->db->insert('cuotas_credito', $cuota);

            if ($this->db->affected_rows() !== 1) {
                $this->db->trans_rollback();
                return false;
            }
        }
    }

    // ==========================================
    // REGISTRAR PAGO DE CONTADO O CUOTA INICIAL
    // ==========================================

    if ($cuota_inicial > 0) {

        $id_metodo_efectivo = $this->db
            ->select('id_metodo')
            ->where('nombre_metodo', 'Efectivo')
            ->where('estado', 1)
            ->get('metodo_pago')
            ->row('id_metodo');

        if (!$id_metodo_efectivo) {
            $this->db->trans_rollback();
            return false;
        }

        $pago = array(
            'id_pedido' => $id_pedido,
            'id_cuota' => null,
            'fecha' => $fecha_venta,
            'monto' => $cuota_inicial,
            'id_metodo' => $id_metodo_efectivo,
            'estado' => 'Aprobado',
            'comprobante' => null
        );

        $this->db->insert('pagos', $pago);

        if ($this->db->affected_rows() !== 1) {
            $this->db->trans_rollback();
            return false;
        }
    }

    // ==========================================
    // CONFIRMAR TRANSACCIÓN
    // ==========================================

    if ($this->db->trans_status() === false) {
        $this->db->trans_rollback();
        return false;
    }

    $this->db->trans_commit();

    return $id_pedido;
}



public function obtener_cupones_usuario($id_usuario)
{
    return $this->db
        ->where('id_usuario', (int) $id_usuario)
        ->where('estado', 1)
        ->order_by('id_descuento', 'DESC')
        ->get('descuentos')
        ->result();
}


}
