<?php $panels = [
	"users" => ["link" => "users", "count" => $allUsersCount], 
	"orders" => ["link" => "orders", "count" => $allOrdersCount], 
	"categories" => ["link" => "categories", "count" => $allCategoriesCount], 
	"tariffs" => ["link" => "tariffs", "count" => $allTariffsCount], 
	"funds" => ["link" => "funds", "count" => $allFundsCount], 
	"payments" => ["link" => "payments", "count" => $allPaymentsCount], 
	"levels" => ["link" => "levels", "count" => $allLevelsCount],
	"networks" => ["link" => "networks", "count" => $allNetworksCount]
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
				</div>
			</div>
		</div>
	<?php endforeach; ?>
<?php endif; ?>