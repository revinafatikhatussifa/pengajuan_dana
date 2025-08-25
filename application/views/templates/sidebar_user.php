<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #000000;">


    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('user'); ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-user"></i>
        </div>
        <div class="sidebar-brand-text mx-3">User DataLoka</div>
    </a>

    <hr class="sidebar-divider">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('user'); ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Nav Item - Form Pengajuan -->
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('user/rincian'); ?>">
            <i class="fas fa-fw fa-edit"></i>
            <span>Rincian Pengajuan</span></a>
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
