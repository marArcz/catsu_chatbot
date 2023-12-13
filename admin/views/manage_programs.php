<?php require_once '../includes/authenticated.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Programs | Admin</title>
    <?php require_once '../includes/header.php' ?>
</head>

<body class="bg-light">
    <?php $current_page = 'programs' ?>
    <?php require_once '../includes/sidebar.php' ?>
    <main id="main">
        <?php $header_title = 'Manage Programs'; ?>
        <?php require_once '../includes/navbar.php' ?>
        <div class="content">
            <div class="container-fluid">
                <div class="card border-0">
                    <div class="card-body p-4 shadow-sm border-0">
                        <table id="data-table" class="table table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Program</th>
                                    <th>College</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = $pdo->prepare('SELECT programs.*, colleges.name as college FROM programs INNER JOIN colleges ON programs.college_id = colleges.id');
                                $query->execute();
                                $x=1;
                                while ($row = $query->fetch()) {
                                ?>
                                    <tr>
                                        <td><?= $x++ ?></td>
                                        <td><?= $row['program_name'] ?></td>
                                        <td><?= $row['college'] ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php require_once '../includes/scripts.php' ?>
    <script>
        $("#data-table").DataTable();
    </script>
</body>

</html>