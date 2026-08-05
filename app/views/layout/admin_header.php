<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : "Panel de Administración" ?></title>

    <!-- CSS GLOBAL -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/global/reset.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/global/layout.css">

    <!-- CSS EXCLUSIVO DEL PANEL ADMIN -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/admin/admin_navbar.css">

    <!-- CSS específico de cada vista -->
    <?php if (isset($cssPagina)) : ?>
        <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/admin/<?= $cssPagina ?>.css">
    <?php endif; ?>
</head>

<body class="admin-body">

    <!-- Barra superior -->
    <div class="barra-superior-admin"></div>

    <!-- Navbar del panel de administración -->
    <?php include __DIR__ . "/admin_navbar.php"; ?>
