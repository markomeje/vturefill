<!-- Modal -->
<div class="modal fade" id="add-product" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title text-muted">Add product</div>
                <div class="cursor-pointer" data-dismiss="modal" aria-label="Close">
                    <i class="icofont-close text-danger"></i>
                </div>
            </div>
            <form method="post" action="javascript:;" class="add-product-form" data-action="<?= DOMAIN; ?>/products/addProduct">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group input-group-lg col-md-6">
                            <label class="text-muted">Product</label>
                            <input type="text" name="product" class="form-control product" placeholder="e.g., data">
                            <small class="error product-error text-danger"></small>
                        </div>
                        <div class="form-group input-group-lg col-md-6">
                            <label class="text-muted">Category</label>
                            <select class="custom-select category" name="category">
                                <option value="">Select category</option>
                                <?php if(empty($allCategories)): ?>
                                    <option value="">No categories</option>
                                <?php else: ?>
                                    <?php foreach($allCategories as $category): ?>
                                        <option value="<?= $category->id; ?>">
                                            <?= ucfirst($category->category); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <small class="error category-error text-danger"></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex justify-content-right">
                        <button type="submit" class="btn btn-dark text-white add-product-button px-4">
                            <img src="<?= PUBLIC_URL; ?>/images/banners/spinner.svg" class="mr-2 d-none add-product-spinner mb-1">
                            Submit
                        </button>
                        <button type="button" class="btn bg-danger ml-3 text-white" data-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
                <div class="px-3">
                    <div class="alert mt-2 alert-primary add-product-message d-none"></div>
                </div>
            </form>
        </div>
    </div>
</div>