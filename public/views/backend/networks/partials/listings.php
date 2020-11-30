<div class="col-12 col-md-6 col-lg-3 mb-4">
	<div class="card">
		<?php $id = empty($network->id) ? 0 : $network->id; ?>
		<div class="card-body d-flex justify-content-between">
			<a href="javascript:;" class="" data-toggle="modal" data-target="#edit-network">
				<?= empty($network->name) ? "Nill" : ucfirst($network->name); ?>
			</a>
			<div class="text-muted network-status">
				<?= empty($network->status) ? "Nill" : ucfirst($network->status); ?>
			</div>
		</div>
		<div class="card-footer bg-primary d-flex justify-content-between align-items-center">
			<div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input network-switch" <?= (isset($network->status) && strtolower($network->status) === 'manual') ? 'checked=""' : ''; ?> id="<?= $id; ?>" data-url="<?= DOMAIN; ?>/networks/toggleNetworkStatus/<?= $id; ?>">
                <label class="custom-control-label" for="<?= $id; ?>"></label>
            </div>
            <div class="d-flex">
            	<small class="text-white mr-2 cursor-pointer" data-toggle="modal" data-target="#edit-network">
            		<i class="icofont-edit"></i>
            	</small>
            	<small class="text-white cursor-pointer">
            		<i class="icofont-ui-delete"></i>
            	</small>
            </div>
		</div>
	</div>
</div>