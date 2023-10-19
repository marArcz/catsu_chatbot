<?php
require_once '../app/config.php';
require_once '../app/login.php';

require_once '../includes/session.php';
require_once '../conn/conn.php';

// check if already logged in
if(Session::getUser($pdo)){
    Session::redirectTo('home.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_ENV['APP_NAME'] ?></title>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/styles/css/custom.css">
    <link rel="stylesheet" href="../assets/styles/css/auth.css">
</head>

<body class="bg-dark-blue">
    <div class="auth-container container">
        <div class="w-100">
            <p class="text-center fs-3 mb-4 fw-bold text-light">Student Login</p>
            <div class="col-md-4 mx-auto">
                <div class="card">
                    <div class="card-body p-4">
                        <form action="" method="post">
                            <?php if(isset($login_error)) : ?>
                                <div class="alert alert-danger">
                                    <?= $login_error??'' ?>
                                </div>
                            <?php endif ?>
                            <p class="form-text">Please enter your credentials to continue</p>
                            <hr>
                            <div class="mb-3">
                                <label for="" class="form-label fw-bold">Student ID No:</label>
                                <input type="text" name="student_id_no" required value="<?= isset($_POST['submit'])? $_POST['student_id_no']:'' ?>" class="form-control" placeholder="eg. 2020-1234">

                                <?php if (isset($student_id_error)) : ?>
                                    <p class="my-1 text-danger form-text">
                                        <small><?= $student_id_error ?></small>
                                    </p>
                                <?php endif ?>

                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label fw-bold">Password:</label>
                                <input type="password" name="password" required class="form-control" value="<?= isset($_POST['submit'])? $_POST['password']:'' ?>" placeholder="Enter your password">

                                <?php if (isset($password_error)) : ?>
                                    <p class="my-1 text-danger form-text">
                                        <small><?= $password_error ?></small>
                                    </p>
                                <?php endif ?>
                            </div>
                            <button class="btn btn-dark-blue col-12" name="submit" type="submit">LOGIN</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>