<div id="login-page" class="login-page">
	<div class="container">
		<div class="row">
			<div class="col-md-4"></div>
			<div class="col-md-4">
				<section id="content" >			
					<?php echo validation_errors(); ?>
					<?php echo form_open('user/login'); ?>
					  <div class="mb-3">
						<label for="username" class="form-label">Username</label>
						<input type="text" class="form-control" id="username" size="50">
					  </div>
					  <div class="mb-3">
						<label for="password" class="form-label">Password</label>
						<input type="password" class="form-control" id="password" size="50">
					  </div>
					  <div class="text-center">
						<button type="submit" class="btn btn-primary">Login</button>
					  </div>
					</form>								
				</section>
			</div>
			<div class="col-md-4"></div>
		</div>
	</div>	
</div>