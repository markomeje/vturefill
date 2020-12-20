<div class="position-relative">
	<div class="backend-navbar">
		<?php require BACKEND_PATH . DS . "layouts" . DS . "navbar.php"; ?>
	</div>
    <div class="pt-5">
	    <div class="container pt-5 mt-3">
			<div class="d-flex align-items-center my-4">
				<div class="d-flex mr-4 bg-transparent border align-items-center m-0 p-0 rounded cursor-pointer" data-toggle="modal" data-target="#add-tariff">
					<small class="border-right px-3 py-2 text-center text-muted">
						<i class="icofont-plus"></i>
					</small>
					<div class="px-3 py-2 text-muted">Add Tariff</div>
				</div>
				<?php require BACKEND_PATH . DS . "tariffs" . DS . "partials" . DS . "add.php"; ?>
			</div>
			<div class="">
				<?php if(empty($allNetworks)): ?>
					<div class="alert alert-info">No networks added</div>
				<?php else: ?>
					<div class="row">
						<?php foreach($allTariffs as $tariff): ?>
							<?php require BACKEND_PATH . DS . "tariffs" . DS . "partials" . DS . "listings.php"; ?> 
						<?php endforeach; ?>
					</div>
					<?php foreach($allTariffs as $tariff): ?>
						<?php require BACKEND_PATH . DS . "tariffs" . DS . "partials" . DS . "edit.php"; ?> 
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
	    </div>
    </div>
</div>