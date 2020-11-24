<div class="col-12 col-md-6 col-lg-3">
	<div class="card">
		<?php $id = empty($level->id) ? 0 : $level->id; ?>
		<div class="card-body">
			<div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
				<a href="javascript:;" class="" data-toggle="modal" data-target="#edit-level">
					Level <?= empty($level->level) ? "Nill" : ucfirst($level->level); ?>
				</a>
				<div class="text-muted">
					<?= empty($level->status) ? "Nill" : ucfirst($level->status); ?>
				</div>
			</div>
			<div class="d-flex justify-content-between">
				NGN<?= empty($level->minimum) ? "Nill" : number_format($level->minimum); ?> - NGN<?= empty($level->maximum) ? "Nill" : number_format($level->maximum); ?>
			</div>	
		</div>
		<div class="card-footer bg-dark d-flex justify-content-between align-items-center">
			<div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" <?= (isset($level->status) && strtolower($level->status) === 'active') ? 'checked=""' : ''; ?> id="<?= $id; ?>">
                <label class="custom-control-label" for="<?= $id; ?>"></label>
            </div>
            <div class="d-flex">
            	<small class="text-white mr-2" data-toggle="modal" data-target="#edit-level-<?= $id; ?>">
            		<i class="icofont-edit"></i>
            	</small>
            	<small class="text-white" data-id="<?= $id; ?>" data-url="<?= DOMAIN; ?>/levels/deleteLevel/<?= $id; ?>">
            		<i class="icofont-ui-delete"></i>
            	</small>
            </div>
		</div>
	</div>
</div>