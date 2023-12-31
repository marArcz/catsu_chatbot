<?php require_once '../includes/authenticated.php' ?>

<?php 
    if(isset($_GET['st'])){
        $student_id_no = $_GET['st'];
        $query = $pdo->prepare('SELECT * FROM students WHERE student_id_no=?');
        $query->execute([$student_id_no]);
        $student = $query->fetch(PDO::FETCH_ASSOC);
    }else{
        $student = null;
    }
?>

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
    <main id="main" class="<?= Session::hasSession("closed_sidebar") ? 'expanded' : '' ?>">
        <?php $header_title = 'Manage Students'; ?>
        <?php require_once '../includes/navbar.php' ?>
        <div class="content">
            <div class="container-fluid">
                <div class="text-end">
                    <!-- <a href="#insert-modal" data-bs-toggle="modal" class="btn btn-warning text-light">
                        <div class="d-flex flex-colum gap-2 fw-medium">
                            <i class="bi bi-plus-circle-fill"></i>
                            <span>Insert student record</span>
                        </div>
                    </a> -->
                    <?php if ($student) : ?>
                        <a href="../app/delete_student.php?id=<?= $student['id'] ?>" class="btn btn-danger text-light">
                            <div class="d-flex flex-colum gap-2 fw-medium">
                                <i class="bi bi-trash-fill"></i>
                                <span>Delete Record</span>
                            </div>
                        </a>
                    <?php endif ?>
                    <a href="add_student.php" class="btn btn-primary text-light">
                        <div class="d-flex flex-colum gap-2 fw-medium">
                            <i class="bi bi-plus-circle-fill"></i>
                            <span>Insert student record</span>
                        </div>
                    </a>
                </div>
                <form action="" method="post">
                    <div class="col-md-3">
                        <label for="" class="form-label">Student ID No.</label>
                        <select name="student_id_no" id="student-id-no" class="form-select shadow-sm">
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
                    </div>
                </form>

                <!-- student info card -->

                <div class="mb-2 d-flex justify-content-between mt-3 align-items-center">
                    <div>
                        <p class="form-text text-black-50 my-0">
                            <span>Student Information</span>
                        </p>
                    </div>
                    <div>
                        <?php if (isset($_GET['st'])) : ?>
                            <a href="edit_student.php?st=<?= $_GET['st'] ?>" class="btn btn-light-dark-blue-accent btn-sm fw-medium">Update info</a>
                        <?php endif ?>
                    </div>
                </div>
                <div class="card shadow-sm border">
                    <div class="card-body p-4">
                        <div class="">
                            <?php
                            if (isset($_GET['st'])) {
                               
                            ?>
                                <form action="" method="post">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="" class="form-label">
                                                <small>Student ID Number</small>
                                            </label>
                                            <input type="text" name="student_id_no" value="<?= $student['student_id_no'] ?>" class="form-control" disabled required>
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
                        <div class="d-flex justify-content-between align-items-center mb-2 ">
                            <div>
                                <p class="form-text">Enrollment Records</p>
                            </div>
                            <div class="d-flex align-items-center ">
                                <?php if (isset($_GET['st']) && $student) : ?>

                                    <a href="add_new_enrollment.php?st=<?= $student_id_no ?? '' ?>" class="btn btn-dark-blue ">
                                        <i class="bi bi-plus"></i>
                                        <span>
                                            <small>Insert new record</small>
                                        </span>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
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
                                $query = $pdo->prepare("SELECT enrollments.*, programs.program_name FROM enrollments INNER JOIN programs ON enrollments.program_id = programs.id WHERE enrollments.student_id_no = ? ORDER BY year_level ASC, semester ASC");
                                $query->execute([$student_id_no]);
                                while ($enrollment = $query->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <div class="card shadow-sm rounded-3 mt-1">
                                        <div class="card-body px-1">
                                            <div class="row align-items-center">
                                                <div class="col-1 text-center">
                                                    <button class="btn btn-light rounded-0 collapsed row-collapse-toggler" aria-expanded="false" type="button" data-bs-toggle="collapse" data-bs-target="#enrolled-courses-row-<?= $enrollment['id'] ?>">
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
                                                    <a href="edit_enrollment.php?id=<?= $enrollment['id'] ?>" class="btn btn-light-dark-blue btn-sm" type="button">Update</a>
                                                </div>
                                            </div>
                                            <div class="enrolled-courses bg-light mx-3 border mt-3 rounded-2 row-collapse collapse" id="enrolled-courses-row-<?= $enrollment['id'] ?>">
                                                <div class="p-3">
                                                    <p class="fs-6 text-secondary mb-3">Enrolled Courses</p>
                                                    <table class="table">
                                                        <thead class="text-secondary">
                                                            <tr>
                                                                <th class="text-dark fw-light">#</th>
                                                                <th class="text-dark fw-light">Course code</th>
                                                                <th class="text-dark fw-light">Course name</th>
                                                                <th class="text-dark fw-light">Unit</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $get_enrolled_courses = $pdo->prepare("SELECT enrolled_courses.*, courses.name, courses.unit FROM enrolled_courses INNER JOIN courses ON enrolled_courses.course_code = courses.code WHERE enrolled_courses.enrollment_id = ?");
                                                            $get_enrolled_courses->execute([$enrollment['id']]);
                                                            $i = 1;
                                                            while ($enrolled_course = $get_enrolled_courses->fetch()) {
                                                            ?>
                                                                <tr>
                                                                    <td><?= $i++ ?></td>
                                                                    <td><?= $enrolled_course['course_code'] ?></td>
                                                                    <td><?= $enrolled_course['name'] ?></td>
                                                                    <td><?= $enrolled_course['unit'] ?></td>
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
                                <?php
                                }
                                ?>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php require_once '../includes/student-modals.php' ?>
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

            $(".row-collapse-toggler").on("click", function(e) {
                let btn = $(this);
                console.log(btn)
                if (btn.hasClass('collapsed')) {
                    btn.find('i').addClass("bi-chevron-right").removeClass("bi-chevron-down")
                } else {
                    btn.find('i').removeClass("bi-chevron-right").addClass("bi-chevron-down")
                }
                // if(btn.attr("aria-expanded")){
                //     btn.find('i').addClass("bi-chevron-right").removeClass("bi-chevron-down");
                // }else{
                //     btn.find('i').removeClass("bi-chevron-right").addClass("bi-house");
                // }
            })
        })
    </script>
</body>

</html>