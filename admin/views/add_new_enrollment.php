<?php require_once '../includes/authenticated.php' ?>
<?php require_once '../app/add_new_enrollment.php' ?>

<?php
if (!isset($_GET['st'])) {
    Session::redirectTo('manage_students.php');
    exit;
}
$student_id_no = $_GET['st'];

$get_student = $pdo->prepare("SELECT * FROM students WHERE student_id_no = ?");
$get_student->execute([$student_id_no]);
$student = $get_student->fetch();


// get latest enrollment record
$query = $pdo->prepare("SELECT * FROM enrollments WHERE student_id_no = ? ORDER BY year_end");
$query->execute([$student_id_no]);
$enrollment = $query->fetch();

if ($enrollment) {
    if ($enrollment['semester'] < 3) {
        $year_start = date('Y');
        $year_end = intval(date('Y')) + 1;
    } else {
        $year_start = intval(date('Y')) + 1;
        $year_end = intval(date('Y')) + 2;
    }
} else {
    $year_start = date('Y');
    $year_end = intval(date('Y')) + 1;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert new enrollment record | Admin</title>
    <?php require_once '../includes/header.php' ?>
</head>

<body class="bg-light">
    <?php $current_page = 'students' ?>
    <?php require_once '../includes/sidebar.php' ?>
    <main id="main" class="<?= Session::hasSession("closed_sidebar") ? 'expanded' : '' ?>">
        <?php $header_title = 'Manage Students'; ?>
        <?php require_once '../includes/navbar.php' ?>
        <div class="content">
            <div class="container-lg">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="link-dark-blue-accent" href="manage_students.php?st=<?= $student_id_no ?>">
                                <span>Students</span>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <?= $student['firstname'] . ' ' . $student['lastname'] ?>
                        </li>
                    </ol>
                </nav>
                <!-- <hr> -->
                <div class=" mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <p class="my-1 fw-semibold text-secondary mb-3">Inserting new enrollment record</p>
                            <hr>
                            <form action="" method="post">
                                <input type="hidden" name="student_id_no" value="<?= $student_id_no ?>">
                                <div class="mb-3">
                                    <div class="row gy-3">
                                        <div class="col-md">
                                            <label for="" class="form-label text-secondary">
                                                Year level:
                                            </label>
                                            <select name="year_level" required class="form-select">
                                                <?php
                                                for ($x = 1; $x <= 4; $x++) {
                                                ?>
                                                    <option <?= $enrollment ? ($x == $enrollment['year_level'] + 1 ? 'selected' : ($enrollment['year_level'] + 1 >= 4 && $x == 4 ? 'selected' : '')) : '' ?> value="<?= $x ?>"><?= $x ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md">
                                            <label for="" class="form-label text-secondary">
                                                Semester:
                                            </label>
                                            <select required class="form-select" name="semester">
                                                <option <?= $enrollment ? ($enrollment['semester'] + 1 == 1 ? 'selected' : '') : '' ?> value="1">1</option>
                                                <option <?= $enrollment ? ($enrollment['semester'] + 1 == 2 ? 'selected' : '') : '' ?> value="2">2</option>
                                                <option <?= $enrollment ? ($enrollment['semester'] + 1 >= 3 ? 'selected' : '') : '' ?> value="3">3</option>
                                            </select>
                                        </div>
                                        <div class="col-md">
                                            <label for="" class="form-label text-secondary">
                                                Block:
                                            </label>
                                            <select name="block" required class="form-control">
                                                <?php
                                                $blocks = ['A', 'B', 'C', 'D', 'E', 'F'];
                                                foreach ($blocks as $key => $block) {
                                                ?>
                                                    <option <?= $enrollment ? ($block == $enrollment['block'] ? 'selected' : '') : '' ?> value="<?= $block ?>"><?= $block ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-1">
                                    <label class="form-label text-secondary">
                                        School Year:
                                    </label>
                                    <div class="">
                                        <div class="row">
                                            <div class="col-md">
                                                <div class="input-group">
                                                    <span class="input-group-text">Start</span>
                                                    <input type="number" class="form-control" required name="year_start" value="<?= $year_start ?>" />
                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">End</span>
                                                    <input type="number" class="form-control" required name="year_end" value="<?= $year_end ?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="form-label text-secondary">
                                        Program:
                                    </label>
                                    <select id="programs" required class="form-select" name="program_id">
                                        <option value="">Select program</option>
                                        <?php
                                        $query = $pdo->prepare("SELECT * FROM programs");
                                        $query->execute();
                                        while ($row = $query->fetch()) {
                                        ?>

                                            <option value="<?= $row['id'] ?>"><?= $row['program_name'] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <p>Courses to enroll:</p>
                                    <div class="mb-3">
                                        <div class="d-flex">
                                            <select name="" id="courses-select" class="form-select h-100 py-4">
                                                <?php
                                                $query = $pdo->prepare("SELECT * FROM courses");
                                                $query->execute();
                                                while ($row = $query->fetch()) {
                                                ?>
                                                    <option value="<?= $row['code'] ?>"><?= $row['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                            <button class="btn btn-dark-blue" type="button" id="btn-add-course">Add</button>
                                        </div>
                                    </div>
                                    <p class="form-text mb-1">Selected courses:</p>
                                    <div class="list-group" id="selected-courses">
                                        <div id="selected-courses-placeholder" class="text-danger">
                                            No courses selected
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex gap-2 mt-5">
                                    <a href="manage_students.php?st=<?= $_GET['st'] ?>" class="btn btn-light-dark">Cancel</a>
                                    <button type="submit" id="btn-submit" disabled class="btn btn-dark-blue" name="add_enrollment">Insert Record</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <?php require_once '../includes/scripts.php' ?>
    <script>
        $(document).ready(function() {
            $("#courses-select").select2({
                placeholder: 'Select a course'
            })

            $("#btn-add-course").on("click", function(e) {
                let selectedOption = $("#courses-select").find(':selected');

                const newCourseElem = `
                        <div id="selected-course-${selectedOption.val()}" class="list-group-item selected-course" style="display:none">
                            <input type="hidden" name="courses[]" value="${selectedOption.val()}">
                            <div class="d-flex w-100">
                                <div>
                                    <p class="my-1">${selectedOption.val()} - ${selectedOption.html()}</p>
                                </div>
                                <div class="ms-auto">
                                    <button id="btn-remove-course-${selectedOption.val()}" class="btn btn-danger btn-remove-course" data-code="${selectedOption.val()}" data-course="${selectedOption.html()}" type="button">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>
                            </div>            
                        </div>
                    `;
                    
                $(newCourseElem).appendTo("#selected-courses").show(400)
                $("#btn-submit").removeAttr('disabled')

                $(`#btn-remove-course-${selectedOption.val()}`).on('click', function(e) {
                    e.stopPropagation();
                    console.log('remove')
                    let btn = $(this);
                    let courseName = btn.data('course')
                    let courseCode = btn.data('code')

                    $(`#selected-course-${courseCode}`).hide(500);
                    setTimeout(() => {
                        $(`#selected-course-${courseCode}`).remove()
                        var newOption = new Option(courseName, courseCode, false, false);
                        $('#courses-select').prepend(newOption).trigger('change');
                        $('#courses-select').val(courseCode).trigger('change')
                        console.log('options: ', $('#courses-select').find('option'))
                        if ($('#selected-courses').find(".selected-course").length == 0) {
                            $("#selected-courses-placeholder").show()
                            $("#btn-submit").attr('disabled',true)
                        }
                        $("#btn-add-course").removeAttr('disabled')
                    }, 400)
                })

                $("#selected-courses-placeholder").hide(500);
                selectedOption.remove();
                $('#courses-select').trigger('change');
                if ($("#courses-select").find('option').length == 0) {
                    $("#btn-add-course").attr('disabled', true)
                }
            })
        })
        $("#data-table").DataTable();

        $("#programs").on("change", function(e) {
            let program_id = $(this).val();

            $.ajax({
                url: "../app/api_get_courses.php",
                method: "get",
                data: {
                    program_id
                },
                dataType: "json",
                success: function(res) {
                    $('#courses').html("");
                    for (let course of res.courses) {
                        $("#courses").append(
                            `  <div class="card mb-2">
                                            <div class="card-body py-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name="courses[]" value="${course.code}" checked type="checkbox" value="" id="checkbox-${course.id}">
                                                    <label class="form-check-label" for="checkbox-${course.id}">
                                                        ${course.name}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>`
                        )
                    }
                }
            })
        })
    </script>
</body>

</html>