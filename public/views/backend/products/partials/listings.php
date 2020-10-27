<div class="col-12">
	<div class="border bg-light text-muted p-3 mb-4">
		<?= empty($category) ? "Nill" : $category; ?> Category
	</div>
	<?php if(empty($values)): ?>
		<div class="alert alert-info">No products in category</div>
	<?php else: ?>
		<div class="row">
			<?php foreach($values as $product): ?>
				<div class="col-12 col-md-6 col-lg-3 mb-4">
					<div class="card">
						<?php $id = empty($product->id) ? 0 : $product->id; ?>
						<?php $name = empty($product->name) ? "Nill" : $product->name; ?>
						<div class="card-body d-flex justify-content-between">
							<a href="javascript:;" class="">
								<?= $name ?>
							</a>
							<?php if(isset($product->family) && strtolower($product->family) === "data"): ?>
							    <a href="<?= DOMAIN; ?>/products/tarrifs/<?= strtolower($name); ?> " class="font-weight-lighter text-decoration-none">
							    	<i class="icofont-arrow-right"></i>
							    </a>
							<?php endif; ?>
						</div>
						<div class="card-footer d-flex justify-content-between bg-dark align-items-center">
							<div class="custom-control custom-switch">
				                <input type="checkbox" class="custom-control-input" <?= (isset($product->status) && strtolower($product->status) === 'active') ? 'checked=""' : ''; ?> id="product-<?= $id; ?>">
				                <label class="custom-control-label" for="product-<?= $id; ?>"></label>
				            </div>
							<div class="d-flex align-items-center">
								<small class="text-white mr-2">
									<i class="icofont-ui-delete"></i>
								</small>
								<small class="text-white">
									<i class="icofont-edit"></i>
								</small>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>