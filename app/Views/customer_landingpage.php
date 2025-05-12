<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>customer_landing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
       <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
       <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</head>
<body class="landing">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="<?= base_url('picture/logo.png') ?>" alt="Logo" width="300" class="d-inline-block align-text-top"style="max-height: 70px; object-fit: contain;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?= base_url("{$tableNumber}/{$businessOwnerId}") ?>">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <?php if ($isLoggedIn): ?>
                            <p>Welcome, <?= $username ?> (<?= $userId ?>)</p>
                        <?php endif; ?>
                    </li>
                </ul>
    
                
                <div class="ms-lg-5 d-flex align-items-center">
                <?php if ($isLoggedIn): ?>
                    <div class="ms-lg-5 d-flex align-items-center">
                    <a class="navbar-cart me-3 text-decoration-none text-dark" href="<?= base_url("{$tableNumber}/{$businessOwnerId}/customer/logout") ?>">
                        <i class="bi bi-person-circle me-1"></i>
                        <span class="me-2">Log out</span>
                    </a>
                    </div>
                    <?php else : ?>
                        <a class="navbar-cart me-3 text-decoration-none text-dark" href="<?= base_url('login') ?>?tableNumber=<?= $tableNumber ?>&businessOwnerId=<?= $businessOwnerId ?>">
                            <i class="bi bi-person-circle me-1"></i>
                            <span class="me-2">Log in</span>
                        </a>


                <?php endif; ?>
                 
    
                 
                    <a class="navbar-cart me-3 text-decoration-none text-dark" href="#">
                        <i class="bi bi-basket2-fill me-2"></i><span class="cart-count me-2"></span>
                    </a>
                    <a class="navbar-phone me-3 text-decoration-none text-dark" href="tel:+1123456789">
                        <i class="bi bi-telephone-fill me-2"></i><span class="me-2">07 1234 5678</span>
                    </a>
                </div>
        </div>
    </nav>
<!-- carousel -->
    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="<?= base_url('image/c1.jpg') ?>" class="d-block w-100 img-fluid" alt="...">
          </div>
          <div class="carousel-item">
          <img src="<?= base_url('image/c2.jpg') ?>" class="d-block w-100 img-fluid" alt="...">
          </div>
          <div class="carousel-item">
            <img src="<?= base_url('image/c3.jpg') ?>" class="d-block w-100 img-fluid" alt="...">
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
<!-- carousel end -->
    

<div class="container">
    <p class="fw-bold fs-6 text-center mt-4">Welcome to <?= $restaurantName ?> Restaurant<br> Your Table: <?= $tableNumber ?></p>
    <hr class="my-1">
    
    <h3 class="mt-5 fs-4">Best Seller</h3>
<div class="row justify-content-center">
    <?php foreach ($bestSellers as $bestSeller): ?>
        <div class="col-lg-4 col-sm-3 mb-4 mt-5">
            <div class="card">
                <img src="<?= base_url('image/' . esc($bestSeller['img'])) ?>" class="card-img-top img-fluid" alt="<?= $bestSeller['name'] ?>">
                <div class="card-body d-flex flex-column align-items-center">
                    <h5 class="card-title item-description"><?= $bestSeller['name'] ?></h5>
                    <p class="card-text item-price">$<?= $bestSeller['price'] ?></p>
                    <a href="#" class="btn btn-primary btn-add-to-cart"><i class="bi bi-bag-plus me-2"></i>Add to Cart</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>




     <!-- Category section -->
     <div class="container text-center">
    <div class="row">
        <?php foreach ($menuItems as $menuItem): ?>
            <div class="card mb-3 mt-5">
                <div class="row g-0 align-items-center justify-content-center">
                    <div class="col-lg-4 col-sm-5">
                        <img src="<?= base_url('image/' . esc($menuItem['img'])) ?>" class="img-fluid rounded-start" style="max-height: 100px;" alt="<?= esc($menuItem['name']) ?>">
                        <a class="attribution" href="https://www.freepik.com/free-photo/delicious-donuts_6190284.htm#&position=0&from_view=search&track=ais&uuid=45c8b6c7-2d9f-4a9c-b64c-6efd80e86334">Image by Racool_studio</a>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?= esc($menuItem['name']) ?></h5>
                            <p class="card-text item-description"><?= esc($menuItem['description']) ?></p>
                            <p class="card-text item-price"><small class="text-body-secondary">$ <?= esc($menuItem['price']) ?></small> <a href="#" class="btn btn-primary btn-add-to-cart" data-item-name="<?= $menuItem['name'] ?>"><i class="bi bi-bag-plus me-1"></i> Add</a></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>


        <!-- Pagination links -->
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
                <a class="page-link"  href="<?= $currentPage == $totalPages ? '#' : "?page=" . ($currentPage + 1) ?>">Next</a>
            </li>
        </ul>
    </nav>
    </div>
</div>

            

                <!-- Price and Order -->
              
                
                <div class="fixed-bottom bg-light p-3">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="text-start">Estimated Price: <span id="cartTotal">$0.00</span></p>
                            
                            </div>
                            <div class="d-grid gap-2 col-6 mx-auto">
                                <a href="<?= base_url("{$tableNumber}/{$businessOwnerId}/orderconfirm") ?>" class="btn btn-primary">Place Order</a>
                            </div>

                        </div>
                    </div>
                </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
        // Event handler for adding items to the cart
        $('.btn-add-to-cart').on('click', function() {
   

            // Get item details from the card
            var card = $(this).closest(".card");
            var itemName = card.find(".card-title").text();
            var itemDescription = card.find(".item-description").text(); 
            var itemPriceText = card.find(".item-price").text().replace('$', '').trim(); 
            var itemPrice = parseFloat(itemPriceText);

            // Check if item price is valid
            if (!isNaN(itemPrice)) {
                // Create cart item object
                var cartItem = {
                    name: itemName,
                    description: itemDescription,
                    price: itemPrice
                };

                // Retrieve cart data from session storage
                var cartData = JSON.parse(sessionStorage.getItem('cartData')) || [];

                // Add cart item to cart data
                cartData.push(cartItem);

                // Update cart count and total
                var cartCount = parseInt(sessionStorage.getItem('cartCount')) || 0;
                var cartTotal = parseFloat(sessionStorage.getItem('cartTotal')) || 0;
                cartCount++;
                cartTotal += itemPrice;

                // Update sessionStorage with updated cart data, count, and total
                sessionStorage.setItem('cartData', JSON.stringify(cartData));
                sessionStorage.setItem('cartCount', cartCount);
                sessionStorage.setItem('cartTotal', cartTotal);


                // Update cart UI
                $('.cart-count').text(cartCount);
                $('#cartTotal').text('$' + cartTotal.toFixed(2));
            }
        });
        sessionStorage.setItem('cartCount', 0);
        sessionStorage.setItem('cartTotal', 0);
    });
</script>


                
</body>

</html>
