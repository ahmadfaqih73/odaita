<!DOCTYPE html>
<html lang="en">

<head>
	<?php $this->load->view("admin/templates/header.php") ?>
</head>

<body class="page-top">
	
	


	<!-- Page Wrapper -->
    <div id="wrapper">
	
		 <!-- Sidebar -->
		 <?php $this->load->view('admin/templates/sidebar'); ?>
        <!-- End of Sidebar -->
		

		<!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php $this->load->view('admin/templates/topbar'); ?>
                <!-- End of Topbar -->

				
                <!-- Begin Page Content -->
                <div class="container-fluid">

				

		<div id="layoutSidenav_content">
			<main>
			<div class="container-fluid px-4">
				<h1 class="mt-4">Form Data</h1>
				
				<?php if ($this->session->flashdata('success')): ?>
				<div class="alert alert-success" role="alert">
					<?php echo $this->session->flashdata('success'); ?>
				</div>
				<?php endif; ?>
				<!--breadcrumb-->

				<!--end breadcrumb-->

				<!-- DataTables -->
				<div class="card mb-3">
					<div class="card-header">
						<a href="<?php echo site_url('admin/users/add') ?>"><i class="fas fa-plus"></i> Add New</a>
					</div>
					<div class="card-body">

						<div class="table-responsive">
							<table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th>Username</th>
										<th>Nama_lengkap</th>
										<th>Email</th>
										<th>Password</th>
										<th>Alamat</th>
										<th>Jenis_kelamin</th>
										<th>Last_Login</th>
										<th>Terdaftar</th>
										<th>Phone</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($users as $user): ?> <!--?????-->
									<tr>
										<td>
											<?php echo $user->username ?>
										</td>
										<td>
											<?php echo $user->nama_lengkap ?>
										</td>
										<td>
											<?php echo $user->email ?>
										</td>
										<td>
											<?php echo $user->password ?>
										</td>
										
										
										<td class="small">
											<?php echo substr($user->alamat, 0, 120) ?>...</td>
										
										<td>
											<?php echo $user->jenis_kelamin ?>
										</td>
										<td>
											<?php echo $user->last_login ?>
										</td>
										<td>
											<?php echo $user->terdaftar?>
										</td>
										
										<td width="">
											<?php echo $user->phone ?>
										</td>
										
										<td width="100" >
											<div class="row">
												<a href="<?php echo site_url('admin/users/edit/'.$user->user_id) ?>"
												class="btn btn-small"><i class="fas fa-edit"></i></a>
												<a href="<?php echo site_url('admin/users/delete/'.$user->user_id) ?>" 
												onclick="return confirm('Apakah kamu yakin hapus <?php echo $user->nama_lengkap ?>');" 
												class="btn btn-small text-danger"><i class="fas fa-trash"></i></a>
											</div>	
										</td>
									</tr>
									<?php endforeach; ?>

								</tbody>
							</table>
						</div>
					</div>
				</div>

			</div>
			</main>
			<!-- /.container-fluid -->

			<!-- Sticky Footer -->
			<footer class="py-4 bg-light mt-auto">
				<?php $this->load->view("admin/templates/footer.php") ?>
			</footer>


		</div>
				</div>
			</div>
		</div>
		<!-- /.content-wrapper -->

	</div>
	<!-- /#wrapper -->

	<!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


	<!--scrolltop-->
	<!--endscrolltop-->
	<!--modal-->
	<!--end modal-->
	<?php $this->load->view("admin/templates/js.php") ?>


	<script>
	function deleteConfirm(url){
	$('#btn-delete').attr('href', url);
	$('#deleteModal').modal();
	}
	</script>
</body>

</html>