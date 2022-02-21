<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
    
    <img src="<?= base_url('assets/') ; ?>admin/img/odaita.png">
                
    
    
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="<?php echo site_url('index.php') ?>">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        Dashboard</a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Administrator
</div>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-cog"></i>
        <span>Input Dimensi</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Kriteria Dimensi:</h6>
            <a class="collapse-item" href="<?php echo site_url('admin/Tangible') ?>">Tangible</a>
            <a class="collapse-item" href="<?php echo site_url('admin/Reliability') ?>">Reliability</a>
            <a class="collapse-item" href="<?php echo site_url('admin/Responsivenes') ?>">Responsivenes</a>
            <a class="collapse-item" href="<?php echo site_url('admin/Assurance') ?>">Assurance</a>
            <a class="collapse-item" href="<?php echo site_url('admin/Emphaty') ?>">Emphaty</a>
        </div>
    </div>
</li>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a  href="<?php echo site_url('admin/users/') ?>"class="nav-link collapsed" 
        aria-expanded="true" aria-controls="collapsePages">
        <i class="fas fa-fw fa-user"></i>
        Manajemen User
    </a>
    
</li>


<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Fuzzy
</div>
<!-- Nav Item - Utilities Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFuzzy"
        aria-expanded="true" aria-controls="collapseFuzzy">
        <i class="fas fa-fw fa-cog"></i>
        <span>Fuzzy</span>
    </a>
    <div id="collapseFuzzy" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?php echo site_url('admin/Fuzzy/keanggotaan') ?>">Keanggotaan</a>
            <a class="collapse-item" href="<?php echo site_url('admin/Fuzzy/aturan') ?>">Aturan</a>
            <a class="collapse-item" href="<?php echo site_url('admin/Fuzzy/perhitungan') ?>">Perhitungan</a>
        </div>
    </div>
</li>


<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Proses
</div>

<!-- Nav Item - Utilities Collapse Menu -->
<li class="nav-item">
    <a  href="<?php echo site_url('admin/Kuisioner/') ?>"class="nav-link collapsed" 
        aria-expanded="true" aria-controls="collapsePages">
        <i class="fas fa-fw fa-user"></i>
        Data kuisioner
    </a>
    
</li>

<!-- Nav Item - Charts -->


<!-- Nav Item - Tables -->
<li class="nav-item">
        <a  href="<?php echo site_url('admin/Hasil/') ?>"class="nav-link collapsed" 
        aria-expanded="true" aria-controls="collapsePages">
        <i class="fas fa-fw fa-table"></i>
        Hasil kuisioner
    </a>
    
</li>

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

<!-- Sidebar Message -->


</ul>
<!-- End of Sidebar -->