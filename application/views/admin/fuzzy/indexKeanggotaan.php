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
				<h1 class="mt-4">Data Keanggotaan</h1>
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
										<th>No</th>
										<th>tipe</th>
										<th>Variabel</th>
										<th>Keanggotaan</th>
										<th>Fungsi</th>
										<th>Batas Bawah</th>
										<th>Batas Tengah</th>
										<th>Batas Atas</th>
										
									</tr>
								</thead>
								<tbody>
									<?php 
                                    $i=1;
                                    foreach ($keanggotaan as $k) {
                                    ?>
                                    <tr>
                                        <th><?= $i++ ?></th>
										<th><?= $k->tipe ?></th>
										<th><?= $k->variabel ?></th>
										<th><?= $k->nm_keanggotaan ?></th>
										<th><?= $k->nama_fungsi ?></th>
										<th><?= $k->nilai_batas_bawah ?> </th>
										<th><?= $k->nilai_batas_tengah ?> </th>
										<th><?= $k->nilai_batas_atas ?> </th>
										
                                    </tr>
                                    <?php 
                                    }?>
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
        <form action="<?= base_url('admin/Fuzzy/storeKeanggotaan') ?> " method="post">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Keanggotaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col">
                    <label for="variabel" class="col-form-label">Tipe:</label>
                    <select name="tipe" class="form-control" id="nm_keanggotaan">
                        
                        <option value="Input">Input</option>
                        <option value="Output">Output</option>
                        
                    </select>
                    </div>
                    <div class="col">
                    <label for="variabel" class="col-form-label">Variabel:</label>
                    <select name="variabel" class="form-control" id="nm_keanggotaan">
                        
                        <option value="Persepsi">Persepsi</option>
                        <option value="Harapan">Harapan</option>
                        <option value="Pelayanan">Pelayanan</option>
                        
                    </select>
                    </div>
                    <div class="col">
                    <label for="nm_keanggotaan" class="col-form-label">Keanggotaan:</label>
                    <select name="nm_keanggotaan" class="form-control" id="nm_keanggotaan">
                        <?php 
                        foreach ($kepuasan as $k) {
                        ?>
                        <option value="<?= $k->alias ?>"><?= $k->alias ?></option>
                        <?php }?>
                    </select>
                    </div>
                    <div class="col">
                    <label for="nama_fungsi" class="col-form-label">Nama Fungsi:</label>
                    <select name="nama_fungsi" class="form-control" id="nama_fungsi">
                       <option value="Linear Turun">Linear Turun</option>
                       <option value="Segitiga">Segitiga</option>
                       <option value="Linear Naik">Linear Naik</option>
                    </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col">
                        <label for="nilai_batas_bawah" class="col-form-label">Nilai Batas Bawah:</label>
                        <input type="nummber" name="nilai_batas_bawah" class="form-control"/>
                        </div>
                        <div class="col">
                        <label for="nilai_batas_tengah" class="col-form-label">Nilai Batas Tegah:</label>
                        <input type="nummber" name="nilai_batas_tengah" class="form-control" id="tangible"/>
                        </div>
                        <div class="col">
                        <label for="nilai_batas_atas" class="col-form-label">Nilai Batas Atas:</label>
                        <input type="nummber" name="nilai_batas_atas" class="form-control" id="tangible"/>
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