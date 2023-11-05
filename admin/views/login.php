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
                    <div class="col-md-6">
                        <p class="text-center text-light fs-2 mb-4 fw-bold mt-0">Catsu Chatbot Support</p>
                        <div class="card border-0 shadow p-3">
                            <div class="card-body">
                                <p class="fw-bold">Admin Login</p>
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

                                    <button class="btn btn-dark-blue col-12" type="submit" name="login">Login</button>
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