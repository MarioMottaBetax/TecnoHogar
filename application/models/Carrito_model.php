
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carrito_model extends CI_Model
{
    // Obtener el carrito activo del cliente
    public function obtener_carrito($id_usuario)
    {
        return $this->db
            ->where('id_usuario', $id_usuario)
            ->where('estado', 1)
            ->get('pedidos')
            ->row();
    }

    // Crear carrito si el cliente no tiene uno
    public function crear_carrito($id_usuario)
    {
        $data = array(
            'id_usuario' => $id_usuario,
            'estado' => 1,
            'total' => 0,
            'id_descuento' => NULL,
            'descuento_aplicado' => 0
        );

        $this->db->insert('pedidos', $data);

        return $this->db->insert_id();
    }

    // Obtener o crear carrito
    public function obtener_o_crear_carrito($id_usuario)
    {
        $carrito = $this->obtener_carrito($id_usuario);

        if ($carrito) {
            return $carrito->id_pedido;
        }

        return $this->crear_carrito($id_usuario);
    }

    // Consultar productos del carrito
    public function obtener_productos_carrito($id_pedido)
    {
        $this->db->select('
            pd.id_detalle,
            pd.id_producto,
            pd.cantidad,
            pd.precio_unitario,
            pd.subtotal,
            p.nombre_producto,
            p.categoria,
            p.cantidad AS existencias
        ');

        $this->db->from('pedido_detalles pd');
        $this->db->join(
            'productos p',
            'p.id_producto = pd.id_producto'
        );
        $this->db->where('pd.id_pedido', $id_pedido);

        return $this->db->get()->result();
    }

    // Agregar producto al carrito
    public function agregar_producto($id_usuario, $id_producto, $cantidad)
    {
        $this->db->trans_begin();

        // Buscar producto y bloquear registro
        $producto = $this->db
            ->where('id_producto', $id_producto)
            ->get('productos')
            ->row();

        if (!$producto || $producto->cantidad < $cantidad || $cantidad < 1) {
            $this->db->trans_rollback();
            return array('success' => false, 'mensaje' => 'Producto sin existencias suficientes.');
        }

        $id_pedido = $this->obtener_o_crear_carrito($id_usuario);

        $detalle = $this->db
            ->where('id_pedido', $id_pedido)
            ->where('id_producto', $id_producto)
            ->get('pedido_detalles')
            ->row();

        $cantidad_final = $cantidad;

        if ($detalle) {
            $cantidad_final += $detalle->cantidad;
        }

        if ($cantidad_final > $producto->cantidad) {
            $this->db->trans_rollback();
            return array('success' => false, 'mensaje' => 'No hay suficientes unidades disponibles.');
        }

        if ($detalle) {
            $this->db
                ->where('id_detalle', $detalle->id_detalle)
                ->update('pedido_detalles', array(
                    'cantidad' => $cantidad_final,
                    'subtotal' => $cantidad_final * $producto->precio
                ));
        } else {
            $this->db->insert('pedido_detalles', array(
                'id_pedido' => $id_pedido,
                'id_producto' => $id_producto,
                'cantidad' => $cantidad,
                'precio_unitario' => $producto->precio,
                'subtotal' => $cantidad * $producto->precio,
                'garantia' => $producto->garantia
            ));
        }

        $this->actualizar_total($id_pedido);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array('success' => false, 'mensaje' => 'No se pudo agregar el producto.');
        }

        $this->db->trans_commit();

        return array('success' => true, 'mensaje' => 'Producto agregado al carrito.');
    }

    // Actualizar cantidad
    public function actualizar_cantidad($id_usuario, $id_detalle, $cantidad)
    {
        if ($cantidad < 1) {
            return false;
        }

        $this->db->trans_begin();

        $carrito = $this->obtener_carrito($id_usuario);

        if (!$carrito) {
            $this->db->trans_rollback();
            return false;
        }

        $detalle = $this->db
            ->where('id_detalle', $id_detalle)
            ->where('id_pedido', $carrito->id_pedido)
            ->get('pedido_detalles')
            ->row();

        if (!$detalle) {
            $this->db->trans_rollback();
            return false;
        }

        $producto = $this->db
            ->where('id_producto', $detalle->id_producto)
            ->get('productos')
            ->row();

        if (!$producto || $cantidad > $producto->cantidad) {
            $this->db->trans_rollback();
            return false;
        }

        $this->db
            ->where('id_detalle', $id_detalle)
            ->update('pedido_detalles', array(
                'cantidad' => $cantidad,
                'subtotal' => $cantidad * $detalle->precio_unitario
            ));

        $this->actualizar_total($carrito->id_pedido);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }

        $this->db->trans_commit();

        return true;
    }

    // Eliminar producto
    public function eliminar_producto($id_usuario, $id_detalle)
    {
        $carrito = $this->obtener_carrito($id_usuario);

        if (!$carrito) {
            return false;
        }

        $eliminado = $this->db
            ->where('id_detalle', $id_detalle)
            ->where('id_pedido', $carrito->id_pedido)
            ->delete('pedido_detalles');

        $filas_eliminadas = $this->db->affected_rows();

        if ($eliminado && $filas_eliminadas > 0) {
            $this->actualizar_total($carrito->id_pedido);
        }

        return $eliminado && $filas_eliminadas > 0;
    }

    // Actualizar total del pedido
    public function actualizar_total($id_pedido)
    {
        $this->db->select_sum('subtotal');
        $this->db->where('id_pedido', $id_pedido);

        $resultado = $this->db->get('pedido_detalles')->row();

        $total = $resultado->subtotal ? $resultado->subtotal : 0;

        $this->db
            ->where('id_pedido', $id_pedido)
            ->update('pedidos', array('total' => $total));

        return $total;
    }


    // Confirmar el pedido del cliente
    // Confirmar compra y registrar el pago
public function confirmar_pedido(
    $id_usuario,
    $id_descuento = NULL,
    $metodo = 'Efectivo',
    $comprobante = NULL,
    $numero_cuotas = 0
) {
    $this->db->trans_begin();

    // Métodos de pago permitidos
    $metodos_permitidos = array('Efectivo', 'Transferencia / Consignación', 'Débito', 'Crédito');

    if (!in_array($metodo, $metodos_permitidos, TRUE)) {
        $this->db->trans_rollback();

        return array(
            'success' => false,
            'mensaje' => 'El método de pago seleccionado no es válido.'
        );
    }

    $id_metodo = $this->db->select('id_metodo')
        ->where('nombre_metodo', $metodo)
        ->where('estado', 1)
        ->get('metodo_pago')
        ->row('id_metodo');

    if (!$id_metodo) {
        $this->db->trans_rollback();
        return array('success' => false, 'mensaje' => 'El método de pago no está disponible.');
    }

    $es_credito = ($metodo === 'Crédito');
    $numero_cuotas = (int) $numero_cuotas;

    if ($es_credito && ($numero_cuotas < 1 || $numero_cuotas > 60)) {
        $this->db->trans_rollback();
        return array('success' => false, 'mensaje' => 'Selecciona entre 1 y 60 cuotas para el crédito.');
    }

    // Buscar y bloquear el carrito activo
    $carrito = $this->db->query(
        "SELECT * FROM pedidos
         WHERE id_usuario = ?
         AND estado = 1
         LIMIT 1
         FOR UPDATE",
        array($id_usuario)
    )->row();

    if (!$carrito) {
        $this->db->trans_rollback();

        return array(
            'success' => false,
            'mensaje' => 'No tienes un carrito activo para confirmar.'
        );
    }

    // Verificar que tenga productos
    $productos = $this->db
        ->where('id_pedido', $carrito->id_pedido)
        ->get('pedido_detalles')
        ->result();

    if (empty($productos)) {
        $this->db->trans_rollback();

        return array(
            'success' => false,
            'mensaje' => 'Tu carrito está vacío.'
        );
    }

    // Verificar existencias actuales
    foreach ($productos as $detalle) {

        $producto = $this->db
            ->where('id_producto', $detalle->id_producto)
            ->get('productos')
            ->row();

        if (
            !$producto ||
            $producto->cantidad < $detalle->cantidad
        ) {
            $this->db->trans_rollback();

            return array(
                'success' => false,
                'mensaje' => 'Uno de los productos ya no tiene existencias suficientes.'
            );
        }
    }

    // Calcular total original
    $total = $this->actualizar_total($carrito->id_pedido);

    if ($total <= 0) {
        $this->db->trans_rollback();

        return array(
            'success' => false,
            'mensaje' => 'El total de la compra no es válido.'
        );
    }

    // Valores iniciales del descuento
    $descuento_aplicado = 0;
    $total_final = $total;

    // Validar cupón si el cliente seleccionó uno
    if (!empty($id_descuento)) {

        $cupon = $this->db->query(
            "SELECT * FROM descuentos
             WHERE id_descuento = ?
             AND id_usuario = ?
             AND estado = 1
             LIMIT 1
             FOR UPDATE",
            array($id_descuento, $id_usuario)
        )->row();

        if (!$cupon) {
            $this->db->trans_rollback();

            return array(
                'success' => false,
                'mensaje' => 'El cupón no existe, no te pertenece o ya fue utilizado.'
            );
        }

        // Verificar compra mínima
        if ($total < $cupon->rango) {
            $this->db->trans_rollback();

            return array(
                'success' => false,
                'mensaje' => 'La compra no alcanza el valor mínimo requerido para utilizar este cupón.'
            );
        }

        // Aplicar siempre el 10 %
        $descuento_aplicado = $this->calcular_descuento($total);
        $total_final = $total - $descuento_aplicado;
    }

    if (!$es_credito) {
        // Un pedido de contado debe tener un único pago principal.
        $pago_existente = $this->db
            ->where('id_pedido', $carrito->id_pedido)
            ->where('id_cuota IS NULL', NULL, FALSE)
            ->get('pagos')
            ->row();

        if ($pago_existente) {
            $this->db->trans_rollback();
            return array('success' => false, 'mensaje' => 'Este pedido ya tiene un pago registrado.');
        }
    }

    // Actualizar el pedido existente
    $this->db
        ->where('id_pedido', $carrito->id_pedido)
        ->where('id_usuario', $id_usuario)
        ->where('estado', 1)
        ->update('pedidos', array(
            // 2 = Pendiente de revisión; 4 = Aprobado.
            'estado' => $es_credito ? 4 : 2,
            'fecha' => date('Y-m-d H:i:s'),
            'total' => $total_final,
            'id_descuento' => !empty($id_descuento)
                ? $id_descuento
                : NULL,
            'descuento_aplicado' => $descuento_aplicado
        ));

    if ($this->db->trans_status() === FALSE ||
        $this->db->affected_rows() !== 1) {

        $this->db->trans_rollback();

        return array(
            'success' => false,
            'mensaje' => 'No fue posible actualizar el pedido.'
        );
    }

    // La reserva se confirma al cerrar la compra: se descuenta inventario
    // y se crean las garantías asociadas a los productos adquiridos.
    foreach ($productos as $detalle) {
        $this->db
            ->set('cantidad', 'cantidad - ' . (int) $detalle->cantidad, FALSE)
            ->where('id_producto', $detalle->id_producto)
            ->where('cantidad >=', $detalle->cantidad)
            ->update('productos');

        if ($this->db->affected_rows() !== 1) {
            $this->db->trans_rollback();
            return array('success' => false, 'mensaje' => 'Las existencias cambiaron antes de confirmar la compra.');
        }

        if ((int) $detalle->garantia > 0) {
            $inicio = new DateTime();
            $vencimiento = clone $inicio;
            $vencimiento->modify('+' . (int) $detalle->garantia . ' months');

            $this->db->insert('garantias', array(
                'tipo' => 1,
                'id_detalle' => $detalle->id_detalle,
                'fecha_compra' => $inicio->format('Y-m-d'),
                'fecha_inicio' => $inicio->format('Y-m-d'),
                'fecha_vencimiento' => $vencimiento->format('Y-m-d'),
                'estado_garantia' => 'Vigente'
            ));

            if ($this->db->affected_rows() !== 1) {
                $this->db->trans_rollback();
                return array('success' => false, 'mensaje' => 'No fue posible generar la garantía del producto.');
            }
        }
    }

    if ($es_credito) {
        $this->db->insert('creditos', array(
            'id_pedido' => $carrito->id_pedido,
            'monto_total' => $total_final,
            'numero_cuotas' => $numero_cuotas
        ));

        $id_credito = $this->db->insert_id();
        if (!$id_credito) {
            $this->db->trans_rollback();
            return array('success' => false, 'mensaje' => 'No fue posible crear el crédito.');
        }

        $monto_base = floor(($total_final / $numero_cuotas) * 100) / 100;
        $acumulado = 0;
        $vencimiento = new DateTime();

        for ($numero = 1; $numero <= $numero_cuotas; $numero++) {
            $vencimiento->modify('+1 month');
            $monto_cuota = ($numero === $numero_cuotas)
                ? round($total_final - $acumulado, 2)
                : $monto_base;
            $acumulado += $monto_cuota;

            $this->db->insert('cuotas_credito', array(
                'id_credito' => $id_credito,
                'numero_cuota' => $numero,
                'monto_cuota' => $monto_cuota,
                'fecha_vencimiento' => $vencimiento->format('Y-m-d'),
                'estado' => 1
            ));

            if ($this->db->affected_rows() !== 1) {
                $this->db->trans_rollback();
                return array('success' => false, 'mensaje' => 'No fue posible generar las cuotas del crédito.');
            }
        }
    } else {
        // Registrar pago pendiente de revisión para métodos de contado.
        $this->db->insert('pagos', array(
            'id_pedido' => $carrito->id_pedido,
            'id_cuota' => NULL,
            'fecha' => date('Y-m-d H:i:s'),
            'monto' => $total_final,
            'id_metodo' => $id_metodo,
            'estado' => 'Pendiente',
            'comprobante' => $comprobante
        ));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array('success' => false, 'mensaje' => 'No fue posible registrar el pago.');
        }
    }

    // Marcar el cupón como utilizado
    if (!empty($id_descuento)) {

        $this->db
            ->where('id_descuento', $id_descuento)
            ->where('id_usuario', $id_usuario)
            ->where('estado', 1)
            ->update('descuentos', array(
                'estado' => 2
            ));

        if (
            $this->db->trans_status() === FALSE ||
            $this->db->affected_rows() !== 1
        ) {
            $this->db->trans_rollback();

            return array(
                'success' => false,
                'mensaje' => 'No fue posible actualizar el estado del cupón.'
            );
        }
    }

    if ($this->db->trans_status() === FALSE) {
        $this->db->trans_rollback();

        return array(
            'success' => false,
            'mensaje' => 'Ocurrió un error al procesar la compra.'
        );
    }

    $this->db->trans_commit();

    return array(
        'success' => true,
        'mensaje' => $es_credito
            ? 'Tu compra a crédito fue aprobada y las cuotas fueron generadas.'
            : 'Tu compra fue registrada correctamente. El pago está pendiente de revisión.',
        'id_pedido' => $carrito->id_pedido,
        'total' => $total_final,
        'descuento' => $descuento_aplicado
    );
}


    // Obtener todos los pedidos del cliente, excepto los carritos activos
    public function obtener_pedidos_cliente($id_usuario)
    {
        return $this->db
            ->select('id_pedido, fecha, total, estado')
            ->from('pedidos')
            ->where('id_usuario', $id_usuario)
            ->where('estado !=', 1)
            ->order_by('fecha', 'DESC')
            ->get()
            ->result();
    }

    // Obtener un pedido específico perteneciente al cliente
    public function obtener_pedido_cliente($id_pedido, $id_usuario)
    {
        return $this->db
            ->where('id_pedido', $id_pedido)
            ->where('id_usuario', $id_usuario)
            ->where('estado !=', 1)
            ->get('pedidos')
            ->row();
    }

    // Obtener los productos de un pedido
    public function obtener_detalles_pedido($id_pedido)
    {
        return $this->db
            ->select('
                pd.id_detalle,
                pd.id_producto,
                pd.cantidad,
                pd.precio_unitario,
                pd.subtotal,
                p.nombre_producto,
                p.categoria
            ')
            ->from('pedido_detalles pd')
            ->join('productos p', 'p.id_producto = pd.id_producto', 'left')
            ->where('pd.id_pedido', $id_pedido)
            ->get()
            ->result();
    }

    // Obtener cupones disponibles del cliente
public function obtener_cupones_disponibles($id_usuario)
{
    return $this->db
        ->where('id_usuario', $id_usuario)
        ->where('estado', 1)
        ->order_by('id_descuento', 'DESC')
        ->get('descuentos')
        ->result();
}

// Calcular el descuento del 10 %
public function calcular_descuento($total)
{
    return round($total * 0.10, 2);
}

// Obtener métodos de pago activos
public function obtener_metodos_pago()
{
    return $this->db
        ->where('estado', 1)
        ->order_by('id_metodo', 'ASC')
        ->get('metodo_pago')
        ->result();
}

}
