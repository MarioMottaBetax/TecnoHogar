
<?php

$conexion = new mysqli(
    'localhost',
    'root',
    '',
    'tecnohogar_db'
);

if ($conexion->connect_error) {
    die('Error de conexión: ' . $conexion->connect_error);
}

$conexion->set_charset('utf8mb4');

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombres = trim($_POST['nombres']);
    $apellidos = trim($_POST['apellidos']);
    $correo = trim($_POST['correo']);
    $password = $_POST['password'];

    if (
        $nombres === '' ||
        $apellidos === '' ||
        !filter_var($correo, FILTER_VALIDATE_EMAIL) ||
        strlen($password) < 8
    ) {
        $mensaje = 'Verifica los datos. La contraseña debe tener al menos 8 caracteres.';

    } else {

        $consulta = $conexion->prepare(
            "SELECT id_usuario FROM usuarios WHERE correo = ?"
        );

        $consulta->bind_param('s', $correo);
        $consulta->execute();
        $consulta->store_result();

        if ($consulta->num_rows > 0) {

            $mensaje = 'Este correo ya está registrado.';

        } else {

            $consulta->close();

            $hash = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $id_rol = 1;

            $insertar = $conexion->prepare(
                "INSERT INTO usuarios
                (id_rol, nombres, apellidos, correo, password, estado)
                VALUES (?, ?, ?, ?, ?, 1)"
            );

            $insertar->bind_param(
                'issss',
                $id_rol,
                $nombres,
                $apellidos,
                $correo,
                $hash
            );

            if ($insertar->execute()) {
                $mensaje = 'Administrador creado correctamente.';
            } else {
                $mensaje = 'No fue posible crear el administrador.';
            }

            $insertar->close();
        }

        if ($consulta) {
            $consulta->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear administrador</title>
</head>
<body>

    <h2>Crear administrador - TecnoHogar</h2>

    <p><?php echo htmlspecialchars($mensaje); ?></p>

    <form method="POST">

        <label>Nombres:</label><br>
        <input type="text" name="nombres" required><br><br>

        <label>Apellidos:</label><br>
        <input type="text" name="apellidos" required><br><br>

        <label>Correo electrónico:</label><br>
        <input type="email" name="correo" required><br><br>

        <label>Contraseña:</label><br>
        <input type="password" name="password"
               minlength="8" required><br><br>

        <button type="submit">
            Crear administrador
        </button>

    </form>

</body>
</html>
