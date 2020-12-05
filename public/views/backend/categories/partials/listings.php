<div class="col-12 col-md-6 col-lg-3 mb-4">
	<div class="card">
		<?php $id = empty($category->id) ? 0 : $category->id; ?>
		<div class="card-body d-flex justify-content-between">
			<a href="javascript:;" class="" data-toggle="modal" data-target="#edit-category">
				<?= empty($category->category) ? "Nill" : ucfirst($category->category); ?>
			</a>
			<div class="text-muted">
				<?= empty($category->status) ? "Nill" : ucfirst($category->status); ?>
			</div>
		</div>
		<div class="card-footer bg-prussian d-flex justify-content-between align-items-center">
			<div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" <?= (isset($category->status) && strtolower($category->status) === 'active') ? 'checked=""' : ''; ?> id="<?= $id; ?>">
                <label class="custom-control-label" for="<?= $id; ?>"></label>
            </div>
            <div class="d-flex">
            	<small class="text-white mr-2" data-toggle="modal" data-target="#edit-category">
            		<i class="icofont-edit"></i>
            	</small>
            	<small class="text-white">
            		<i class="icofont-ui-delete"></i>
            	</small>
            </div>
		</div>
	</div>
</div>