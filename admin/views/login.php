<?php
require_once '../../conn/conn.php';
require_once '../includes/session.php';
require_once '../app/login.php';

$query = $pdo->prepare('SELECT * FROM admins');
$query->execute();
if ($query->rowCount() == 0) {
    Session::redirectTo('signup.php');
    exit;
} else {
    $admin = Session::getUser($pdo);
    if ($admin) {
        Session::redirectTo('dashboard.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/styles/css/custom.css">
    <link rel="stylesheet" href="../../assets/styles/css/app.css">
</head>

<body class="bg-dark-blue">
    <main>
        <div class="login-container">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="text-center">
                        <img src="../../assets/images/catsu.png" width="70" height="70" alt="" class="img-fluid mb-3">
                        <p class="text-white-50"><?= $_ENV['APP_NAME'] ?></p>
                    </div>
                    <p class="text-center fs-3 mb-4 fw-bold text-light">Admin Login</p>
                    <div class="col-md-6">
                        <div class="card border-0 shadow p-3">
                            <div class="card-body">
                                <p class="form-text">Login to manage system</p>
                                <hr>
                                <form action="" method="post">
                                    <?php if (isset($error['username'])) : ?>
                                        <p class="text-danger form-text"><?= $error['username'] ?></p>
                                    <?php endif ?>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Username</label>
                                        <input required type="text" class="form-control" value="<?= isset($_POST['username']) ? $_POST['username'] : '' ?>" name="username">

                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Password</label>
                                        <input required type="password" class="form-control" value="<?= isset($_POST['password']) ? $_POST['password'] : '' ?>" name="password">
                                        <?php if (isset($error['password'])) : ?>
                                            <p class="text-danger form-text"><?= $error['password'] ?></p>
                                        <?php endif ?>
                                    </div>

                                    <button class="btn btn-dark-blue col-12" type="submit" name="login">LOGIN</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>