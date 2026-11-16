
    <div class="page-heading">
    <div>
        <h1>Proveedores</h1>
        <p>Administra los proveedores de TecnoHogar.</p>
    </div>

    <a href="<?= base_url('proveedores/crear'); ?>"
       class="btn btn-primary">
        + Nuevo proveedor
    </a>
</div>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success">
            <?= $this->session->flashdata('success'); ?>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger">
            <?= $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>

    <div class="content-card">

        <div class="table-responsive">
            <table id="tablaProveedores" class="table table-striped table-hover align-middle">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Proveedor</th>
                        <th>NIT</th>
                        <th>Celular</th>
                        <th>Correo</th>
                        <th>Ciudad</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($proveedores)): ?>

                        <?php foreach ($proveedores as $proveedor): ?>
                            <tr>
                                <td><?= $proveedor->id_proveedor; ?></td>

                                <td>
                                    <strong>
                                        <?= html_escape($proveedor->nombre_proveedor); ?>
                                    </strong>
                                </td>

                                <td>
                                    <?= !empty($proveedor->nit)
                                        ? html_escape($proveedor->nit)
                                        : 'No registrado'; ?>
                                </td>

                                <td>
                                    <?= !empty($proveedor->celular)
                                        ? html_escape($proveedor->celular)
                                        : 'No registrado'; ?>
                                </td>

                                <td>
                                    <?= !empty($proveedor->correo)
                                        ? html_escape($proveedor->correo)
                                        : 'No registrado'; ?>
                                </td>

                                <td>
                                    <?= !empty($proveedor->ciudad)
                                        ? html_escape($proveedor->ciudad)
                                        : 'No registrada'; ?>
                                </td>

                                <td>
                                    <?php if ((int)$proveedor->estado === 1): ?>
                                        <span class="badge bg-success">Activo</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Inactivo</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <div class="d-flex gap-2">

                                        <a href="<?= base_url('proveedores/editar/'.$proveedor->id_proveedor); ?>"
                                           class="btn btn-sm btn-warning">
                                            Editar
                                        </a>

                                        <form action="<?= base_url('proveedores/cambiar_estado/'.$proveedor->id_proveedor); ?>"
                                              method="post"
                                              onsubmit="return confirm('¿Deseas cambiar el estado de este proveedor?');">

                                            <?php if ($this->config->item('csrf_protection')): ?>
                                                <input type="hidden"
                                                       name="<?= $this->security->get_csrf_token_name(); ?>"
                                                       value="<?= $this->security->get_csrf_hash(); ?>">
                                            <?php endif; ?>

                                            <button type="submit"
                                                    class="btn btn-sm <?= (int)$proveedor->estado === 1 ? 'btn-danger' : 'btn-success'; ?>">
                                                <?= (int)$proveedor->estado === 1 ? 'Desactivar' : 'Activar'; ?>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    <?php endif; ?>
                </tbody>

            </table>
        </div>

        <?php if (empty($proveedores)): ?>
            <div class="text-center py-4">
                <p class="text-muted mb-0">
                    Todavía no hay proveedores registrados.
                </p>
            </div>
        <?php endif; ?>

    </div>
