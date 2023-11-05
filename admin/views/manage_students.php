<?php require_once '../includes/authenticated.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students | Admin</title>
    <?php require_once '../includes/header.php' ?>
</head>

<body class="bg-light">
    <?php $current_page = 'students' ?>
    <?php require_once '../includes/sidebar.php' ?>
    <main>
        <?php $header_title = 'Manage Students'; ?>
        <?php require_once '../includes/navbar.php' ?>
        <div class="content">
            <div class="container-lg">
                <form action="" method="post">
                    <div class="col-md-3">
                        <label for="" class="form-label">Student ID No.</label>
                        <select name="student_id_no" id="student-id-no" class="form-select">
                            <option value="">Select</option>
                            <?php
                            $query = $pdo->prepare("SELECT student_id_no FROM students");
                            $query->execute();
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                                <option <?= isset($_GET['st']) ? ($row['student_id_no'] == $_GET['st'] ? 'selected' : '') : '' ?> value="<?= $row['student_id_no'] ?>"><?= $row['student_id_no'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <!-- <input 
                            type="text" 
                            class="form-control shadow-sm"
                            id="student-id-no-input"
                            > -->
                    </div>
                </form>
                <!-- student info card -->
                <p class="form-text text-black-50 mb-2 mt-4">
                    <span>Student Information</span>
                </p>
                <div class="card shadow-sm border">
                    <div class="card-body p-4">
                        <div class="">
                            <?php
                            if (isset($_GET['st'])) {
                                $student_id_no = $_GET['st'];
                                $query = $pdo->prepare('SELECT * FROM students WHERE student_id_no=?');
                                $query->execute([$student_id_no]);
                                $student = $query->fetch(PDO::FETCH_ASSOC);

                            ?>
                                <form action="" method="post">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="" class="form-label">
                                                <small>Student ID Number</small>
                                            </label>
                                            <input type="text" name="firstname" value="<?= $student['student_id_no'] ?>" class="form-control" disabled required>
                                        </div>
                                    </div>
                                    <div class="row gy-3">
                                        <div class="col-md-4">
                                            <label for="" class="form-label">
                                                <small>Firstname</small>
                                            </label>
                                            <input type="text" name="firstname" value="<?= $student['firstname'] ?>" class="form-control" disabled required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="" class="form-label">
                                                <small>Middlename</small>
                                            </label>
                                            <input type="text" name="middlename" value="<?= $student['middlename'] ?>" class="form-control" disabled required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="" class="form-label">
                                                <small>Lastname</small>
                                            </label>
                                            <input type="text" name="lastname" value="<?= $student['lastname'] ?>" class="form-control" disabled required>
                                        </div>
                                    </div>
                                </form>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <!-- end of student info -->
                <div class="row mt-2 gy-4 mb-3">
                    <!-- enrollment records -->
                    <div class="col-md-12">
                        <p class="form-text">Enrollment Records</p>
                        <div class="card shadow-sm rounded-3">
                            <div class="card-body px-1">
                                <div class="row">
                                    <div class="col-1"></div>
                                    <div class="col">
                                        <small class=" fw-semibold text-dark-blue-accent">Program</small>
                                    </div>
                                    <div class="col">
                                        <small class=" fw-semibold text-dark-blue-accent">Year Level</small>
                                    </div>
                                    <div class="col">
                                        <small class=" fw-semibold text-dark-blue-accent">Block</small>
                                    </div>
                                    <div class="col">
                                        <small class=" fw-semibold text-dark-blue-accent">Semester</small>
                                    </div>
                                    <div class="col">
                                        <small class=" fw-semibold text-dark-blue-accent">School Year</small>
                                    </div>
                                    <div class="col">
                                        <small class=" fw-semibold text-dark-blue-accent">Action</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- rows -->
                        <?php
                        if (isset($_GET['st'])) {
                        ?>
                            <div>
                                <?php
                                $query = $pdo->prepare("SELECT enrollments.*, programs.program_name FROM enrollments INNER JOIN programs ON enrollments.program_id = programs.id WHERE enrollments.student_id_no = ?");
                                $query->execute([$student_id_no]);
                                while ($enrollment = $query->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <div class="card shadow-sm rounded-3 mt-1">
                                        <div class="card-body px-1">
                                            <div class="row align-items-center">
                                                <div class="col-1 text-center">
                                                    <button class="btn btn-light" type="button">
                                                        <i class="bi bi-chevron-right"></i>
                                                    </button>
                                                </div>
                                                <div class="col">
                                                    <small>
                                                        <?= $enrollment['program_name'] ?>
                                                    </small>
                                                </div>
                                                <div class="col">
                                                    <small class=" fw-medium">
                                                        <?= $enrollment['year_level'] ?>
                                                    </small>
                                                </div>
                                                <div class="col">
                                                    <small class=" fw-medium">
                                                        <?= $enrollment['block'] ?>
                                                    </small>
                                                </div>
                                                <div class="col">
                                                    <small class=" fw-medium">
                                                        <?= $enrollment['semester'] ?>
                                                    </small>
                                                </div>
                                                <div class="col">
                                                    <small class=" fw-medium">
                                                        <?= $enrollment['year_start'] . '-' . $enrollment['year_end'] ?>
                                                    </small>
                                                </div>
                                                <div class="col">
                                                    Action
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="col-md">
                        <p class="form-text mb-2 mt-0">Enrolled Courses</p>
                        <div class="card shadow-sm">
                            <div class="card-body p-4">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>
                                                
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php require_once '../includes/scripts.php' ?>
    <script>
        $("#data-table").DataTable();
        $(function() {
            $("#student-id-no").on("change", function(e) {
                let val = $(this).val();
                if (val != '') {
                    window.location.href = `manage_students.php?st=${val}`;
                }
            })
        })
    </script>
</body>

</html>