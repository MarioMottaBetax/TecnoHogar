
<div class="container-fluid py-4">

    <?php $m = $mantenimiento; ?>

    <div class="mb-4">
        <a href="<?= site_url('servicio_tecnico'); ?>" class="text-decoration-none">
            ← Volver
        </a>
        <h2 class="mt-2">Servicio #<?= (int) $m->id_mantenimiento; ?></h2>
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

    <div class="row g-4">

        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5>Información del servicio</h5>

                    <p><strong>Cliente:</strong>
                        <?= html_escape($m->cliente_nombre . ' ' . $m->cliente_apellido); ?>
                    </p>

                    <p><strong>Equipo:</strong>
                        <?= html_escape($m->nombre_equipo); ?>
                    </p>

                    <p><strong>Tipo:</strong>
                        <?= (int) $m->tipo_servicio === 1 ? 'Garantía' : 'Externo'; ?>
                    </p>

                    <p><strong>Descripción:</strong><br>
                        <?= nl2br(html_escape($m->descripcion_problema)); ?>
                    </p>

                    <p><strong>Fecha de ingreso:</strong>
                        <?= html_escape($m->fecha_ingreso); ?>
                    </p>

                    <p><strong>Fecha de entrega:</strong>
                        <?= $m->fecha_entrega
                            ? html_escape($m->fecha_entrega)
                            : 'Pendiente'; ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5>Asignación de técnico</h5>

                    <?= form_open('servicio_tecnico/asignar_tecnico'); ?>

                    <input type="hidden" name="id_mantenimiento"
                           value="<?= $m->id_mantenimiento; ?>">

                    <label class="form-label">Seleccionar técnico</label>

                    <select name="id_tecnico" class="form-select" required>
                        <option value="">Seleccionar</option>

                        <?php foreach ($tecnicos as $tecnico): ?>
                            <option value="<?= $tecnico->id_usuario; ?>"
                                <?= (int) $m->id_tecnico === (int) $tecnico->id_usuario ? 'selected' : ''; ?>>
                                <?= html_escape($tecnico->nombre1 . ' ' . $tecnico->apellido1); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <button class="btn btn-primary mt-3" type="submit">
                        Asignar técnico
                    </button>

                    <?= form_close(); ?>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">

                    <h5>Diagnóstico y costos</h5>

                    <?= form_open('servicio_tecnico/actualizar_diagnostico'); ?>

                    <input type="hidden" name="id_mantenimiento"
                           value="<?= $m->id_mantenimiento; ?>">

                    <div class="mb-3">
                        <label class="form-label">Diagnóstico</label>
                        <textarea name="diagnostico" class="form-control"
                                  rows="4"><?= html_escape($m->diagnostico); ?></textarea>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Mano de obra</label>
                            <input type="number" min="0" step="0.01"
                                   name="mano_obra" class="form-control"
                                   value="<?= html_escape($m->mano_obra); ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Costo de repuestos</label>
                            <input type="number" min="0" step="0.01"
                                   name="costo_repuestos" class="form-control"
                                   value="<?= html_escape($m->costo_repuestos); ?>" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">
                        Guardar diagnóstico
                    </button>

                    <?= form_close(); ?>

                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Registrar avance</h5>

                    <?= form_open('servicio_tecnico/actualizar_estado'); ?>

                    <input type="hidden" name="id_mantenimiento"
                           value="<?= $m->id_mantenimiento; ?>">

                    <label class="form-label">Estado</label>

                    <select name="estado" class="form-select" required>
                        <option value="">Seleccionar estado</option>
                        <option>En diagnóstico</option>
                        <option>Esperando repuestos</option>
                        <option>En reparación</option>
                        <option>Reparado</option>
                        <option>Entregado</option>
                        <option>No reparable</option>
                    </select>

                    <label class="form-label mt-3">Detalle del avance</label>
                    <textarea name="detalle" class="form-control"
                              rows="3" required></textarea>

                    <button class="btn btn-success mt-3" type="submit">
                        Registrar avance
                    </button>

                    <?= form_close(); ?>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Historial del servicio</h5>

                    <?php if (!empty($seguimientos)): ?>
                        <div class="service-history">
                            <?php foreach ($seguimientos as $s): ?>
                                <div class="service-history-item">
                                    <strong><?= html_escape($s->estado); ?></strong>
                                    <p class="mb-1">
                                        <?= nl2br(html_escape($s->detalle)); ?>
                                    </p>
                                    <small class="text-muted">
                                        <?= html_escape($s->fecha_registro); ?>
                                    </small>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">Todavía no hay avances registrados.</p>
                    <?php endif; ?>

                </div>
            </div>
        </div>

    </div>
</div>
