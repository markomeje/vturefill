<div class="position-relative">
	<div class="backend-navbar">
		<?php require BACKEND_PATH . DS . "layouts" . DS . "navbar.php"; ?>
	</div>
    <div class="backend-content">
	    <div class="container">
			<div class="d-flex justify-content-between mb-4 align-items-center">
				<a href="javascript:;" class="btn btn-sm bg-success px-4 rounded-pill btn-light text-white mr-3" data-toggle="modal" data-target="#add-level">
    				<i class="icofont-plus font-weight-lighter"></i> <span class="previous-next-text">Add Level</span>
    			</a>
				<?php require BACKEND_PATH . DS . "levels" . DS . "partials" . DS . "add.php"; ?>
				<div class="d-flex align-items-center">
	    			<a href="<?= isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'javascript:;'; ?>" class="btn btn-sm bg-warning px-4 rounded-pill btn-light text-white previous-url mr-3">
	    				<i class="icofont-arrow-left"></i> <span class="previous-next-text">Previous</span>
	    			</a>
	    			<button class="btn btn-sm bg-info px-4 rounded-pill btn-light text-white">
	    				<span class="previous-next-text">Options</span> <i class="icofont-caret-down"></i>
	    			</button>
	    		</div>
			</div>
			<div class="">
				<?php if(empty($allLevels)): ?>
					<div class="alert alert-info">No levels added</div>
				<?php else: ?>
					<div class="row">
						<?php foreach($allLevels as $level): ?>
							<?php require BACKEND_PATH . DS . "levels" . DS . "partials" . DS . "listings.php"; ?> 
						<?php endforeach; ?>
					</div>
					<?php foreach($allLevels as $level): ?>
						<?php require BACKEND_PATH . DS . "levels" . DS . "partials" . DS . "edit.php"; ?> 
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
	    </div>
    </div>
</div>