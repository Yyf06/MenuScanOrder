<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customer Sign up or Login </title>
 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
   
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
  </head>
  <body>
   

    <header>
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
            
                </ul>
    
                
                <div class="ms-lg-5 d-flex align-items-center">
                <?php if ($isLoggedIn): ?>
                    <div class="ms-lg-5 d-flex align-items-center">
                    <a class="navbar-cart me-3 text-decoration-none text-dark" href="<?= base_url('/customer/logout') ?>">
                        <i class="bi bi-person-circle me-1"></i>
                        <span class="me-2">Log out</span>
                    </a>
                    </div>
                    <?php else : ?>
                        <a class="navbar-cart me-3 text-decoration-none text-dark" href="<?= base_url("{$tableNumber}/{$businessOwnerId}/login") ?>">
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
  </header>
  <body>

  <main class="container">
    <div class="jumbotron">
        <h1 class="display-4">Your Table: <?= esc($tableNumber) ?></h1>
        <p>Restaurant Name: <?= esc($restaurantName) ?></p>

        <div class="col-md-6">
            <p class="lead">Cart Total: <span id="cartTotal">$0.00</span></p>
        </div>
        <h2>Order Details</h2>
        <table id="cart-items" class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Dish Name</th>
                    <th scope="col">Price</th>
                </tr>
            </thead>
            <tbody>
   
            </tbody>
        </table>
        <button class="btn btn-primary btn-confirm mb-3">Confirm</button>
    </div>

    
</main>

<footer class="bg-dark text-light py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <p>&copy; 2024 MenuScanOrder. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="#" class="text-light me-3">Privacy Policy</a>
                <a href="#" class="text-light">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
$(document).ready(function() {

    // Retrieve cart data from session storage
    var cartData = JSON.parse(sessionStorage.getItem('cartData')) || [];
    console.log("Retrieved cart data:", cartData);


    updateCartUI(cartData);

    function updateCartUI(cartData) {
        console.log("Updating cart UI...");

        var cartItemsHTML = ''; // Variable to store the HTML for cart items
        var cartTotal = 0; // Variable to store the total price of the cart
        var cartCount = parseInt(sessionStorage.getItem('cartCount')) || 0;

        // Check if cartData has been filled
        if (cartData.length > 0) {
            // Generate HTML for each cart item
            cartData.forEach(function(item) {
                cartItemsHTML += '<tr>' +
                    '<td>' + item.name + '</td>' +
                    '<td>$' + item.price.toFixed(2) + '</td>' +
                    '</tr>';

                cartTotal += item.price; // Add the price of the item to the total
            });
        } else {
            // If cart is empty, display a message
            cartItemsHTML += '<tr><td colspan="2">Cart is empty</td></tr>';
        }

        // Update the cart details table with the generated HTML
        $('#cart-items tbody').html(cartItemsHTML);
        console.log("Updated cart items HTML:", cartItemsHTML);

        // Update the cart total on the page
        $('#cartTotal').text('$' + cartTotal.toFixed(2));
        console.log("Updated cart total:", cartTotal);
        $('.btn-confirm').on('click', function() {
        // Display alert message
        alert("Order is placed successfully!");
        sessionStorage.removeItem('cartData');
        sessionStorage.removeItem('cartCount');
        sessionStorage.removeItem('cartTotal');

        // Update the cart UI to reflect the changes
        updateCartUI([]);
    });
   

    }
});
</script>