
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

    <div class="mb-4">
        <h1>Nueva compra</h1>
        <p class="text-muted">
            Registra los productos adquiridos a un proveedor.
        </p>
    </div>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger">
            <?= $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">

            <?= form_open('compras/guardar', array('id' => 'formCompra')); ?>

                <h5 class="mb-3">Información de la compra</h5>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Proveedor *</label>

                        <select name="id_proveedor" class="form-select" required>
                            <option value="">Selecciona un proveedor</option>

                            <?php foreach ($proveedores as $proveedor): ?>
                                <option value="<?= $proveedor->id_proveedor; ?>"
                                    <?= set_select('id_proveedor', $proveedor->id_proveedor); ?>>
                                    <?= html_escape($proveedor->nombre_proveedor); ?>
                                </option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Responsable</label>

                        <input type="text"
                               class="form-control"
                               value="<?= html_escape($nombre); ?>"
                               readonly>
                    </div>

                    <div class="col-12 mb-4">
                        <label class="form-label">Observaciones</label>

                        <textarea name="observaciones"
                                  class="form-control"
                                  rows="2"
                                  placeholder="Información adicional de la compra..."><?= html_escape(set_value('observaciones')); ?></textarea>
                    </div>

                </div>

                <hr>

                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                    <h5 class="mb-0">Productos de la compra</h5>

                    <button type="button" id="agregarProducto" class="btn btn-outline-primary btn-sm">
                        + Agregar producto
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="tablaDetalleCompra">

                        <thead class="table-light">
                            <tr>
                                <th style="min-width: 230px;">Producto</th>
                                <th style="min-width: 120px;">Cantidad</th>
                                <th style="min-width: 160px;">Costo unitario</th>
                                <th style="min-width: 150px;">Subtotal</th>
                                <th style="width: 70px;">Acción</th>
                            </tr>
                        </thead>

                        <tbody id="productosCompra">

                            <tr class="fila-producto">

                                <td>
                                    <select name="id_producto[]" class="form-select producto-select" required>
                                        <option value="">Selecciona producto</option>

                                        <?php foreach ($productos as $producto): ?>
                                            <option value="<?= $producto->id_producto; ?>">
                                                <?= html_escape($producto->nombre_producto); ?>
                                            </option>
                                        <?php endforeach; ?>

                                    </select>
                                </td>

                                <td>
                                    <input type="number"
                                           name="cantidad[]"
                                           class="form-control cantidad-input"
                                           min="1"
                                           step="1"
                                           required>
                                </td>

                                <td>
                                    <input type="number"
                                           name="costo_unitario[]"
                                           class="form-control costo-input"
                                           min="0.01"
                                           step="0.01"
                                           required>
                                </td>

                                <td>
                                    <input type="text"
                                           class="form-control subtotal-input"
                                           value="$0"
                                           readonly>
                                </td>

                                <td>
                                    <button type="button"
                                            class="btn btn-outline-danger btn-sm eliminar-producto"
                                            title="Eliminar producto">
                                        X
                                    </button>
                                </td>

                            </tr>

                        </tbody>

                    </table>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <div class="text-end">
                        <span class="text-muted">Total de la compra</span>
                        <h3 id="totalCompra">$0</h3>
                    </div>
                </div>

                <hr>

                <div class="d-flex gap-2 flex-wrap">
                    <button type="submit" class="btn btn-primary">
                        Registrar compra
                    </button>

                    <a href="<?= base_url('compras'); ?>" class="btn btn-secondary">
                        Cancelar
                    </a>
                </div>

            <?= form_close(); ?>

        </div>
    </div>

