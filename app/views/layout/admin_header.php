<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : "Admin - RefriServices" ?></title>

    <!-- CSS GLOBAL NECESARIO -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/global/reset.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/global/layout.css">

    <!-- CSS DE COMPONENTES (REUTILIZADOS) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/componentes/header.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/componentes/navbar.css">

    <!-- CSS de página del admin -->
    <?php if (isset($cssPagina)) : ?>
        <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/paginas/<?= $cssPagina ?>.css">
    <?php endif; ?>
</head>

<body class="admin-body">
    <div class="barra-superior-admin"></div>
    <?php include "admin_navbar.php"; ?>
