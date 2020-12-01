<!-- Modal -->
<div class="modal fade" id="add-tariff" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title text-muted">Add Tariff</div>
                <div class="cursor-pointer" data-dismiss="modal" aria-label="Close">
                    <i class="icofont-close text-danger"></i>
                </div>
            </div>
            <form method="post" action="javascript:;" class="add-tariff-form" data-action="<?= DOMAIN; ?>/tariffs/addTariff">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group input-group-lg col-md-6">
                            <label class="text-muted">Bundle</label>
                            <input type="text" name="bundle" class="form-control bundle" placeholder="e.g., 2GB">
                            <small class="error bundle-error text-danger"></small>
                        </div>
                        <div class="form-group input-group-lg col-md-6">
                            <label class="text-muted">Network</label>
                            <select class="custom-select network" name="network">
                                <option value="">Select network</option>
                                <?php if(empty($allNetworks)): ?>
                                    <option value="">No network</option>
                                <?php else: ?>
                                    <?php foreach($allNetworks as $network): ?>
                                        <option value="<?= $network->id; ?>">
                                            <?= $network->name; ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <small class="error network-error text-danger"></small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="text-muted">Amount</label>
                            <div class="input-group input-group-lg">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">NGN</div>
                                </div>
                                <input type="number" name="amount" class="form-control amount" placeholder="e.g., 2000">
                            </div>
                            <small class="error amount-error text-danger"></small>
                        </div>
                        <div class="form-group input-group-lg col-md-6">
                            <label class="text-muted">Duration</label>
                            <input type="text" name="duration" class="form-control duration" placeholder="e.g., 30days">
                            <small class="error duration-error text-danger"></small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group input-group-lg col-md-6">
                            <label class="text-muted">Data Plan</label>
                            <input type="text" name="plan" class="form-control plan" placeholder="e.g., 1000">
                            <small class="error plan-error text-danger"></small>
                        </div>
                        <div class="form-group input-group-lg col-md-6">
                            <label class="text-muted">Status</label>
                            <select class="custom-select status" name="status">
                                <option value="">Select status</option>
                                <?php if(empty($tariffStatus)): ?>
                                    <option value="">No status</option>
                                <?php else: ?>
                                    <?php foreach($tariffStatus as $status): ?>
                                        <option value="<?= $status; ?>">
                                            <?= ucfirst($status); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <small class="error status-error text-danger"></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex justify-content-right">
                        <button type="submit" class="btn btn-dark text-white add-tariff-button px-4">
                            <img src="<?= PUBLIC_URL; ?>/images/banners/spinner.svg" class="mr-2 d-none add-tariff-spinner mb-1">
                            Submit
                        </button>
                        <button type="button" class="btn bg-danger ml-3 text-white" data-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
                <div class="px-3">
                    <div class="alert mt-2 add-tariff-message d-none"></div>
                </div>
            </form>
        </div>
    </div>
</div>