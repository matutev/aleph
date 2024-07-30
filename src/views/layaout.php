<!DOCTYPE html>
<html lang="es" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aleph</title>
    <link href="<?= $this->basePublicUrl ?>public/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= $this->basePublicUrl ?>public/assets/css/styles.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

    <!-- Begin page content -->
    <main class="flex-shrink-0">
        <div class="container">
            <?php require_once 'src/views/categorias/categorias.php'; ?>
        </div>
    </main>

    <footer class="footer mt-auto py-3 bg-body-tertiary">
        <div class="container">
            <span class="text-body-secondary"> 2024 | Aleph</span>
        </div>
    </footer>

    <script src="<?= $this->basePublicUrl ?>public/assets/js/bootstrap.bundle.min.css"></script>
    <script src="<?= $this->basePublicUrl ?>public/assets/js/jquery.min.js"></script>
    <script src="<?= $this->basePublicUrl ?>public/assets/js/base.js"></script>
</body>

</html>