<?php require_once '../includes/authenticated.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment Record | Admin</title>
    <?php require_once '../includes/header.php' ?>
</head>

<body class="bg-light">
    <?php $current_page = 'enrollment_record' ?>
    <?php require_once '../includes/sidebar.php' ?>
    
    <main>
        <?php $header_title = 'Manage Enrollment Record'; ?>
        <?php require_once '../includes/navbar.php' ?>
        <div class="content">
            <div class="container-lg">
                <form action="">
                    <div class="col-md-6">
                        <div class="mb-3">
                        <select name="" class="form-select" id=""></select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <?php require_once '../includes/scripts.php' ?>
</body>

</html>