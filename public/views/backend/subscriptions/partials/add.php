<!-- Modal -->
<div class="modal fade" id="add-tv-subscription" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title text-muted">Add Tv Subscription</div>
                <div class="cursor-pointer" data-dismiss="modal" aria-label="Close">
                    <i class="icofont-close text-danger"></i>
                </div>
            </div>
            <form method="post" action="javascript:;" class="add-tv-subscription-form" data-action="<?= DOMAIN; ?>/subscriptions/addTvSubscription">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group input-group-lg col-md-6">
                            <label class="text-muted">Plan Name</label>
                            <input type="text" name="plan" class="form-control plan" placeholder="e.g., Gotv Smallie">
                            <small class="error plan-error text-danger"></small>
                        </div>
                        <div class="form-group input-group-lg col-md-6">
                            <label class="text-muted">Amount</label>
                            <input type="text" name="amount" class="form-control amount" placeholder="e.g., 1000">
                            <small class="error amount-error text-danger"></small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group input-group-lg col-md-6">
                            <label class="text-muted">Duration</label>
                            <input type="text" name="duration" class="form-control duration" placeholder="e.g., 1 Month">
                            <small class="error duration-error text-danger"></small>
                        </div>
                        <div class="form-group input-group-lg col-md-6">
                            <label class="text-muted">Tv</label>
                            <select class="custom-select tv" name="tv">
                                <option>Select Tv</option>
                                <?php if(empty($tvs)): ?>
                                    <option>No Tvs Available</option>
                                <?php else: ?>
                                    <?php foreach($tvs as $tv): ?>
                                        <option value="<?= $tv; ?>">
                                            <?= $tv; ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <small class="error tv-error text-danger"></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex justify-content-right">
                        <button type="submit" class="btn btn-dark text-white add-tv-subscription-button px-4">
                            <img src="<?= PUBLIC_URL; ?>/images/banners/spinner.svg" class="mr-2 d-none add-tv-subscription-spinner mb-1">
                            Submit
                        </button>
                        <button type="button" class="btn bg-danger ml-3 text-white" data-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
                <div class="px-3">
                    <div class="alert mt-2 add-tv-subscription-message d-none"></div>
                </div>
            </form>
        </div>
    </div>
</div>