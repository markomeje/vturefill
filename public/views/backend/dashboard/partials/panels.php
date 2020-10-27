<?php $panels = [
	"users" => ["link" => "users"], 
	"orders" => ["link" => "orders"], 
	"categories" => ["link" => "categories"], 
	"tariffs" => ["link" => "tariffs"], 
	"funds" => ["link" => "funds"], 
	"payments" => ["link" => "payments"], 
	"levels" => ["link" => "levels"]
]; ?>
<?php if(empty($panels)): ?>
	<div class="col-12">
		<div class="alert alert-danger">An error occured</div>
	</div>
<?php else: ?>
	<?php foreach($panels as $panel => $values): ?>
		<div class="col-12 col-md-6 col-lg-3 mb-4">
			<div class="card border-0 rounded bg-white shadow">
				<div class="card-body d-flex align-items-center">
					<div class="rounded bg-dark text-center mr-3 panel-icons">
						<i class="icofont-signal text-white"></i>
					</div>
					<div class="">
						<a href="<?= empty($values["link"]) ? "javascript:;" : DOMAIN."/".$values["link"]; ?>" class="d-block">
							<?= empty($panel) ? "Nill" : ucfirst($panel); ?>
						</a>
						<small class="text-muted">
							<?= empty($values["count"]) ? 0 : $values["count"]; ?> Added
						</small>
					</div>
				</div>
				<div class="card-footer bg-dark">
					<small class="text-white">
						<?= empty($femaleApplicantsPercentage) ? 0 : $femaleApplicantsPercentage; ?>users
					</small>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
<?php endif; ?>