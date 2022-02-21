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
				<h1 class="mt-4">Daya Tanggap</h1>
				

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
						<a href="<?php echo site_url('admin/responsivenes/add') ?>"><i class="fas fa-plus"></i> Tambahkan</a>
					</div>
					<div class="card-body">

						<div class="table-responsive">
							<table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th>No</th>
										<th>Kode pernyataan</th>
										<th>Pernyataan</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								<?php $no =0;?>
									<?php foreach ($pernyataan as $pernyataan): 
										 $no++ ?> <!--?????-->

									<tr>
										<td>
											<?php echo $no ?>
										</td>
										<td>
											<?php echo $pernyataan->kode_kriteria ?>
										</td>
										<td>
											<?php echo $pernyataan->pernyataan ?>
										</td>
										
										<td width="100" >
											<div class="row">
												<a href="<?php echo site_url('admin/responsivenes/edit/'.$pernyataan->id) ?>"
												class="btn btn-small"><i class="fas fa-edit"></i> Edit</a>
												<a href="<?php echo site_url('admin/responsivenes/delete/'.$pernyataan->id) ?>" 
												onclick="return confirm('Apakah kamu yakin hapus <?php echo $pernyataan->kode_kriteria ?>');" 
												class="btn btn-small text-danger"><i class="fas fa-trash"></i> Hapus</a>
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