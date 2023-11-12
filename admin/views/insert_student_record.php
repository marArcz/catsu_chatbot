<?php require_once '../includes/authenticated.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert new student | Admin</title>
    <?php require_once '../includes/header.php' ?>
</head>

<body class="bg-light">
    <?php $current_page = 'students' ?>
    <?php require_once '../includes/sidebar.php' ?>
    <main id="main">
        <?php $header_title = 'Manage Students'; ?>
        <?php require_once '../includes/navbar.php' ?>
        <div class="content">
            <div class="container-fluid">
                <form action="" method="post">
                    
                </form>
            </div>
        </div>
    </main>
 
    <?php require_once '../includes/scripts.php' ?>
    <script>
        $("#data-table").DataTable();
    </script>
</body>

</html>