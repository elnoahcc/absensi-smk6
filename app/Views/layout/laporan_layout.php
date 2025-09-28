<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?=$title?> - <?=$user['name']?> (<?=date('d-m-Y')?>)</title>
    <!-- Import Google Font Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 30px;
            color: #333;
            background-color: #f9fafb;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            padding: 25px 30px;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 6px 18px rgba(0,0,0,0.08);
        }
        header {
            text-align: center;
            margin-bottom: 20px;
            position: relative;
        }
        .header-text {
            overflow: hidden;
        }
        header h1 {
            font-size: 26px;
            margin: 0;
            font-weight: 600;
            color: #111827;
        }
        header p {
            font-size: 14px;
            color: #6b7280;
            margin: 5px 0 0;
        }
        header img {
            position: absolute;
            top: 10px;
            left: 30px;
            max-width: 120px;
        }
        #head {
            margin-top: 25px;
            font-size: 14px;
            width: 100%;
            border-collapse: collapse;
        }
        #head th, #head td {
            padding: 6px 8px;
        }
        #head th {
            text-align: left;
            color: #374151;
            font-weight: 500;
        }
        #head td {
            color: #111827;
        }
        #data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            font-size: 13px;
            border: 1px solid #d1d5db;
        }
        #data th, #data td {
            border: 1px solid #d1d5db;
            padding: 10px 8px;
            text-align: left;
        }
        #data th {
            background-color: #f3f4f6;
            font-weight: 600;
            color: #1f2937;
        }
        #data tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }
        #data tbody tr:hover {
            background-color: #eef2ff;
        }
        #tanggal, #right {
            font-size: 14px;
            position: absolute; 
            z-index: -1; 
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <img src="https://smkn6solo.sch.id/wp-content/uploads/2022/07/SMK-N-6-Surakarta.png" alt="Logo">
            <div class="header-text">
                <h1><?=$title?></h1>  
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
                        <td><?php
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
                        ?></td>
                        <td><?=esc($attendance['activity'])?></td>
                        <td><?=esc($attendance['description'])?></td>
                    <?php } ?>
                    <?php if($data_show == '2') { ?>
                        <td><?=esc($attendance['status'])?></td>
                        <td><?php
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
                        ?></td>
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
