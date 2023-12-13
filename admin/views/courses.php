<?php require_once '../includes/authenticated.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses | Admin</title>
    <?php require_once '../includes/header.php' ?>
</head>

<body class="bg-light">
    <?php $current_page = 'courses' ?>
    <?php require_once '../includes/sidebar.php' ?>
    <main id="main">
        <?php $header_title = 'Manage Courses'; ?>
        <?php require_once '../includes/navbar.php' ?>
        <div class="content">
            <div class="container-fluid">
                <div class="text-end mb-3">
                    <a href="add_course.php" class="btn btn-dark-blue">Add new</a>
                </div>
                <table class="table" id="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Course Code</th>
                            <th>Course Name</th>
                            <th>Unit</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = $pdo->prepare("SELECT * FROM courses");
                        $query->execute();
                        $x = 1;
                        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                            <tr>
                                <td><?= $x++ ?></td>
                                <td><?= $row['code'] ?></td>
                                <td><?= $row['name'] ?></td>
                                <td><?= $row['unit'] ?></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="edit_course.php?id=<?= $row['id'] ?>" class="btn btn-light-success btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="../app/delete_course.php?id=<?= $row['id'] ?>" class="btn btn-light-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <?php require_once '../includes/scripts.php' ?>
    <script>
        $("#data-table").DataTable();
    </script>
</body>

</html>