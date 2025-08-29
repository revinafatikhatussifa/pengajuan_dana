<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #000000;">
    
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('admin'); ?>">
        <div class="sidebar-brand-icon">
            <i class="fas fa-fw fa-user-tie"></i>
        </div>
        <div class="sidebar-brand-text mx-3">DataLoka Admin</div>
    </a>

    <hr class="sidebar-divider">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('admin'); ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Nav Item - Daftar Pengajuan -->
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('admin/daftar'); ?>">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Daftar Pengajuan</span></a>
    </li>

     <li class="nav-item">
        <a class="nav-link" href="<?= base_url('admin/rincian'); ?>">
            <i class="fas fa-fw fa-edit"></i>
            <span>Daftar rincian</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('admin/dokumen'); ?>">
            <i class="fas fa-fw fa-folder"></i>
            <span>Daftar dokumen</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('admin/laporan'); ?>">
            <i class="fas fa-fw fa-address-book"></i>
            <span>Laporan</span></a>
    </li>

    <hr class="sidebar-divider">

    <!-- Nav Item - Logout -->
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('auth/logout'); ?>">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span></a>
    </li>

</ul>
<!-- End of Sidebar -->
