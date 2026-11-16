
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<main class="main-content">

    <div class="page-header">
        <div>
            <h1>Editar proveedor</h1>
            <p>Actualiza la información del proveedor.</p>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>

            <?= form_open('proveedores/actualizar/' . $proveedor->id_proveedor); ?>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nombre del proveedor *</label>
                        <input type="text"
                               name="nombre_proveedor"
                               class="form-control"
                               value="<?= html_escape(set_value('nombre_proveedor', $proveedor->nombre_proveedor)); ?>"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">NIT</label>
                        <input type="text"
                               name="nit"
                               class="form-control"
                               value="<?= html_escape(set_value('nit', $proveedor->nit)); ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Celular</label>
                        <input type="text"
                               name="celular"
                               class="form-control"
                               value="<?= html_escape(set_value('celular', $proveedor->celular)); ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Correo electrónico</label>
                        <input type="email"
                               name="correo"
                               class="form-control"
                               value="<?= html_escape(set_value('correo', $proveedor->correo)); ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Departamento</label>
                        <input type="text"
                               name="departamento"
                               class="form-control"
                               value="<?= html_escape(set_value('departamento', $proveedor->departamento)); ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ciudad</label>
                        <input type="text"
                               name="ciudad"
                               class="form-control"
                               value="<?= html_escape(set_value('ciudad', $proveedor->ciudad)); ?>">
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Dirección</label>
                        <input type="text"
                               name="direccion"
                               class="form-control"
                               value="<?= html_escape(set_value('direccion', $proveedor->direccion)); ?>">
                    </div>

                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Guardar cambios
                    </button>

                    <a href="<?= base_url('proveedores'); ?>"
                       class="btn btn-secondary">
                        Cancelar
                    </a>
                </div>

            <?= form_close(); ?>

        </div>
    </div>

</main>
