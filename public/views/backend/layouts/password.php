<!-- Modal -->
<div class="modal fade" id="update-password" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header align-items-center border-bottom-orange">
                <div class="modal-title text-muted">Update password</div>
                <div class="cursor-pointer" data-dismiss="modal" aria-label="Close">
                    <i class="icofont-close text-danger"></i>
                </div>
            </div>
            <form method="POST" action="javascript:;" class="update-password-form" data-action="<?= DOMAIN; ?>/passwords/update">
                <div class="px-3">
                    <div class="alert py-2 px-3 mt-4 mb-0 rounded update-password-message d-none"></div>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group input-group-lg col-md-6">
                            <label class="text-muted">Update reason</label>
                            <select class="custom-select reason" name="reason">
                                <option value="">Select reason</option>
                                <option value="Security issues">Security issues</option>
                            </select>
                            <small class="error reason-error text-danger"></small>
                        </div>
                        <div class="form-group input-group-lg col-md-6">
                            <label class="text-muted">Current password</label>
                            <input type="password" name="currentpassword" class="form-control currentpassword" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
                            <small class="error currentpassword-error text-danger"></small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group input-group-lg col-md-6">
                            <label class="text-muted">New password</label>
                            <input type="password" name="newpassword" class="form-control newpassword" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
                            <small class="error newpassword-error text-danger"></small>
                        </div>
                        <div class="form-group input-group-lg col-md-6">
                            <label class="text-muted">Confirm password</label>
                            <input type="password" name="confirmpassword" class="form-control confirmpassword" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
                            <small class="error confirmpassword-error text-danger"></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-orange">
                    <div class="d-flex justify-content-left">
                        <button type="submit" class="btn border-0 orange-gradient orange-shadow rounded-pill text-white update-password-button px-4">
                            <img src="<?= IMAGES_URL; ?>/banners/spinner.svg" class="mr-2 d-none update-password-spinner mb-1">
                            Submit
                        </button>
                        <button type="button" class="btn bg-danger text-white ml-3" data-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>