<div class="position-relative">
	<div class="backend-navbar">
		<?php require BACKEND_PATH . DS . "layouts" . DS . "navbar.php"; ?>
	</div>
    <div class="pt-5">
	    <div class="container pt-5 mt-3">
	    	<!-- <div class="row">
                <div class="col-12 col-md-6 col-lg-6 mb-4">
                    <?php require BACKEND_PATH . DS . 'layouts' . DS . 'links.php'; ?>
                </div>
	            <div class="col-12 col-md-6 col-lg-6 mb-4">
                    <form action="<?= DOMAIN; ?>" method="get" class="search-tariffs">
			            <div class="row no-gutters">
			                <div class="col-10">
			                    <div class="form-group input-group-lg mb-0">
			                        <input type="search" name="query" class="form-control backend-search-input border-right-0" placeholder="Search tariffs" autocomplete="on" value="<?= empty($query) ? '' : $query; ?>">
			                    </div>
			                </div>
			                <div class="col-2">
			                    <button type="submit" class="btn btn-lg btn-dark btn-block text-white mb-0 backend-search-button border">
			                        <i class="icofont-ui-search"></i>
			                    </button>
			                </div>
			            </div>
			        </form>
                </div>
	        </div> -->
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