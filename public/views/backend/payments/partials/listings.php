<div class="col-12 col-md-6 col-lg-4 mb-4">
	<div class="card">
		<?php $id = empty($payment->id) ? 0 : $payment->id; ?>
		<div class="card-body">
			<div class="d-flex justify-content-between align-items-center pb-2 mb-2 border-bottom">
				<a href="javascript:;" class="">
					<?= empty($payment->email) ? "Nill" : VTURefill\Core\Help::limitStringLength(strtolower($payment->email), 16); ?>
				</a>
				<small class="text-muted">
					<?= empty($payment->username) ? '' : VTURefill\Core\Help::limitStringLength($payment->username, 14); ?>
				</small>
			</div>
			<div class="d-flex justify-content-between align-items-center">
				<div class="text-muted">
					NGN<?= empty($payment->amount) ? 0 : number_format($payment->amount); ?>
				</div>
				<small class="<?= (isset($payment->status) && strtolower($payment->status) === 'paid') ? 'text-success' : 'text-danger'; ?>" id="<?= $id; ?>">
					<?= empty($payment->status) ? "Nill" : ucfirst($payment->status); ?>
				</small>
			</div>
		</div>
		<div class="card-footer bg-prussian d-flex justify-content-between align-items-center">
			<div class="text-white">
				<?= empty($payment->date) ? "" : date("F j, Y", strtotime($payment->date)); ?>
			</div>
        	<div class="d-flex">
            	<small class="text-warning cursor-pointer" data-url="<?= DOMAIN; ?>/payments/deletePayment/<?= $id; ?>">
            		<i class="icofont-ui-delete"></i>
            	</small>
            </div>
		</div>
	</div>
</div>