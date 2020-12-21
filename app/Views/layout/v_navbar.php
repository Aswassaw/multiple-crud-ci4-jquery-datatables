<!-- Mengisi variabel $uri dengan service('uri')/ url saat ini -->
<?php $uri = service('uri'); ?>

<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url() ?>">
            <img src="<?= base_url() ?>/assets/img/logo/logo50px.webp" width="30" height="30" class="d-inline-block align-top" alt="Logo Web" loading="lazy">
            CRUD AJAX
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item <?= ($uri->getSegment(1)) == '' ? 'active' : null ?>">
                    <a class="nav-link" href="<?= base_url('') ?>">Home</a>
                </li>
                <li class="nav-item <?= ($uri->getSegment(1)) == 'user' ? 'active' : null ?>">
                    <a class="nav-link" href="<?= base_url('user') ?>">User</a>
                </li>
            </ul>
        </div>
    </div>
</nav>