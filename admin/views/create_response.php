<?php require_once '../includes/authenticated.php' ?>
<?php require_once '../app/create_response.php' ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Response | Admin</title>
    <?php require_once '../includes/header.php' ?>
</head>

<body class="bg-light">
    <?php $current_page = 'responses' ?>
    <?php require_once '../includes/sidebar.php' ?>
    <main>
        <?php $header_title = 'Create Responses'; ?>
        <?php require_once '../includes/navbar.php' ?>
        <!-- <div class="bg-dark-blue-accent py-5"></div> -->
        <div class="content">
            <div class="container-lg">
                <div class="col-md-8 mx-auto">
                    <form action="" method="post">
                        <div class="card shadow-sm border mb-3 create-form-card">
                            <div class="card-body p-4">
                                <div class="mb-3">
                                    <label for=" " class="form-label fw-medium">Response type:</label>
                                    <select required name="response_type" id="response-type" class="form-select">
                                        <option value="">Select</option>
                                        <option value="2">Message</option>
                                        <option value="1">Action</option>
                                    </select>
                                </div>
                                <div class="mb-3 d-none" id="actions">
                                    <label for=" " class="form-label fw-medium">Action:</label>
                                    <select required name="action" class="form-select">
                                        <?php
                                        $query = $pdo->prepare('SELECT * FROM actions');
                                        $query->execute();

                                        while ($row = $query->fetch()) {
                                        ?>
                                            <option value="<?= $row['id'] ?>">
                                                <?= $row['name'] ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3 d-none" id="response">
                                    <label for="" class="form-label fw-medium">Response content:</label>
                                    <textarea name="response" class="form-control" rows="4"></textarea>
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
                                        <div class="row gx-0 keyword-row-item">
                                            <div class="col">
                                                <div class="border p-2">
                                                    <input type="text" class="form-control" required name="keywords[]">
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
                                    </div>
                                    <div class="text-end mt-2">
                                        <button class="btn btn-dark-blue-accent btn-add-keyword rounded-pill" type="button">
                                            <small class="">
                                                <i class="bi bi-plus-circle me-2"></i>
                                                <span>Add Item</span>
                                            </small>
                                        </button>
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
                                    </div>
                                    <div class="text-end mt-2">
                                        <button class="btn btn-dark-blue-accent btn-add-suggestion rounded-pill" type="button">
                                            <small class="">
                                                <i class="bi bi-plus-circle me-2"></i>
                                                <span>Add Item</span>
                                            </small>
                                        </button>
                                    </div>
                                </div>
                                <!-- end of suggestions -->
                                <!-- <hr class="form-divider d-none"> -->
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-end">
                                    <a href="responses.php" class="btn btn-light me-1">Cancel</a>
                                    <button type="submit" id="submit-btn" name="submit" disabled class="btn btn-dark-blue">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
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
                                <input type="text" class="form-control" required name="keywords[]">
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
        })
    </script>
</body>

</html>