<!DOCTYPE html>
<html lang="en">

<head>

<?php $this->load->view('admin/templates/header'); ?>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php $this->load->view('admin/templates/user_sidebar'); ?>
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

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Selamat Datang ..</h1>
                        
                    </div>
                    <h5 class="modal-title" id="exampleModalLabel">Berilah penilaian anda mengenai kualitas pelayanan yang diberikan oleh pihak perusahaan Odaita Hotel pada masing-masing pernyataan setiap dimensi Servqual dengan pilihan jawaban : Tidak Penting (TPG), Kurang Penting (KPG), Cukup Penting (CP), Penting (P), Sangat Penting (SP). Berikut Kuisioner Harapan</h5>
                    <h6 class="modal-title" id="exampleModalLabel"></h6>
                    
                    <!-- Content Row -->
                    <?php $this->load->view('pages/list2'); ?>
                    <!-- Content Row -->

                   

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php $this->load->view('admin/templates/footer'); ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?= site_url('admin/login/logout') ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- js -->
    <?php $this->load->view('admin/templates/js'); ?>
            <!-- End of js -->

</body>

</html>