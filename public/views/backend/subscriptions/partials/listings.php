<div class="col-12 col-md-6 col-lg-4 mb-4">
	<div class="card">
		<?php $id = empty($subscription->id) ? 0 : $subscription->id; ?>
		<div class="card-body">
			<div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
				<a href="javascript:;" class="" data-toggle="modal" data-target="#edit-tv-subscription-<?= $id; ?>">
					<?= empty($subscription->tv) ? "Nill" : ucfirst($subscription->tv); ?>
				</a>
				<div class="text-muted">
					NGN<?= empty($subscription->amount) ? "0.0" : number_format($subscription->amount); ?>
				</div>
			</div>
			<div class="d-flex justify-content-between">
				<div class="text-muted">
					<?= empty($subscription->duration) ? "Nill" : $subscription->duration; ?>
				</div> 
				<div class="text-muted">
					<?= empty($subscription->plan) ? "Nill" : VTURefill\Core\Help::limitStringLength($subscription->plan, 22); ?>
				</div>
			</div>	
		</div>
		<div class="card-footer bg-prussian d-flex justify-content-between align-items-center">
			<div class="text-white">
				<?= empty($subscription->date) ? NOW() : VTURefill\Core\Help::formatDate($subscription->date); ?>
			</div>
            <div class="d-flex">
            	<small class="text-warning mr-2 cursor-pointer" data-toggle="modal" data-target="#edit-tv-subscription-<?= $id; ?>">
            		<i class="icofont-edit"></i>
            	</small>
            	<small class="text-danger cursor-pointer" data-id="<?= $id; ?>" data-url="<?= DOMAIN; ?>/subscriptions/deleteTvSubscription/<?= $id; ?>">
            		<i class="icofont-ui-delete"></i>
            	</small>
            </div>
		</div>
	</div>
</div>