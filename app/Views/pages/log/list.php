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
   
<?php $this->endSection(); ?>

<?php $this->section('content'); ?>
    <div class="row">
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-body row">
                    <div class="col-6">
                        <h6>Status Kehadiran Hari Ini</h6>
                        <?php if(!$attendancecount) { ?>
                            <h4 class="text-bold text-danger">Tidak Hadir</h4>
                        <?php } else { ?>
                            <h4 class="text-bold <?php if($attendancecount['status_today']=='Hadir') { echo "text-success";} else if ($attendancecount['status_today']=='Ijin') {echo "text-info";} else {echo "text-danger";}?>"><?=esc($attendancecount['status_today'])?></h4>
                        <?php } ?>
                    </div>
                    <div class="col-6">
                        <button onclick="logModal();" class="btn btn-success btn-lg mt-1"><i class="fas fa-pen"></i> Tulis log hari ini</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-body row">
                    <div class="col-lg-4 col-6 ">
                        <h6>Total Kehadiran</h6>
                        <h4 class="text-bold"><?php if($attendancecount) { echo esc($attendancecount['count_hadir']); } else { echo '0';}?></h4>
                    </div>
                    <!-- 'Hadir Online' removed -->
                    <div class="col-lg-4 col-6">
                        <h6>Total Izin</h6>
                        <h4 class="text-bold"><?php if($attendancecount) { echo esc($attendancecount['count_ijin']); } else { echo '0';}?></h4>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-lightblue">
                    <h3 class="card-title text-white ">Kehadiran dan Laporan Siswa</h3>
                </div>
                <div class="card-body">
                    <div class="card card-body">
                        <div class="row">
                            <div class="col-xl-3 col-4">
                                <div class="form-group">
                                    <label>Dari</label>
                                    <input type="date" class="form-control" id="start_date" onchange="pilih_custom()">
                                </div>
                            </div>
                            <div class="col-xl-3 col-4">
                                <div class="form-group">
                                    <label>Sampai</label>
                                    <input type="date" class="form-control" id="end_date" onchange="pilih_custom()">
                                </div>
                            </div>
                            <div class="col-xl-3 col-4">
                                <div class="form-group">
                                    <label>Filter</label>
                                    <select class="form-control" id="filter" onchange="filter()">
                                        <option value="all">Semua</option>
                                        <option value="7">7 Hari Terakhir</option>
                                        <option value="30">30 Hari Terakhir</option>
                                        <option value="thismonth">Bulan Ini</option>
                                        <option value="lastmonth">Bulan Kemarin</option>
                                        <option value="custom">Kustom</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-3 col-12">
                                <label>&nbsp;</label><br>
                                <button class='btn btn-secondary' onclick="printModal()"><i class="fas fa-print"></i> Print</button>
                        </div>
                    </div>
                    <div class="table-responsive mt-4">
                        <table id="tabel-absensi" class='table table-bordered'>
                            <thead>
                                <tr>
                                    <th width="100px">Tanggal</th>
                                    <th width="100px">Status</th>
                                    <th width="100px">Keterangan</th>
                                    <th width="200px">Waktu</th>
                                    <th width="150px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $this->endSection(); ?>

<?php $this->section('modal'); ?>
<div class="modal fade" id="logModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="overlay" id="overlaylog">
            <i class="fas fa-2x fa-sync fa-spin"></i>
        </div>
        <div class="modal-header">
          <h4 class="modal-title"><i class="fas fa-pen mr-2"></i> Tulis Log</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id='form_log'>
            <form method="post" action="<?=base_url()?>log" id="form-log" enctype="multipart/form-data">
                <?=csrf_field();?>
                <div class="form-group">
                    <label>Aktivitas</label>
                    <input type="text" id="activity_text" name="activity" class="form-control" autocomplete="off">
                    <div class="invalid-feedback" id="err-activity">
                    </div>
                </div>
                <label>Deskripsi</label>
                <textarea id="description_text" name="description" class="form-control"></textarea>
                <div class="mt-3" id="ss_log">
                    <label>Screenshot bukti</label>
                    <img src="" id="image_ss" class="w-100 mb-2"></img>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="image" id="customFile" accept="image/jpg, image/jpeg, image/png">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                        <div class="invalid-feedback" id="err-upload">
                        </div>
                    </div>
                </div>
            </form>
          </div>
          <div id='error_log'>
            <p id="error_msg" class="text-center mt-2"></p>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-info" id="btn-submit" onclick="logSubmit()">Simpan</button>
        </div>
      </div>
    </div>
  </div>
<div class="modal fade" id="showLogModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="overlay" id="overlayshowlog">
            <i class="fas fa-2x fa-sync fa-spin"></i>
        </div>
        <div class="modal-header">
          <h4 class="modal-title" id="title-ijin"><i class="fas fa-info mr-2"></i> Detail Log</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div id='detail_log'>
                <table>
                    <tr>
                        <th width="100px">Tanggal</th>
                        <td> : </td>
                        <td id="date-text"></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td> : </td>
                        <td id="status-text"></td>
                    </tr>
                    <tr>
                        <th>Aktivitas</th>
                        <td> : </td>
                        <td id="activity-text"></td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td> : </td>
                        <td id="description-text"></td>
                    </tr>
                </table>
                <img src="" id="ss_image" class="w-100 mt-2">
            </div>
            <div id='error_log2'>
                <p id="error_msg2" class="text-center"></p>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Oke</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="printModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="title-ijin"><i class="fas fa-print"></i> Pengaturan Cetak</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" method="POST" id="print_form" target="_blank">
            <input type="hidden" name="id" value="<?=esc($user['id'])?>">
            <input type="hidden" name="min" id="min">
            <input type="hidden" name="max" id="max">
            <div class="form-group">
                <label>Filter</label>
                <p id="filter-text">Semua</p>
            </div>
            <div class="form-group">
                <label>Urutkan data dari</label>
                <select name="order_by" class="form-control">
                    <option value="1">Tanggal - ASC</option>
                    <option value="2">Tanggal - DESC</option>
                    <option value="4">Status - ASC</option>
                    <option value="4">Status - DESC</option>
                </select>
            </div>
            <div class="form-group">
                <label>Data yang ditampilkan</label>
                <select name="data_show" class="form-control">
                    <option value="1">Absensi dan Log</option>
                    <option value="2">Absensi</option>
                    <option value="3">Log</option>
                </select>
            </div>
            <div class="form-group">
                <label>Format</label>
                <select name="format" class="form-control" id="format_print">
                    <option value="pdf">Pdf</option>
                    <option value="xls">Excel</option>
                </select>
            </div>
          </form>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
          <button type="button" onclick="print()" class="btn btn-info"><i class="fas fa-print"></i> Print</button>
        </div>
      </div>
    </div>
  </div>
<?php $this->endSection(); ?>

<?php $this->section('js'); ?>
    <script src="<?=base_url()?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <script>
        $(function () {
            bsCustomFileInput.init();
        });
        function printModal() {
            $('#printModal').modal();
        }

        function print() {
            format = $('#format_print').val()
            if (format == 'xls') {
                $('#print_form').attr('action', '<?= base_url()?>attendance/printxls');
                document.getElementById('print_form').submit();
            } else {
                $('#print_form').attr('action', '<?= base_url()?>attendance/printpdf');
                document.getElementById('print_form').submit();
            }
        }

        function showLog(id) {
            $('#overlayshowlog').show();
            $('#showLogModal').modal();
            $.ajax({
                url: "<?=base_url()?>/log/getdata/"+id,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    $('#error_log2').hide();
                    $('#detail_log').show();
                    $('#date-text').html(response.date);
                    $('#status-text').html(response.status_id);
                    $('#activity-text').html(response.activity);
                    $('#description-text').html(response.description);
                    if(response.image != '') {
                        $("#ss_image").attr("src","<?=base_url()?>images/data/"+response.user_id+"/"+response.image);
                        $('#ss_image').show();
                    } else {
                        $('#ss_image').hide();
                    }
                    $('#btn-submit').show();
                    $('#overlayshowlog').hide();
                },
                error: function(xhr, status, error) {
                    if (status === 'timeout') {
                        $('#error_msg2').html('TimeoutError: Permintaan melebihi waktu yang ditentukan.');;
                    } else if (status === 'abort') {
                        $('#error_msg2').html('AbortError: Permintaan dibatalkan.');
                    } else if (status === 'parsererror') {
                        $('#error_msg2').html('ParseError: Gagal mem-parsing data JSON.');
                    } else if (xhr.status === 0) {
                        $('#error_msg2').html('NetworkError: Tidak dapat terhubung ke server. Periksa koneksi internet.');
                    } else if (xhr.status >= 400 && xhr.status < 600) {
                        $('#error_msg2').html(`ServerError (Status ${xhr.status}): ${error}`);
                    } else {
                        $('#error_msg2').html(`UnexpectedError: ${status} - ${error}`);
                    }
                    // console.log(xhr.status)
                    // $('#error_msg').html('Something wrong with server');
                    $('#error_log2').show();
                    $('#detail_log').hide();
                    $('#btn-submit').hide();
                    $('#overlayshowlog').hide();
                },
                timeout: 5000
            });
        }

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

        function logSubmit()
        {
            var activity = document.getElementById("activity_text");
            if (activity.value == "") {
                if(!activity.classList.contains('is-invalid')) {
                    activity.classList.add('is-invalid');
                }
                $('#err-activity').html("Aktivitas belum di isi");
                return;
            }
            // Submit form (no online check-in required)
            document.getElementById('form-log').submit();
        }


        function logModal() {
            $('#overlaylog').show();
            $('#logModal').modal();
            $.ajax({
                url: "<?=base_url()?>/log/getdata",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if(response.status == 'success') {
                        $('#error_log').hide();
                        $('#form_log').show();
                        $('#ss_log').hide();
                        $('#activity_text').val(response.activity);
                        $('#description_text').html(response.description);
                        if(response.image != '') {
                            $("#image_ss").attr("src","<?=base_url()?>images/data/"+response.user_id+"/"+response.image);
                            $('#image_ss').show();
                        } else {
                            $('#image_ss').hide();
                        }
                        $('#btn-submit').show();
                        $('#overlaylog').hide();
                    } else {
                        $('#error_msg').html(response.message);
                        $('#error_log').show();
                        $('#ss_log').hide();
                        $('#image_ss').hide();
                        $('#form_log').hide();
                        $('#btn-submit').hide();
                        $('#overlaylog').hide();
                    }
                },
                error: function(xhr, status, error) {
                    if (status === 'timeout') {
                        $('#error_msg').html('TimeoutError: Permintaan melebihi waktu yang ditentukan.');;
                    } else if (status === 'abort') {
                        $('#error_msg').html('AbortError: Permintaan dibatalkan.');
                    } else if (status === 'parsererror') {
                        $('#error_msg').html('ParseError: Gagal mem-parsing data JSON.');
                    } else if (xhr.status === 0) {
                        $('#error_msg').html('NetworkError: Tidak dapat terhubung ke server. Periksa koneksi internet.');
                    } else if (xhr.status >= 400 && xhr.status < 600) {
                        $('#error_msg').html(`ServerError (Status ${xhr.status}): ${error}`);
                    } else {
                        $('#error_msg').html(`UnexpectedError: ${status} - ${error}`);
                    }
                    // $('#error_msg').html('Something wrong with server');
                    $('#error_log').show();
                    $('#form_log').hide();
                    $('#btn-submit').hide();
                    $('#overlaylog').hide();
                }
            });
        }

        function filter()
        {
            input = $('#filter').val();
            var tgl_awal = new Date();
            var tgl_akhir = new Date();
            if(input == 'all') {
                document.getElementById('start_date').valueAsDate = null;
                document.getElementById('end_date').valueAsDate = null;
                document.getElementById('min').value = null;
                document.getElementById('max').value = null;
                document.getElementById('filter-text').innerHTML = 'Semua';
                $('#tabel-absensi').DataTable().ajax.url("<?= base_url()?>attendance/data/<?=esc($user['id'])?>/all").load();
            } else if(input == '7') {
                tgl_awal.setDate(tgl_awal.getDate()-7);
                document.getElementById('start_date').valueAsDate = tgl_awal;
                document.getElementById('end_date').valueAsDate = tgl_akhir;
                document.getElementById('min').value = tgl_awal.toISOString().split('T')[0];
                document.getElementById('max').value = tgl_akhir.toISOString().split('T')[0];
                document.getElementById('filter-text').innerHTML = '7 Hari Terakhir <br>( '+tgl_awal.toISOString().split('T')[0]+' sd '+tgl_akhir.toISOString().split('T')[0]+' )';
                $('#tabel-absensi').DataTable().ajax.url("<?= base_url()?>attendance/data/<?=esc($user['id'])?>/"+tgl_awal.toISOString().split('T')[0]+':'+tgl_akhir.toISOString().split('T')[0]).load();
            } else if(input == '30') {
                tgl_awal.setDate(tgl_awal.getDate()-30);
                document.getElementById('start_date').valueAsDate = tgl_awal;
                document.getElementById('end_date').valueAsDate = tgl_akhir;
                document.getElementById('min').value = tgl_awal.toISOString().split('T')[0];
                document.getElementById('max').value = tgl_akhir.toISOString().split('T')[0];
                document.getElementById('filter-text').innerHTML = '30 Hari Terakhir <br>( '+tgl_awal.toISOString().split('T')[0]+' sd '+tgl_akhir.toISOString().split('T')[0]+' )';
                $('#tabel-absensi').DataTable().ajax.url("<?= base_url()?>attendance/data/<?=esc($user['id'])?>/"+tgl_awal.toISOString().split('T')[0]+':'+tgl_akhir.toISOString().split('T')[0]).load();
            } else if(input == 'thismonth') {
                tgl_awal.setDate(1);
                document.getElementById('start_date').valueAsDate = tgl_awal;
                document.getElementById('end_date').valueAsDate = tgl_akhir;
                document.getElementById('min').value = tgl_awal.toISOString().split('T')[0];
                document.getElementById('max').value = tgl_akhir.toISOString().split('T')[0];
                document.getElementById('filter-text').innerHTML = 'Bulan Ini <br>( '+tgl_awal.toISOString().split('T')[0]+' sd '+tgl_akhir.toISOString().split('T')[0]+' )';
                $('#tabel-absensi').DataTable().ajax.url("<?= base_url()?>attendance/data/<?=esc($user['id'])?>/"+tgl_awal.toISOString().split('T')[0]+':'+tgl_akhir.toISOString().split('T')[0]).load();
            } else if(input == 'lastmonth') {
                tgl_awal.setDate(1);
                tgl_awal.setMonth(tgl_awal.getMonth()-1);
                tgl_akhir.setDate(0);
                document.getElementById('start_date').valueAsDate = tgl_awal;
                document.getElementById('end_date').valueAsDate = tgl_akhir;
                document.getElementById('min').value = tgl_awal.toISOString().split('T')[0];
                document.getElementById('max').value = tgl_akhir.toISOString().split('T')[0];   
                document.getElementById('filter-text').innerHTML = 'Bulan Kemarin <br>( '+tgl_awal.toISOString().split('T')[0]+' sd '+tgl_akhir.toISOString().split('T')[0]+' )';
                $('#tabel-absensi').DataTable().ajax.url("<?= base_url()?>attendance/data/<?=esc($user['id'])?>/"+tgl_awal.toISOString().split('T')[0]+':'+tgl_akhir.toISOString().split('T')[0]).load();
            }
        }

        function pilih_custom() {
            document.getElementById('filter').value = 'custom';
            start_date = document.getElementById('start_date').value;
            end_date = document.getElementById('end_date').value;
            document.getElementById('min').value = start_date;
            document.getElementById('max').value = end_date;
            if (start_date=='') {
                start_date = 'awal'
            }if (end_date=='') {
                end_date = 'sekarang'
            }
            document.getElementById('filter-text').innerHTML = 'Kustom <br>( '+start_date+' sd. '+end_date+' )';
            $('#tabel-absensi').DataTable().ajax.url("<?= base_url()?>attendance/data/<?=esc($user['id'])?>/"+start_date+':'+end_date).load();
        }

        $(document).ready(function() {
            $('#tabel-absensi').DataTable({
                processing: true,
                order: [[0, 'desc']],
                searching: false,
                ajax: {
                    url: '<?= base_url()?>attendance/data/<?=esc($user['id'])?>/all',
                    dataSrc: ''
                },
                columns: [
                    {data:'tanggal'},
                    {data:'status'},
                    {data:'keterangan'},
                    {data:'waktu'},
                    {data:'id',
                       render: function (data, type, row, meta) {
                            return '<a class="btn btn-sm btn-info text-white" onClick="showLog('+"'"+data+"'"+')"><i class="fas fa-eye"></i> Lihat Log</a>';
                        }   
                    },
                ],
            });
        });
    </script>
<?php $this->endSection(); ?>