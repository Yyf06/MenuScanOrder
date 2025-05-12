<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<div class="container">
    <h1 class="mt-5">Welcome <?php if (!empty($username)) : ?>
        <span class="text-primary"><?= htmlspecialchars($username) ?></span>!
    <?php endif; ?></h1>
    <p>Today is: <span class="fw-bold"><?= date('F j, Y') ?></span></p>
    
</div>


<?= $this->endSection() ?>