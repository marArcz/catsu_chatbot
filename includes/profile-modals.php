<!-- Change Password Modal -->
<div class="modal fade" id="password-modal" tabindex="-1" aria-labelledby="password-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title fs-6 fw-medium" id="password-modal-label">
                    <i class="bi bi-lock-fill me-1"></i>
                    <span>Change Password</span>
                </p>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <form action="" id="password-form" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="" class="form-label">
                            <small>Current Password:</small>
                        </label>
                        <input id="current-password" required class="form-control" type="password" name="current_password">
                        <p class="mt-1 mb-0 text-danger form-text" >
                            <small id="current-password-error"></small>
                        </p>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">
                            <small>New Password:</small>
                        </label>
                        <input id="new-password" required class="form-control" type="password" name="new_password">
                         <p class="mt-1 mb-0 text-danger form-text" >
                            <small id="new-password-error"></small>
                        </p>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">
                            <small>Confirm New Password:</small>
                        </label>
                        <input id="confirm-password" required class="form-control" type="password" name="confirm_password">
                         <p class="mt-1 mb-0 text-danger form-text" >
                            <small id="confirm-password-error"></small>
                        </p>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-sm bordered-btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-dark-blue btn-sm">Save changes</button>
                </div>
            </form>

        </div>
    </div>
</div>