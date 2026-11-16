
<div class="pedidos-container">

    <div class="pedidos-encabezado">
        <div>
            <h2>Mis pedidos</h2>
            <p>Consulta tus compras y revisa el estado de cada pedido.</p>
        </div>

        <a href="<?= base_url('cliente/productos'); ?>"
           class="btn btn-outline-primary">
            <i class="bi bi-bag-plus"></i>
            Seguir comprando
        </a>
    </div>

    <?php if (!empty($pedidos)): ?>

        <div class="pedidos-tabla-container">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Pedido</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($pedidos as $pedido): ?>

                            <?php
                                $estados = array(
                                    2 => 'Pendiente',
                                    3 => 'En revisión',
                                    4 => 'Aprobado',
                                    5 => 'Rechazado',
                                    6 => 'Finalizado',
                                    7 => 'Cancelado'
                                );

                                $clases = array(
                                    2 => 'estado-pendiente',
                                    3 => 'estado-revision',
                                    4 => 'estado-aprobado',
                                    5 => 'estado-rechazado',
                                    6 => 'estado-finalizado',
                                    7 => 'estado-cancelado'
                                );

                                $estado = isset($estados[$pedido->estado])
                                    ? $estados[$pedido->estado]
                                    : 'Desconocido';

                                $clase = isset($clases[$pedido->estado])
                                    ? $clases[$pedido->estado]
                                    : 'estado-desconocido';
                            ?>

                            <tr>
                                <td>
                                    <strong>#<?= (int) $pedido->id_pedido; ?></strong>
                                </td>

                                <td>
                                    <?= !empty($pedido->fecha)
                                        ? date('d/m/Y', strtotime($pedido->fecha))
                                        : 'Sin fecha'; ?>
                                </td>

                                <td>
                                    <strong>
                                        $<?= number_format($pedido->total, 0, ',', '.'); ?>
                                    </strong>
                                </td>

                                <td>
                                    <span class="pedido-estado <?= $clase; ?>">
                                        <?= $estado; ?>
                                    </span>
                                </td>

                                <td>
                                    <a
                                        href="<?= base_url('cliente/pedidos/detalle/' . $pedido->id_pedido); ?>"
                                        class="btn btn-sm btn-outline-primary"
                                    >
                                        <i class="bi bi-eye"></i>
                                        Ver detalle
                                    </a>
                                </td>
                            </tr>

                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    <?php else: ?>

        <div class="pedidos-vacio">
            <i class="bi bi-receipt"></i>
            <h3>Aún no tienes pedidos</h3>
            <p>Cuando realices una compra, podrás consultar aquí su información.</p>

            <a href="<?= base_url('cliente/productos'); ?>"
               class="btn btn-primary">
                Explorar productos
            </a>
        </div>

    <?php endif; ?>

</div>
