
<div class="container-fluid py-4">

    <div class="mb-4">
        <a href="<?= site_url('servicio_tecnico'); ?>" class="text-decoration-none">
            ← Volver a servicios
        </a>
        <h2 class="mt-2">Registrar servicio técnico</h2>
        <p class="text-muted">Ingresa los datos del equipo y del cliente.</p>
    </div>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger">
            <?= $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>

    <?= form_open('servicio_tecnico/guardar'); ?>

    <div class="card shadow-sm mb-4">
        <div class="card-body">

            <h5 class="mb-3">Información del servicio</h5>

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Cliente</label>
                    <select name="id_usuario" class="form-select" required>
                        <option value="">Seleccionar cliente</option>

                        <?php foreach ($clientes as $cliente): ?>
                            <option value="<?= $cliente->id_usuario; ?>">
                                <?= html_escape(
                                    $cliente->nombre1 . ' ' .
                                    $cliente->apellido1 . ' - ' .
                                    $cliente->cedula
                                ); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tipo de servicio</label>
                    <select name="tipo_servicio" id="tipoServicio" class="form-select" required>
                        <option value="">Seleccionar tipo</option>
                        <option value="1">Garantía</option>
                        <option value="2">Equipo externo</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Nombre del equipo</label>
                    <input type="text" name="nombre_equipo"
                           class="form-control" maxlength="100" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Garantía asociada</label>
                    <select name="id_garantia" class="form-select">
                        <option value="">No aplica (equipo externo)</option>
                        <?php foreach ($garantias as $garantia): ?>
                            <option value="<?= (int) $garantia->id_garantia; ?>">
                                #<?= (int) $garantia->id_garantia; ?> · <?= html_escape($garantia->nombre_producto . ' · ' . $garantia->nombre1 . ' ' . $garantia->apellido1); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <small class="text-muted">Obligatoria únicamente para servicios por garantía.</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Técnico asignado</label>
                    <select name="id_tecnico" class="form-select">
                        <option value="">Dejar sin asignar</option>

                        <?php foreach ($tecnicos as $tecnico): ?>
                            <option value="<?= $tecnico->id_usuario; ?>">
                                <?= html_escape(
                                    $tecnico->nombre1 . ' ' .
                                    $tecnico->apellido1
                                ); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label">Descripción del problema</label>
                    <textarea name="descripcion_problema"
                              class="form-control"
                              rows="4" required></textarea>
                </div>

            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2">
        <a href="<?= site_url('servicio_tecnico'); ?>"
           class="btn btn-outline-secondary">Cancelar</a>

        <button type="submit" class="btn btn-primary">
            Registrar servicio
        </button>
    </div>

    <?= form_close(); ?>

</div>
