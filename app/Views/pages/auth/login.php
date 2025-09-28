<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistem Absensi | SMK N 6 SKA</title>

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
      background: url('<?=base_url()?>images/background-login1.svg') no-repeat center center fixed;
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
      padding: 20px;
      min-height: 100vh;
    }

    /* Bagian kiri */
    .login-left {
      flex: 1;
      color: white;
      text-align: center;
    }

    .login-left img {
      width: 260px; /* lebih besar */
      margin: 20px 0;
    }

    .login-left h2 {
      font-size: 1.6rem; /* lebih besar */
      font-weight: 700;
      margin-bottom: 20px;
    }

    .login-left p {
      font-size: 1.3rem; /* lebih besar */
      line-height: 1.6;
      font-weight: 600;
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
      background: rgba(255, 255, 255, 0.1); /* transparan */
      backdrop-filter: blur(20px) saturate(180%);
      -webkit-backdrop-filter: blur(20px) saturate(180%);
      border-radius: 18px;
      padding: 25px;
      border: 1px solid rgba(255, 255, 255, 0.25);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.37);
    }

    .card-header {
      text-align: center;
      margin-bottom: 15px;
    }

    .card-header h3 {
      font-size: 1.3rem;
      font-weight: 700;
      color: #fff; /* putih */
    }

    .form-control {
      height: 46px;
      font-size: 1rem;
      border-radius: 10px 0 0 10px;
    }

    .input-group-text {
      border-radius: 0 10px 10px 0;
    }

    .btn {
      border-radius: 10px;
      font-weight: 600;
      padding: 12px;
      font-size: 1rem;
      background: rgba(37, 99, 235, 0.8);
      backdrop-filter: blur(10px);
      border: none;
      transition: 0.3s;
      color: #fff;
    }

    .btn:hover {
      background: rgba(29, 78, 216, 0.9);
    }

    /* Responsive */
    @media (max-width: 768px) {
      .login-wrapper {
        flex-direction: column;
        justify-content: center;
        text-align: center;
      }
      .login-left {
        margin-bottom: 30px;
      }
    }
  </style>
</head>
<body>
<div class="login-wrapper">
  <!-- Kiri -->
  <div class="login-left">
    <h2>Sistem Absensi SMK Negeri 6 Surakarta</h2>
    <img src="https://smkn6solo.sch.id/wp-content/uploads/2022/07/SMK-N-6-Surakarta.png" 
         alt="Logo" class="brand-image">
    <p>Visioner Inovatif<br>Kompeten Amanah</p>
  </div>

  <!-- Kanan -->
  <div class="login-right">
    <div class="login-box">
      <div class="card">
        <div class="card-header">
          <h3>Selamat Datang<br>Silakan Login</h3>
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
              <input type="text" class="form-control" placeholder="Masukkan Username" name="username" autocomplete="off">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" class="form-control" id="password" placeholder="Masukkan Password" name="password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-eye" id="togglePassword" style="cursor:pointer;"></span>
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

<!-- Script Show/Hide Password -->
<script>
  const togglePassword = document.querySelector('#togglePassword');
  const password = document.querySelector('#password');
  togglePassword.addEventListener('click', function () {
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    this.classList.toggle('fa-eye-slash');
  });
</script>
</body>
</html>
