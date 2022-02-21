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
				<h1 class="mt-4">Tambah Data</h1>
				<!--breadcrumb-->

				<!--end breadcrumb-->

				<?php if ($this->session->flashdata('success')): ?>
				<div class="alert alert-success" role="alert">
					<?php echo $this->session->flashdata('success'); ?>
				</div>
				<?php endif; ?>

				<div class="card mb-3">
					<div class="card-header">
						<a href="<?php echo site_url('admin/users/') ?>"><i class="fas fa-arrow-left"></i> Kembali</a>
					</div>
						<div class="card-body">

						<form action="<?php echo site_url('admin/users/add') ?>" method="post" enctype="multipart/form-data" >
								
								<div class="form-group">
									<label for="username">Username*</label>
									<input class="form-control <?php echo form_error('username') ? 'is-invalid':'' ?>"
									type="text" name="username" placeholder="username" />
									<div class="invalid-feedback">
										<?php echo form_error('username') ?>
									</div>
								</div>

								<div class="form-group">
									<label for="nama_lengkap">Nama_lengkap*</label>
									<input class="form-control <?php echo form_error('nama_lengkap') ? 'is-invalid':'' ?>"
									type="text" name="nama_lengkap" placeholder="nama_lengkap" />
									<div class="invalid-feedback">
										<?php echo form_error('nama_lengkap') ?>
									</div>
								</div>
								
								<div class="form-group">
									<label for="email">Email*</label>
									<input class="form-control <?php echo form_error('email') ? 'is-invalid':'' ?>"
									type="text" name="email" placeholder="email" />
									<div class="invalid-feedback">
										<?php echo form_error('email') ?>
									</div>
								</div>

								<div class="form-group">
									<label for="password">Password*</label>
									<input class="form-control <?php echo form_error('password') ? 'is-invalid':'' ?>"
									type="text" name="password" placeholder="password" />
									<div class="invalid-feedback">
										<?php echo form_error('password') ?>
									</div>
								</div>

								<div class="form-group">
									<label for="alamat">Alamat*</label>
									<textarea class="form-control <?php echo form_error('alamat') ? 'is-invalid':'' ?>"
									name="alamat" placeholder="alamat..."></textarea>
									<div class="invalid-feedback">
										<?php echo form_error('alamat') ?>
									</div>
								</div>

								<div class="form-group">
									<label for="jenis_kelamin">Jenis_kelamin*</label>
									<input class="form-control <?php echo form_error('jenis_kelamin') ? 'is-invalid':'' ?>"
									type="enum('laki_laki','perempuan')" name="jenis_kelamin" min="0" placeholder="jenis_kelamin" />
									<div class="invalid-feedback">
										<?php echo form_error('jenis_kelamin') ?>
									</div>
								</div>

								<div class="form-group">
									<label for="phone">Phone*</label>
									<input class="form-control <?php echo form_error('phone') ? 'is-invalid':'' ?>"
									type="number" name="phone" min="0" placeholder="phone" />
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
				</div>
				</div>
			</div>
			<!-- /.container-fluid -->

			<!-- Sticky Footer -->
			<footer class="py-4 bg-light mt-auto">
				<?php $this->load->view("admin/templates/footer.php") ?>
			</footer>

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

</body>

</html>






