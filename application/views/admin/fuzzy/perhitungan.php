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
				<h1 class="mt-4">Perhitungan</h1>
				<!--breadcrumb-->

				<!--end breadcrumb-->

				<!-- DataTables -->
				<h3 class="mt-4">Nilai Awal</h3>
				<table class="table ">
                <thead>
                </thead>
                <tbody>
                    <?php foreach($render->result() as $i=>$row){?>
                            <tr>
                            <?php $j=0;foreach($row as $col){ ?>
                                <td><?= $col?></td>
                            <?php $j++;} ?>
                            </tr>
                        <?php } ?>
                </tbody>
                </table>

                <hr>
                <!-- DataTables -->
				<h3 class="mt-4">BERIKUT MERUPAKAN TAHAP IMPLIKASI </h3>
				<table class="table ">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Harapan</th>
                        <th>Persepsi</th>
                        <th>Implikasi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($imp as $i=>$row){?>
                            <tr>
                                <td><?= ($i+1)?></td>
                            <?php foreach($row as $col){ ?>
                                <td><?= $col?></td>
                            <?php } ?>
                            </tr>
                        <?php } ?>
                </tbody>
                </table>

                
                <hr>
                <!-- DataTables -->
				<h3 class="mt-4">DEFUZZIFIKASI</h3>
				<table class="table ">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>M</th>
                        <th>a-predikat</th>
                        <th>Rule</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($deff as $i=>$row){?>
                            <tr>
                                <td>M-<?= ($i+1)?></td>
                            <?php foreach($row as $col){ ?>
                                <td><?= $col?></td>
                            <?php } ?>
                            </tr>
                        <?php } ?>
                </tbody>
                
				<h3 class="mt-4">Nilai Defuzzifikasi = <?= $z?> (<?= $hasil?>) </h3>
                </table>
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