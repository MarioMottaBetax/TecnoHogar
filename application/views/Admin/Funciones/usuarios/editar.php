
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Editar usuario</h2>
            <p class="text-muted mb-0">
                Modifica la información de la cuenta seleccionada.
            </p>
        </div>

        <a href="<?= base_url('usuarios'); ?>"
           class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger">
            <?= $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('usuarios/actualizar/' . $usuario->id_usuario); ?>"
          method="POST"
          id="formUsuario">

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Información personal</h5>
            </div>

            <div class="card-body">
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Primer nombre *</label>
                        <input type="text" name="nombre1"
                               class="form-control"
                               value="<?= html_escape($usuario->nombre1); ?>"
                               maxlength="50" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Segundo nombre</label>
                        <input type="text" name="nombre2"
                               class="form-control"
                               value="<?= html_escape($usuario->nombre2); ?>"
                               maxlength="50">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Primer apellido *</label>
                        <input type="text" name="apellido1"
                               class="form-control"
                               value="<?= html_escape($usuario->apellido1); ?>"
                               maxlength="50" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Segundo apellido</label>
                        <input type="text" name="apellido2"
                               class="form-control"
                               value="<?= html_escape($usuario->apellido2); ?>"
                               maxlength="50">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Cédula *</label>
                        <input type="text" name="cedula"
                               class="form-control"
                               value="<?= html_escape($usuario->cedula); ?>"
                               maxlength="20" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Celular *</label>
                        <input type="text" name="celular"
                               class="form-control"
                               value="<?= html_escape($usuario->celular); ?>"
                               maxlength="20" required>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Correo electrónico *</label>
                        <input type="email" name="correo"
                               class="form-control"
                               value="<?= html_escape($usuario->correo); ?>"
                               maxlength="100" required>
                    </div>

                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Ubicación</h5>
            </div>

            <div class="card-body">
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Departamento</label>
                        <input type="text" name="departamento"
                               class="form-control"
                               value="<?= html_escape($usuario->departamento); ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Ciudad</label>
                        <input type="text" name="ciudad"
                               class="form-control"
                               value="<?= html_escape($usuario->ciudad); ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Barrio</label>
                        <input type="text" name="barrio"
                               class="form-control"
                               value="<?= html_escape($usuario->barrio); ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Dirección</label>
                        <input type="text" name="direccion"
                               class="form-control"
                               value="<?= html_escape($usuario->direccion); ?>">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Referencia</label>
                        <input type="text" name="referencia"
                               class="form-control"
                               value="<?= html_escape($usuario->referencia); ?>">
                    </div>

                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Cuenta y permisos</h5>
            </div>

            <div class="card-body">
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Rol *</label>

                        <select name="id_rol" class="form-select" required>
                            <?php foreach ($roles as $rol): ?>
                                <option value="<?= (int) $rol->id_rol; ?>"
                                    <?= ((int) $usuario->id_rol === (int) $rol->id_rol) ? 'selected' : ''; ?>>
                                    <?= html_escape($rol->nombre_rol); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            Nueva contraseña
                        </label>

                        <input type="password"
                               name="contrasena"
                               class="form-control"
                               minlength="8"
                               maxlength="255"
                               autocomplete="new-password">

                        <small class="text-muted">
                            Déjala vacía para conservar la contraseña actual.
                        </small>
                    </div>

                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="<?= base_url('usuarios'); ?>"
               class="btn btn-light">
                Cancelar
            </a>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i>
                Guardar cambios
            </button>
        </div>

    </form>

</div>
