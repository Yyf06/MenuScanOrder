

<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<main>
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item ms-3 mt-2"><a href="#">Home</a></li>
            <li class="breadcrumb-item ms-3 mt-2" aria-current="page"><a href="<?= base_url("order_management") ?>">Order Management</a></li>
            <li class="breadcrumb-item ms-3 mt-2" aria-current="page"><a href="<?= base_url("order_management/pendingOrder") ?>">Current order</a></li>
        </ol>
    </nav>
    <div id="alertContainer">
            <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success" role="alert">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>
    </div>
    <div class="col-md-6">
        <div class="card mt-3">
            <div class="card-body">
                        <?php foreach ($orders as $order): ?>
                            <p class="card-text text-danger fs-3">Table: <?= $order['tableNumber'] ?> | Order: #<?= $order['orderNumber'] ?></p>
                            <p class="card-text">People: <?= $order['numberOfPeople'] ?></p>
                            <hr>

                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title">Dish Name</h5>
                                </div>
                                <div class="col gap-3">
                                    <h5 class="card-title2">Quantity</h5>
                                </div>
                            </div>

                            <ul class="list-group list-group-flush">
                                <?php foreach ($order['orderItems'] as $item): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center"><?= $item['name'] ?><span class="badge bg-primary"><?= $item['quantity'] ?></span></li>
                                <?php endforeach; ?>
                            </ul>

                            <div class="d-grid gap-2 mt-3 mb-5">
                             <button class="btn btn-danger btn-delete"  href="<?= base_url("pendingOrder/delete/{$order['orderNumber']}") ?>" type="button">Delete Order</button>
                            </div> 
                     
                        <?php endforeach; ?>
                        </div>
        </div>
    </div>
</main>


<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
</script>
<?= $this->endSection() ?>
</body>
</html>

