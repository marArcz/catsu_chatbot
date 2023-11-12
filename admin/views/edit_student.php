<?php require_once '../includes/authenticated.php' ?>
<?php require_once '../app/edit_student.php' ?>

<?php 
    if(!isset($_GET['st'])){
        Session::redirectTo('manage_students.php');
    }

    $student_id_no = $_GET['st'];
    $query = $pdo->prepare("SELECT * FROM students WHERE student_id_no = ?");
    $query->execute([$student_id_no]);

    $student = $query->fetch();

    if(!$student){
        Session::redirectTo('manage_students.php');
    }
?>

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
                        <p class=" fw-semibold text-dark-blue-accent">Update student</p>
                        <hr>
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="" class="form-label">Student ID No:</label>
                                <input readonly type="text" value="<?= $student['student_id_no'] ?>" name="student_id_no" class="form-control bg-light">
                                <?php if (isset($error)) : ?>
                                    <p class="my-1 form-text text-danger">
                                        <?= $error['student_id_no'] ?>
                                    </p>
                                <?php endif ?>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Firstname:</label>
                                <input required type="text" value="<?= isset($_POST['firstname']) ? $_POST['firstname'] : $student['firstname'] ?>" name="firstname" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Middlename:</label>
                                <input required type="text" value="<?= isset($_POST['middlename']) ? $_POST['middlename'] : $student['middlename'] ?>" name="middlename" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Lastname:</label>
                                <input required id="lastname" value="<?= isset($_POST['lastname']) ? $_POST['lastname'] : $student['lastname'] ?>" type="text" name="lastname" class="form-control">
                            </div>
                            <div class="mt-5">
                                <div class="d-flex gap-3">
                                    <a href="manage_students.php" class="btn btn-secondary">Cancel</a>
                                    <button class="btn btn-dark-blue" type="submit" name="submit">Save changes</button>
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