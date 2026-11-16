
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Registrar abono</h2>
            <p class="text-muted mb-0">Registrar pagos de cuotas pendientes de créditos</p>
        </div>

        <a href="<?= base_url('pagos'); ?>" class="btn btn-outline-secondary">
            Volver a pagos
        </a>
    </div>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger">
            <?= $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>

    <?php if (empty($cuotas)): ?>
        <div class="alert alert-info">
            No hay cuotas pendientes de pago actualmente.
        </div>
    <?php else: ?>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">

                <form action="<?= base_url('pagos/guardar'); ?>" method="POST">

                    <div class="mb-3">
                        <label for="id_cuota" class="form-label fw-semibold">
                            Seleccionar cuota
                        </label>

                        <select name="id_cuota" id="id_cuota"
                                class="form-select" required>
                            <option value="">Seleccione una cuota</option>

                            <?php foreach ($cuotas as $cuota): ?>
                                <option
                                    value="<?= $cuota->id_cuota; ?>"
                                    data-cliente="<?= html_escape($cuota->nombre ?? ''); ?>"
                                    data-credito="<?= $cuota->id_credito; ?>"
                                    data-numero="<?= $cuota->numero_cuota; ?>"
                                    data-valor="<?= $cuota->monto_cuota; ?>"
                                    data-abonado="<?= $cuota->total_abonado ?? 0; ?>"
                                    data-saldo="<?= max(0, $cuota->monto_cuota - ($cuota->total_abonado ?? 0)); ?>"
                                    data-fecha="<?= $cuota->fecha_vencimiento; ?>">
                                    Crédito #<?= $cuota->id_credito; ?>
                                    - Cuota <?= $cuota->numero_cuota; ?>
                                    - <?= html_escape($cuota->nombre ?? 'Cliente'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div id="informacionCuota" class="card bg-light border-0 mb-4"
                         style="display:none;">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">Información de la cuota</h5>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <small class="text-muted">Cliente</small>
                                    <p class="fw-semibold mb-0" id="cliente"></p>
                                </div>

                                <div class="col-md-6">
                                    <small class="text-muted">Crédito</small>
                                    <p class="fw-semibold mb-0" id="credito"></p>
                                </div>

                                <div class="col-md-6">
                                    <small class="text-muted">Número de cuota</small>
                                    <p class="fw-semibold mb-0" id="numeroCuota"></p>
                                </div>

                                <div class="col-md-6">
                                    <small class="text-muted">Vencimiento</small>
                                    <p class="fw-semibold mb-0" id="fechaVencimiento"></p>
                                </div>

                                <div class="col-md-4">
                                    <small class="text-muted">Valor de la cuota</small>
                                    <h5 id="valorCuota" class="fw-bold mb-0"></h5>
                                </div>

                                <div class="col-md-4">
                                    <small class="text-muted">Total abonado</small>
                                    <h5 id="totalAbonado" class="text-success fw-bold mb-0"></h5>
                                </div>

                                <div class="col-md-4">
                                    <small class="text-muted">Saldo pendiente</small>
                                    <h5 id="saldoPendiente" class="text-danger fw-bold mb-0"></h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label for="monto" class="form-label fw-semibold">
                                Valor del abono
                            </label>

                            <input type="number" name="monto" id="monto"
                                   class="form-control" min="1"
                                   step="0.01" required
                                   placeholder="Ingrese el valor del abono">

                            <small class="text-muted">
                                No puede superar el saldo pendiente.
                            </small>
                        </div>

                        <div class="col-md-6">
                            <label for="metodo" class="form-label fw-semibold">
                                Método de pago
                            </label>

                            <select name="metodo" id="metodo"
                                    class="form-select" required>
                                <option value="">Seleccione un método</option>
                                <option value="Efectivo">Efectivo</option>
                                <option value="Transferencia / Consignación">Transferencia / consignación</option>
                                <option value="Débito">Débito</option>
                                <option value="Crédito">Crédito</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="comprobante" class="form-label fw-semibold">
                                Referencia del comprobante (opcional)
                            </label>

                            <input type="text" name="comprobante" id="comprobante"
                                   class="form-control"
                                   maxlength="255"
                                   placeholder="Número o referencia del comprobante">
                        </div>

                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="<?= base_url('pagos'); ?>"
                           class="btn btn-light">
                            Cancelar
                        </a>

                        <button type="submit" class="btn btn-primary"
                                id="btnRegistrar" disabled>
                            Registrar abono
                        </button>
                    </div>

                </form>

            </div>
        </div>

    <?php endif; ?>

</div>

<script src="<?= base_url('public/js/pagos.js'); ?>"></script>
