<div class="">
	<div class="container position-relative">
		<div class="row justify-content-center py-5">
			<div class="col-12 col-md-6 col-lg-4">
				<div class="my-3">
					<h3 class="text-prussian">Login Here</h3>
					<form action="javascript:;" method="POST" class="login-form" data-action="<?= DOMAIN; ?>/login/login">
						<div class="alert my-3 px-3 login-message d-none"></div>
						<div class="form-group input-group-lg">
							<label for="" class="text-muted mb-2">Email</label>
							 <input type="email" name="email" class="form-control email" placeholder="e.g., john@doe.com">
							 <small class="error email-error text-danger"></small>
						</div>
						<div class="form-group input-group-lg">
							<label for="" class="text-muted mb-2">Password</label>
							<input type="password" name="password" class="form-control password" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
							<small class="error password-error text-danger"></small>
						</div>
						<button type="submit" class="btn mt-4 btn-lg border-0 bg-prussian text-white login-button btn-block">
							<img src="<?= PUBLIC_URL; ?>/images/banners/spinner.svg" class="mr-2 d-none login-spinner mb-1">
							Login
						</button>
					</form>
				</div>
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#0099ff" fill-opacity="1" d="M0,256L16,224C32,192,64,128,96,106.7C128,85,160,107,192,106.7C224,107,256,85,288,96C320,107,352,149,384,144C416,139,448,85,480,96C512,107,544,181,576,192C608,203,640,149,672,128C704,107,736,117,768,149.3C800,181,832,235,864,250.7C896,267,928,245,960,229.3C992,213,1024,203,1056,181.3C1088,160,1120,128,1152,128C1184,128,1216,160,1248,192C1280,224,1312,256,1344,256C1376,256,1408,224,1424,208L1440,192L1440,320L1424,320C1408,320,1376,320,1344,320C1312,320,1280,320,1248,320C1216,320,1184,320,1152,320C1120,320,1088,320,1056,320C1024,320,992,320,960,320C928,320,896,320,864,320C832,320,800,320,768,320C736,320,704,320,672,320C640,320,608,320,576,320C544,320,512,320,480,320C448,320,416,320,384,320C352,320,320,320,288,320C256,320,224,320,192,320C160,320,128,320,96,320C64,320,32,320,16,320L0,320Z"></path></svg>
			</div>
		</div>
	</div>
</div>

