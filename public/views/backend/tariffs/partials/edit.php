<!-- Modal -->
<?php $id = empty($tariff->id) ? 0 : $tariff->id; ?>
<div class="modal fade" id="edit-tariff-<?= $id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title text-muted">Edit Tariff</div>
                <div class="cursor-pointer" data-dismiss="modal" aria-label="Close">
                    <i class="icofont-close text-danger"></i>
                </div>
            </div>
            <form method="post" action="javascript:;" class="edit-tariff-form" data-action="<?= DOMAIN; ?>/tariffs/editTariff/<?= $id; ?>">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group input-group-lg col-md-6">
                            <label class="text-muted">Bundle</label>
                            <input type="text" name="bundle" class="form-control bundle" placeholder="e.g., 2GB" value="<?= empty($tariff->bundle) ? 'Nill' : $tariff->bundle; ?>">
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
                                        <option value="<?= $network->id; ?>" <?= $network->id === $tariff->network ? 'selected' : ''; ?>>
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
                                <input type="number" name="amount" class="form-control amount" placeholder="e.g., 2000" value="<?= empty($tariff->amount) ? '' : $tariff->amount; ?>">
                            </div>
                            <small class="error amount-error text-danger"></small>
                        </div>
                        <div class="form-group input-group-lg col-md-6">
                            <label class="text-muted">Duration</label>
                            <input type="text" name="duration" class="form-control duration" placeholder="e.g., 30days" value="<?= empty($tariff->duration) ? '' : $tariff->duration; ?>">
                            <small class="error duration-error text-danger"></small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group input-group-lg col-md-6">
                            <label class="text-muted">Data Plan</label>
                            <input type="text" name="plan" class="form-control plan" placeholder="e.g., 1000" value="<?= empty($tariff->plan) ? '' : $tariff->plan; ?>">
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
                                        <option value="<?= $status; ?>" <?= (strtolower($status) === strtolower($tariff->status)) ? "selected" : ""; ?> >
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
                        <button type="submit" class="btn btn-dark text-white edit-tariff-button px-4">
                            <img src="<?= PUBLIC_URL; ?>/images/banners/spinner.svg" class="mr-2 d-none edit-tariff-spinner mb-1">
                            Submit
                        </button>
                        <button type="button" class="btn bg-danger ml-3 text-white" data-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
                <div class="px-3">
                    <div class="alert mt-2 edit-tariff-message d-none"></div>
                </div>
            </form>
        </div>
    </div>
</div>