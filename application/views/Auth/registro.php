
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta | TecnoHogar</title>

    <link rel="stylesheet" href="<?= base_url('public/css/auth.css'); ?>">
</head>
<body>

<div class="register-container">

    <div class="register-header">
        <div class="brand-icon">T</div>
        <h1>TecnoHogar</h1>
        <p>Tu tecnología, más cerca de ti.</p>
    </div>

    <div class="register-card">

        <div class="form-heading">
            <h2>Crear una cuenta</h2>
            <p>Regístrate para disfrutar de nuestros servicios.</p>
        </div>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-error">
                <?= $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <?php if (validation_errors()): ?>
            <div class="alert alert-error">
                <?= validation_errors(); ?>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('auth/guardar_registro'); ?>" method="POST">

            <!-- INFORMACIÓN PERSONAL -->
            <div class="form-section">
                <h3><span>01</span> Información personal</h3>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="nombre1">Primer nombre *</label>
                        <input type="text" id="nombre1" name="nombre1"
                            value="<?= set_value('nombre1'); ?>"
                            placeholder="Tu primer nombre" required>
                    </div>

                    <div class="form-group">
                        <label for="nombre2">Segundo nombre</label>
                        <input type="text" id="nombre2" name="nombre2"
                            value="<?= set_value('nombre2'); ?>"
                            placeholder="Tu segundo nombre">
                    </div>

                    <div class="form-group">
                        <label for="apellido1">Primer apellido *</label>
                        <input type="text" id="apellido1" name="apellido1"
                            value="<?= set_value('apellido1'); ?>"
                            placeholder="Tu primer apellido" required>
                    </div>

                    <div class="form-group">
                        <label for="apellido2">Segundo apellido</label>
                        <input type="text" id="apellido2" name="apellido2"
                            value="<?= set_value('apellido2'); ?>"
                            placeholder="Tu segundo apellido">
                    </div>

                    <div class="form-group">
                        <label for="cedula">Cédula *</label>
                        <input type="text" id="cedula" name="cedula"
                            value="<?= set_value('cedula'); ?>"
                            placeholder="Número de identificación" required>
                    </div>

                    <div class="form-group">
                        <label for="celular">Celular *</label>
                        <input type="tel" id="celular" name="celular"
                            value="<?= set_value('celular'); ?>"
                            placeholder="Número de contacto" required>
                    </div>
                </div>
            </div>

            <!-- DIRECCIÓN -->
            <div class="form-section">
                <h3><span>02</span> Dirección de residencia</h3>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="departamento">Departamento *</label>
                        <input type="text" id="departamento" name="departamento"
                            value="<?= set_value('departamento'); ?>"
                            placeholder="Ej. Antioquia" required>
                    </div>

                    <div class="form-group">
                        <label for="ciudad">Ciudad o municipio *</label>
                        <input type="text" id="ciudad" name="ciudad"
                            value="<?= set_value('ciudad'); ?>"
                            placeholder="Tu ciudad" required>
                    </div>

                    <div class="form-group">
                        <label for="barrio">Barrio *</label>
                        <input type="text" id="barrio" name="barrio"
                            value="<?= set_value('barrio'); ?>"
                            placeholder="Tu barrio" required>
                    </div>

                    <div class="form-group">
                        <label for="direccion">Dirección *</label>
                        <input type="text" id="direccion" name="direccion"
                            value="<?= set_value('direccion'); ?>"
                            placeholder="Ej. Calle 10 # 20-30" required>
                    </div>

                    <div class="form-group full-width">
                        <label for="referencia">Referencia adicional</label>
                        <input type="text" id="referencia" name="referencia"
                            value="<?= set_value('referencia'); ?>"
                            placeholder="Indicaciones para encontrar tu residencia">
                    </div>
                </div>
            </div>

            <!-- DATOS DE ACCESO -->
            <div class="form-section">
                <h3><span>03</span> Datos de acceso</h3>

                <div class="form-grid">
                    <div class="form-group full-width">
                        <label for="correo">Correo electrónico *</label>
                        <input type="email" id="correo" name="correo"
                            value="<?= set_value('correo'); ?>"
                            placeholder="ejemplo@correo.com" required>
                    </div>

                    <div class="form-group">
                        <label for="contrasena">Contraseña *</label>
                        <input type="password" id="contrasena" name="contrasena"
                            placeholder="Mínimo 8 caracteres"
                            minlength="8" required>
                    </div>

                    <div class="form-group">
                        <label for="confirmar_contrasena">Confirmar contraseña *</label>
                        <input type="password" id="confirmar_contrasena"
                            name="confirmar_contrasena"
                            placeholder="Repite tu contraseña"
                            minlength="8" required>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-register">
                Crear mi cuenta
                <span>→</span>
            </button>

            <p class="login-link">
                ¿Ya tienes una cuenta?
                <a href="<?= site_url('auth/cliente'); ?>">Inicia sesión</a>
            </p>

        </form>
    </div>

    <footer>
        © <?= date('Y'); ?> TecnoHogar. Todos los derechos reservados.
    </footer>

</div>

</body>
</html>
