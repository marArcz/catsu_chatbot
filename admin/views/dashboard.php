<?php require_once '../includes/authenticated.php' ?>
<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Admin</title>
    <?php require_once '../includes/header.php' ?>
</head>

<body>
    <?php
    $current_page = 'dashboard';
    require_once '../includes/sidebar.php'
    ?>
    <main>
        <?php $header_title = 'Dashboard'; ?>
        <?php require_once '../includes/navbar.php' ?>
        <div class="content">
            <div class="container-sm">
                <!-- <h5 class="mt-3">Dashboard</h5> -->
                <div class="row">
                    <?php
                    $get_students = $pdo->prepare("SELECT * FROM students");
                    $get_students->execute();
                    $students = $get_students->fetchAll();
                    ?>
                    <div class="col-md-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <a href="manage_students.php" class="link-light">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="fs-4 text-warning fw-medium">Students</p>
                                            <p href="manage_students.php" class="my-0 fs-4 fw-bold text-dark-blue"><?= count($students) ?></p>
                                        </div>
                                        <div>
                                            <i class="bi bi-person-badge text-dark-blue-accent fs-1"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php require_once '../includes/scripts.php' ?>
</body>

</html>