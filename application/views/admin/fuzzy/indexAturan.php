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
				<h1 class="mt-4">Data Aturan</h1>
				<!--breadcrumb-->

				<!--end breadcrumb-->

				<!-- DataTables -->
				<div class="card mb-3">
					<div class="card-header">
						<a href="" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-plus"></i> Add New</a>
					</div>
					<div class="card-body">

						<div class="table-responsive">
							<table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th>Id Aturan</th>
										<th>Harapan</th>
										<th>Persepsi</th>
										<th>Pelayanan</th>
										
										
									</tr>
								</thead>
								<tbody>
                                    <?php 
                                    $i=1;
                                    foreach ($aturan as $a ) {
                                    ?>
                                    <tr>
                                        <td> <?= $i++ ?> </td>
                                        <td><?= $a->harapan ?></td>
                                        <td><?= $a->persepsi ?></td>
                                        <td><?= $a->pelayanan ?></td>
                                        
                                    </tr>
                                    <?php 
                                    }
                                    ?>
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
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        <form action="<?= base_url('admin/Fuzzy/storeAturan') ?> " method="post">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Aturan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
       
                <div class="form-group row">
                    <div class="col">
                    <label for="tangible" class="col-form-label">Harapan:</label>
                    <select name="tangible" class="form-control" id="tangible">
                        <?php 
                        foreach ($kepuasan as $k) {
                        ?>
                        <option value="<?= $k->kepuasan ?>"><?= $k->kepuasan ?></option>
                        <?php }?>
                    </select>
                    </div>
                    <div class="col">
                    <label for="reliability" class="col-form-label">Persepsi:</label>
                    <select name="reliability" class="form-control" id="tangible">
                        <?php 
                        foreach ($kepuasan as $k) {
                        ?>
                        <option value="<?= $k->kepuasan ?>"><?= $k->kepuasan ?></option>
                        <?php }?>
                    </select>
                    </div>
                    <div class="col">
                    <label for="responsibility" class="col-form-label">Pelayanan:</label>
                    <select name="responsibility" class="form-control" id="tangible">
                        <?php 
                        foreach ($kepuasan as $k) {
                        ?>
                        <option value="<?= $k->kepuasan ?>"><?= $k->kepuasan ?></option>
                        <?php }?>
                    </select>
                    </div>
                </div>

             
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
            </div>
        </div>
        </form>
    </div>



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