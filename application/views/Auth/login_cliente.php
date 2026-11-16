
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

        <a href="<?= base_url('portal'); ?>" class="back-link">
            &larr; Volver
        </a>

        <h1>Bienvenido</h1>
        <p>Ingresa a tu cuenta de TecnoHogar</p>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="auth-error">
                <?= html_escape($this->session->flashdata('error')); ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('auth/validar_cliente'); ?>" method="post">

            <label for="correo">Correo electrónico</label>
            <input type="email" id="correo" name="correo"
                   placeholder="ejemplo@correo.com" required>

            <label for="contrasena">Contraseña</label>
            <input type="password" id="contrasena" name="contrasena"
                   placeholder="Ingresa tu contraseña" required>

            <button type="submit">Iniciar sesión</button>

        </form>

        <p class="auth-footer">
            ¿No tienes una cuenta?
            <a href="<?= base_url('auth/registro'); ?>">Regístrate</a>

                </p>
        <?php if ($this->session->flashdata('exito')): ?>
            <div class="alert alert-success">
                <?= $this->session->flashdata('exito'); ?>
            </div>
        <?php endif; ?>
        
    </div>
</div>

</body>
</html>
