<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<main>
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item ms-3 mt-2"><a href="#">Home</a></li>
            <li class="breadcrumb-item ms-3 mt-2" aria-current="page"><a href="<?= base_url("order_management") ?>">Order Management</a></li>
            <li class="breadcrumb-item ms-3 mt-2" aria-current="page"><a href="<?= base_url("order_management/pastOrder") ?>">Past order</a></li>
        </ol>
    </nav>
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
                        <div class="col quantity">
                            <h5 class="card-title2">Quantity</h5>
                        </div>
                    </div>

                    <ul class="list-group list-group-flush">
                        <?php foreach ($order['orderItems'] as $item): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center"><?= $item['name'] ?><span class="badge bg-primary"><?= $item['quantity'] ?></span></li>
                        <?php endforeach; ?>
                    </ul>

                    <div class="d-grid gap-2 mt-3 mb-5">

                    <a class="btn btn-danger" href="<?= base_url("order_management/pastOrder/delete/{$order['orderNumber']}") ?>">Delete Order</a>

                    </div>  
                    <hr>   
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</main>

<?= $this->endSection() ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script>


</script>

</body>
</html>

