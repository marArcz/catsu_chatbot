<?php require_once '../includes/authenticated.php' ?>
<?php require_once '../app/add_course.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course | Admin</title>
    <?php require_once '../includes/header.php' ?>
</head>

<body class="bg-light">
    <?php $current_page = 'responses' ?>
    <?php require_once '../includes/sidebar.php' ?>
    <main id="main">
        <?php $header_title = 'Manage Responses'; ?>
        <?php require_once '../includes/navbar.php' ?>
        <div class="content">
            <div class="container-fluid">
                <form action="" method="post">
                    <p class="form-text">Add New Course</p>
                    <hr>
                    <div class="mb-3">
                        <label for="" class="form-label">
                            Code:
                        </label>
                        <input value="<?= isset($_POST['code']) ? $_POST['code']:'' ?>" type="text" name="code" class="form-control" required>
                        <p class="form-text my-1">
                            <?= $error ??'' ?>
                        </p>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">
                            Name:
                        </label>
                        <input value="<?= isset($_POST['name']) ? $_POST['name']:'' ?>" type="text" name="name" class="form-control" required>
                    </div>
                    <div class="d-flex gap-2 mt-5">
                        <a href="courses.php" class="btn btn-light-secondary">Cancel</a>
                        <button type="submit" name="submit" class="btn btn-dark-blue-accent">Add course</button>
                    </div>
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