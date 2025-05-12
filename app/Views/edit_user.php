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
                        <a class="nav-link" href="<?= base_url('admin') ?>"> <span class="badge bg-primary">Admin</span></a>
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
            <h2 class="fw-bold">Edit User</h2>
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
        
        <form id="editUserForm" method="post" action="<?= base_url('admin/update_user/'.$userData['id']) ?>" onsubmit="return confirmPasswordChange()">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" value="<?= $userData['username'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" value=="<?= $userData['password_hashed'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="businessname" class="form-label">Business Name</label>
                <input type="text" class="form-control" id="businessname" name="businessname" placeholder="Enter business name" value="<?= !empty($subscriptions) ? $userData['business_name']: '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="start-date" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="start-date" name="start-date" value="<?= !empty($subscriptions) ? date('Y-m-d', strtotime($subscriptions['start_date'])) : '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="end-date" class="form-label">End Date</label>
                <input type="date" class="form-control" id="end-date" name="end-date" value="<?= !empty($subscriptions) ? date('Y-m-d', strtotime($subscriptions['end_date'])) : '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="subscription-plan" class="form-label">Subscription Plan</label>
                <select class="form-select" id="subscription-plan" name="subscription-plan" required>
                    <option value="one_year" <?= !empty($subscriptions) && $subscriptions['subscription_plan'] == 'one_year' ? 'selected' : '' ?>>One Year Plan</option>
                    <option value="six_month" <?= !empty($subscriptions) && $subscriptions['subscription_plan'] == 'six_month' ? 'selected' : '' ?>>Six-Month Plan</option>
                    <option value="other" <?= !empty($subscriptions) && $subscriptions['subscription_plan'] == 'other' ? 'selected' : '' ?>>Other Plan</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="active" <?= !empty($subscriptions) && $subscriptions['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="expired" <?= !empty($subscriptions) && $subscriptions['status'] == 'expired' ? 'selected' : '' ?>>Expired</option>
                    <option value="canceled" <?= !empty($subscriptions) && $subscriptions['status'] == 'canceled' ? 'selected' : '' ?>>Canceled</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" id="updateUserBtn">Update User</button>
        </form>
</section>

<script>
        function confirmPasswordChange() {
        var confirmChange = confirm('Are you sure you want to change the password of this user?');
        
        return confirmChange;
    }

</script>

</body>
</html>