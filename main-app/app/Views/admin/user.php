<main class="py-5 bg-white">
	<?php 
		$session = \Config\Services::session(); 
		$msg = $session->getFlashdata('success_msg'); 
		$errors = $session->getFlashdata('errors');
	?>
	<?php if( isset( $msg ) ){ ?>
		<div class="container mb-5">
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
	<?php if( isset( $errors['logo'] ) ){ ?>
		<div class="container mb-5">
			<div class="row">
				<div class="offset-md-2 col-md-8 alert alert-danger alert-dismissible fade show" role="alert">
					<?php echo $errors['logo']; ?>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					</button>
				</div>
			</div>
		</div>
	<?php } ?>
	<div class="container">
		<div class="row">
			<?php 
				$status = '';
				$statusIcon = '';
				switch( $serviceprovider['is_approved'] ){
					case 0:
						$status = 'Rejected';
						$statusIcon = '<i class="fas fa-times-circle" style="color: #d80707;"></i>';
						break;
					case 1:
						$status = 'Not Approved Yet';
						$statusIcon = '<i class="fas fa-exclamation-circle" style="color: #868686;"></i>';
						break;
					case 2:
						$status = 'Approved';
						$statusIcon = '<i class="fas fa-check-double" style="color: #e51c48;"></i>';
						break;
				}
			?>
			<div class="col-md-5">
				<h4>Status: <?php echo $status; ?> <?php echo $statusIcon; ?></h4>
			</div>
			<div class="col-md-7 text-right">
				<?php if( $serviceprovider['is_approved'] == 0 ){ ?>
					<form action="<?= route_to('approve-user', $serviceprovider['id']); ?>" method="post" class="d-inline">
						<button class="btn btn-main btn-sm mr-2">
							<i class="fas fa-check-square mr-1"></i> Approve
						</button>
					</form>
					<button class="btn btn-dark btn-sm dlt-user" data-toggle="modal" data-target="#userDeleteModal">
						<i class="fas fa-times-circle"></i> Delete
					</button>
				<?php } elseif( $serviceprovider['is_approved'] == 1 ) { ?>
					<form action="<?= route_to('approve-user', $serviceprovider['id']); ?>" method="post" class="d-inline">
						<button class="btn btn-main btn-sm mr-2">
							<i class="fas fa-check-square mr-1"></i> Approve
						</button>
					</form>
					<form action="<?= route_to('reject-user', $serviceprovider['id']); ?>" method="post" class="d-inline">
						<button class="btn btn-dark btn-sm">
							<i class="fas fa-times-circle"></i> Reject
						</button>
					</form>
				<?php } elseif( $serviceprovider['is_approved'] == 2 ) { ?>
					<form action="<?= route_to('reject-user', $serviceprovider['id']); ?>" method="post">
						<button type="submit" class="btn btn-dark btn-sm">
							<i class="fas fa-times-circle"></i> Reject
						</button>
					</form>
				<?php } ?>
			</div>
		</div>
	</div>
	<div class="container my-5">
		<div class="row my-4">
			<div class="col-md-6 personal-info">
				<h2 class="mb-5">User Details:</h2>
				<div class="mb-3 pb-3 border-bottom">
					<span class="title">Name:</span> <?php echo $serviceprovider['name']; ?>
				</div>
				<div class="mb-3 pb-3 border-bottom">
					<span class="title">Email:</span> <?php echo $serviceprovider['email']; ?>
				</div>
				<div class="mb-3 pb-3 border-bottom">
					<span class="title">Company:</span> <?php echo $serviceprovider['company']; ?>
				</div>
				<div class="mb-3 pb-3 border-bottom">
					<span class="title">Phone:</span> <?php echo $serviceprovider['phone']; ?>
				</div>
				<div class="mb-3 pb-3 border-bottom">
					<span class="title">Services:</span> <?php echo $serviceprovider['services']; ?>
				</div>
				<div class="mb-3 pb-3">
					<span class="title">Address:</span> <?php echo $serviceprovider['address']; ?>
				</div>
				<a class="btn btn-main btn-lg w-100 mt-2" style="color: #fff;" href="<?= route_to('edit-user', $serviceprovider['id']); ?>">
					Edit Personal Information
				</a>
			</div>
			<div class="col-md-6">
				<h2 class="mb-5">Add/update additional information</h2>
				<form action="<?= route_to('process-additional-info', $serviceprovider['id']) ?>" method="post" enctype="multipart/form-data">
					<div class="form-group border-bottom pb-4">
						<label for="comment">Add Comment</label>
						<textarea name="comment" id="comment" class="form-control form-control-lg" rows="6"><?php echo $serviceprovider['comment']; ?></textarea>
					</div>
					<!-- Dropdown removed from here -->
					<?php $services_list = $serviceprovider['services_list'] ? unserialize( $serviceprovider['services_list'] ): []; ?>
					<div class="form-group border-bottom pb-4">
						<label for="servicespicker">Add Services</label>
        				<select class="servicespicker form-control form-control-lg" name="services_list[]" multiple="multiple" id="servicespicker">
							<?php foreach ($services as $service) { ?>
								<option value="<?= $service['name']; ?>" <?php if( in_array($service['name'], $services_list) ) { echo "selected"; } ?> >
									<?= $service['name']; ?>
								</option>
							<?php } ?>
						</select>
					</div>
					<div class="row justify-content-between align-items-center mt-4 border-bottom pb-4 no-gutters">
						<div class="col-6">
							<label for="logo">Upload Logo</label>
							<input type="file" id="logo" name="logo">
						</div>
						<div class="col-4">
							<div class="text-center">
								<?php 
									$logo = '';
									$logo = $serviceprovider['logo'] ? $serviceprovider['logo'] : 'logo-dummy.png';
									$logoPath = '/uploads/images/' . $logo;
								?>
								<img src="<?php echo base_url($logoPath); ?>" class="img-thumbnail">
							</div>
						</div>
					</div>
					<div class="row justify-content-between align-items-center mt-4 border-bottom pb-4 no-gutters">
						<div class="col-lg-6">
							<label for="documents">Upload Documents</label>
							<input type="file" id="documents" name="documents[]" multiple>
						</div>
						<div class="col-lg-5 mt-4 mt-lg-0">
							<?php foreach ($providerDocuments as $document) { ?>
								<div class="row border-bottom pb-2 mb-2 doc-link align-items-center">
									<?php 
									$docPath = base_url('/uploads/documents/' . $document['document']); 
									?>
									<div class="col-10">
										<a href="<?php echo $docPath; ?>" target="_blank">
											<?php echo $document['document']; ?>
										</a>
									</div>
									<div class="col-2">
										<a href="<?= route_to('delete-document', $document['id']); ?>" class="dlt-icon">
											<i class="fas fa-trash-alt"></i>
										</a>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
					<button class="btn btn-lg btn-main mt-5 w-100" type="submit">Submit</button>
				</form>
			</div>
		</div>
	</div>
</main>
<?php // Service provider delete modal ?>
<div class="modal fade" id="userDeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      	<div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Are You Sure?</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
      	</div>
      	<div class="modal-body">
       		This user and all his details (logo and documents) will be deleted.
      	</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <form action="<?= route_to('delete-user', $serviceprovider['id']); ?>" method="post" class="d-inline">
			<button class="btn btn-main">
				Yes, Delete
			</button>
		</form>
      </div>
    </div>
  </div>
</div>