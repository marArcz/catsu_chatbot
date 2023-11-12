<?php require_once '../includes/authenticated.php' ?>
<?php require_once '../app/change-password.php' ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $title = "Profle" ?>
    <?php require_once '../includes/header.php' ?>
</head>

<body>
    <?php $current_page = 'profile' ?>
    <?php require_once '../includes/navbar.php' ?>
    <?php
    $user = Session::getUser($pdo);
    // get current enrollment
    $query = $pdo->prepare("SELECT enrollments.*, programs.program_name FROM enrollments INNER JOIN programs ON enrollments.program_id = programs.id WHERE enrollments.year_start = :year OR enrollments.year_end = :year ORDER BY enrollments.semester DESC");
    $query->execute([':year' => date("Y")]);
    $enrollment = $query->fetch(PDO::FETCH_ASSOC);
    ?>
    <main>
        <div class="container text-light pt-4">
            <!-- <h5>Manage Profile</h5>
            <hr> -->
            <div class="alert alert-info">
                <p class="fs-6 my-1 fw-bold">Manage your account</p>
                <p class="form-text my-1">You can change your account's password below.</p>
            </div>
            <?php if (Session::hasSession("success")) : ?>
                <hr>
                <div class="alert bg-light-success px-4">
                    <div class="d-flex align-items-center">
                        <div>
                            <!-- <p class="my-1 text-light fw-bold">Success</p> -->
                            <p class="my-1 text-white-50">
                                <small><?= Session::getSuccess() ?></small>
                            </p>
                        </div>
                        <div class="ms-auto">
                            <i class=" bi bi-check-circle-fill fs-4"></i>
                        </div>
                    </div>
                </div>
            <?php endif ?>
            <!-- <hr> -->
            <ul class="list-group rounded-2 shadow mb-3">
                <li class="list-group-item bg-light d-flex align-items-center">
                    <div class="">
                        <p class="my-1 text-black-50">
                            <small>Name</small>
                        </p>
                        <p class="my-1">
                            <?= $user['firstname'] ?> <?= $user['middlename'] ?> <?= $user['lastname'] ?>
                        </p>
                    </div>
                </li>
                <li class="list-group-item bg-light d-flex align-items-center">
                    <div class="">
                        <p class="my-1 text-black-50">
                            <small>Current Year Level</small>
                        </p>
                        <p class="my-1">
                            <?php if ($enrollment) : ?>
                                <?= $enrollment['year_level'] ?>
                            <?php endif ?>
                        </p>
                    </div>
                </li>
                <li class="list-group-item bg-light d-flex align-items-center">
                    <div class="">
                        <p class="my-1 text-black-50">
                            <small>Current Program</small>
                        </p>
                        <p class="my-1">
                            <?php if ($enrollment) : ?>
                                <?= $enrollment['program_name'] ?>
                            <?php endif ?>
                        </p>
                    </div>
                </li>
                <li class="list-group-item bg-light d-flex align-items-center">
                    <div class="">
                        <p class="my-1 text-black-50">
                            <small>Current Semester</small>
                        </p>
                        <p class="my-1">
                            <?php if ($enrollment) : ?>
                                <?= $enrollment['semester'] ?>
                            <?php endif ?>
                        </p>
                    </div>
                </li>
                <li class="list-group-item bg-light p-0 position-relative">
                    <div class="d-flex p-3 text-decoration-none align-items-center justify-content-between">
                        <div>
                            <p class="my-1 text-secondary">
                                <small>Student ID No.</small>
                            </p>
                            <p class="my-1">
                                <?= $user['student_id_no'] ?>
                            </p>
                        </div>
                    </div>
                </li>
                <li class="list-group-item p-0 position-relative">
                    <a href="#password-modal" data-bs-toggle="modal" class="d-flex clickable p-3 text-decoration-none align-items-center justify-content-between">
                        <div>
                            <p class="my-1 text-secondary">
                                <small>Password</small>
                            </p>
                            <p class="my-1">*************************</p>
                        </div>
                        <div class="">
                            <i class="bi bi-chevron-right"></i>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </main>

    <?php include_once '../includes/profile-modals.php'  ?>
    <?php include_once '../includes/scripts.php'  ?>

    <script>
        $(function() {
            $("#password-form").on("submit", function(e) {
                e.preventDefault();
                const newPass = $("#new-password")
                const currentPass = $("#current-password")
                const confirmPass = $("#confirm-password")

                $("#new-password-error").html("");
                $("#confirm-password-error").html("");
                $("#current-password-error").html("");
                if (newPass.val() === confirmPass.val()) {
                    $.ajax({
                        url: "profile.php",
                        method: "post",
                        data: {
                            current_password: $("#current-password").val(),
                            new_password: $("#confirm-password").val(),
                            change_pass: true
                        },
                        dataType: "json",
                        success: function(res) {
                            if (res.success) {
                                window.location.reload();
                            } else {
                                if (res.new_password_error) {
                                    $("#new-password-error").html("* " + res.new_password_error);
                                } else if (res.current_password_error) {
                                    $("#current-password-error").html("* " + res.current_password_error);
                                }
                            }
                        },
                        error: err => console.error(err)
                    })
                } else {
                    setTimeout(() => {
                        $("#new-password-error").html("* Passwords does not match");
                        $("#confirm-password-error").html("* Passwords does not match");
                    }, 500)
                }

            })
        })
    </script>
</body>

</html>