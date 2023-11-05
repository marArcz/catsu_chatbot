<?php require_once '../includes/authenticated.php' ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $title = "Profle" ?>
    <?php require_once '../includes/header.php' ?>
</head>

<body>
    <?php $current_page = 'profile' ?>
    <?php require_once '../includes/navbar.php' ?>
    <?php
    $user = Session::getUser($pdo);
    ?>
    <main>
        <div class="container text-light pt-4">
            <h5>Manage Profile</h5>
            <hr>
            <ul class="list-group ">
                <li class="list-group-item d-flex align-items-center">
                    <div class="">
                        <p class="my-1 text-black-50">
                            <small>Name</small>
                        </p>
                        <p class="my-1">
                            <?= $user['firstname'] ?> <?= $user['middlename'] ?> <?= $user['lastname'] ?>
                        </p>
                    </div>
                </li>
                <li class="list-group-item">
                    <p class="my-1 text-secondary">
                        <small>Password</small>
                    </p>
                    <p class="my-1"><?= $user['firstname'] . ' ' . $user['lastname'] ?></p>
                </li>
            </ul>
        </div>
    </main>
</body>

</html>