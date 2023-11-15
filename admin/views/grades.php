<?php require_once '../includes/authenticated.php' ?>
<?php require_once '../app/edit-grades.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Grades | Admin</title>
    <?php require_once '../includes/header.php' ?>
</head>

<body class="bg-light">
    <?php $current_page = 'grades' ?>
    <?php require_once '../includes/sidebar.php' ?>
    <main id="main" class="<?= Session::hasSession("closed_sidebar") ? 'expanded' : '' ?>">
        <?php $header_title = 'Manage Grades'; ?>
        <?php require_once '../includes/navbar.php' ?>
        <div class="content">
            <div class="container-fluid">
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
                        <!-- rows -->
                        <?php
                        if (isset($_GET['st'])) {
                        ?>
                            <p>Grades</p>
                            <div>
                                <?php
                                $query = $pdo->prepare("SELECT enrollments.*, programs.program_name FROM enrollments INNER JOIN programs ON enrollments.program_id = programs.id WHERE enrollments.student_id_no = ? ORDER BY year_level ASC, semester ASC");
                                $query->execute([$student_id_no]);
                                while ($enrollment = $query->fetch(PDO::FETCH_ASSOC)) {
                                ?>

                                    <div class="card shadow-sm rounded-1 mt-1 mb-3 grades-card">
                                        <div class="card-body">

                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Program</th>
                                                        <th>Year Level</th>
                                                        <th>Block</th>
                                                        <th>Semester</th>
                                                        <th>School Year</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><?= $enrollment['program_name'] ?></td>
                                                        <td><?= $enrollment['year_level'] ?></td>
                                                        <td><?= $enrollment['block'] ?></td>
                                                        <td><?= $enrollment['semester'] ?></td>
                                                        <td>
                                                            <?= $enrollment['year_start'] . '-' . $enrollment['year_end'] ?>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="enrolled-courses mt-3 rounded-2 row-collapse " id="enrolled-courses-row-<?= $enrollment['id'] ?>">
                                                <div class="">
                                                    <div class="d-flex align-items-center justify-content-between flex-wrap mb-3">
                                                        <p class="fs-6 text-dark-blue-accent my-0">Enrolled Courses</p>
                                                        <button data-id="<?= $enrollment['id'] ?>" type="button" data-bs-toggle="modal" data-bs-target="#edit-modal" class="btn btn-sm btn-dark-blue-accent">Edit Grades</button>
                                                    </div>
                                                    <div class="table-responsive-sm">
                                                        <table class="table table-bordered">
                                                            <thead class="text-secondary">
                                                                <tr>
                                                                    <th class="text-dark fw-light">#</th>
                                                                    <th class="text-dark fw-light">Course code</th>
                                                                    <th class="text-dark fw-light">Course name</th>
                                                                    <th class="text-dark fw-light">Unit</th>
                                                                    <th class="text-dark fw-light bg-dark-blue-accent bg-opacity-10">Grade</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $get_enrolled_courses = $pdo->prepare("SELECT enrolled_courses.*, courses.name, courses.unit FROM enrolled_courses INNER JOIN courses ON enrolled_courses.course_code = courses.code WHERE enrolled_courses.enrollment_id = ?");
                                                                $get_enrolled_courses->execute([$enrollment['id']]);
                                                                $i = 1;
                                                                while ($enrolled_course = $get_enrolled_courses->fetch()) {
                                                                    $find_grade = $pdo->prepare('SELECT * FROM grades WHERE course_code = ? AND enrollment_id = ?');
                                                                    $find_grade->execute([$enrolled_course['course_code'], $enrolled_course['enrollment_id']]);
                                                                    $grade = $find_grade->fetch();
                                                                ?>
                                                                    <tr>
                                                                        <td><?= $i++ ?></td>
                                                                        <td><?= $enrolled_course['course_code'] ?></td>
                                                                        <td><?= $enrolled_course['name'] ?></td>
                                                                        <td><?= $enrolled_course['unit'] ?></td>
                                                                        <td class="bg-dark-blue-accent bg-opacity-10 text-dark-blue-accent"><?= $grade ? $grade['grade'] : 'NA' ?></td>
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

    <?php require_once '../includes/grades-modal.php' ?>
    <?php require_once '../includes/scripts.php' ?>
    <script>
        $("#data-table").DataTable();
        $(function() {
            $("#student-id-no").on("change", function(e) {
                let val = $(this).val();
                if (val != '') {
                    window.location.href = `grades.php?st=${val}`;
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

            $("#edit-modal").on("show.bs.modal", function(e) {
                let btn = $(e.relatedTarget);
                $.get('../app/get-grades.php', {
                    id: btn.data('id')
                }, function(res) {
                    console.log('res: ', res)
                    $("#form-content").html(res)
                })
            })

            $("#edit-modal").on("hidden.bs.modal", function(e) {
                $("#form-content").html("")
            })

            $(".input-grades").on("input", function(e) {

            })
        })
    </script>
</body>

</html>