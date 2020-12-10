<div class="col-12 col-md-6 col-lg-4 mb-4">
	<div class="card">
		<?php $id = empty($level->id) ? 0 : $level->id; ?>
		<div class="card-body">
			<div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
				<a href="javascript:;" class="" data-toggle="modal" data-target="#edit-level-<?= $id; ?>">
					Level <?= empty($level->level) ? "Nill" : ucfirst($level->level); ?>
				</a>
				<div class="text-muted">
					<?= empty($level->discount) ? "0.0" : ucfirst($level->discount); ?>%
				</div>
			</div>
			<div class="d-flex justify-content-between">
				<div>NGN<?= empty($level->minimum) ? "Nill" : number_format($level->minimum); ?></div> 
				<div>NGN<?= empty($level->maximum) ? "Nill" : number_format($level->maximum); ?></div>
			</div>	
		</div>
		<div class="card-footer bg-prussian d-flex justify-content-between align-items-center">
			<div class="text-white">
				<?= empty($level->date) ? NOW() : VTURefill\Core\Help::formatDate($level->date); ?>
			</div>
            <div class="d-flex">
            	<small class="text-warning mr-2 cursor-pointer" data-toggle="modal" data-target="#edit-level-<?= $id; ?>">
            		<i class="icofont-edit"></i>
            	</small>
            	<small class="text-danger cursor-pointer" data-id="<?= $id; ?>" data-url="<?= DOMAIN; ?>/levels/deleteLevel/<?= $id; ?>">
            		<i class="icofont-ui-delete"></i>
            	</small>
            </div>
		</div>
	</div>
</div>