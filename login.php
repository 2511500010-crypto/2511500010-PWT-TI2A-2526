<?php
session_start();
include "config/koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | HALO Connect</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="index.php"><b>HALO</b>Connect</a>
  </div>
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Silakan login untuk memulai sesi Anda</p>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" name="Username" class="form-control" placeholder="Username" required autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="Password" class="form-control" id="Password" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-12">
            <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
          </div>
        </div>
      </form>

      <div class="mt-3 text-center">
        <small class="text-muted">
          <i class="fas fa-info-circle"></i> Demo Akun:<br>
        </small>
      </div>
    </div>
  </div>
</div>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>

<?php
if (isset($_POST['login'])) {
    $Username = mysqli_real_escape_string($koneksi, $_POST['Username']);
    $Password = $_POST['Password'];

    if (empty($Username) || empty($Password)) {
        echo '<script>alert("Username dan Password tidak boleh kosong!");</script>';
    } else {
        $query = mysqli_query($koneksi, "SELECT * FROM users WHERE Username = '$Username' AND Password = '$Password'");
        $userquery = mysqli_fetch_array($query);
        
        if ($userquery) {
            $role = $userquery['Role'];
            $_SESSION['Role'] = $role;
            $_SESSION['Username'] = $Username;
            
            // CEK PASSWORD DEFAULT UNTUK GURU DAN SISWA
            $harus_ganti_password = false;
            
            if ($role == 'guru' && $Password == '12345') {
                $harus_ganti_password = true;
            } elseif ($role == 'siswa' && $Password == '12345') {
                $harus_ganti_password = true;
            }
            
            // Jika masih password default, redirect ke halaman ganti password
            if ($harus_ganti_password) {
                header("location:PAGES/ganti_password.php");
                exit;
            } else {
                // Redirect ke dashboard
                header("location:index.php");
                exit;
            }
        } else {
            echo '<div class="alert alert-danger alert-dismissible" style="position:fixed;top:20px;right:20px;z-index:9999;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-ban"></i> Login Gagal!</h5>
                    Username atau Password salah!
                  </div>';
        }
    }
}
?>