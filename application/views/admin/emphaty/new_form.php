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
				<h3 class="mt-4">Tambah Emphaty</h3>
				
				<!--breadcrumb-->

				<!--end breadcrumb-->

				<!-- DataTables -->
				<div class="card mb-3">	
					<div class="card-header">

						<a href="<?php echo site_url('admin/emphaty/') ?>"><i class="fas fa-arrow-left"></i>
							Back</a>
					</div>
			
					<div class="card-body">

						<div class="table-responsive">
							<table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
							<form class="user" action="<?= base_url('admin/emphaty/store') ?>" method="post" enctype="multipart/form-data" >
						
							<input hidden type="text" name="id_dimensi" value="5">

						   <div class="form-group">
							   <label for="kode_kriteria">Kode Kriteria*</label>
							   <input class="form-control" required
							   type="text" name="kode_kriteria" placeholder="Kode Kriteria" />
						   </div>

						   <div class="form-group">
							   <label for="pernyataan">Pernyataan*</label>
							   <textarea class="form-control" required
							   name="pernyataan" placeholder="Pernyataan..."></textarea>

						   </div>

						   
   
					   <button class="btn btn-success" type="submit" name="btn">simpan</button>
				   </form>
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