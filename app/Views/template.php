<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nav</title>
 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>
   
<nav class="navbar navbar-expand-lg" style="background-color:#eeeeee">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="<?= base_url('picture/logo.png') ?>" alt="Logo" width="300" class="d-inline-block align-text-top" style="max-height: 50px; object-fit: contain;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('landing'); ?>">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Order Management</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo base_url('order_management'); ?>">Order Management</a></li>
                        <li><a class="dropdown-item" href="<?php echo base_url('order_management/pendingOrder') ?>">Current Orders</a></li>
                        <li><a class="dropdown-item" href="<?php echo base_url('order_management/pastOrder') ?>">Past Orders</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Menu Management</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo base_url('menu_management') ?>">Menu Management</a></li>
                        <li><a class="dropdown-item" href="<?php echo base_url('menu_management/category_management') ?>">Category Management</a></li>
                        <li><a class="dropdown-item" href="<?php echo base_url('menu_management/add_item') ?>">Add Menu Items</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('qrcode') ?>">QR code</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('businessowner/logout') ?>">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<main>
    <?= $this->renderSection('content') ?> 
</main>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<?= $this->renderSection('scripts') ?>

</body>
</html>
