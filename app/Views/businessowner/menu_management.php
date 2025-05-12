<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<main>
    <!--  -->
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item ms-3 mt-2"><a href="<?= base_url('landing'); ?>">Home</a></li>
            <li class="breadcrumb-item ms-3 mt-2" aria-current="page"><a href="<?= base_url('menu_management') ?>">Menu Management</a></li>
        </ol>
    </nav>

    <!--  -->
    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Menu Management</h2>
            </div>
            <div class="row mb-4">
                <div class="col-md-6 mb-3 mb-lg-0">
                    <form method="post" action="<?= base_url('menu_management/search'); ?>">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Enter your search..." name="search">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="<?= base_url('menu_management/add_item') ?>" class="btn btn-primary">Add New Item</a>
                </div>

            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Is Best Seller</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($menuItems)): ?>
                    <?php foreach ($menuItems as $menuItem): ?>
                        <tr>
                            <td><?= $menuItem['id'] ?></td>
                            <td><img src="<?= base_url('image/' . esc($menuItem['img'])) ?>" alt="<?= $menuItem['name'] ?>" 
                            class="img-fluid" style="max-width: 30px;"></td>
                            <td><?= $menuItem['name'] ?></td>
                            <td><?= $menuItem['Category_ID'] ?></td>
                            <td><?= $menuItem['price'] ?></td>
                            <td>
                            <div class="description-wrapper">
                            <?= $menuItem['description'] ?>
                               
                            </div>

                            </td>
                            <td><input type="checkbox" <?= $menuItem['is_best_seller'] ? 'checked' : '' ?> disabled></td>
                            <td>
                                <div class="changebutton">
                                <a href="<?= base_url('menu_management/view_item/' . $menuItem['id']) ?>" class="btn btn-sm btn-primary me-2 mb-1"><i class="bi bi-eye-fill"></i></a>
                                <a href="<?= base_url('menu_management/edit_item/' . $menuItem['id']) ?>" class="btn btn-sm btn-info me-2 mb-1"><i class="bi bi-pencil-fill"></i></a>
                                <a href="<?= base_url('/menu_management/delete_item/' . $menuItem['id']) ?>" class="btn btn-sm btn-warning mb-1" onclick="return confirm('Are you sure you want to delete this item?')"><i class="bi bi-dash-circle-fill"></i></a>
                                    </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="6">No menu items found.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?= $currentPage == 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="<?= $currentPage == 1 ? '#' : "?page=" . ($currentPage - 1) ?>" tabindex="-1" aria-disabled="<?= $currentPage == 1 ? 'true' : 'false' ?>">Previous</a>
                    </li>
                    <?php for ($page = 1; $page <= $totalPages; $page++) : ?>
                        <li class="page-item <?= $page == $currentPage ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $page ?>"><?= $page ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?= $currentPage == $totalPages ? 'disabled' : '' ?>">
                        <a class="page-link" href="<?= $currentPage == $totalPages ? '#' : "?page=" . ($currentPage + 1) ?>">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </section>
</main>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
 
</script>

<?= $this->endSection() ?>
</body>
</html>
