<div class="text-center pt-5">
	<div class="alert <?= ($verifyFund === true) ? 'alert-success' : 'alert-danger'; ?>">
		<?= ($verifyFund === true) ? 'Payment successfull' : 'An error occured. Try again'; ?>

	</div>
</div><?= gettype($verifyFund) ; ?>