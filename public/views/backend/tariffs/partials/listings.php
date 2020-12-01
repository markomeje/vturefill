<?php $id = empty($tariff->id) ? 0 : $tariff->id; ?>
<div class="col-12 col-md-6 col-lg-3 mb-4">
	<div class="card">
		<div class="card-body">
			<div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
				<a href="javascript:;" class="" data-toggle="modal" data-target="#edit-tariff-<?= $id; ?>">
					<?= empty($tariff->bundle) ? "Nill" : $tariff->bundle; ?>
				</a>
				<div class="text-muted">
					NGN<?= empty($tariff->amount) ? "Nill" : number_format($tariff->amount); ?>
				</div>
			</div>
			<div class="d-flex justify-content-between">
				<div class="text-muted">
					<?= empty($tariff->name) ? "Nill" : $tariff->name; ?>, 
					<?= empty($tariff->plan) ? "Nill" : $tariff->plan; ?>
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