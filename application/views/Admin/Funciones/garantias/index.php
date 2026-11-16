
    <div class="page-heading">
        <div>
            <h1>Gestión de garantías</h1>
            <p>Consulta y administra las garantías de los productos vendidos.</p>
        </div>
    </div>

    <!-- MENSAJES -->
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success">
            <?= html_escape($this->session->flashdata('success')); ?>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger">
            <?= html_escape($this->session->flashdata('error')); ?>
        </div>
    <?php endif; ?>

    <!-- TABLA -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <div class="table-responsive">
                <table id="tablaGarantias"
                       class="table table-striped table-hover align-middle w-100">

                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Producto</th>
                            <th>Cliente</th>
                            <th>Cédula</th>
                            <th>Fecha de compra</th>
                            <th>Vencimiento</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($garantias)): ?>

                            <?php foreach ($garantias as $garantia): ?>
                                <tr>
                                    <td>
                                        <?= (int) $garantia->id_garantia; ?>
                                    </td>

                                    <td>
                                        <?= html_escape($garantia->nombre_producto); ?>
                                    </td>

                                    <td>
                                        <?= html_escape(
                                            $garantia->nombre1 . ' ' . $garantia->apellido1
                                        ); ?>
                                    </td>

                                    <td>
                                        <?= html_escape($garantia->cedula); ?>
                                    </td>

                                    <td>
                                        <?= !empty($garantia->fecha_compra)
                                            ? date('d/m/Y', strtotime($garantia->fecha_compra))
                                            : 'No registrada'; ?>
                                    </td>

                                    <td>
                                        <?= !empty($garantia->fecha_vencimiento)
                                            ? date('d/m/Y', strtotime($garantia->fecha_vencimiento))
                                            : 'No registrada'; ?>
                                    </td>

                                    <td>
                                        <?php
                                            $estado = $garantia->estado_garantia;
                                            $clase = 'secondary';

                                            if ($estado === 'Vigente') {
                                                $clase = 'success';
                                            } elseif ($estado === 'Vencida') {
                                                $clase = 'danger';
                                            } elseif ($estado === 'En revisión') {
                                                $clase = 'warning';
                                            } elseif ($estado === 'Anulada') {
                                                $clase = 'secondary';
                                            }
                                        ?>

                                        <span class="badge bg-<?= $clase; ?>">
                                            <?= html_escape($estado); ?>
                                        </span>
                                    </td>

                                    <td>
                                        <a href="<?= base_url('garantias/detalle/' . $garantia->id_garantia); ?>"
                                           class="btn btn-sm btn-outline-primary">
                                            Ver detalle
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        <?php endif; ?>
                    </tbody>

                </table>
            </div>

            <?php if (empty($garantias)): ?>
                <div class="text-center py-4">
                    <h6>No hay garantías registradas</h6>
                    <p class="text-muted mb-0">
                        Las garantías aparecerán aquí cuando se registren ventas
                        de productos que tengan cobertura.
                    </p>
                </div>
            <?php endif; ?>

        </div>
    </div>

