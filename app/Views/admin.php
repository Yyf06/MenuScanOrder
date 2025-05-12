<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin for users subscription</title>    
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
                        <a class="nav-link" href="#"> <span class="badge bg-primary">Admin</span></a>
                    </li>
                      <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/adminlogout') ?>">Logout</a>
                      </li>
                  </ul>
              </div>
          </div>
      </nav>
    </header>
    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">User Management</h2>
            </div>
            <hr>
            <div class="row mb-4">
                <div class="col-md-6 mb-3 mb-lg-0">
                    <h3>Add Users</h3>
                    <form id="addUserForm" action="<?= base_url('/admin/adduser') ?>" method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username">
                            <div id="usernameError" class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <div id="passwordError" class="invalid-feedback"></div>
                        </div>
                        <button type="submit" class="btn btn-primary">Add User</button>
                    </form>

                </div>
                <hr class=" mt-4">
                <h3>Alter Password</h3>
                <form id="alterPasswordform" action="<?= base_url('/admin/alterpassword') ?>" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username_c">
                        <div id="usernameNotFound" class="invalid-feedback"></div>
                    </div>
                    <!-- <div class="mb-3">
                        <label for="userid" class="form-label">UserID</label>
                        <input type="text" class="form-control" id="userid" name="userid">
                        <div id="useridNotFound" class="invalid-feedback"></div>
                    </div> -->
                    <div class="mb-3">
                        <label for="newpassword" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="password" name="password_c">
                    
                    </div>
                    <button type="submit" class="btn btn-danger">Alter Password</button>
                </form>

            </div>
            <hr>
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
            <h3>Users List</h3>
            <table class="table-responsive mb-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th  class="px-3">Username</th>
                        <th>Password</th>
                        <th class="px-3">Businessname</th>
                        <th  class="px-3">Start-date</th>
                        <th>End-date</th>
                        <th>Subscription Plan</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="userList">
                    <?php foreach ($userData as $user): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td class="px-3"><?= $user['username'] ?></td> 
                        <td class="password-column"><?= $user['password_hashed'] ?></td>
                        <td class="px-3"><?= $user['business_name'] ?></td>

                        <?php
                            $startDate = '';
                            $endDate = '';
                            $planName = '';
                            $status = '';

                            foreach ($subscriptions as $subscription) {
                                if ($subscription['user_id'] == $user['id']) {
                                    $planName = $subscription['subscription_plan'];
                                    $startDate = $subscription['start_date'];
                                    $endDate = $subscription['end_date'];
                                    $status = $subscription['status'];
                                    break;
                                }
                            }
                            ?>

                        <td><?= $startDate ?></td>
                        <td><?= $endDate ?></td>
                        <td><?= $planName ?></td>
                        <td><?= $status ?></td>
                        <td class="px-3 changebutton">
                        <a href="<?= base_url('/admin/edit_user/' . $user['id']) ?>" class="btn btn-primary btn-sm btn-info me-2 mb-1"><i class="bi bi-pencil-fill"></i></a>
                        <a href="<?= base_url('/admin/delete_user/' . $user['id']) ?>" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Are you sure you want to delete this user?')"><i class="bi bi-dash-circle-fill"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
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
    
    <script>
    document.getElementById('addUserForm').addEventListener('submit', function (event) {
        var usernameInput = document.getElementById('username');
        var passwordInput = document.getElementById('password');



        if (usernameInput.value.trim() === '') {
            usernameInput.classList.add('is-invalid');
            document.getElementById('usernameError').textContent = 'Username is required';
            event.preventDefault();
        }

        if (passwordInput.value.trim() === '') {
            passwordInput.classList.add('is-invalid');
            document.getElementById('passwordError').textContent = 'Password is required';
            event.preventDefault();
        }
    });

</script>
</body>
</html>