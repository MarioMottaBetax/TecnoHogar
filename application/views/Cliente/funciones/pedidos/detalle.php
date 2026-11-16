
<?php
$estados = array(
    2 => 'Pendiente',
    3 => 'En revisión',
    4 => 'Aprobado',
    5 => 'Rechazado',
    6 => 'Finalizado',
    7 => 'Cancelado'
);

$estado = isset($estados[$pedido->estado])
    ? $estados[$pedido->estado]
    : 'Desconocido';
?>

<div class="pedidos-container">

    <div class="pedidos-encabezado">
        <div>
            <h2>Detalle del pedido #<?= (int) $pedido->id_pedido; ?></h2>
            <p>Consulta los productos y la información de tu compra.</p>
        </div>

        <a href="<?= base_url('cliente/pedidos'); ?>"
           class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i>
            Volver a mis pedidos
        </a>
    </div>

    <!-- Información general -->
    <div class="pedido-detalle-resumen">

        <div>
            <span>Número de pedido</span>
            <strong>#<?= (int) $pedido->id_pedido; ?></strong>
        </div>

        <div>
            <span>Fecha</span>
            <strong>
                <?= !empty($pedido->fecha)
                    ? date('d/m/Y', strtotime($pedido->fecha))
                    : 'Sin fecha'; ?>
            </strong>
        </div>

        <div>
            <span>Estado del pedido</span>
            <strong><?= $estado; ?></strong>
        </div>

        <div>
            <span>Total de compra</span>
            <strong class="pedido-total">
                $<?= number_format($pedido->total, 0, ',', '.'); ?>
            </strong>
        </div>

    </div>

    <!-- Productos -->
    <div class="pedido-productos">

        <h4>
            <i class="bi bi-box-seam"></i>
            Productos del pedido
        </h4>

        <?php if (!empty($productos)): ?>

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Categoría</th>
                            <th>Precio unitario</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($productos as $producto): ?>

                            <tr>
                                <td>
                                    <strong>
                                        <?= html_escape($producto->nombre_producto); ?>
                                    </strong>
                                </td>

                                <td>
                                    <?= html_escape($producto->categoria); ?>
                                </td>

                                <td>
                                    $<?= number_format($producto->precio_unitario, 0, ',', '.'); ?>
                                </td>

                                <td>
                                    <?= (int) $producto->cantidad; ?>
                                </td>

                                <td>
                                    <strong>
                                        $<?= number_format($producto->subtotal, 0, ',', '.'); ?>
                                    </strong>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        <?php else: ?>

            <div class="alert alert-info">
                Este pedido no tiene productos registrados.
            </div>

        <?php endif; ?>

        <div class="pedido-total-final">
            <span>Total del pedido</span>
            <strong>
                $<?= number_format($pedido->total, 0, ',', '.'); ?>
            </strong>
        </div>

    </div>

</div>
