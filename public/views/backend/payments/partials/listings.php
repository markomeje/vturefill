<div class="col-12 col-md-6 col-lg-3 mb-4">
	<div class="card">
		<?php $id = empty($payment->id) ? 0 : $payment->id; ?>
		<div class="card-body">
			<div class="d-flex justify-content-between align-items-center pb-2 mb-2 border-bottom">
				<a href="javascript:;" class="" data-toggle="modal" data-target="#edit-payment">
					<?= empty($payment->email) ? "Nill" : VTURefill\Core\Help::limitStringLength($payment->email, 16); ?>
				</a>
			</div>
			<div class="d-flex justify-content-between">
				<small class="">
					NGN<?= empty($payment->amount) ? 0 : number_format($payment->amount); ?>
				</small>
				<small class="<?= (isset($payment->status) && strtolower($payment->status) === 'paid') ? 'text-success' : 'text-danger'; ?>" id="<?= $id; ?>">
					<?= (empty($payment->status) || strtolower($payment->status) === 'initialized') ? "Unpaid" : "Paid"; ?>
				</small>
			</div>
		</div>
		<div class="card-footer bg-dark d-flex justify-content-between align-items-center">
			<small class="text-white">
				<?= empty($payment->date) ? "" : date("F j, Y", strtotime($payment->date)); ?>
			</small>
        	<small class="text-white cursor-pointer">
        		<div class="dropdown dropleft">
        			<small class="" data-toggle="dropdown">
        				<i class="icofont-caret-down"></i>
        			</small>
        			<div class="dropdown-menu">
        				<div class="dropdown-item">Delete</div>
        			</div>
        		</div>
        	</small>
		</div>
	</div>
</div>