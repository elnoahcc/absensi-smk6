<?php $this->extend('layout/main_layout'); ?>

<?php $this->section('css'); ?>
    <!-- Import Font Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?=base_url()?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/plugins/sweetalert2/sweetalert2.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif !important;
            font-size: 0.875rem; /* lebih kecil (14px) */
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Inter', sans-serif !important;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        h1 { font-size: 1.5rem; } /* 24px */
        h2 { font-size: 1.25rem; } /* 20px */
        h3 { font-size: 1.125rem; } /* 18px */
        h4 { font-size: 1rem; }    /* 16px */
        h5 { font-size: 0.95rem; } /* 15.2px */
        h6 { font-size: 0.875rem; }/* 14px */
        .table, .form-control, .btn, p, span, label {
            font-size: 0.85rem !important; /* samain biar rapi */
        }
    </style>
<?php $this->endSection(); ?>

<?php $this->section('content'); ?>
    <!-- Import Font Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif !important;
        }
        .info-box-text {
            font-weight: 600;
            font-size: 0.95rem;
        }
        .info-box h1 {
            font-weight: 700;
            font-size: 2rem;
            margin: 0.2rem 0;
        }
        .info-box small {
            color: #6c757d;
        }
        .brand-card p.h3 {
            font-weight: 700;
            margin-bottom: 0.25rem;
        }
        .brand-card p.text-muted {
            font-size: 0.9rem;
        }
        .img-md {
            width: 64px;
            height: auto;
        }
    </style>

    <div class="row">
        <!-- Total User Aktif -->
        <div class="col-lg-3 col-md-6 col-6 mb-3 order-lg-1 order-2">
            <div class="info-box h-100 shadow-sm">
                <span class="info-box-icon bg-lightblue elevation-1">
                    <i class="fas fa-user"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Total User Aktif</span>
                    <h1><?= esc($usercount['count_active']) ?></h1>
                    <small>dari <b><?= esc($usercount['count_all']) ?></b> user</small>
                </div>
            </div>
        </div>

        <!-- Total Grup -->
        <div class="col-lg-3 col-md-6 col-6 mb-3 order-lg-2 order-3">
            <div class="info-box h-100 shadow-sm">
                <span class="info-box-icon bg-info elevation-1">
                    <i class="fas fa-list"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Grup</span>
                    <h1><?= esc($categorycount['total']) ?></h1>
                    <small>&nbsp;</small>
                </div>
            </div>
        </div>

        <!-- Company Branding -->
        <div class="col-lg-6 col-12 mb-3 order-lg-3 order-1">
            <div class="card h-100 brand-card shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <img src="<?= base_url() ?>images/logo-smkn6.svg" class="img-md mr-3" alt="Logo SMK N 6">
                    <div>
                        <p class="h3">SMK Negeri 6 Surakarta</p>
                        <p class="m-0 text-muted">Sistem Aplikasi Manajemen Absensi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $this->endSection(); ?>
