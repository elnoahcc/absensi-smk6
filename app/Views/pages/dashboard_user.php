<?php $this->extend('layout/main_layout'); ?>

<?php $this->section('css'); ?>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?=base_url()?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/plugins/sweetalert2/sweetalert2.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif !important;
            font-size: 14px;
            background: #f8f9fa;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Inter', sans-serif !important;
        }
        .table, .form-control, .btn, p, span, label {
            font-size: 14px !important;
        }

        .dashboard-header {
            background: white;
            border: 1px solid #dee2e6;
            padding: 24px 28px;
            margin-bottom: 24px;
        }

        .user-info h2 {
            font-size: 24px;
            font-weight: 600;
            color: #111827;
            margin: 0 0 4px 0;
        }

        .user-info p {
            font-size: 14px;
            color: #6b7280;
            margin: 0;
        }

        .stat-box {
            background: white;
            border: 1px solid #dee2e6;
            padding: 24px;
            margin-bottom: 24px;
        }

        .stat-label {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .stat-number {
            font-size: 36px;
            font-weight: 600;
            color: #111827;
            line-height: 1;
            margin-bottom: 8px;
        }

        .stat-meta {
            font-size: 14px;
            color: #9ca3af;
        }

        .stat-link {
            font-size: 14px;
            color: #2563eb;
            text-decoration: none;
            margin-top: 12px;
            display: inline-block;
        }

        .stat-link:hover {
            color: #1d4ed8;
        }

        .school-brand {
            background: white;
            border: 1px solid #dee2e6;
            padding: 32px 28px;
            margin-bottom: 24px;
        }

        .school-brand img {
            height: 56px;
            margin-bottom: 16px;
        }

        .school-brand h3 {
            font-size: 20px;
            font-weight: 600;
            color: #111827;
            margin: 0 0 4px 0;
        }

        .school-brand p {
            font-size: 14px;
            color: #6b7280;
            margin: 0;
        }

        /* Panduan Absensi Styles */
        .guide-section {
            background: white;
            border: 1px solid #dee2e6;
            padding: 28px;
            margin-bottom: 24px;
        }

        .guide-title {
            font-size: 18px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 16px;
        }

        .rules-list {
            list-style: none;
            padding: 0;
            margin: 0 0 24px 0;
        }

        .rules-list li {
            padding: 10px 12px;
            margin-bottom: 8px;
            background: #f8f9fa;
            border-left: 3px solid #6c757d;
            font-size: 14px;
            color: #374151;
        }

        .method-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .method-container {
                grid-template-columns: 1fr;
            }
        }

        .method-card {
            background: #f8f9fa;
            padding: 20px;
            border: 1px solid #dee2e6;
        }

        .method-header {
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid #dee2e6;
        }

        .method-title {
            font-size: 16px;
            font-weight: 600;
            color: #111827;
            margin: 0 0 4px 0;
        }

        .method-steps {
            list-style: decimal;
            padding-left: 20px;
            margin: 0;
        }

        .method-steps li {
            margin-bottom: 8px;
            font-size: 14px;
            color: #374151;
            line-height: 1.6;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge-offline {
            background: #ffc107;
            color: #000;
        }

        .badge-online {
            background: #0d6efd;
            color: white;
        }
    </style>
<?php $this->endSection(); ?>

<?php $this->section('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="dashboard-header">
                <div class="user-info">
                    <h2><?=esc($user['name'])?></h2>
                    <p><?=esc($user['category_name'])?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-12">
            <div class="stat-box">
                <div class="stat-label">KEHADIRAN</div>
                <div class="stat-number"><?php echo $attendancecount ? esc($attendancecount['hadir_count']) : "0"; ?></div>
                <div class="stat-meta">Ijin: <?php echo $attendancecount ? esc($attendancecount['ijin_count']) : "0"; ?></div>
                <a href="<?=base_url('log')?>" class="stat-link">Lihat selengkapnya →</a>
            </div>
        </div>

        <div class="col-lg-8 col-12">
            <div class="school-brand">
                <img src="<?=base_url()?>images/logo-smkn6.svg" alt="Logo">
                <h3>SMK Negeri 6 Surakarta</h3>
                <p>Sistem Aplikasi Manajemen Absensi</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="guide-section">
                <h3 class="guide-title">Peraturan Absensi</h3>
                <ul class="rules-list">
                    <li>Absensi dilakukan setiap hari pada jam yang telah ditentukan oleh sekolah</li>
                    <li>Siswa wajib melakukan absensi masuk dan pulang sesuai jadwal</li>
                    <li>Terlambat melakukan absensi akan dicatat dalam sistem</li>
                    <li>Jika tidak bisa hadir, siswa wajib mengajukan izin melalui sistem atau surat resmi</li>
                    <li>Manipulasi data absensi akan dikenakan sanksi sesuai peraturan sekolah</li>
                </ul>

                <h3 class="guide-title" style="margin-top: 32px;">Cara Melakukan Absensi</h3>
                <div class="method-container">
                    <!-- Offline Method -->
                    <div class="method-card">
                        <div class="method-header">
                            <h4 class="method-title">Absensi Offline (Fingerprint)</h4>
                            <span class="badge badge-offline">Offline</span>
                        </div>
                        <ol class="method-steps">
                            <li>Datang ke lokasi mesin fingerprint yang tersedia di sekolah</li>
                            <li>Pastikan jari dalam keadaan bersih dan kering</li>
                            <li>Tempelkan jari yang sudah terdaftar pada sensor fingerprint</li>
                            <li>Tunggu hingga muncul notifikasi berhasil (bunyi beep atau lampu hijau)</li>
                            <li>Pastikan nama Anda muncul di layar mesin</li>
                            <li>Absensi Anda akan otomatis tersimpan dalam sistem</li>
                        </ol>
                    </div>

                    <!-- Online Method -->
                    <div class="method-card">
                        <div class="method-header">
                            <h4 class="method-title">Absensi Online (Website/App)</h4>
                            <span class="badge badge-online">Online</span>
                        </div>
                        <ol class="method-steps">
                            <li>Login ke sistem absensi menggunakan akun Anda</li>
                            <li>Klik menu "Absensi" atau tombol "Check-In/Check-Out"</li>
                            <li>Pastikan lokasi GPS Anda aktif (jika diperlukan)</li>
                            <li>Ambil foto selfie untuk verifikasi (jika diminta sistem)</li>
                            <li>Klik tombol "Submit" atau "Kirim Absensi"</li>
                            <li>Tunggu konfirmasi bahwa absensi berhasil tercatat</li>
                            <li>Anda akan menerima notifikasi atau email konfirmasi</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $this->endSection(); ?>