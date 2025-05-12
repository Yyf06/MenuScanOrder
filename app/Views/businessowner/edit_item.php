<?= $this->extend('template') ?>
<?= $this->section('content') ?>

<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item ms-3 mt-2"><a href="#">Home</a></li>
        <li class="breadcrumb-item ms-3 mt-2"><a href="<?= base_url('menu_management') ?>">Menu Management</a></li>
        <li class="breadcrumb-item ms-3 mt-2" aria-current="page"><a href="#">Edit Menu Items</a></li>
      </ol>
</nav>

<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Edit Menu Item</h2>
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
        <form id="aiForm" action="<?= base_url("menu_management/generate_ai_description/{$menuItem['id']}") ?>" method="POST">
            <div class="mb-3 mt-3">
                <label for="aiDescription" class="form-label">AI Recommended Description</label>
                <textarea class="form-control" id="aiDescription" name="aiDescription" rows="3">
                <?= $menuItem['ai_description'] ?>
                </textarea>
            </div>
            <button type="submit" class="btn btn-primary mt-2 mb-2" id="AIgenerate">Recommend Description</button>
        </form>
        <form id="editItemForm" method="post" action="<?= base_url('menu_management/update_item/'.$menuItem['id']) ?>">
            <div class="mb-3">
                <label for="dishName" class="form-label">Item Name</label>
                <input type="text" class="form-control" id="dishName" name="dishName" placeholder="Enter dish name" value="<?= $menuItem['name'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="text" class="form-control" id="price" name="price" aria-label="Dollar amount (with dot and two decimal places)" placeholder="Enter price" value="<?= $menuItem['price'] ?>" required>
                    <span class="input-group-text">0.00</span>
                </div>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter description" required><?= $menuItem['description'] ?></textarea>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-select" id="category" name="category" required>
                    <option value="appetizer" <?= isset($menuItem['Category_ID']) && $menuItem['Category_ID'] == 'appetizer' ? 'selected' : '' ?>>Cold Dish</option>
                    <option value="main" <?= isset($menuItem['Category_ID']) && $menuItem['Category_ID'] == 'main' ? 'selected' : '' ?>>Mains</option>
                    <option value="dessert" <?= isset($menuItem['Category_ID']) && $menuItem['Category_ID'] == 'dessert' ? 'selected' : '' ?>>Dessert</option>
                    <option value="beverage" <?= isset($menuItem['Category_ID']) && $menuItem['Category_ID'] == 'beverage' ? 'selected' : '' ?>>Beverage</option>
                </select>
            </div>

            <div class="mb-3">
                <img src="<?= base_url('image/' . esc($menuItem['img'])) ?>" class="img-fluid" style="max-height:70px" alt="<?= esc($menuItem['name']) ?>">
                <br>
                <label for="image" class="form-label">Upload Picture</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="bestseller" name="bestseller" <?= isset($menuItem['bestseller']) && $menuItem['bestseller'] ? 'checked' : '' ?>>
                <label class="form-check-label" for="bestseller">Is Best Seller</label>
            </div>
            <button type="submit" class="btn btn-primary" id="updateDishBtn">Update Dish</button>
        </form>

        
    </div>
<?= $this->endSection() ?>


<script>
    document.getElementById('AIgenerate').addEventListener('click', function(event) {
        
        fetch(`<?= base_url('menu_management/generate_ai_description/' . $menuItem['id']) ?>`, {
            method: 'POST'
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json(); 
        })
        .then(data => {
            document.getElementById('aiDescription').value = data.aiDescription;
        })
        .catch(error => {
            console.error('Fetch error:', error.message); 
        });
    });


    document.getElementById('editItemForm').addEventListener('submit', function(event) {
        
        const formData = new FormData(this);

        fetch(this.action, {
            method: this.method,
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to update menu item. Please try again later.');
            }
            return response.json();
        })
        .then(data => {
           

            const successMessage = data.success ? data.success : 'Menu item updated successfully.';
            showAlert(successMessage, 'success');
        })
        .catch(error => {
            console.error(error);

            showAlert(error.message, 'danger');
        });
    });


    function showAlert(message, type) {
        const alertContainer = document.getElementById('alertContainer');
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

</body>
</html>
