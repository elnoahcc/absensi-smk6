<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title ?> | Absensi SMK Negeri 6 Surakarta</title>
  
  <?php
$fullName = session('user_name');
$parts = explode(' ', trim($fullName));

if (count($parts) > 1) {
    // Ambil nama depan & nama terakhir
    $displayName = $parts[0] . ' ' . end($parts);
} else {
    // Jika hanya satu kata
    $displayName = $fullName;
}
?>


  <?php $this->section('css'); ?>
    <!-- Import Font Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?=base_url()?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/plugins/sweetalert2/sweetalert2.min.css">

    <style>
    .card-title {
        color: #fff !important;
        font-size: 1.3rem;  /* ukuran standar h4 */
        font-weight: 600;
    }

        /* ===== COLOR VARIABLES ===== */
        :root {
            --primary-color: #1e40af;
            --primary-hover: #1e3a8a;
            --primary-light: #dbeafe;
            --secondary-color: #64748b;
            --bg-main: #f8fafc;
            --bg-sidebar: #ffffff;
            --bg-navbar: #ffffff;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --border-color: #e2e8f0;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        /* ===== BASE STYLES ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif !important;
            font-size: 14px !important;
            line-height: 1.6;
            color: var(--text-primary) !important;
            background-color: var(--bg-main) !important;
            letter-spacing: -0.01em;
        }
        
        /* ===== TYPOGRAPHY ===== */
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Inter', sans-serif !important;
            font-weight: 600;
            color: var(--text-primary) !important;
            letter-spacing: -0.02em;
        }
        
        h1 { font-size: 28px !important; line-height: 1.2; }
        h2 { font-size: 24px !important; line-height: 1.3; }
        h3 { font-size: 20px !important; line-height: 1.3; }
        h4 { font-size: 18px !important; line-height: 1.4; }
        h5 { font-size: 16px !important; line-height: 1.4; }
        h6 { font-size: 14px !important; line-height: 1.5; }
        
        p, span, label, .table, .form-control, .btn, .dropdown-item, .nav-link {
            font-size: 14px !important;
            font-family: 'Inter', sans-serif !important;
            color: var(--text-primary);
        }

        /* ===== NAVBAR STYLING ===== */
        .main-header.navbar {
            background-color: var(--bg-navbar) !important;
            border-bottom: 1px solid var(--border-color) !important;
            box-shadow: var(--shadow-sm) !important;
            height: 60px;
            padding: 0 1.5rem;
        }

        .navbar .nav-link {
            color: var(--text-primary) !important;
            padding: 0.5rem 1rem !important;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .navbar .nav-link:hover {
            background-color: var(--bg-main) !important;
            color: var(--primary-color) !important;
        }

        .navbar .nav-link i {
            color: var(--text-secondary) !important;
            font-size: 18px;
        }

        .navbar .form-inline h5 {
            color: var(--text-primary) !important;
            font-weight: 600 !important;
            font-size: 16px !important;
            margin: 0;
        }

        /* Dropdown User Menu */
        .navbar-nav .dropdown-menu {
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-md);
            border-radius: 8px;
            padding: 0.5rem;
            min-width: 200px;
        }

        .dropdown-item {
            border-radius: 6px;
            padding: 0.6rem 1rem !important;
            margin-bottom: 2px;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: var(--bg-main) !important;
            color: var(--primary-color) !important;
        }

        .dropdown-header {
            font-weight: 600 !important;
            color: var(--text-primary) !important;
            padding: 0.5rem 1rem !important;
        }

        /* ===== SIDEBAR STYLING ===== */
        .main-sidebar {
            background-color: var(--bg-sidebar) !important;
            border-right: 1px solid var(--border-color) !important;
            box-shadow: var(--shadow-sm) !important;
        }

        .brand-link {
            background-color: var(--bg-sidebar) !important;
            border-bottom: 1px solid var(--border-color) !important;
            padding: 1rem 1rem !important;
            height: 60px;
            display: flex;
            align-items: center;
        }

        .brand-link:hover {
            background-color: var(--bg-sidebar) !important;
        }

        .brand-text {
            color: var(--text-primary) !important;
            font-weight: 600 !important;
            font-size: 15px !important;
        }

        .brand-image {
            margin-right: 0.5rem;
            margin-left: 0.25rem;
        }

        /* Sidebar Navigation */
        .sidebar {
            padding-top: 1rem;
        }

        .sidebar .nav-link {
            color: var(--text-secondary) !important;
            border-radius: 8px;
            margin: 2px 12px;
            padding: 0.7rem 1rem !important;
            transition: all 0.2s ease;
            font-weight: 500;
        }

        .sidebar .nav-link:hover {
            background-color: var(--primary-light) !important;
            color: var(--primary-color) !important;
            transform: translateX(2px);
        }

        .sidebar .nav-link.active {
            background-color: var(--primary-color) !important;
            color: #ffffff !important;
            box-shadow: var(--shadow-sm);
        }

        .sidebar .nav-link.active p {
            color: #ffffff !important;
        }

        .sidebar .nav-link i {
            color: var(--text-secondary) !important;
            width: 20px;
            text-align: center;
            margin-right: 0.75rem;
        }

        .sidebar .nav-link:hover i {
            color: var(--primary-color) !important;
        }

        .sidebar .nav-link.active i {
            color: #ffffff !important;
        }

        .sidebar .nav-link p {
            margin: 0;
            display: inline;
        }

        /* ===== CONTENT AREA ===== */
        .content-wrapper {
            background-color: var(--bg-main) !important;
            min-height: calc(100vh - 60px);
        }

        .content-header {
            padding: 1.5rem 1.5rem 1rem 1.5rem;
            background-color: transparent !important;
        }

        .content-header .row {
            align-items: center;
        }

        .content {
            padding: 0 1.5rem 1.5rem 1.5rem;
        }

        /* ===== CARDS & BOXES ===== */
        .card {
            border: 1px solid var(--border-color);
            border-radius: 10px;
            box-shadow: var(--shadow-sm);
            background-color: #ffffff;
        }

        .card-header {
            background-color: #ffffff;
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 1.25rem;
            border-radius: 10px 10px 0 0 !important;
        }

        .card-body {
            padding: 1.25rem;
        }

        /* ===== BUTTONS ===== */
        .btn {
            border-radius: 6px !important;
            font-weight: 500 !important;
            padding: 0.5rem 1rem !important;
            transition: all 0.2s ease;
            border: none;
        }

        .btn-primary {
            background-color: var(--primary-color) !important;
            color: #ffffff !important;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover) !important;
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .btn-danger {
            background-color: #dc2626 !important;
        }

        .btn-danger:hover {
            background-color: #b91c1c !important;
        }

        .btn-default {
            background-color: #f1f5f9 !important;
            color: var(--text-primary) !important;
        }

        .btn-default:hover {
            background-color: #e2e8f0 !important;
        }

        /* ===== FORMS ===== */
        .form-control {
            border: 1px solid var(--border-color) !important;
            border-radius: 6px !important;
            padding: 0.6rem 0.875rem !important;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 3px var(--primary-light) !important;
        }

        /* ===== TABLES ===== */
        .table {
            color: var(--text-primary) !important;
        }

        .table thead th {
            border-bottom: 2px solid var(--border-color) !important;
            font-weight: 600 !important;
            text-transform: uppercase;
            font-size: 12px !important;
            letter-spacing: 0.05em;
            color: var(--text-secondary) !important;
            padding: 0.875rem !important;
        }

        .table tbody td {
            padding: 0.875rem !important;
            border-bottom: 1px solid var(--border-color) !important;
        }

        .table-hover tbody tr:hover {
            background-color: var(--bg-main) !important;
        }

        /* ===== MODAL ===== */
        .modal-content {
            border: 1px solid var(--border-color);
            border-radius: 10px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            border-bottom: 1px solid var(--border-color);
            padding: 1.25rem 1.5rem;
        }

        .modal-title {
            font-size: 18px !important;
            font-weight: 600 !important;
            color: var(--text-primary) !important;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            border-top: 1px solid var(--border-color);
            padding: 1rem 1.5rem;
        }

        /* ===== FOOTER ===== */
        .main-footer {
            background-color: #ffffff !important;
            border-top: 1px solid var(--border-color) !important;
            color: var(--text-secondary) !important;
            padding: 1rem 1.5rem;
        }

        .main-footer a {
            color: var(--primary-color) !important;
            text-decoration: none;
            font-weight: 500;
        }

        .main-footer a:hover {
            text-decoration: underline;
        }

        /* ===== UTILITY CLASSES ===== */
        .text-muted {
            color: var(--text-secondary) !important;
        }

        /* ===== SCROLLBAR ===== */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-main);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--text-secondary);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .content-header,
            .content {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }
    </style>
<?php $this->endSection(); ?>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="<?=base_url()?>assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?=base_url()?>assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <?= $this->renderSection('css'); ?>
  <link rel="stylesheet" href="<?=base_url()?>assets/css/adminlte.min.css">
  <link rel="icon" type="image/png" href="https://smkn6solo.sch.id/wp-content/uploads/2022/07/SMK-N-6-Surakarta.png">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <form class="form-inline ml-3">
      <h5 class="m-0">Sistem Absensi SMK Negeri 6 Surakarta</h5>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <span class="mr-2">
            <?php echo session('username'); ?>
          </span>
          <i class="far fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">Hi, <?= $displayName ?></span>
          <div class="dropdown-divider"></div>
          <a href="<?= base_url('profile') ?>" class="dropdown-item">
            <i class="fas fa-cogs mr-2"></i> User Setting
          </a>
          <a href="<?=base_url('logout')?>" class="dropdown-item" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-power-off mr-2"></i> Logout
          </a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar elevation-1">
    <!-- Brand Logo -->
    <a href="<?=base_url()?>" class="brand-link">
      <img src="https://smkn6solo.sch.id/wp-content/uploads/2022/07/SMK-N-6-Surakarta.png" 
           alt="Logo" class="brand-image" style="height:35px; width:auto;">
      <span class="brand-text">SMK N 6 Surakarta</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <?php $uri = current_url(true);?>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="<?=base_url()?>dashboard" class="nav-link <?php if($uri->getSegment(1) == 'dashboard') { echo "active"; } ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <?php if(session('user_role') != 'admin') { ?>
            <li class="nav-item">
            <a href="<?=base_url()?>log" class="nav-link <?php if($uri->getSegment(1) == 'log') { echo "active"; } ?>">
              <i class="nav-icon fas fa-book"></i>
              <p>Log</p>
            </a>
            </li>
          <?php } ?>
          <?php if(session('user_role') != 'user') { ?>
          <li class="nav-item">
            <a href="<?=base_url()?>category" class="nav-link <?php if($uri->getSegment(1) == 'category') { echo "active"; } ?>">
              <i class="nav-icon fas fa-list"></i>
              <p>Kelas</p>
            </a>
          </li>
          <?php } ?>
          <?php if(session('user_role') == 'admin') {?>
            <li class="nav-item">
              <a href="<?=base_url()?>user" class="nav-link <?php if($uri->getSegment(1) == 'user') { echo "active"; } ?>">
                <i class="nav-icon fas fa-users"></i>
                <p>Siswa</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?=base_url()?>admin" class="nav-link <?php if($uri->getSegment(1) == 'admin') { echo "active"; } ?>">
                <i class="nav-icon fas fa-user-secret"></i>
                <p>Admin</p>
              </a>
            </li>
          <?php } ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4 class="m-0"><b><?= $subtitle; ?></b></h4>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <?= $this->renderSection('action-button'); ?>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <?= $this->renderSection('content'); ?>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
<footer class="main-footer">
  <strong>
    Copyright &copy; <?= date('Y') ?>
    <a href="https://smkn6solo.sch.id/">SMK Negeri 6 Surakarta</a>.
  </strong>
  All rights reserved.
  <br>
  <small>Kolaborasi antara SMK Negeri 6 Surakarta dengan Enuma Technology</small>
</footer>


  <div class="modal fade" id="logoutModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Apakah kamu yakin?</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Pilih Log Out untuk mengahiri sesi.</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
          <a href="<?=base_url()?>logout" class="btn btn-danger">Log Out</a>
        </div>
      </div>
    </div>
  </div>
  <?= $this->renderSection('modal'); ?>

</div>
<!-- ./wrapper -->

<script src="<?=base_url()?>assets/plugins/jquery/jquery.min.js"></script>
<script src="<?=base_url()?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?=base_url()?>assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<?= $this->renderSection('js'); ?>
<script src="<?=base_url()?>assets/js/adminlte.js"></script>
</body>
</html>