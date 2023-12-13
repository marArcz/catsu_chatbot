<?php require_once '../includes/authenticated.php' ?>
<?php require_once '../app/edit_response.php' ?>
<?php

if (!isset($_GET['id'])) {
    Session::redirectTo('responses.php');
    exit;
}
// get response details
$query = $pdo->prepare('SELECT response.*,response_types.name as response_type FROM response INNER JOIN response_types ON response.response_type_id = response_types.id WHERE response.id = ?');
$query->execute([$_GET['id']]);
$response = $query->fetch();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Response | Admin</title>
    <?php require_once '../includes/header.php' ?>
</head>

<body class="bg-light">
    <?php $current_page = 'responses' ?>
    <?php require_once '../includes/sidebar.php' ?>
    <main id="main" class="<?= Session::hasSession("closed_sidebar") ? 'expanded':'' ?>">
        <?php $header_title = 'View Response'; ?>
        <?php require_once '../includes/navbar.php' ?>
        <!-- <div class="bg-dark-blue-accent py-5"></div> -->
        <div class="content">
            <div class="container-fluid">
                <div class="col-md-8 mx-auto">
                    <input type="hidden" id="response-type" value="<?= $response['response_type_id'] ?>">
                    <input type="hidden" name="response_id" value="<?= $response['id'] ?>">
                    <div class="card shadow-sm border mb-3 create-form-card">
                        <div class="card-body p-4">

                            <div class="mb-3 d-none" id="actions">
                                <?php
                                $query = $pdo->prepare('SELECT * FROM actions WHERE id = ?');
                                $query->execute([$response['action_id']]);
                                $action = $query->fetch();
                                ?>
                                <label for=" " class="form-label fw-medium">Action:</label>
                                <input type="text" readonly class="form-control" value="<?= $action['name'] ?>">
                            </div>

                            <div class="mb-3 d-none" id="response">
                                <label for="" class="form-label fw-medium">Response content:</label>
                                <textarea name="response" class="form-control" rows="4"><?= $response['message'] ?></textarea>
                            </div>
                            <div class="instruction">
                                <p class="form-text text-secondary">Please select an option above</p>
                            </div>

                            <!-- keywords -->
                            <div class="mb-3 d-none" id="keywords">
                                <div class="row gx-0">
                                    <div class="col ">
                                        <div class="bg-dark-blue-accent py-2 px-3">
                                            <p class="my-1 text-light ">
                                                Keywords
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div id="keywords-container">
                                    <?php
                                    // get queries
                                    $query = $pdo->prepare('SELECT * FROM queries WHERE response_id = ?');
                                    $query->execute([$response['id']]);
                                    $queries = $query->fetchAll();
                                    ?>

                                    <?php
                                    if ($queries) {
                                        foreach ($queries as $query) {
                                    ?>
                                            <div class="row gx-0 keyword-row-item">
                                                <div class="col">
                                                    <div class="border p-2">
                                                        <input type="text" value="<?= $query['keyword'] ?>" class="form-control" readonly name="keywords[]">
                                                    </div>
                                                </div>
                                            </div>
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <!-- suggestions -->
                            <div class="mb-3 d-none" id="suggestions">
                                <div class="row gx-0">
                                    <div class="col ">
                                        <div class="bg-dark-blue-accent py-2 px-3">
                                            <p class="my-1 text-light ">
                                                Suggestions
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div id="suggestions-container">
                                    <?php
                                    // get suggestions
                                    $query = $pdo->prepare('SELECT * FROM suggestions WHERE response_id = ?');
                                    $query->execute([$response['id']]);

                                    while ($row = $query->fetch()) {
                                    ?>
                                        <div class="row gx-0 suggestion-row-item">
                                            <div class="col">
                                                <div class="border p-2">
                                                    <input type="text" readonly value="<?= $row['keyword'] ?>" class="form-control" name="suggestions[]">
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <!-- end of suggestions -->
                            <!-- <hr class="form-divider d-none"> -->
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-end align-items-center">
                                <div class="me-3">
                                    <a href="responses.php" class="link-secondary me-1 text-decoration-none">
                                        <i class="bi bi-chevron-left"></i>
                                        <span>Back to List</span>
                                    </a>
                                </div>
                                <a href="edit_response.php?id=<?= $response['id'] ?>" class="btn btn-dark-blue">
                                    <span>Edit</span>
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php require_once '../includes/scripts.php' ?>
    <script>
        $(function() {
            $(".btn-add-keyword").on('click', function(e) {
                let container = $("#keywords-container");
                let itemsCount = $(".keyword-row-item").length;
                let newItem = `
                    <div class="row gx-0 keyword-row-item">
                        <div class="col">
                            <div class="border p-2">
                                <input type="text" class="form-control" readonly name="keywords[]">
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-auto col-3">
                            <div class="border p-2">
                                <button type="button" class="btn btn-light-danger btn-remove-keyword">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;

                container.append(newItem);

                $('.btn-remove-keyword').on('click', function(e) {
                    let itemsCount = $(".keyword-row-item").length;

                    if (itemsCount > 1) {
                        $(this).parent().parent().parent().remove()
                    }
                })
            })

            $(".btn-add-suggestion").on('click', function(e) {
                let container = $("#suggestions-container");
                let newItem = `
                    <div class="row gx-0 suggestion-row-item">
                        <div class="col">
                            <div class="border p-2">
                                <input type="text" class="form-control" name="suggestions[]">
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-auto col-3">
                            <div class="border p-2">
                                <button type="button" class="btn btn-light-danger btn-remove-suggestion">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;

                container.append(newItem);

                $('.btn-remove-suggestion').on('click', function(e) {
                    let itemsCount = $(".suggestion-row-item").length;

                    if (itemsCount > 1) {
                        $(this).parent().parent().parent().remove()
                    }
                })
            })

            $('.btn-remove-keyword').on('click', function(e) {
                let itemsCount = $(".keyword-row-item").length;

                if (itemsCount > 1) {
                    $(this).parent().parent().parent().remove()
                }

            })

            $('.btn-remove-suggestion').on('click', function(e) {
                let itemsCount = $(".suggestion-row-item").length;

                if (itemsCount > 1) {
                    $(this).parent().parent().parent().remove()
                }
            })

            $("#response-type").on('change', function(e) {
                let type = e.target.value;
                if (type == '') {
                    $(".instruction").removeClass('d-none')
                    $("#keywords").addClass('d-none');
                    $("#suggestions").addClass('d-none');
                    $("#response").addClass('d-none');
                    $("#actions").addClass('d-none');
                    $("#submit-btn").attr('disabled', true)
                    $(".form-divider").addClass('d-none')
                } else {
                    $(".form-divider").removeClass('d-none')
                    $(".instruction").addClass('d-none')
                    $("#submit-btn").attr('disabled', false)
                    if (type == 2) {
                        $("#response").removeClass('d-none');
                        $("#keywords").removeClass('d-none');
                        $("#suggestions").removeClass('d-none');
                        $("#actions").addClass('d-none');

                    } else {
                        $("#response").addClass('d-none');
                        $("#keywords").removeClass('d-none');
                        $("#suggestions").addClass('d-none');
                        $("#actions").removeClass('d-none');
                    }
                }
            })

            let response_type = $("#response-type").val();
            if (response_type == '') {
                $(".instruction").removeClass('d-none')
                $("#keywords").addClass('d-none');
                $("#suggestions").addClass('d-none');
                $("#response").addClass('d-none');
                $("#actions").addClass('d-none');
                $("#submit-btn").attr('disabled', true)
                $(".form-divider").addClass('d-none')
            } else {
                $(".form-divider").removeClass('d-none')
                $(".instruction").addClass('d-none')
                $("#submit-btn").attr('disabled', false)
                if (response_type == 2) {
                    $("#response").removeClass('d-none');
                    $("#keywords").removeClass('d-none');
                    $("#suggestions").removeClass('d-none');
                    $("#actions").addClass('d-none');

                } else {
                    $("#response").addClass('d-none');
                    $("#keywords").removeClass('d-none');
                    $("#suggestions").addClass('d-none');
                    $("#actions").removeClass('d-none');
                }
            }
        })
    </script>
</body>

</html>