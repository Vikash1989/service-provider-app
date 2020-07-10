<main class="bg-white py-5">
	<?php 
		$session = \Config\Services::session(); 
		$errors = $session->getFlashdata('errors'); 
		$msg = $session->getFlashdata('success_msg'); 
	?>
	<?php if( isset( $errors['name'] ) ){ ?>
		<div class="container mb-3">
			<div class="row">
				<div class="offset-md-2 col-md-8 alert alert-danger alert-dismissible fade show" role="alert">
					<?php echo $errors['name']; ?>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					</button>
				</div>
			</div>
		</div>
	<?php } ?>
	<?php if( isset( $msg ) ){ ?>
		<div class="container mb-3">
			<div class="row">
				<div class="offset-md-2 col-md-8 alert alert-success alert-dismissible fade show" role="alert">
					<?php  echo $msg; ?>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					</button>
				</div>
			</div>
		</div>
	<?php  } ?>
	<div class="container">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<form action="<?= route_to('add-service'); ?>" method="post">
					<?= csrf_field() ?>
					<div class="row">
						<div class="col-md-8">
							<input type="text" name="name" class="form-control form-control-lg mx-md-2 mb-4 mb-md-0 <?php if(isset($errors['name'])) { echo 'is-invalid'; } ?>" placeholder="Enter Service Title" value="<?= old('name') ?>">
						</div>
						<div class="col-md-4">
							<button type="submit" class="btn btn-main btn-lg w-100">Add Service</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<div class="row all-services my-5">
					<!-- 1 -->
					<?php foreach ($services as $service) { ?>
						<div class="col-md-4 service-tab border">
							<div class="row align-items-center py-4 h-100">
								<div class="col-10"><?= $service['name']; ?></div>
								<div class="col-2">
									<a href="<?= route_to('delete-service', $service['id']); ?>" class="dlt-icon">
										<i class="fas fa-trash-alt"></i>
									</a>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</main>