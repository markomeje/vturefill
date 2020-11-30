<div class="text-center p-0 m-0">
	<div class="alert <?= ($verifyPayment === true) ? 'alert-success' : 'alert-danger'; ?>">
		<?= ($verifyPayment === true) ? 'Payment Successfull' : 'Payment Verification Failed. Try again'; ?>
	</div>
</div>