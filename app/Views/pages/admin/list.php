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

<?php $this->section('action-button'); ?>
  <a href="<?=base_url()?>admin/add" class="btn btn-primary btn-sm float-right"><i class="fas fa-plus"></i> Tambah</a>
<?php $this->endSection(); ?>

<?php $this->section('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-lightblue">
                    <h4 class="card-title">Daftar Admin</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="admin-table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($admin as $key => $admin):?>
                                    <tr>
                                        <td><?=$key + 1?></td>
                                        <td><?=esc($admin['name'])?></td>
                                        <td>
                                            <?php if($admin['id'] != '1'):?>
                                                <a href="<?=base_url()?>admin/edit/<?=esc($admin['id'])?>" class="btn btn-secondary btn-sm"><i class="fas fa-pen"></i> Ubah</a>
                                                <button onclick="deleteModal('<?=esc($admin['id'])?>');" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Hapus</button>
                                            <?php endif;?>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<?php $this->endSection(); ?>

<?php $this->section('modal'); ?>
  <div class="modal fade" id="deleteModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Apakah kamu yakin?</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Data yang dihapus tidak bisa kembali.</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
          <form method="post" action="<?=base_url()?>admin/delete">
            <?=csrf_field();?>
            <input type='hidden' name="id" id="id_delete">
            <button type="submit" class="btn btn-danger">Hapus</button>
          </form>
        </div>
      </div>
    </div>
  </div>
<?php $this->endSection(); ?>

<?php $this->section('js'); ?>
    <script src="<?=base_url()?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script>
        function deleteModal($id) {
            $('#deleteModal').modal();
            $('#id_delete').val($id);
        }

        $(document).ready(function() {
            $('#admin-table').DataTable();
        });
        var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
        });

        <?php if(session()->getFlashdata('error')): ?>
        Toast.fire({
            icon: 'error',
            title: '<?=esc(session()->getFlashdata('error'))?>'
        })
        <?php endif; ?>

        <?php if(session()->getFlashdata('success')): ?>
        Toast.fire({
            icon: 'success',
            title: '<?=esc(session()->getFlashdata('success'))?>'
        })
        <?php endif; ?>
    </script>
<?php $this->endSection(); ?>