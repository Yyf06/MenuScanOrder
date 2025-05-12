<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<main>
      <!--  -->
      <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item ms-3 mt-2"><a href="#">Home</a></li>
          <li class="breadcrumb-item ms-3 mt-2" aria-current="page"><a href="<?= base_url("order_management") ?>">Order Management</a></li>
        </ol>
      </nav>

<!--  -->
<div class="container">
    <div class="row">
        <div class="col mx-2">
            <div class="card text-bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Today's Order</h5>
                    <i class="bi bi-card-checklist fs-1"></i>
                    <p class="card-text text-md-end fs-1"><?= $todaysOrderCount ?></p>
                </div>
            </div>
        </div>

        <div class="col mx-2">
            <div class="card text-bg-success">
                <div class="card-body">
                    <h5 class="card-title">Total Order</h5>
                    <i class="bi bi-clock-history fs-1"></i>
                    <p class="card-text text-md-end fs-1"><?= $totalOrderCount ?></p>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="d-grid gap-2 d-md-flex justify-content-center mt-5">
  
<a href="<?= base_url('order_management/pendingOrder') ?>" class="btn btn-primary">View Current Order</a>
    <a href="<?= base_url('order_management/pastOrder') ?>" class="btn btn-primary">View Past Order</a>
</div>
</main>
<?= $this->endSection() ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    
</script>





</body>
</html>     
      



