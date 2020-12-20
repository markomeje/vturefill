<div class="position-relative">
	<div class="backend-navbar">
		<?php require BACKEND_PATH . DS . "layouts" . DS . "navbar.php"; ?>
	</div>
    <div class="pt-5">
	    <div class="container pt-5">
			<div class="d-flex align-items-center justify-content-between mb-4" style="padding-top: 32px;">
				<a class="btn btn-sm btn-primary text-white rounded-pill px-4" data-toggle="modal" data-target="#add-category">
					Add Category
				</a>
	    		<a href="<?= DOMAIN; ?>/dashboard">
	    			Dashboard
	    		</a>
				<?php require BACKEND_PATH . DS . "categories" . DS . "partials" . DS . "add.php"; ?>
			</div>
			<div class="">
				<?php if(empty($allCategories)): ?>
					<div class="alert alert-info">No categories added</div>
				<?php else: ?>
					<div class="row">
						<?php foreach($allCategories as $category): ?>
							<?php require BACKEND_PATH . DS . "categories" . DS . "partials" . DS . "listings.php"; ?> 
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
	    </div>
    </div>
</div>