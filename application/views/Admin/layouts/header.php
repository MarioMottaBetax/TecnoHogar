
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= html_escape($titulo); ?></title>

    <!-- URL base para los archivos JavaScript -->
    <script>
        const BASE_URL = <?= json_encode(base_url()); ?>;
    </script>

    <!-- Bootstrap 5 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <!-- DataTables Bootstrap 5 -->
    <link
        rel="stylesheet"
        href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css"
    >

    <!-- CSS propio de TecnoHogar: SIEMPRE AL FINAL -->
    <link
        rel="stylesheet"
        href="<?= base_url('public/css/admin.css'); ?>"
    >

    <link rel="stylesheet" 
    href="<?= base_url('public/css/servicio_tecnico.css'); ?>"
    >
    
    <link rel="stylesheet" 
    href="<?= base_url('public/css/contabilidad.css'); ?>"
    >


</head>

<body>

<div class="admin-layout">

    <!-- BARRA SUPERIOR -->
    <header class="topbar">

        <div class="topbar-left">

            <button
                class="menu-toggle"
                id="menuToggle"
                type="button"
            >
                ☰
            </button>

            <span class="topbar-title">
                Panel administrativo
            </span>

        </div>

        <div class="topbar-right">

            <span class="admin-user">
                <?= html_escape($nombre); ?>
            </span>

            <a
                href="<?= site_url('auth/cerrar_sesion'); ?>"
                class="logout-link"
            >
                Cerrar sesión
            </a>

        </div>

    </header>
