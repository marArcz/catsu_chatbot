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
        $current_page='dashboard';
        require_once '../includes/sidebar.php'
    ?>
    <main>
        <?php require_once '../includes/navbar.php' ?>
        <div class="content">
            <div class="container-sm">
                <h2 class="mt-3">Dashboard</h2>
            </div>
        </div>
    </main>
</body>

</html>