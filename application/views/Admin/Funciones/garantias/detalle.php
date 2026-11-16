
<div class="page-heading">
    <div>
        <h1>Detalle de garantía</h1>
        <p>Consulta la información y administra el estado de esta garantía.</p>
    </div>

    <a href="<?= base_url('garantias'); ?>" class="btn btn-outline-secondary">
        Volver
    </a>
</div>

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

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <h5 class="mb-3">Información de la garantía</h5>

        <div class="row g-3">
            <div class="col-md-4">
                <strong>Número de garantía</strong>
                <p><?= (int) $garantia->id_garantia; ?></p>
            </div>

            <div class="col-md-4">
                <strong>Producto</strong>
                <p><?= html_escape($garantia->nombre_producto); ?></p>
            </div>

            <div class="col-md-4">
                <strong>Fecha de compra</strong>
                <p><?= date('d/m/Y', strtotime($garantia->fecha_compra)); ?></p>
            </div>

            <div class="col-md-4">
                <strong>Inicio de garantía</strong>
                <p><?= date('d/m/Y', strtotime($garantia->fecha_inicio)); ?></p>
            </div>

            <div class="col-md-4">
                <strong>Fecha de vencimiento</strong>
                <p><?= date('d/m/Y', strtotime($garantia->fecha_vencimiento)); ?></p>
            </div>

            <div class="col-md-4">
                <strong>Estado actual</strong>
                <p>
                    <span class="badge bg-primary">
                        <?= html_escape($garantia->estado_garantia); ?>
                    </span>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <h5 class="mb-3">Información del cliente</h5>

        <div class="row g-3">
            <div class="col-md-4">
                <strong>Nombre</strong>
                <p>
                    <?= html_escape($garantia->nombre1 . ' ' . $garantia->apellido1); ?>
                </p>
            </div>

            <div class="col-md-4">
                <strong>Cédula</strong>
                <p><?= html_escape($garantia->cedula); ?></p>
            </div>

            <div class="col-md-4">
                <strong>Correo electrónico</strong>
                <p><?= html_escape($garantia->correo); ?></p>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h5 class="mb-3">Administrar garantía</h5>

        <?= form_open('garantias/actualizar'); ?>

            <input type="hidden" name="id_garantia"
                   value="<?= (int) $garantia->id_garantia; ?>">

            <div class="mb-3">
                <label class="form-label">Estado de la garantía</label>

                <select name="estado_garantia" class="form-select" required>
                    <?php
                    $estados = array(
                        'Vigente',
                        'Vencida',
                        'En revisión',
                        'Anulada'
                    );
                    ?>

                    <?php foreach ($estados as $estado): ?>
                        <option value="<?= html_escape($estado); ?>"
                            <?= $garantia->estado_garantia === $estado ? 'selected' : ''; ?>>
                            <?= html_escape($estado); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Observaciones</label>

                <textarea name="observaciones"
                          class="form-control"
                          rows="4"
                          placeholder="Escribe las observaciones de esta garantía..."><?= html_escape($garantia->observaciones); ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">
                Guardar cambios
            </button>

        <?= form_close(); ?>
    </div>
</div>
