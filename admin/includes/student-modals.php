<!-- Change Password Modal -->
<div class="modal fade" id="insert-modal" tabindex="-1" aria-labelledby="password-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title fs-6 fw-medium" id="password-modal-label">
                    <i class="bi bi-plus-circle me-1"></i>
                    <span>Insert student record</span>
                </p>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div class="modal-body p-4">
                <div class="text-center d-flex flex-column my-3 gap-3">
                    <a  class="btn btn-dark-blue-accent d-flex flex-column justify-content-center align-items-center">
                        <i class="bi bi-upload"></i>
                        <span>Import from spreadsheet</span>
                    </a>
                    <div>
                        <div class="row">
                            <div class="col">
                                <hr>
                            </div>
                            <div class="col-auto">
                                <p class="my-0">Or</p>
                            </div>
                            <div class="col">
                                <hr>
                            </div>
                        </div>
                    </div>
                    <a href="add_student.php" class="btn btn-dark-blue d-flex flex-column justify-content-center align-items-center">
                        <i class="bi bi-keyboard"></i>
                        <span>Input student information</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>