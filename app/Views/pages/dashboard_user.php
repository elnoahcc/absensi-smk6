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
            font-family: 'Inter', sans-serif;
            background: #f3f4f6;
        }

        /* Card & Box Style */
        .info-box {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(14px);
            border-radius: 18px;
            border: 1px solid rgba(255,255,255,0.5);
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            padding: 20px;
            display: flex;
            align-items: center;
            transition: all 0.25s ease;
        }
        .info-box:hover {
            transform: translateY(-5px) scale(1.01);
            box-shadow: 0 12px 32px rgba(0,0,0,0.15);
        }

        .info-box-content {
            flex: 1;
        }

        .info-box-content span.info-box-text {
            font-size: 15px;
            font-weight: 500;
            color: #6b7280;
            letter-spacing: 0.2px;
        }

        .info-box-content h1,
        .info-box-content h5 {
            margin: 6px 0;
            font-weight: 700;
            color: #111827;
        }

        .info-box-content small {
            font-size: 13px;
            color: #6b7280;
        }

        /* Header with action */
        .info-box-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .info-box-header a {
            display: inline-flex;
            align-items: center;
            color: #2563eb;
            transition: color 0.2s ease;
        }
        .info-box-header a:hover {
            color: #1d4ed8;
        }

        /* Futuristic Link Icon */
        .link-icon {
            width: 18px;
            height: 18px;
            stroke-width: 2.2;
        }

        /* Branding Card */
        .card {
            border-radius: 20px;
            border: 1px solid rgba(255,255,255,0.4);
            background: linear-gradient(135deg, rgba(255,255,255,0.9), rgba(245,245,245,0.7));
            backdrop-filter: blur(14px);
            box-shadow: 0 8px 28px rgba(0,0,0,0.12);
            overflow: hidden;
            transition: all 0.25s ease;
        }
        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 36px rgba(0,0,0,0.18);
        }

        .card-body {
            padding: 28px;
        }

        .card-body img {
            height: 64px;
            width: auto;
        }

        .card-body p.h3 {
            font-size: 1.55rem;
            color: #111827;
        }
        .card-body p.text-muted {
            color: #6b7280 !important;
            font-size: 0.95rem;
        }
    </style>

    <div class="row">
        <!-- User Welcome -->
        <div class="col-lg-3 col-md-6 col-12 mb-3 order-lg-1 order-2">
            <div class="info-box h-100">
                <div class="info-box-content">
                    <span class="info-box-text">Selamat Datang</span>
                    <h5>
                        <?=esc($user['name'])?>
                    </h5>
                    <small><?=esc($user['category_name'])?></small>
                </div>
            </div>
        </div>

        <!-- Attendance -->
        <div class="col-lg-3 col-md-6 col-12 mb-3 order-lg-2 order-3">
            <div class="info-box h-100">
                <div class="info-box-content">
                    <div class="info-box-header">
                        <span class="info-box-text">Total Kehadiran</span>
                        <!-- Inline SVG Icon -->
                        <a href="<?=base_url('attendance')?>" title="Lihat detail">
                            <svg xmlns="http://www.w3.org/2000/svg" class="link-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5h6v6m-6-6L20 11m-7 9H6a2 2 0 01-2-2V6a2 2 0 012-2h7"/>
                            </svg>
                        </a>
                    </div>
                    <h1>
                        <?php if($attendancecount) { echo esc($attendancecount['hadir_count']); } else { echo "0";}?>
                    </h1>
                    <small>Ijin <?php if($attendancecount) { echo esc($attendancecount['ijin_count']); } else { echo "0";}?></small>
                </div>
            </div>
        </div>

        <!-- Company Branding -->
        <div class="col-lg-6 col-12 mb-3 order-lg-3 order-1">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center justify-content-start">
                    <img src="<?=base_url()?>images/logo-smkn6.svg" class="img-md mr-3">
                    <div>
                        <p class="h3 font-weight-bold mb-1">SMK Negeri 6 Surakarta</p>
                        <p class="m-0 text-muted">Sistem Aplikasi Manajemen Absensi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $this->endSection(); ?>
