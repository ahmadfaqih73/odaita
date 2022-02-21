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
				<h1 class="mt-4">Edit Data</h1>
				
				
				<?php if ($this->session->flashdata('success')): ?>
				<div class="alert alert-success" role="alert">
					<?php echo $this->session->flashdata('success'); ?>
				</div>
				<?php endif; ?>

				<!-- Card  -->
				<div class="card mb-3">
					<div class="card-header">

						<a href="<?php echo site_url('admin/users/') ?>"><i class="fas fa-arrow-left"></i>
							Back</a>
					</div>
					<div class="card-body">

						<form action="<?= base_url('admin/users/edit_data/') ?>" method="post" enctype="multipart/form-data">
						<!-- Note: atribut action dikosongkan, artinya action-nya akan diproses 
							oleh controller tempat vuew ini digunakan. Yakni index.php/admin/products/edit/ID --->

							<input type="hidden" name="user_id" value="<?php echo $user->user_id?>" />

								<div class="form-group">
									<label for="username">Username*</label>
									
									<input class="form-control <?php echo form_error('username') ? 'is-invalid':'' ?>"
									type="text" name="username" value="<?php echo $user->username?>" />
									<div class="invalid-feedback">
										<?php echo form_error('username') ?>
									</div>
								</div>

								<div class="form-group">
									<label for="nama_lengkap">Nama_lengkap*</label>
									<input class="form-control <?php echo form_error('nama_lengkap') ? 'is-invalid':'' ?>"
									type="text" name="nama_lengkap" value="<?php echo $user->nama_lengkap ?>" />
									<div class="invalid-feedback">
										<?php echo form_error('nama_lengkap') ?>
									</div>
								</div>

								<div class="form-group">
									<label for="email">Email*</label>
									<input class="form-control <?php echo form_error('email') ? 'is-invalid':'' ?>"
									type="text" name="email" value="<?php echo $user->email ?>" />
									<div class="invalid-feedback">
										<?php echo form_error('email') ?>
									</div>
								</div>

								<div class="form-group">
									<label for="password">Password*</label>
									<input class="form-control <?php echo form_error('password') ? 'is-invalid':'' ?>"
									type="text" name="password" value="<?php echo $user->password?>" />
									<div class="invalid-feedback">
										<?php echo form_error('password') ?>
									</div>
								</div>

								<div class="form-group">
									<label for="alamat">Alamat*</label>
									<textarea class="form-control <?php echo form_error('alamat') ? 'is-invalid':'' ?>"
									name="alamat" ><?php echo $user->alamat?></textarea>
									<div class="invalid-feedback">
										<?php echo form_error('alamat') ?>
									</div>
								</div>

								<div class="form-group">
									<label for="jenis_kelamin">Jenis_kelamin*</label>
									<input class="form-control <?php echo form_error('jenis_kelamin') ? 'is-invalid':'' ?>"
									type="text" name="jenis_kelamin" value="<?php echo $user->jenis_kelamin?>" />
									<div class="invalid-feedback">
										<?php echo form_error('jenis_kelamin') ?>
									</div>
								</div>

								<div class="form-group">
									<label for="phone">phone*</label>
									<input class="form-control <?php echo form_error('phone') ? 'is-invalid':'' ?>"
									type="number" name="phone" min="0" value="<?php echo $user->phone?>" />
									<div class="invalid-feedback">
										<?php echo form_error('phone') ?>
									</div>
								</div>

							<input class="btn btn-success" type="submit" name="btn" value="Save" />
						</form>

					</div>

					<div class="card-footer small text-muted">
						* required fields
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





		