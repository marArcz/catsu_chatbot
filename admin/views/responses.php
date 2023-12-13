<?php require_once '../includes/authenticated.php' ?>
<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Responses | Admin</title>
    <?php require_once '../includes/header.php' ?>
</head>

<body class="bg-light">
    <?php $current_page = 'responses' ?>
    <?php require_once '../includes/sidebar.php' ?>
    <main id="main" class="<?= Session::hasSession("closed_sidebar") ? 'expanded':'' ?>">
        <?php $header_title = 'Manage Responses'; ?>
        <?php require_once '../includes/navbar.php' ?>
        <div class="content">
            <div class="container-fluid">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex flex-wrap justify-content-between align-items-center">
                            <p class="my-1">
                                <small>List of responses</small>
                            </p>
                            <div class="text-end ">
                                <a href="create_response.php" class="btn btn-dark-blue-accent">Create New</a>
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table id="data-table" class="table table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date Created</th>
                                        <th>Response / Action</th>
                                        <th>Keyword</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = $pdo->prepare('SELECT response.*,response_types.name as response_type FROM response INNER JOIN response_types ON response.response_type_id = response_types.id ORDER BY response_type_id,id DESC');
                                    $query->execute();
                                    $i = 1;
                                    while ($row = $query->fetch()) {
                                    ?>
                                        <tr class="">
                                            <td><?= $i++ ?></td>
                                            <td><?= date('M d, Y', strtotime($row['created_at'])) ?></td>
                                            <td>
                                                <?php if ($row['response_type'] == 'Message') : ?>
                                                    <p class="my-1"><?= $row['message'] ?></p>
                                                <?php else : ?>
                                                    <?php
                                                    // get response action
                                                    $get_action = $pdo->prepare('SELECT * FROM actions WHERE id=?');
                                                    $get_action->execute([$row['action_id']]);
                                                    $action = $get_action->fetch(PDO::FETCH_ASSOC);
                                                    ?>
                                                    <div class="badge bg-dark-blue-accent">
                                                        <?= $action['name']  ?>
                                                    </div>
                                                <?php endif ?>
                                            </td>
                                            <td>
                                                <p class="my-1">
                                                    <small>
                                                        <?php
                                                        // get keywords
                                                        $getKeywords = $pdo->prepare('SELECT keyword FROM queries WHERE response_id=?');
                                                        $getKeywords->execute([$row['id']]);
                                                        $keywords = $getKeywords->fetchAll(PDO::FETCH_COLUMN);
                                                        echo implode(', ', $keywords);
                                                        ?>
                                                    </small>
                                                </p>
                                            </td>
                                            <td>
                                                <?php if ($row['is_active'] == 1) : ?>
                                                    <div class="badge bg-success">Active</div>
                                                <?php else : ?>
                                                    <div class="badge bg-success">Inactive</div>
                                                <?php endif ?>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <ul class="dropdown-menu py-0">
                                                        <li class="border-bottom py-1">
                                                            <a class="dropdown-item" href="view_response.php?id=<?= $row['id'] ?>">
                                                                <i class="bi bi-eye-fill me-2"></i>
                                                                <small>View</small>
                                                            </a>
                                                        </li>
                                                        <li class="border-bottom py-2">
                                                            <a class="dropdown-item" href="edit_response.php?id=<?= $row['id'] ?>">
                                                                <i class="bi bi-pencil-square text-blue me-2"></i>
                                                                <small>Edit</small>
                                                            </a>
                                                        </li>
                                                        <li class="border-bottom py-2">
                                                            <a class="dropdown-item delete" href="../app/delete_response.php?id=<?= $row['id'] ?>">
                                                                <i class="bi bi-trash-fill text-danger me-2"></i>
                                                                <small>Delete</small>
                                                            </a>
                                                        </li>
                                                    </ul>
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
                </div>
            </div>
        </div>
    </main>

    <?php require_once '../includes/scripts.php' ?>
    <script>
        $('#data-table').DataTable();
    </script>
</body>

</html>