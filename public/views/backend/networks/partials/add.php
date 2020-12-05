<!-- Modal -->
<div class="modal fade" id="add-network" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title text-muted">Add Network</div>
                <div class="cursor-pointer" data-dismiss="modal" aria-label="Close">
                    <i class="icofont-close text-danger"></i>
                </div>
            </div>
            <form method="post" action="javascript:;" class="add-network-form" data-action="<?= DOMAIN; ?>/networks/addNetwork">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group input-group-lg col-md-6">
                            <label class="text-muted">Network Name</label>
                            <input type="text" name="name" class="form-control name" placeholder="e.g., MTN">
                            <small class="error name-error text-danger"></small>
                        </div>
                        <div class="form-group input-group-lg col-md-6">
                            <label class="text-muted">System Code</label>
                            <input type="number" name="code" class="form-control code" placeholder="e.g., 03">
                            <small class="error code-error text-danger"></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex justify-content-right">
                        <button type="submit" class="btn btn-dark text-white add-network-button px-4">
                            <img src="<?= PUBLIC_URL; ?>/images/banners/spinner.svg" class="mr-2 d-none add-network-spinner mb-1">
                            Submit
                        </button>
                        <button type="button" class="btn bg-danger ml-3 text-white" data-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
                <div class="px-3">
                    <div class="alert mt-2 alert-primary add-network-message d-none"></div>
                </div>
            </form>
        </div>
    </div>
</div>