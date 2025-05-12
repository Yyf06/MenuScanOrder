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
        <nav class="navbar navbar-expand-lg" style="background-color:#eeeeee">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="<?= base_url('picture/logo.png') ?>" alt="Logo" width="300" class="d-inline-block align-text-top"style="max-height: 50px; object-fit: contain;">
                </a> 
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNav">
                  <ul class="navbar-nav ms-auto">
                     
                      <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('login') ?>">Login</a>
                      </li>
                  </ul>
              </div>
          </div>
      </nav>
  </header>
  <body>

  <main>
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <h2 class="text-center mb-4">Sign Up</h2>
                    <?php if (session()->getFlashdata('message')) : ?>
                    <div class="alert alert-success" role="alert">
                        <?= session()->getFlashdata('message')['success'] ?>
                    </div>
                    <?php endif; ?>
                    <form action="<?= base_url("/$tableNumber/$businessOwnerId/customer_signup") ?>" method="post">
                    <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                            <?php if (isset($errors['username'])): ?>
                                <div class="text-danger"><?= $errors['username'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="exampleInputPassword1" required>
                            <?php if (isset($errors['password'])): ?>
                                <div class="text-danger"><?= $errors['password'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                            <?php if (isset($errors['email'])): ?>
                                <div class="text-danger"><?= $errors['email'] ?></div>
                            <?php endif; ?>
                        </div>
                        <button type="submit" class="btn btn-primary">Register</button>
                    </form>
                    <div class="text-center">
                    <h2 class="text-center mb-4">Or Log in with</h2>
                    <a href="<?= base_url('googlelogin') ?>"><img class= "me-3" src="<?= base_url('picture/Google.png') ?>" alt="" style="width: 50px; height: auto;"></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>


