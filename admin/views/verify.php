<?php
require_once '../../conn/conn.php';
require_once '../includes/session.php';
require_once '../app/verify.php';

$admin = Session::getUser($pdo);
if (!$admin) {
    Session::redirectTo('login.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify - Admin</title>
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
                        <div class="text-center mb-4">
                            <p class="text-center text-light mb-1 mt-0 fs-2 fw-bold mt-0">Catsu Chatbot Support</p>
                            <p class="text-secondary fs-5 text-uppercase">Admin | Login</p>
                        </div>
                        <div class="card border-0 shadow p-3">
                            <div class="card-body">
                                <p class="fw-bold fs-5">Verify your email address</p>
                                <p>Please enter the verification code we sent to your email address.</p>

                                <form action="" method="post">
                                    <?php if (isset($error)) : ?>
                                        <p class="text-danger form-text fw-bold"><?= $error ?></p>
                                    <?php endif ?>
                                    <div class="mb-3">
                                        <input required type="text" maxlength="6" class="form-control text-uppercase" value="<?= isset($_POST['verification_code']) ? $_POST['verification_code'] : '' ?>" name="verification_code">
                                    </div>

                                    <button class="btn btn-dark-blue col-12" type="submit" name="verify">Verify Account</button>

                                    <div class="mt-3">
                                        <p>
                                            No code recieved?
                                            <a id="resend-code" href="#" class=""> Resend code</a>
                                        </p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        $(function() {
            $.ajax({
                url: '../app/send-verification.php',
                method: 'post',
                dataType: "json",
                success: function(res) {
                    console.log(res)
                },
                error: (err) => console.error(err)
            })
        })
    </script>
</body>


</html>