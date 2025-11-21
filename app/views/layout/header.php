<!-- app/views/layout/header.php -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RefriServices</title>

    <!-- CSS GLOBAL -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/global/reset.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/global/layout.css">

    <!-- COMPONENTES -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/componentes/header.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/componentes/navbar.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/componentes/footer.css">

    <!-- CSS de página -->
    <?php if (isset($cssPagina)) : ?>
        <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/paginas/<?= $cssPagina ?>.css">
    <?php endif; ?>
</head>

<body>

<header>
    <?php include "barra_superior.php"; ?>
    <?php include "navbar.php"; ?>
</header>

