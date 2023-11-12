<?php require_once '../includes/authenticated.php' ?>
<?php require_once '../app/add_student.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add new student | Admin</title>
    <?php require_once '../includes/header.php' ?>
</head>

<body class="bg-light">
    <?php $current_page = 'students' ?>
    <?php require_once '../includes/sidebar.php' ?>
    <main id="main" class="<?= Session::hasSession("closed_sidebar") ? 'expanded' : '' ?>">
        <?php $header_title = 'Manage Students'; ?>
        <?php require_once '../includes/navbar.php' ?>
        <div class="content">
            <div class="container-fluid">
                <div class="card rounded-2 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <p class=" fw-semibold text-dark-blue-accent">Add new student</p>
                        <hr>
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="" class="form-label">Student ID No:</label>
                                <input required type="text" value="<?= isset($_POST['student_id_no']) ? $_POST['student_id_no'] : '' ?>" name="student_id_no" class="form-control">
                                <?php if (isset($error)) : ?>
                                    <p class="my-1 form-text text-danger">
                                        <?= $error['student_id_no'] ?>
                                    </p>
                                <?php endif ?>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Firstname:</label>
                                <input required type="text" value="<?= isset($_POST['firstname']) ? $_POST['firstname'] : '' ?>" name="firstname" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Middlename:</label>
                                <input required type="text" value="<?= isset($_POST['middlename']) ? $_POST['middlename'] : '' ?>" name="middlename" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Lastname:</label>
                                <input required id="lastname" value="<?= isset($_POST['lastname']) ? $_POST['lastname'] : '' ?>" type="text" name="lastname" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Password:</label>
                                <p class="form-text my-1 text-secondary">Same as the lastname</p>
                                <input required id="password" value="<?= isset($_POST['password']) ? $_POST['password'] : '' ?>" type="text" name="password" value="" class="form-control">
                            </div>
                            <div class="mt-4">
                                <div class="d-flex gap-3">
                                    <a href="manage_students.php" class="btn btn-secondary">Cancel</a>
                                    <button class="btn btn-dark-blue" type="submit" name="submit">Save Student</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php require_once '../includes/scripts.php' ?>
    <script>
        $("#data-table").DataTable();

        $("#lastname").on('input', function(e) {
            $("#password").val($(this).val())
        })
    </script>
</body>

</html>