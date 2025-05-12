
<?= $this->extend('template') ?>

<?= $this->section('content') ?>
  
    <main>
        <!--  -->
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
          <ol class="breadcrumb mt-3">
            <li class="breadcrumb-item ms-3 mt-2"><a href="#">Home</a></li>
            <li class="breadcrumb-item ms-3 mt-2"><a href="<?= base_url('menu_management') ?>">Menu Management</a></li>
            <li class="breadcrumb-item ms-3 mt-2" aria-current="page"><a href="#">Category Management</a></li>
          </ol>
        </nav>

        <div class="card col-md-6 mx-auto mb-3">
        <div class="card-body">
            <h5 class="card-title">Add Category</h5>
            <form action="<?= base_url('menu_management/category_management') ?>" method="post" id="addCategoryForm">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="categoryName" name="categoryName" placeholder="Enter category name" aria-label="Category name" aria-describedby="button-addon2">
                    <button class="btn btn-primary" type="submit" id="addCategoryBtn">Add</button>
                </div>
            </form>
        </div>
      </div>
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
      <div class="col-md-6 mx-auto">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Current Categories</h5>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span> ID</span>
                        <span>Name</span>
                        <span>Action</span>
                    </li>
        
                    <?php foreach ($categories as $category): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><?= $category['id'] ?></span>
                            <span><?= $category['name'] ?></span>
                            <form action="<?= base_url('menu_management/category_management/delete/' . $category['id']) ?>" method="post" onsubmit="return confirm('Are you sure you want to delete this category?')">
                                <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                            </form>
                    <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
                </ul>
            </div>
        </div>
    </div>
    </main>

    <?= $this->endSection() ?>
    <?= $this->section('scripts') ?>
  
    <script> 
    
    document.getElementById('addCategoryForm').addEventListener('submit', function(event) {

    const categoryNameInput = document.getElementById('categoryName');
    const categoryName = categoryNameInput.value;

    if (!categoryName.trim()) {
        alertMessage('Please enter a category name.', 'danger');
        return; 
    }

    const data = { name: categoryName };
    const baseUrl = '<?= base_url() ?>';
    const url = `${baseUrl}menu_management/category_management`;

    fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(response => {
    if (!response.ok) {
        throw new Error('Network response was not ok');
    }
    return response.json(); 
    })
    .then(data => {
        alertMessage('Category added successfully!', 'success');
        categoryNameInput.value = ''; 
    })
        .catch(error => {
        console.error('Fetch error:', error.message); 
        alertMessage('Error adding category. Please try again later.', 'danger');
    });
});

function alertMessage(message, type) {
    const alertContainer = document.getElementById('alertContainer');
    const alertElement = document.createElement('div');
    alertElement.className = `alert alert-${type}`;
    alertElement.textContent = message;
    alertContainer.appendChild(alertElement);
    setTimeout(() => alertElement.remove(), 3000); 
}
</script>
    
    
<?= $this->endSection() ?>
