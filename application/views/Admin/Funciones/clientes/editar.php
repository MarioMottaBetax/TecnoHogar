
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<main class="main-content">

    <div class="mb-4">
        <h1 class="mb-1">Editar cliente</h1>
        <p class="text-muted mb-0">
            Modifica la información personal y de contacto del cliente.
        </p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <?= form_open('clientes/actualizar/' . $cliente->id_usuario); ?>

            <h5 class="mb-3">Información personal</h5>

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Primer nombre *</label>
                    <input type="text" name="nombre1" class="form-control"
                           value="<?= set_value('nombre1', $cliente->nombre1); ?>" required>
                    <?= form_error('nombre1', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Segundo nombre</label>
                    <input type="text" name="nombre2" class="form-control"
                           value="<?= set_value('nombre2', $cliente->nombre2); ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Primer apellido *</label>
                    <input type="text" name="apellido1" class="form-control"
                           value="<?= set_value('apellido1', $cliente->apellido1); ?>" required>
                    <?= form_error('apellido1', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Segundo apellido</label>
                    <input type="text" name="apellido2" class="form-control"
                           value="<?= set_value('apellido2', $cliente->apellido2); ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Cédula *</label>
                    <input type="text" name="cedula" class="form-control"
                           value="<?= set_value('cedula', $cliente->cedula); ?>" required>
                    <?= form_error('cedula', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Celular *</label>
                    <input type="text" name="celular" class="form-control"
                           value="<?= set_value('celular', $cliente->celular); ?>" required>
                    <?= form_error('celular', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="col-md-12">
                    <label class="form-label">Correo electrónico *</label>
                    <input type="email" name="correo" class="form-control"
                           value="<?= set_value('correo', $cliente->correo); ?>" required>
                    <?= form_error('correo', '<small class="text-danger">', '</small>'); ?>
                </div>

            </div>

            <hr class="my-4">

            <h5 class="mb-3">Información de ubicación</h5>

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Departamento</label>
                    <input type="text" name="departamento" class="form-control"
                           value="<?= set_value('departamento', $cliente->departamento); ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Ciudad</label>
                    <input type="text" name="ciudad" class="form-control"
                           value="<?= set_value('ciudad', $cliente->ciudad); ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Barrio</label>
                    <input type="text" name="barrio" class="form-control"
                           value="<?= set_value('barrio', $cliente->barrio); ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Dirección</label>
                    <input type="text" name="direccion" class="form-control"
                           value="<?= set_value('direccion', $cliente->direccion); ?>">
                </div>

                <div class="col-md-12">
                    <label class="form-label">Punto de referencia</label>
                    <textarea name="referencia" class="form-control" rows="2"><?= set_value('referencia', $cliente->referencia); ?></textarea>
                </div>

            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end gap-2">

                <a href="<?= base_url('clientes'); ?>" class="btn btn-secondary">
                    Cancelar
                </a>

                <button type="submit" class="btn btn-primary">
                    Guardar cambios
                </button>

            </div>

            <?= form_close(); ?>

        </div>
    </div>

</main>
