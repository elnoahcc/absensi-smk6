<?php $this->extend('layout/main_layout') ?>

<?php $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Guru</h3>
        <div class="card-tools">
            <a href="<?= base_url('guru/add') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Guru
            </a>
        </div>
    </div>
    <div class="card-body">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <table id="guruTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Kelas yang Dikelola</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($guru as $g): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $g['name'] ?></td>
                    <td><?= $g['username'] ?></td>
                    <td><?= $g['kelas_dikelola'] ?? 'Tidak ada' ?></td>
                    <td>
                        <span class="badge badge-<?= $g['active'] ? 'success' : 'danger' ?>">
                            <?= $g['active'] ? 'Aktif' : 'Tidak Aktif' ?>
                        </span>
                    </td>
                    <td>
                        <a href="<?= base_url('guru/edit/' . $g['id']) ?>" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="<?= base_url('guru/delete/' . $g['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus guru ini?')">
                            <i class="fas fa-trash"></i> Hapus
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $this->endSection() ?>

<?php $this->section('css') ?>
<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<?php $this->endSection() ?>

<?php $this->section('js') ?>
<!-- DataTables -->
<script src="<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function() {
    $('#guruTable').DataTable({
        "responsive": true,
        "autoWidth": false,
    });
});
</script>
<?php $this->endSection() ?>