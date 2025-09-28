<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistem Absensi | PPLG SMK N 6 SKA</title>

  <!-- Font: Inter -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url()?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url()?>assets/css/adminlte.min.css">
  <link rel="icon" type="image/x-icon" href="<?=base_url()?>images/logo-smkn6.svg">

  <!-- Custom CSS -->
  <style>
    body {
      font-family: 'Inter', sans-serif;
      margin: 0;
      background: url('<?=base_url()?>images/background-login.svg') no-repeat center center;
      background-size: cover;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .login-wrapper {
      display: flex;
      width: 100%;
      max-width: 1100px;
      align-items: center;
      justify-content: space-between;
      padding: 40px;
      min-height: 100vh;
    }

    /* Bagian kiri (logo gabungan SMK + RPL) */
    .login-left {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-left img {
      width: 300px;
    }

    /* Bagian kanan (form login) */
    .login-right {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .card {
      width: 100%;
      max-width: 380px;
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(16px) saturate(180%);
      -webkit-backdrop-filter: blur(16px) saturate(180%);
      border-radius: 18px;
      border: 1px solid rgba(255, 255, 255, 0.25);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.37);
    }

    .card-header {
      border-bottom: none;
      background: transparent;
      text-align: center;
      padding: 20px 10px 10px 10px;
    }

    .card-header h3 {
      font-size: 1.2rem;
      font-weight: 700;
      color: #f2f2f2;
    }

    .form-control {
      height: 46px;
      font-size: 1rem;
      border-radius: 12px 0 0 12px;
    }

    .input-group-text {
      border-radius: 0 12px 12px 0;
    }

    .btn {
      border-radius: 12px;
      font-weight: 600;
      padding: 12px;
      font-size: 1rem;
      background: linear-gradient(135deg, #2563eb, #1d4ed8);
      border: none;
      transition: 0.3s;
    }

    .btn:hover {
      background: linear-gradient(135deg, #1d4ed8, #1e40af);
    }

    /* Responsive */
    @media (max-width: 768px) {
      .login-wrapper {
        flex-direction: column;
        justify-content: center;
        text-align: center;
        padding: 20px;
      }
      .login-left {
        margin-bottom: 25px;
      }
      .login-left img {
        width: 200px;
      }
    }
  </style>
</head>
<body>
<div class="login-wrapper">
  <!-- Kiri -->
  <div class="login-left">
   <img src="https://smkn6solo.sch.id/wp-content/uploads/2022/07/SMK-N-6-Surakarta.png" 
     alt="Logo" class="brand-image" style="height:300px; width:auto;">

  </div>

  <!-- Kanan -->
  <div class="login-right">
    <div class="login-box">
      <div class="card">
        <div class="card-header">
          <h3>Sistem Absensi<br>SMK N 6 Surakarta</h3>
        </div>
        <div class="card-body">
          <?php if(session()->getFlashdata('error')): ?>
            <div class="text-center mt-0 mb-2 text-danger">
              <?= session()->getFlashdata('error'); ?>
            </div>
          <?php endif; ?>
          <form action="<?=base_url()?>login" method="post">
            <?=csrf_field();?>
            <div class="input-group mb-3">
              <input type="username" class="form-control" placeholder="Masukkan Username" name="username" autocomplete="off">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" class="form-control" placeholder="Masukkan Password" name="password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block">Masuk</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- jQuery -->
<script src="<?=base_url()?>assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=base_url()?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url()?>assets/js/adminlte.min.js"></script>
</body>
</html>
