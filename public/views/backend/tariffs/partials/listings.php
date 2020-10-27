<?php $allGroupedTariffs = []; ?>
<?php if(isset($allTariffs) && is_array($allTariffs) && count($allTariffs) > 0): ?>
	<?php foreach ($allTariffs as $tariffs): ?>
		<?php $allGroupedTariffs[$tariffs->network][] = $tariffs; ?>
	<?php endforeach; ?>
<?php endif; ?>
<?php $networkName = empty($network->name) ? "Nill" : ucfirst($network->name); ?>
<div class="col-12">
	<div class="text-muted bg-light border p-3 rounded cursor-pointer">
		<?= $networkName; ?>
	</div>
	<?php if(empty($allGroupedTariffs)): ?>
		<div class="text-muted py-3">No <?= $networkName; ?> tariffs added</div>
	<?php else: ?>
	    <div class="row">
		    <?php foreach($allGroupedTariffs[$network->id] as $tariff): ?>
				<div class="col-12 col-md-6 col-lg-3 my-4">
					<div class="card">
						<?php $id = empty($tariff->id) ? 0 : $tariff->id; ?>
						<div class="card-body">
							<div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
								<a href="javascript:;" class="" data-toggle="modal" data-target="#edit-tariff-<?= $id; ?>">
									<?= empty($tariff->bundle) ? "Nill" : $tariff->bundle; ?>
								</a>
								<div class="text-muted">
									NGN<?= empty($tariff->amount) ? "Nill" : $tariff->amount; ?>
								</div>
							</div>
							<div class="d-flex justify-content-between">
								<div class="text-muted">
									<?= empty($tariff->code) ? "0000" : $tariff->code; ?>
								</div>
								<div class="text-muted">
									<?= empty($tariff->duration) ? "Nill" : $tariff->duration; ?>
								</div>
							</div>	
						</div>
						<div class="card-footer bg-dark d-flex justify-content-between align-items-center">
							<div class="custom-control custom-checkbox">
				                <input type="checkbox" class="custom-control-input" id="<?= $id; ?>">
				                <label class="custom-control-label" for="<?= $id; ?>"></label>
				            </div>
							<div class="d-flex">
								<small class="cursor-pointer text-white mr-2" data-toggle="modal" data-target="#edit-tariff-<?= $id; ?>">
				        			<i class="icofont-edit"></i>
				        		</small>
				        		<small class="cursor-pointer">
				        			<i class="icofont-ui-delete text-white"></i>
				        		</small>
				        	</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>