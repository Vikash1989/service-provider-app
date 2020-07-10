<main class="container mb-5">
	<div class="pt-5 text-center">
		<h3>Update Personal Information</h3>
	</div>
	<?php 
		$session = \Config\Services::session(); 
		$errors = $session->getFlashdata('errors'); 
	?>
	<div class="col-md-10 offset-md-1 p-5 bg-main">
		<form action="<?= route_to('update-user', $serviceprovider['id']); ?>" method="post">
			<?= csrf_field() ?>
			<div class="row mb-2">
				<div class="col-md-6">
					<div class="form-group">
						<input type="text" class="form-control form-control-lg rounded-0 <?php if(isset($errors['name'])) { echo 'is-invalid'; } ?>" placeholder="Full Name" name="name" value="<?= $serviceprovider['name']; ?>">
						<?php if( isset( $errors['name'] ) ){ ?>
							<div class="invalid-feedback"><?php echo $errors['name']; ?></div>
						<?php } ?>
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<input type="text" class="form-control form-control-lg rounded-0 <?php if(isset($errors['email'])) { echo 'is-invalid'; } ?>" placeholder="Email ID" name="email" value="<?= $serviceprovider['email']; ?>">
						<?php if( isset( $errors['email'] ) ){ ?>
							<div class="invalid-feedback"><?php echo $errors['email']; ?></div>
						<?php } ?>
					</div>
				</div>
			</div>

			<div class="row mb-2">
				<div class="col-md-6">
					<div class="form-group">
						<input type="text" class="form-control form-control-lg rounded-0 <?php if(isset($errors['company'])) { echo 'is-invalid'; } ?>" placeholder="Company Name" name="company" value="<?= $serviceprovider['company']; ?>">
						<?php if( isset( $errors['company'] ) ){ ?>
							<div class="invalid-feedback"><?php echo $errors['company']; ?></div>
						<?php } ?>
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<input type="text" class="form-control form-control-lg rounded-0 <?php if(isset($errors['phone'])) { echo 'is-invalid'; } ?>" placeholder="Phone Number" name="phone" value="<?= $serviceprovider['phone']; ?>">
						<?php if(isset($errors['company'])) { ?>
							<div class="invalid-feedback"><?php echo $errors['phone']; ?></div>
						<?php } ?>
					</div>
				</div>
			</div>

			<div class="row mb-2">
				<div class="col-12">
					<div class="form-group">
						<input type="text" class="form-control form-control-lg rounded-0 <?php if(isset($errors['services'])) { echo 'is-invalid'; } ?>" placeholder="Services Offered" name="services" value="<?= $serviceprovider['services']; ?>">
						<?php if(isset($errors['services'])) { ?>
							<div class="invalid-feedback"><?php echo $errors['services']; ?></div>
						<?php } ?>
					</div>
				</div>
			</div>

			<div class="row mb-2">
				<div class="col-12">
					<div class="form-group">
						<textarea class="form-control form-control-lg rounded-0 <?php if( isset( $errors['address'] ) ){ echo 'is-invalid'; } ?>" placeholder="Address" name="address"><?= $serviceprovider['address']; ?></textarea>
						<?php if( isset( $errors['address'] ) ) { ?>
							<div class="invalid-feedback"><?php echo $errors['address']; ?></div>
						<?php } ?>
					</div>
				</div>
			</div>
			<button class="btn btn-lg btn-main w-100" type="submit">Update</button>
		</form>
	</div>
</main>