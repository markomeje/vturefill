<div class="position-relative">
	<div class="backend-navbar">
		<?php require BACKEND_PATH . DS . "layouts" . DS . "navbar.php"; ?>
	</div>
    <div class="pt-5">
	    <div class="container pt-5">
	    	<div class="row">
                <div class="col-12 col-md-6 col-lg-6 mb-4">
                    <?php require BACKEND_PATH . DS . 'layouts' . DS . 'links.php'; ?>
                </div>
	            <div class="col-12 col-md-6 col-lg-6 mb-4">
                    <form action="<?= DOMAIN; ?>" method="get" class="search-dashboard">
			            <div class="row no-gutters">
			                <div class="col-10">
			                    <div class="form-group input-group-lg mb-0">
			                        <input type="search" name="query" class="form-control backend-search-input border-right-0" placeholder="Search here" autocomplete="on" value="<?= empty($query) ? '' : $query; ?>">
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
	        </div>
	    	<div class="row mb-1">
				<?php require BACKEND_PATH . DS . "dashboard" . DS . "partials" . DS . "panels.php"; ?>
			</div>
			<div class="d-block">
				<?php if(empty($allNetworks)): ?>
					<div class="alert alert-info">No networks added</div>
				<?php else: ?>
					<div class="alert alert-info mb-4">All networks</div>
					<div class="row">
						<?php foreach($allNetworks as $network): ?>
							<?php require BACKEND_PATH . DS . "dashboard" . DS . "networks" . DS . "listings.php"; ?> 
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
	    </div>
    </div>
</div>