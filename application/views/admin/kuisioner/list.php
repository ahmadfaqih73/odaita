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
				<h1 class="mt-4">Data Kuisioner</h1>
				
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
						<a href="<?php echo site_url('admin/assurance/add') ?>"><i class="fas fa-plus"></i> Tambahkan</a>
					</div>
					<div class="card-body">

						<div class="table-responsive">
							<table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th>Id_jawaban</th>
										<th>Username</th>
										<th>Tanggal</th>
										<th>Kritik</th>
										<th>harapan</th>
										<th>Persepsi</th>
										<th>Status</th>
										<th>Opsi</th>
									</tr>
								</thead>
								<tbody>
								<?php $no =0;?>
									<?php foreach ($jawaban as $jawaban): 
										 $no++ ?> <!--?????-->

									<tr>
										<td>
											<?php echo $no ?>
										</td>
										
										<td>
											<?php echo $jawaban->username ?>
										</td>
										<td>
											<?php echo $jawaban->tanggal ?>
										</td>
										<td>
											<?php echo $jawaban->kritik ?>
										</td>
										<td>
											<?php echo $jawaban->Harapan ?>
										</td>
										<td>
											<?php echo $jawaban->Persepsi ?>
										</td>
										
										<td>
											<a  href="<?= site_url('admin/fuzzy/perhitungan/'.$jawaban->code_quisioner) ?>" class="btn <?= ( $jawaban->status == "Sudah" ? "btn-success" : "btn-danger" )?>" ><?= $jawaban->status ?></a>
										</td>
										
										
										<td width="100" >
											<div class="row">
												<a href="<?= site_url('admin/fuzzy/perhitungan/'.$jawaban->code_quisioner) ?>"
												class="btn btn-small"><i class="fas fa-edit"></i> Hitung</a>
												<a href="<?php echo site_url('admin/kuisioner/delete/'.$jawaban->id_jawaban) ?>" 
												onclick="return confirm('Apakah kamu yakin hapus <?php echo $jawaban->id_jawaban ?>');" 
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