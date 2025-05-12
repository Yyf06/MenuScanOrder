<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<main class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1 class="mt-5 mb-4">Menu Item Details</h1>
            <p><strong>ID:</strong> <?= $menuItem['id'] ?></p>
            <p><strong>Name:</strong> <?= $menuItem['name'] ?></p>
            <p><strong>Description:</strong> <?= $menuItem['description'] ?></p>
            <p><strong>Price:</strong> <?= $menuItem['price'] ?></p>
            <p><strong>Best Seller:</strong> <?= $isBestSeller ?></p>
            <p><strong>Image:</strong></p>
            <img src="<?= base_url('image/' . esc($menuItem['img'])) ?>" class="img-fluid" alt="<?= esc($menuItem['name']) ?>">
            <a href="<?= base_url('menu_management/edit_item/' . $menuItem['id']) ?>" class="btn btn-primary mt-3">Edit</a>
            <a href="<?= base_url('menu_management') ?>" class="btn btn-secondary mt-3">Go Back</a>
        </div>
    </div>
</main>
<?= $this->endSection() ?>

