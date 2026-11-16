
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= html_escape($titulo); ?></title>
    <link rel="stylesheet" href="<?= base_url('public/css/auth.css'); ?>">
</head>
<body>

<div class="auth-container">
    <div class="auth-card">

        <a href="<?= base_url('portal/administrativo'); ?>" class="back-link">
            &larr; Volver a selección de cargo
        </a>

        <h1>Acceso administrativo</h1>
        <p class="role-message">
                Ingresa como
                <strong class="role-name role-<?= $id_rol; ?>">
                    <?= html_escape($nombre_rol); ?>
                </strong>
        </p>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="auth-error">
                <?= html_escape($this->session->flashdata('error')); ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('auth/validar_admin/' . $id_rol); ?>"
              method="post">

            <label for="correo">Correo electrónico</label>
            <input type="email" id="correo" name="correo"
                   placeholder="Tu correo institucional" required>

            <label for="contrasena">Contraseña</label>
            <input type="password" id="contrasena" name="contrasena"
                   placeholder="Tu contraseña" required>

            <button type="submit">Ingresar</button>

        </form>

    </div>
</div>

</body>
</html>
