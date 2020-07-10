<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="<?php echo base_url('css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('css/admin.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('css/fontawesome/all.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('css/select2.min.css'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,700;1,300&display=swap" rel="stylesheet">
	<title><?= esc($title); ?></title>
</head>
<body class="bg-main">
	<main class="py-5">
		<div class="container">
			<div class="login-form my-5 bg-white px-4 py-5">
				<?php 
					$session = \Config\Services::session(); 
					$errors = $session->getFlashdata('errors');
				?>
				<form action="<?= route_to('admin-auth'); ?>" method="post">
					<?= csrf_field() ?>
					<h1 class="text-center mb-5">Sign in to your account</h1>
					<?php if( isset($errors['invalidDetails']) ){ ?>
						<div class="alert alert-danger mb-4">
							<?php echo $errors['invalidDetails']; ?>
						</div>
					<?php } ?>
					<div class="form-group mb-5">
						<label for="email">Email</label>
						<input type="text" class="form-control form-control-lg rounded-0 <?php if( isset($errors['email']) ) { echo 'is-invalid'; } ?>" name="email" id="email" value="<?= old('email') ?>">
						<?php if(isset($errors['email'])) { ?>
							<div class="invalid-feedback"><?php echo $errors['email']; ?></div>
						<?php } ?>
					</div>
					<div class="form-group mb-5">
						<label for="password">Password</label>
						<input type="password" class="form-control form-control-lg rounded-0 <?php if( isset($errors['password']) ) { echo 'is-invalid'; } ?>" name="password" id="password">
						<?php if(isset($errors['password'])) { ?>
							<div class="invalid-feedback"><?php echo $errors['password']; ?></div>
						<?php } ?>
					</div>
					<button class="btn btn-lg w-100 btn-main" type="submit">Submit</button>
				</form>
			</div>
		</div>
	</main>
	<script type="text/javascript" src="<?php echo base_url('js/jquery.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('js/bootstrap.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('js/select2.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('js/admin.js'); ?>"></script>
</body>
</html>