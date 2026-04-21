<?php
  include "config/koneksi.php";
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Log in</title>

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
    <a href="index.php"><b>Admin</b>LTE</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" name="Username" class="form-control" placeholder="Username" required>
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

    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

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
    $Username = $_POST['Username'];
    $Password = $_POST['Password'];

    if (empty($Username) || empty($Password)) {
        echo '<script>alert("Username dan Password tidak boleh kosong!");</script>';
    } else {
        $query = mysqli_query($koneksi, "SELECT * FROM users WHERE Username = '$Username' AND Password = '$Password'");
        $userquery = mysqli_fetch_array($query);
        
        if ($userquery) {
            $_SESSION['Role'] = $userquery['Role'];
            $_SESSION['Username'] = $Username;
            
            // CEK KHUSUS ROLE GURU DENGAN PASSWORD DEFAULT 12345
            // Redirect ke file ganti_password.php yang ada di folder PAGE
            if ($userquery['Role'] == 'guru' && $Password == '12345') {
                header("location:PAGES/ganti_password.php");
                exit;
            } else {
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