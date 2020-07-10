<main class="bg-white py-5">
	<?php 
		$session = \Config\Services::session(); 
		$msg = $session->getFlashdata('success_msg'); 
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
	<div class="container my-5">
		<h1 class="mb-5">List of all registered service providers</h1>
		<div class="table-responsive data-table">
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>Personal Information</th>
						<th>Company</th>
						<th>Address</th>
						<th>Services</th>
						<th class="text-center">Status</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($serviceProviders as $provider): ?>
					<tr>
						<td>
							<p><b>Name:</b> <?php echo $provider['name']; ?></p>
							<p><b>Email:</b> <?php echo $provider['email']; ?></p>
							<p><b>Phone:</b> <?php echo $provider['phone']; ?></p>
						</td>
						<td><?php echo $provider['company']; ?></td>
						<td><?php echo $provider['address']; ?></td>
						<td><?php echo $provider['services']; ?></td>
						<td class="text-center">
							<?php 
								$status = '';
								$statusIcon = '';
								switch( $provider['is_approved'] ) {
									case 0:
										$status = 'Rejected';
										$statusIcon = '<i class="fas fa-times rejected"></i>';
										break;
									case 1:
										$status = 'No Action';
										$statusIcon = '<i class="fas fa-eye-slash no-action"></i>';
										break;
									case 2:
										$status = 'Approved';
										$statusIcon = '<i class="fas fa-check approved"></i>';
										break;
								}
							?>
							<span class="status-icon"><?php echo $statusIcon; ?></span>
							<span class="status"><?php echo $status; ?></span>
						</td>
						<td class="text-center">
							<a href="<?php echo route_to('view-user', $provider['id']) ?>" class="icon icon-link">
								<i class="fas fa-external-link-alt"></i>
								<span class="status">View Details</span>
							</a>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</main>