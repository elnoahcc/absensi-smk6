<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?=$title?> - <?=$user['name']?> (<?=date('d-m-Y')?>)</title>
    <!-- Font Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            background-color: #fff;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 20px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }

        header {
            display: flex;
            align-items: center; /* SEJAJARKAN VERTIKAL logo dan teks */
            gap: 20px;
            margin-bottom: 20px;
        }

        .logo {
            width: 80px;
            height: auto;
            object-fit: contain;
        }

        .header-text {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        header h1 {
            font-size: 20px;
            margin: 0;
            font-weight: 600;
        }

        header p {
            font-size: 14px;
            color: #777;
            margin: 2px 0 0 0;
        }

        #head {
            margin-top: 10px;
            font-size: 14px;
            width: 100%;
        }

        #head th {
            text-align: left;
            padding-right: 8px;
        }

        #data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 12px;
        }

        #data, #data th, #data td {
            border: 1px solid #aaa;
        }

        #data th, #data td {
            padding: 8px;
        }

        #data th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <!-- Logo kiri -->
            <img src="https://smkn6solo.sch.id/wp-content/uploads/2022/07/SMK-N-6-Surakarta.png" 
                 alt="Logo" class="logo">

            <!-- Judul kanan -->
            <div class="header-text">
                <h1>Laporan Absensi dan Log</h1>
                <p>Laporan Absensi & Log Aktivitas</p>
            </div>
        </header>

        <table id='head'>
            <tr>
                <th width="50px">Nama</th>
                <td>:</td>
                <td width="300px"><?=$user['name']?></td>
                <th width="110px">Tanggal Cetak</th>
                <td>:</td>
                <td width="170px"><?=date('d-m-Y')?></td>
            </tr>
            <tr>
                <th>Grup</th>
                <td>:</td>
                <td><?=$user['category_name']?></td>
                <th>Periode</th>
                <td>:</td>
                <td><?=$periode?></td>
            </tr>
        </table>

        <table id="data">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <?php if($data_show == '1') { ?>
                        <th>Status</th>
                        <th>Waktu</th>
                        <th>Aktivitas</th>
                        <th>Deskripsi</th>
                    <?php } ?>
                    <?php if($data_show == '2') { ?>
                        <th>Status</th>
                        <th>Waktu</th>
                    <?php } ?>
                    <?php if($data_show == '3') { ?>
                        <th>Aktivitas</th>
                        <th>Deskripsi</th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php if(!$attendance) { ?>
                    <tr>
                        <td colspan='5' style="text-align: center">Tidak ada data</td>
                    </tr>
                <?php } else { foreach($attendance as $attendance) { ?>
                <tr>
                    <td><?=esc(date('Y-m-d',strtotime($attendance['created_at'])))?></td>
                    <?php if($data_show == '1') { ?>
                        <td><?=esc($attendance['status'])?></td>
                        <td>
                            <?php
                                if($attendance['status'] == 'Ijin') {
                                    echo "-";
                                } else {
                                    if($attendance['no_limit'] == '1') {
                                        echo date('H:i:s',strtotime($attendance['checkin']));
                                    } else {
                                        if($attendance['checkout'] == null && date('Y-m-d',strtotime($attendance['created_at'])) == date("Y-m-d")) {
                                            echo date('H:i:s',strtotime($attendance['checkin']))." - Belum Pulang";
                                        } else if($attendance['checkout'] == null) {
                                            echo date('H:i:s',strtotime($attendance['checkin']))." - Tidak Absen";
                                        } else {
                                            echo date('H:i:s',strtotime($attendance['checkin']))." - ".date('H:i:s',strtotime($attendance['checkout']));
                                        }
                                    }
                                }
                            ?>
                        </td>
                        <td><?=esc($attendance['activity'])?></td>
                        <td><?=esc($attendance['description'])?></td>
                    <?php } ?>
                    <?php if($data_show == '2') { ?>
                        <td><?=esc($attendance['status'])?></td>
                        <td>
                            <?php
                                if($attendance['status'] == 'Ijin') {
                                    echo "-";
                                } else {
                                    if($attendance['no_limit'] == '1') {
                                        echo date('H:i:s',strtotime($attendance['checkin']));
                                    } else {
                                        if($attendance['checkout'] == null && date('Y-m-d',strtotime($attendance['created_at'])) == date("Y-m-d")) {
                                            echo date('H:i:s',strtotime($attendance['checkin']))." - Belum Pulang";
                                        } else if($attendance['checkout'] == null) {
                                            echo date('H:i:s',strtotime($attendance['checkin']))." - Tidak Absen";
                                        } else {
                                            echo date('H:i:s',strtotime($attendance['checkin']))." - ".date('H:i:s',strtotime($attendance['checkout']));
                                        }
                                    }
                                }
                            ?>
                        </td>
                    <?php } ?>
                    <?php if($data_show == '3') { ?>
                        <td><?=esc($attendance['activity'])?></td>
                        <td><?=esc($attendance['description'])?></td>
                    <?php } ?>
                </tr>
                <?php } } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
