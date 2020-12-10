<!-- Modal -->
<div class="modal fade" id="add-level" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title text-muted">Add Level</div>
                <div class="cursor-pointer" data-dismiss="modal" aria-label="Close">
                    <i class="icofont-close text-danger"></i>
                </div>
            </div>
            <form method="post" action="javascript:;" class="add-level-form" data-action="<?= DOMAIN; ?>/levels/addLevel">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group input-group-lg col-md-6">
                            <label class="text-muted">Level</label>
                            <input type="number" name="level" class="form-control level" placeholder="e.g., 2">
                            <small class="error level-error text-danger"></small>
                        </div>
                        <div class="form-group input-group-lg col-md-6">
                            <label class="text-muted">Discount</label>
                            <input type="text" name="discount" class="form-control discount" placeholder="e.g., 0.2">
                            <small class="error discount-error text-danger"></small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="text-muted">Minimum</label>
                            <div class="input-group input-group-lg">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">NGN</div>
                                </div>
                                <input type="number" name="minimum" class="form-control minimum" placeholder="e.g., 1000">
                            </div>
                            <small class="error minimum-error text-danger"></small>
                        </div>
                        <div class="form-group input-group-lg col-md-6">
                            <label class="text-muted">Maximum</label>
                            <div class="input-group input-group-lg">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">NGN</div>
                                </div>
                                <input type="number" name="maximum" class="form-control maximum" placeholder="e.g., 6000">
                            </div>
                            <small class="error maximum-error text-danger"></small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-12">
                            <label class="text-muted">Description</label>
                            <textarea name="description" class="form-control description" rows="4" placeholder="e.g., For the sake of placeholding."></textarea>
                            <small class="error description-error text-danger"></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex justify-content-right">
                        <button type="submit" class="btn btn-dark text-white add-level-button px-4">
                            <img src="<?= PUBLIC_URL; ?>/images/banners/spinner.svg" class="mr-2 d-none add-level-spinner mb-1">
                            Submit
                        </button>
                        <button type="button" class="btn bg-danger ml-3 text-white" data-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
                <div class="px-3">
                    <div class="alert mt-2 add-level-message d-none"></div>
                </div>
            </form>
        </div>
    </div>
</div>