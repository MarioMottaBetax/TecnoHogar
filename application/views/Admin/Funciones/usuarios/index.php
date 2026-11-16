
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Gestión de usuarios</h2>
            <p class="text-muted mb-0">
                Administra los usuarios registrados en TecnoHogar.
            </p>
        </div>

        <a href="<?= base_url('usuarios/crear'); ?>"
           class="btn btn-primary">
            <i class="bi bi-person-plus"></i>
            Nuevo usuario
        </a>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= $this->session->flashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= $this->session->flashdata('error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="table-responsive">
                <table id="tablaUsuarios"
                       class="table table-hover table-striped align-middle w-100">

                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Cédula</th>
                            <th>Celular</th>
                            <th>Correo</th>
                            <th>Rol</th>
                            <th>Ciudad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($usuarios)): ?>
                            <?php foreach ($usuarios as $usuario): ?>

                                <?php
                                    $rol = strtolower(trim($usuario->nombre_rol));

                                    $colores = [
                                        'administrador' => 'badge-rol-admin',
                                        'vendedor'      => 'badge-rol-vendedor',
                                        'técnico'       => 'badge-rol-tecnico',
                                        'tecnico'       => 'badge-rol-tecnico',
                                        'cliente'       => 'badge-rol-cliente'
                                    ];

                                    $colorRol = isset($colores[$rol])
                                        ? $colores[$rol]
                                        : 'bg-secondary';
                                ?>

                                <tr>
                                    <td><?= (int) $usuario->id_usuario; ?></td>

                                    <td>
                                        <strong>
                                            <?= html_escape(
                                                trim(
                                                    $usuario->nombre1 . ' ' .
                                                    $usuario->nombre2 . ' ' .
                                                    $usuario->apellido1 . ' ' .
                                                    $usuario->apellido2
                                                )
                                            ); ?>
                                        </strong>
                                    </td>

                                    <td><?= html_escape($usuario->cedula); ?></td>

                                    <td><?= html_escape($usuario->celular); ?></td>

                                    <td><?= html_escape($usuario->correo); ?></td>

                                    <td>
                                        <span class="badge <?= $colorRol; ?>">
                                            <?= html_escape($usuario->nombre_rol); ?>
                                        </span>
                                    </td>

                                    <td><?= html_escape($usuario->ciudad); ?></td>

                                    <td>
                                        <a href="<?= base_url('usuarios/editar/' . $usuario->id_usuario); ?>"
                                           class="btn btn-sm btn-outline-primary"
                                           title="Editar usuario">
                                            <i class="bi bi-pencil-square"></i>
                                            Editar
                                        </a>
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>
