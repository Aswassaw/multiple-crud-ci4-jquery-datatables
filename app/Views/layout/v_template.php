<!doctype html>
<!-- <html oncontextmenu="return false" lang="en"> -->
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="description" content="Aplikasi CRUD CodeIgniter 4 AJAX">
    <meta name="keywords" content="HTML, CSS, JavaScript, PHP, Bootstrap, CodeIgniter">
    <meta name="author" content="Andry Pebrianto">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <!-- Optional CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/font.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/fontawesome/css/all.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.22/datatables.min.css" />

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.22/datatables.min.js"></script>

    <title><?= $title ?></title>
</head>

<body>
    <!-- Memanggil Navbar -->
    <?= $this->include('layout/v_navbar'); ?>

    <!-- Memanggil Noscript -->
    <?= $this->include('layout/v_noscript'); ?>

    <!-- Switch dark mode -->
    <div class="dark-mode">
        <center>
            <!-- Button Mode Gelap -->
            <div class="custom-control custom-switch wadah-tema-mode">
                <input type="checkbox" class="custom-control-input" id="tema-mode">
                <label class="custom-control-label" for="tema-mode">Light</label>
            </div>
        </center>
    </div>

    <!-- Memanggil Modal Pesan Error -->
    <?= $this->include('layout/v_modalerror'); ?>

    <!-- Memanggil Content -->
    <div class="container main-content mb-3">
        <?= $this->renderSection('content'); ?>
    </div>

    <!-- Memanggil Footer -->
    <?= $this->include('layout/v_footer'); ?>

    <!-- Optional JavaScript -->
    <script src="<?= base_url() ?>/assets/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/event.js"></script>

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

</body>

</html>