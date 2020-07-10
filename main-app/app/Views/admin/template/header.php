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
	<header class="bg-light">
		<div class="container">
			<div class="main-logo text-center">
				<img src="<?= base_url('/uploads/images/logo.jpg'); ?>" alt="">
			</div>
		</div>
	</header>
	<div class="bg-dark">
		<div class="container px-0">
			<div class="navbar navbar-expand-lg navbar-dark">
				<button class="navbar-toggler collapsed ml-auto" type="button" data-toggle="collapse" data-target="#admin-navbar" aria-controls="admin-navbar" aria-expanded="false" aria-label="Toggle navigation">
			        <span class="navbar-toggler-icon"></span>
			    </button>
			    <div class="navbar-collapse collapse" id="admin-navbar">
					<ul class="navbar-nav">
						<li class="nav-item">
							<a href="<?= route_to('admin-dashboard'); ?>" class="nav-link text-light">Dashboard</a>
						</li>
						<li class="nav-item">
							<a href="<?= route_to('services'); ?>" class="nav-link text-light">Services</a>
						</li>
					</ul>
					<ul class="navbar-nav ml-auto">
						<li class="nav-item">
							<a href="<?= route_to('admin-logout'); ?>" class="nav-link text-light">Logout</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>