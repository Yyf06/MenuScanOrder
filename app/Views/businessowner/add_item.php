
<?= $this->extend('template') ?>

<?= $this->section('content') ?>

  <main>
    
     <!-- breadcrumb -->
     <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item ms-3 mt-2"><a href="#">Home</a></li>
        <li class="breadcrumb-item ms-3 mt-2"><a href="<?= base_url('menu_management') ?>">Menu Management</a></li>
        <li class="breadcrumb-item ms-3 mt-2" aria-current="page"><a href="#">Add Menu Items</a></li>
      </ol>
    </nav>



<!-- add-->
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Add Menu Items</h2>
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
           <form method="post" action="<?= base_url('menu_management/add_item') ?>" id="addItemForm" enctype="multipart/form-data">            
            <div class="mb-3">
                <label for="dishName" class="form-label">Item Name</label>
                <input type="text" class="form-control" id="dishName" name="dishName" placeholder="Enter dish name" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="text" class="form-control" id="price" name="price" aria-label="Dollar amount (with dot and two decimal places)" placeholder="Enter price" required>
                    <span class="input-group-text">0.00</span>
                </div>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter description" required></textarea>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-select" id="category" name="category" required>
                    <option selected>Select category</option>
                    <option value="appetizer">Cold Dish</option>
                    <option value="main">Mains</option>
                    <option value="dessert">Dessert</option>
                    <option value="beverage">Beverage</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Upload Picture</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="bestseller" name="bestseller">
                <label class="form-check-label" for="bestseller">Is Best Seller</label>
            </div>
            <button type="submit" class="btn btn-primary" id="addDishBtn">Add Dish</button>
        </form>
    </div>


    <?= $this->endSection() ?>       

    <script>

        document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('addDishBtn').addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);

        fetch('<?= base_url('menu_management/add_item') ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to add menu item. Please try again later.');
            }
            return response.json();
        })
        .then(data => {
        

            const successMessage = 'Menu item added successfully.';
            showSuccessMessage(successMessage);
            document.getElementById('addItemForm').reset();
        })
        .catch(error => {


            showAlert(error.message, 'danger');
        });
    });
});

function showSuccessMessage(message) {
    const successAlert = document.getElementById('successAlert');
    successAlert.innerHTML = message;
    successAlert.style.display = 'block';
}

function showAlert(message, type) {
    const alertContainer = document.getElementById('successAlert');
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const alertHTML = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    alertContainer.innerHTML = alertHTML;
}
</script>


