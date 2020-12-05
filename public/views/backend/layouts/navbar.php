<div class="fixed-top navigation">
	<div class="top-navigation bg-white py-2">
		<div class="container d-flex justify-content-between align-items-center">
			<h5 class="mb-0">
				<a href="<?= DOMAIN; ?>/dashboard" class="text-muted">VTU<span class="text-danger">Refill</span></a>
			</h5>
			<div class="right">
				<ul class="d-flex align-items-center">
				    <li>
					    <a href="" class="text-info">
					    	<span class="text-muted mr-2">Dike Kingsley</span>
						    <li class="text-info">
						    	<i class="icofont-ui-user"></i>
						    </li>
						</a>
					</li>
					
				</ul>
			</div>
		</div>
	</div>
	<div class="low-navigation bg-prussian py-3">
		<div class="container d-flex justify-content-between align-items-center">
			<!-- <ul class="d-flex">
				<li class="mr-3 rounded-circle text-center text-orange bg-white cursor-pointer icon-circle">
			    	<i class="icofont-alarm"></i>
			    </li>
				<li class="rounded-circle text-center bg-danger cursor-pointer icon-circle">
			    	<a href="<?= DOMAIN; ?>/login/logout" class="text-white">
			    		<i class="icofont-power"></i>
			    	</a>
			    </li>
			</ul> -->
			<ul class="d-flex">
				<li class="mr-3 rounded-circle text-center bg-danger cursor-pointer icon-circle">
			    	<a href="<?= DOMAIN; ?>/dashboard" class="text-white text-decoration-none">
			    		<i class="icofont-home"></i>
			    	</a>
			    </li>
			    <li class="rounded-circle text-center bg-white cursor-pointer icon-circle">
			    	<a href="<?= DOMAIN; ?>/login/logout" class="text-muted text-decoration-none">
			    		<i class="icofont-caret-down"></i>
			    	</a>
			    </li>
				<!-- <?php if(empty($backendLinks)): ?>
		    		<li class="">
						<a href="javascript:;" class="text-warning">No Links</a>
					</li>
		        <?php else: ?>
		            <?php foreach($backendLinks as $link): ?>
		            	<li class="mr-3">
							<a href="<?= DOMAIN; ?>/<?= $link; ?>" class=" <?= ($activeController == $link) ? "text-warning" : "text-white"; ?>">
								<i class="icofont-home"></i> <?= ucfirst($link); ?>
							</a>
						</li>
		            <?php endforeach; ?>
		        <?php endif; ?> -->
			</ul>
			<ul class="d-flex align-items-center">
				<li class="mr-3">
			    	<a href="<?= DOMAIN; ?>/login/logout" class="text-white">
			    		<h5 class="mb-0">Logout</h5>
			    	</a>
			    </li>
				<li class="mr-3 rounded-circle text-center text-orange bg-white cursor-pointer icon-circle">
			    	<small><i class="icofont-search"></i></small>
			    </li>
				<li class="rounded-circle text-center bg-success cursor-pointer icon-circle">
			    	<i class="icofont-navigation-menu text-white"></i>
			    </li>
			</ul>
		</div>
	</div>
</div>

