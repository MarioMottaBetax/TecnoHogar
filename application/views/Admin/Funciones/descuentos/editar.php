
<div class="container-fluid py-4">

    <div class="mb-4">
        <a href="<?= base_url('descuentos'); ?>"
           class="text-decoration-none text-muted">
            <i class="bi bi-arrow-left"></i> Volver a descuentos
        </a>

        <h2 class="fw-bold mt-2 mb-1">Editar cupón</h2>
        <p class="text-muted mb-0">
            Modifica el usuario destinatario o el valor del cupón.
        </p>
    </div>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger">
            <?= html_escape($this->session->flashdata('error')); ?>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <form action="<?= base_url('descuentos/actualizar/' . $descuento->id_descuento); ?>"
                  method="POST"
                  id="formDescuento">

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Usuario destinatario
                        </label>

                        <select name="id_usuario"
                                class="form-select"
                                required>

                            <?php foreach ($usuarios as $u): ?>
                                <option value="<?= (int) $u->id_usuario; ?>"
                                    <?= (int) $u->id_usuario === (int) $descuento->id_usuario ? 'selected' : ''; ?>>
                                    <?= html_escape($u->nombre_completo); ?>
                                    - <?= html_escape($u->correo); ?>
                                </option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Valor del cupón (COP)
                        </label>

                        <input type="number"
                               name="cupon"
                               id="valorCupon"
                               class="form-control"
                               min="1"
                               step="0.01"
                               value="<?= html_escape($descuento->cupon); ?>"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Compra mínima requerida
                        </label>

                        <input type="text"
                               id="compraMinima"
                               class="form-control bg-light"
                               readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Porcentaje de descuento
                        </label>

                        <input type="text"
                               class="form-control bg-light"
                               value="10 %"
                               readonly>
                    </div>

                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">

                    <a href="<?= base_url('descuentos'); ?>"
                       class="btn btn-outline-secondary">
                        Cancelar
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>
                        Guardar cambios
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>
