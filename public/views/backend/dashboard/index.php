<div class="position-relative">
	<div class="backend-navbar">
		<?php require BACKEND_PATH . DS . "layouts" . DS . "navbar.php"; ?>
	</div>
    <div class="pt-5">
	    <div class="container pt-5">
	    	<div class="mt-4 d-flex mb-3 justify-content-between align-items-center">
	    		<?php $currentUrl = empty($activeController) ? '' : $activeController; ?>
	    		<h5 class="m-0 p-0">
	    			<a href="<?= DOMAIN; ?>/<?= $currentUrl; ?>">
	    			<?= ucfirst($currentUrl); ?></a>
	    		</h5>
	    		<div class="d-flex align-items-center mt-2">
	    			<a href="<?= isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'javascript:;'; ?>" class="btn btn-sm bg-warning px-4 rounded-pill btn-light text-white previous-url mr-3">
	    				<i class="icofont-arrow-left"></i> <span class="previous-next-text">Previous</span>
	    			</a>
	    			<button class="btn btn-sm bg-info px-4 rounded-pill btn-light text-white next-url">
	    				<span class="previous-next-text">Next</span> <i class="icofont-arrow-right"></i>
	    			</button>
	    		</div>
                <!-- <div class="col-12 col-md-6 col-lg-6 mb-4">
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
                </div> -->
	        </div>
	    	<div class="row mb-1">
				<?php require BACKEND_PATH . DS . "dashboard" . DS . "partials" . DS . "panels.php"; ?>
			</div>
	    </div>
    </div>
</div>