
    <div class="page-heading">
        <div>
            <h1>Inventario</h1>
            <p>Administra los productos y las existencias de TecnoHogar.</p>
        </div>

        <a href="<?= base_url('inventario/crear'); ?>"
           class="btn btn-primary">
            + Nuevo producto
        </a>
    </div>

    <!-- INDICADORES -->
    <div class="row g-3 mb-4">

        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <span class="text-muted">Productos registrados</span>
                    <h3 class="fw-bold mb-0">
                        <?= count($productos); ?>
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <span class="text-muted">Productos con inventario bajo</span>
                    <h3 class="fw-bold mb-0">
                        <?php
                        $bajos = 0;
                        foreach ($productos as $producto) {
                            if ($producto->cantidad <= 5) {
                                $bajos++;
                            }
                        }
                        echo $bajos;
                        ?>
                    </h3>
                </div>
            </div>
        </div>

    </div>

    <!-- MENSAJES -->
    <?php if ($this->session->flashdata('exito')): ?>
        <div class="alert alert-success">
            <?= html_escape($this->session->flashdata('exito')); ?>
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

            <div class="mb-3">
                <h5 class="fw-bold mb-1">Listado de productos</h5>
                <p class="text-muted mb-0">
                    Consulta y administra los productos registrados.
                </p>
            </div>

            <div class="table-responsive">
                <table id="tablaInventario"
                       class="table table-striped table-hover align-middle w-100">

                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Producto</th>
                            <th>Categoría</th>
                            <th>Modelo / Detalle</th>
                            <th>Precio</th>
                            <th>Garantía</th>
                            <th>Existencias</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($productos as $producto): ?>
                            <tr>
                                <td><?= $producto->id_producto; ?></td>

                                <td>
                                    <?= html_escape($producto->nombre_producto); ?>
                                </td>

                                <td>
                                    <?= html_escape($producto->categoria); ?>
                                </td>

                                <td>
                                    <?= !empty($producto->modelo_detalle)
                                        ? html_escape($producto->modelo_detalle)
                                        : 'Sin especificar'; ?>
                                </td>

                                <td>
                                    $<?= number_format($producto->precio, 0, ',', '.'); ?>
                                </td>

                                <td>
                                    <?= (int) $producto->garantia; ?> meses
                                </td>

                                <td>
                                    <?= (int) $producto->cantidad; ?>
                                </td>

                                <td>
                                    <?php if ($producto->cantidad <= 5): ?>
                                        <span class="badge bg-danger">
                                            Inventario bajo
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-success">
                                            Disponible
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <a href="<?= base_url('inventario/editar/'.$producto->id_producto); ?>"
                                       class="btn btn-sm btn-outline-primary">
                                        Editar
                                    </a>

                                    <form method="post"
                                          action="<?= base_url('inventario/eliminar/'.$producto->id_producto); ?>"
                                          class="d-inline"
                                          onsubmit="return confirm('¿Seguro que deseas eliminar este producto?');">

                                        <?php if ($this->config->item('csrf_protection')): ?>
                                            <input type="hidden"
                                                   name="<?= $this->security->get_csrf_token_name(); ?>"
                                                   value="<?= $this->security->get_csrf_hash(); ?>">
                                        <?php endif; ?>

                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>

            </div>

            <?php if (empty($productos)): ?>
                <div class="text-center py-4">
                    <h6>No hay productos registrados</h6>
                    <p class="text-muted">
                        Comienza agregando tu primer producto al inventario.
                    </p>
                </div>
            <?php endif; ?>

        </div>
    </div>


<script>
$(document).ready(function () {

    $('#tablaInventario').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.1.8/i18n/es-ES.json'
        },
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100],
        ordering: true,
        searching: true,
        responsive: true
    });

});
</script>


