<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>insadapp | Home</title>

    <!-- Bootstrap core CSS -->
    <link href="<?= base_url('/public'); ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('https://www.unleashedsoftware.com/assets/uploads/2016/05/hero-product-pages.jpg');
            background-repeat: no-repeat;
            background-size: 100%;
            background-position: fixed;
        }
    </style>
</head>

<body>
    <!-- Page Content -->
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-4 col-md-8">
                <div class="card shadow-lg border-secondary" style="top:7em">
                    <div class="card-header text-center bg-secondary text-white">
                        <h3>Admin Login</h3>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('/admin/auth') ?>" method="post">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" id="username" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <div class="form-group my-4">
                                <button type="submit" name="" id="" class="btn btn-secondary btn-block">Masuk</button>
                            </div>
                            <small><a href="<?= base_url() ?>">Login sebagai user </a></small>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="<?= base_url('/public'); ?>/jquery/jquery.slim.min.js"></script>
    <script src="<?= base_url('/public'); ?>/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>