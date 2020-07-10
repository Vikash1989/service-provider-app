<header class="bg-light">
	<div class="container">
		<div class="main-logo text-center">
			<img src="<?php echo base_url('uploads/images/logo.jpg'); ?>" alt="">
		</div>
	</div>
</header>
<main class="container mb-5">
	<div class="py-5 text-center">
		<h1 class="main-title">Are you a service provider</h1>
		<p class="main-subtitle">Are you looking to partner with LSCOA to help more people?</p>
		<p class="form-title">Fill in the below form. One of our executives will contact you soon.</p>
	</div>
	<?php 
		$session = \Config\Services::session(); 
		$errors = $session->getFlashdata('errors'); 
	?>
	<div class="col-md-10 offset-md-1 p-5 bg-main">
		<form action="/process" method="post">
			<?= csrf_field() ?>
			<div class="row mb-2">
				<div class="col-md-6">
					<div class="form-group">
						<?php if( isset( $errors['name'] ) ): ?>
							<input type="text" class="form-control form-control-lg is-invalid rounded-0" placeholder="Your Full Name" name="name" value="<?= old('name') ?>">
							<div class="invalid-feedback"><?php echo $errors['name']; ?></div>
						<?php else: ?>
							<input type="text" class="form-control form-control-lg rounded-0" placeholder="Your Full Name" name="name" value="<?= old('name') ?>">
						<?php endif; ?>
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<?php if( isset( $errors['email'] ) ): ?>
							<input type="text" class="form-control form-control-lg is-invalid rounded-0" placeholder="Email ID" name="email" value="<?= old('email') ?>">
							<div class="invalid-feedback"><?php echo $errors['email']; ?></div>
						<?php else: ?>
							<input type="text" class="form-control form-control-lg rounded-0" placeholder="Email ID" name="email" value="<?= old('email') ?>">
						<?php endif; ?>
					</div>
				</div>
			</div>

			<div class="row mb-2">
				<div class="col-md-6">
					<div class="form-group">
						<?php if( isset( $errors['company'] ) ): ?>
							<input type="text" class="form-control form-control-lg is-invalid rounded-0" placeholder="Company Name" name="company" value="<?= old('company') ?>">
							<div class="invalid-feedback"><?php echo $errors['company']; ?></div>
						<?php else: ?>
							<input type="text" class="form-control form-control-lg rounded-0" placeholder="Company Name" name="company" value="<?= old('company') ?>">
						<?php endif; ?>
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<?php if( isset( $errors['phone'] ) ): ?>
							<input type="text" class="form-control form-control-lg is-invalid rounded-0" placeholder="Phone Number" name="phone" value="<?= old('phone') ?>">
							<div class="invalid-feedback"><?php echo $errors['phone']; ?></div>
						<?php else: ?>
							<input type="text" class="form-control form-control-lg rounded-0" placeholder="Phone Number" name="phone" value="<?= old('phone') ?>">
						<?php endif; ?>
					</div>
				</div>
			</div>

			<div class="row mb-2">
				<div class="col-12">
					<div class="form-group">
						<?php if( isset( $errors['services'] ) ): ?>
							<input type="text" class="form-control form-control-lg is-invalid rounded-0" placeholder="Services Offered" name="services" value="<?= old('services') ?>">
							<div class="invalid-feedback"><?php echo $errors['services']; ?></div>
						<?php else: ?>
							<input type="text" class="form-control form-control-lg rounded-0" placeholder="Services Offered" name="services" value="<?= old('services') ?>">
						<?php endif; ?>
					</div>
				</div>
			</div>

			<div class="row mb-2">
				<div class="col-12">
					<div class="form-group">
						<?php if( isset( $errors['address'] ) ): ?>
							<textarea class="form-control form-control-lg is-invalid rounded-0" placeholder="Address" name="address"><?= old('address') ?></textarea>
							<div class="invalid-feedback"><?php echo $errors['address']; ?></div>
						<?php else: ?>
							<textarea class="form-control form-control-lg rounded-0" placeholder="Address" name="address"><?= old('address') ?></textarea>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<button class="btn btn-lg btn-main w-100" type="submit">Submit</button>
		</form>
	</div>
</main>