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

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: #f5f5f5;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      overflow: hidden;
    }

    body::before {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image: url('<?=base_url()?>images/background-smkn6-wide.svg');
      background-size: auto 100%;
      background-repeat: repeat-x;
      opacity: 0.1;
      z-index: 0;
      animation: scrollBackground 60s linear infinite;
    }

    @keyframes scrollBackground {
      0% {
        background-position: 0 0;
      }
      100% {
        background-position: -100vw 0;
      }
    }

    .container {
      width: 100%;
      max-width: 900px;
      margin: 0 auto;
      padding: 20px;
      position: relative;
      z-index: 1;
    }

    .login-card {
      background: white;
      border-radius: 2px;
      box-shadow: 0 1px 3px rgba(0,0,0,0.12);
      overflow: hidden;
      display: flex;
    }

    .login-left {
      flex: 1;
      background: #0052cc;
      color: white;
      padding: 60px 50px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .logo-section {
      margin-bottom: 40px;
    }

    .logo-section img {
      width: 80px;
      margin-bottom: 20px;
    }

    .logo-section h1 {
      font-size: 24px;
      font-weight: 600;
      line-height: 1.4;
      margin-bottom: 10px;
    }

    .logo-section p {
      font-size: 14px;
      opacity: 0.9;
      font-weight: 500;
    }

    .login-right {
      flex: 1;
      padding: 60px 50px;
    }

    .form-header {
      margin-bottom: 35px;
    }

    .form-header h2 {
      font-size: 20px;
      font-weight: 600;
      color: #172b4d;
      margin-bottom: 8px;
    }

    .form-header p {
      font-size: 14px;
      color: #5e6c84;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      font-size: 13px;
      font-weight: 600;
      color: #172b4d;
      margin-bottom: 6px;
    }

    .input-wrapper {
      position: relative;
    }

    .form-control {
      width: 100%;
      height: 40px;
      padding: 8px 12px;
      font-size: 14px;
      border: 2px solid #dfe1e6;
      border-radius: 3px;
      transition: border-color 0.15s;
      font-family: 'Inter', sans-serif;
    }

    .form-control:focus {
      outline: none;
      border-color: #0052cc;
    }

    .toggle-password {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      color: #5e6c84;
      cursor: pointer;
      font-size: 14px;
    }

    .toggle-password:hover {
      color: #172b4d;
    }

    .btn-login {
      width: 100%;
      height: 40px;
      background: #0052cc;
      color: white;
      border: none;
      border-radius: 3px;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.15s;
      margin-top: 10px;
    }

    .btn-login:hover {
      background: #0747a6;
    }

    .error-message {
      background: #ffebe6;
      border-left: 3px solid #de350b;
      color: #172b4d;
      padding: 12px;
      font-size: 13px;
      margin-bottom: 20px;
      border-radius: 3px;
    }

    @media (max-width: 768px) {
      .login-card {
        flex-direction: column;
      }

      .login-left,
      .login-right {
        padding: 40px 30px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="login-card">
      <div class="login-left">
        <div class="logo-section">
          <img src="https://smkn6solo.sch.id/wp-content/uploads/2022/07/SMK-N-6-Surakarta.png" alt="Logo">
          <h1>Sistem Absensi<br>SMK Negeri 6 Surakarta</h1>
          <p>Visioner Inovatif Kompeten Amanah</p>
        </div>
      </div>

      <div class="login-right">
        <div class="form-header">
          <h2>Login</h2>
          <p>Masukkan kredensial Anda untuk melanjutkan</p>
        </div>

        <?php if(session()->getFlashdata('error')): ?>
          <div class="error-message">
            <?= session()->getFlashdata('error'); ?>
          </div>
        <?php endif; ?>

        <form action="<?=base_url()?>login" method="post">
          <?=csrf_field();?>
          
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" autocomplete="off" required>
          </div>

          <div class="form-group">
            <label for="password">Password</label>
            <div class="input-wrapper">
              <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
              <span class="toggle-password" id="togglePassword">
                <i class="fas fa-eye"></i>
              </span>
            </div>
          </div>

          <button type="submit" class="btn-login">Masuk</button>
        </form>
      </div>
    </div>
  </div>

  <!-- jQuery -->
  <script src="<?=base_url()?>assets/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?=base_url()?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?=base_url()?>assets/js/adminlte.min.js"></script>

  <script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    
    togglePassword.addEventListener('click', function () {
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
      
      const icon = this.querySelector('i');
      icon.classList.toggle('fa-eye');
      icon.classList.toggle('fa-eye-slash');
    });
  </script>
</body>
</html>