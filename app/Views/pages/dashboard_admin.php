<?php $this->extend('layout/main_layout'); ?>

<?php $this->section('css'); ?>
    <!-- Import Font Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?=base_url()?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/plugins/sweetalert2/sweetalert2.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif !important;
            font-size: 0.875rem;
            background-color: #f5f5f5;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Inter', sans-serif !important;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        h1 { font-size: 1.5rem; }
        h2 { font-size: 1.25rem; }
        h3 { font-size: 1.125rem; }
        h4 { font-size: 1rem; }
        h5 { font-size: 0.95rem; }
        h6 { font-size: 0.875rem; }
        
        .table, .form-control, .btn, p, span, label {
            font-size: 0.85rem !important;
        }

        /* Info Box */
        .modern-info-box {
            background: #ffffff;
            border-radius: 8px;
            padding: 1.5rem;
            border: 1px solid #ddd;
            height: 100%;
        }
        
        .modern-icon-wrapper {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }
        
        .modern-icon-wrapper i {
            font-size: 1.4rem;
            color: #ffffff;
        }
        
        .modern-info-label {
            font-size: 0.8rem;
            color: #666;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        
        .modern-info-value {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            line-height: 1.2;
            margin-bottom: 0.5rem;
        }
        
        .modern-info-subtitle {
            font-size: 0.8rem;
            color: #999;
        }
        
        .modern-info-subtitle b {
            color: #666;
        }

        /* Brand Card */
        .modern-brand-card {
            background: #ffffff;
            border-radius: 8px;
            border: 1px solid #ddd;
            height: 100%;
        }
        
        .modern-brand-card .card-body {
            padding: 2rem;
        }
        
        .brand-logo-wrapper {
            width: 90px;
            height: 90px;
            background: #f8f9fa;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        
        .brand-logo-wrapper img {
            width: 65px;
            height: auto;
        }
        
        .brand-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.4rem;
            color: #333;
            line-height: 1.3;
        }
        
        .brand-subtitle {
            font-size: 1rem;
            color: #666;
            margin: 0;
            line-height: 1.4;
        }

        /* Warna Icon */
        .bg-blue {
            background: #3498db;
        }
        
        .bg-green {
            background: #2ecc71;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .modern-info-value {
                font-size: 1.75rem;
            }
            
            .modern-icon-wrapper {
                width: 45px;
                height: 45px;
            }
            
            .modern-icon-wrapper i {
                font-size: 1.2rem;
            }
            
            .modern-brand-card .card-body {
                padding: 1.5rem;
            }
            
            .brand-logo-wrapper {
                width: 70px;
                height: 70px;
            }
            
            .brand-logo-wrapper img {
                width: 50px;
            }
            
            .brand-title {
                font-size: 1.15rem;
            }
            
            .brand-subtitle {
                font-size: 0.9rem;
            }
        }
    </style>
<?php $this->endSection(); ?>

<?php $this->section('content'); ?>
    <div class="row">
        <!-- Total User Aktif -->
        <div class="col-lg-3 col-md-6 col-6 mb-3 order-lg-1 order-2">
            <div class="modern-info-box">
                <div class="modern-icon-wrapper bg-blue">
                    <i class="fas fa-users"></i>
                </div>
                <div class="modern-info-label">Total User Aktif</div>
                <div class="modern-info-value"><?= esc($usercount['count_active']) ?></div>
                <div class="modern-info-subtitle">dari <b><?= esc($usercount['count_all']) ?></b> total user</div>
            </div>
        </div>

        <!-- Total Kelas -->
        <div class="col-lg-3 col-md-6 col-6 mb-3 order-lg-2 order-3">
            <div class="modern-info-box">
                <div class="modern-icon-wrapper bg-green">
                    <i class="fas fa-school"></i>
                </div>
                <div class="modern-info-label">Total Kelas</div>
                <div class="modern-info-value"><?= esc($categorycount['total']) ?></div>
                <div class="modern-info-subtitle">kelas terdaftar</div>
            </div>
        </div>

        <!-- Company Branding -->
        <div class="col-lg-6 col-12 mb-3 order-lg-3 order-1">
            <div class="card modern-brand-card">
                <div class="card-body d-flex align-items-center">
                    <div class="brand-logo-wrapper mr-4">
                        <img src="<?= base_url() ?>images/logo-smkn6.svg" alt="Logo SMK N 6">
                    </div>
                    <div>
                        <p class="brand-title">SMK Negeri 6 Surakarta</p>
                        <p class="brand-subtitle">Sistem Aplikasi Manajemen Absensi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $this->endSection(); ?>