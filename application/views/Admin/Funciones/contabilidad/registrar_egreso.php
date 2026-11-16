
<div class="container-fluid py-4">

    <div class="mb-4">
        <a href="<?= site_url('contabilidad'); ?>" class="text-decoration-none">
            ← Volver a contabilidad
        </a>

        <h2 class="mt-3">Registrar egreso</h2>
        <p class="text-muted">Registra los gastos realizados por el negocio.</p>
    </div>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger">
            <?= $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-header bg-white">
            Información del egreso
        </div>

        <div class="card-body">
            <form method="post"
                  action="<?= site_url('contabilidad/guardar_egreso'); ?>">

                <input type="hidden"
                       name="<?= $this->security->get_csrf_token_name(); ?>"
                       value="<?= $this->security->get_csrf_hash(); ?>">

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Concepto</label>
                        <input type="text" name="concepto"
                               class="form-control" maxlength="150"
                               placeholder="Ej. Pago de arriendo" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Categoría</label>
                        <select name="categoria" class="form-select" required>
                            <option value="">Seleccionar categoría</option>
                            <option value="Arriendo">Arriendo</option>
                            <option value="Nómina">Nómina</option>
                            <option value="Servicios públicos">Servicios públicos</option>
                            <option value="Transporte">Transporte</option>
                            <option value="Mantenimiento">Mantenimiento</option>
                            <option value="Publicidad">Publicidad</option>
                            <option value="Impuestos">Impuestos</option>
                            <option value="Otros">Otros</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Valor del egreso</label>
                        <input type="number" name="valor"
                               class="form-control" min="1"
                               step="0.01" placeholder="Ej. 250000"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Fecha del gasto</label>
                        <input type="date" name="fecha_egreso"
                               class="form-control"
                               max="<?= date('Y-m-d'); ?>"
                               value="<?= date('Y-m-d'); ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Método de pago</label>
                        <select name="metodo_pago" class="form-select" required>
                            <option value="">Seleccionar método</option>
                            <option value="Efectivo">Efectivo</option>
                            <option value="Transferencia">Transferencia</option>
                            <option value="Tarjeta">Tarjeta</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Descripción adicional</label>
                        <textarea name="descripcion" class="form-control"
                                  rows="4"
                                  placeholder="Detalles adicionales del gasto..."></textarea>
                    </div>

                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="<?= site_url('contabilidad'); ?>"
                       class="btn btn-outline-secondary">
                        Cancelar
                    </a>

                    <button type="submit" class="btn btn-primary">
                        Registrar egreso
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>
