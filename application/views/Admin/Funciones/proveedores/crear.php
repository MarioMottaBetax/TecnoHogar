
    <div class="page-header">
        <div>
            <h1>Registrar proveedor</h1>
            <p>Ingresa la información del nuevo proveedor.</p>
        </div>
    </div>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger">
            <?= $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>

    <?php if (validation_errors()): ?>
        <div class="alert alert-danger">
            <?= validation_errors(); ?>
        </div>
    <?php endif; ?>

    <div class="content-card">

        <?= form_open('proveedores/guardar'); ?>

        <div class="row g-3">

            <div class="col-md-6">
                <label class="form-label">Nombre del proveedor *</label>
                <input type="text"
                       name="nombre_proveedor"
                       class="form-control"
                       maxlength="120"
                       value="<?= html_escape(set_value('nombre_proveedor')); ?>"
                       required>
            </div>

            <div class="col-md-6">
                <label class="form-label">NIT</label>
                <input type="text"
                       name="nit"
                       class="form-control"
                       maxlength="30"
                       value="<?= html_escape(set_value('nit')); ?>">
            </div>

            <div class="col-md-6">
                <label class="form-label">Celular</label>
                <input type="text"
                       name="celular"
                       class="form-control"
                       maxlength="20"
                       value="<?= html_escape(set_value('celular')); ?>">
            </div>

            <div class="col-md-6">
                <label class="form-label">Correo electrónico</label>
                <input type="email"
                       name="correo"
                       class="form-control"
                       maxlength="100"
                       value="<?= html_escape(set_value('correo')); ?>">
            </div>

            <div class="col-md-6">
                <label class="form-label">Departamento</label>
                <input type="text"
                       name="departamento"
                       class="form-control"
                       maxlength="100"
                       value="<?= html_escape(set_value('departamento')); ?>">
            </div>

            <div class="col-md-6">
                <label class="form-label">Ciudad</label>
                <input type="text"
                       name="ciudad"
                       class="form-control"
                       maxlength="100"
                       value="<?= html_escape(set_value('ciudad')); ?>">
            </div>

            <div class="col-12">
                <label class="form-label">Dirección</label>
                <input type="text"
                       name="direccion"
                       class="form-control"
                       maxlength="200"
                       value="<?= html_escape(set_value('direccion')); ?>">
            </div>

        </div>

        <div class="d-flex gap-2 mt-4">

            <button type="submit" class="btn btn-primary">
                Guardar proveedor
            </button>

            <a href="<?= base_url('proveedores'); ?>"
               class="btn btn-secondary">
                Cancelar
            </a>

        </div>

        <?= form_close(); ?>

    </div>

