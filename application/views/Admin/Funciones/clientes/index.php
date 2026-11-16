
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h1 class="mb-1">Clientes</h1>
            <p class="text-muted mb-0">
                Administra la información y los datos de tus clientes.
            </p>
        </div>

        <a href="<?= base_url('clientes/crear'); ?>" class="btn btn-primary">
            + Nuevo cliente
        </a>
    </div>

    <?php if ($this->session->flashdata('exito')): ?>
        <div class="alert alert-success">
            <?= $this->session->flashdata('exito'); ?>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger">
            <?= $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">

            <div class="table-responsive">
                <table id="tablaClientes" class="table table-hover table-striped align-middle w-100">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Cédula</th>
                            <th>Celular</th>
                            <th>Correo</th>
                            <th>Ciudad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (!empty($clientes)): ?>

                            <?php foreach ($clientes as $cliente): ?>

                                <tr>
                                    <td><?= $cliente->id_usuario; ?></td>

                                    <td>
                                        <?= html_escape(
                                            trim(
                                                $cliente->nombre1 . ' ' .
                                                $cliente->nombre2 . ' ' .
                                                $cliente->apellido1 . ' ' .
                                                $cliente->apellido2
                                            )
                                        ); ?>
                                    </td>

                                    <td><?= html_escape($cliente->cedula); ?></td>

                                    <td><?= html_escape($cliente->celular); ?></td>

                                    <td><?= html_escape($cliente->correo); ?></td>

                                    <td><?= html_escape($cliente->ciudad); ?></td>

                                    <td>
                                        <a href="<?= base_url('clientes/editar/' . $cliente->id_usuario); ?>"
                                           class="btn btn-sm btn-outline-primary">
                                            Editar
                                        </a>
                                    </td>
                                </tr>

                            <?php endforeach; ?>

                        <?php endif; ?>

                    </tbody>

                </table>
            </div>

            <?php if (empty($clientes)): ?>
                <div class="text-center py-4">
                    <h5>No hay clientes registrados</h5>
                    <p class="text-muted">
                        Los clientes registrados aparecerán aquí.
                    </p>
                </div>
            <?php endif; ?>

        </div>
    </div>
