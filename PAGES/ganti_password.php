<?php
session_start();
require_once("../config/koneksi.php");  

if(!isset($_SESSION['Username'])) {
    header("location:../login.php");
    exit;
}

$role = $_SESSION['Role'];
$username = $_SESSION['Username'];

// Validasi role (hanya guru atau siswa)
if($role != 'guru' && $role != 'siswa') {
    header("location:../index.php");
    exit;
}

$error = '';
$success = '';

// Cek apakah masih menggunakan password default
$query_cek = mysqli_query($koneksi, "SELECT * FROM users WHERE Username = '$username'");
$user_data = mysqli_fetch_assoc($query_cek);
$password_default = ($role == 'guru') ? '12345' : '1234';
$is_default_password = ($user_data['Password'] == $password_default);

if(isset($_POST['ganti_password'])){
    $password_lama = $_POST['password_lama'];
    $password_baru = $_POST['password_baru'];
    $konfirmasi = $_POST['konfirmasi_password'];
    
    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE Username = '$username'");
    $user = mysqli_fetch_assoc($query);
    
    // Validasi
    if($password_lama != $user['Password']) {
        $error = "Password lama salah!";
    } 
    elseif($password_baru != $konfirmasi) {
        $error = "Password baru tidak cocok!";
    }
    elseif(strlen($password_baru) < 4) {
        $error = "Password baru minimal 4 karakter!";
    }
    else {
        $update = mysqli_query($koneksi, "UPDATE users SET Password = '$password_baru' WHERE Username = '$username'");
        
        if($update) {
            $success = "Password berhasil diubah!";
        } else {
            $error = "Gagal mengupdate password: " . mysqli_error($koneksi);
        }
    }
}

// Ambil data berdasarkan role
$nama = '';
$info_pertama = '';
$info_kedua = '';
$icon = '';

if($role == 'guru') {
    $query_data = mysqli_query($koneksi, "SELECT * FROM guru WHERE Kd_guru = '$username'");
    $data = mysqli_fetch_assoc($query_data);
    $nama = $data['Nm_guru'] ?? '-';
    $info_pertama = "Kode Guru";
    $info_kedua = "Nama Guru";
    $icon = "fas fa-chalkboard-teacher";
} else { // role siswa
    $query_data = mysqli_query($koneksi, "SELECT * FROM siswa WHERE Nis = '$username'");
    $data = mysqli_fetch_assoc($query_data);
    $nama = $data['Nm_siswa'] ?? '-';
    $info_pertama = "NIS";
    $info_kedua = "Nama Siswa";
    $icon = "fas fa-user-graduate";
    
    // Ambil kelas siswa jika ada
    $kelas_siswa = "";
    if($data && $data['Kd_kelas']) {
        $query_kelas = mysqli_query($koneksi, "SELECT Nm_kelas FROM kelas WHERE Kd_kelas = '".$data['Kd_kelas']."'");
        $data_kelas = mysqli_fetch_assoc($query_kelas);
        $kelas_siswa = $data_kelas['Nm_kelas'] ?? '-';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Password - <?= ucfirst($role) ?> | HALO Connect</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --rose: #e8b4b8;
            --azure: #a8d8ea;
            --peach: #ffd7b5;
            --sage: #c1d5c0;
            --cream: #fff5e6;
            --breeze: #c9e9f6;
            --cloud: #f0f0f0;
            --halo-glow: rgba(168, 216, 234, 0.4);
            --text-dark: #4a4a6a;
            --text-soft: #7a7a9a;
            --white-soft: #fefefe;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: <?php echo ($role == 'guru') ? 
                'linear-gradient(145deg, var(--azure) 0%, var(--rose) 50%, var(--peach) 100%)' : 
                'linear-gradient(145deg, var(--sage) 0%, var(--azure) 50%, var(--peach) 100%)'; ?>;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            font-family: 'Segoe UI', 'Poppins', system-ui, sans-serif;
            position: relative;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: -20%;
            left: -20%;
            width: 140%;
            height: 140%;
            background: radial-gradient(circle, var(--halo-glow) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }
        
        .card {
            width: 100%;
            max-width: 500px;
            border-radius: 32px;
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            background: var(--white-soft);
            position: relative;
            z-index: 1;
            transition: transform 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-4px);
        }
        
        .card-header {
            background: <?php echo ($role == 'guru') ? 
                'linear-gradient(125deg, var(--rose) 0%, var(--peach) 40%, var(--cream) 100%)' : 
                'linear-gradient(125deg, var(--sage) 0%, var(--peach) 40%, var(--cream) 100%)'; ?>;
            padding: 28px 25px;
            text-align: center;
            border-bottom: none;
        }
        
        .card-header h3 {
            margin: 0;
            font-size: 26px;
            font-weight: 600;
            color: var(--text-dark);
        }
        
        .card-header h3 i {
            color: var(--rose);
            margin-right: 8px;
        }
        
        .card-header p {
            margin: 12px 0 0;
            font-size: 14px;
            color: var(--text-dark);
            font-weight: 500;
        }
        
        .card-body {
            padding: 32px 30px;
            background: var(--white-soft);
        }
        
        .form-group {
            margin-bottom: 22px;
        }
        
        .form-group label {
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--text-dark);
            font-size: 0.9rem;
        }
        
        .form-group label i {
            color: var(--sage);
            margin-right: 8px;
        }
        
        .form-control {
            border-radius: 60px;
            border: 1.5px solid #edeef2;
            padding: 12px 18px;
            background-color: var(--cream);
            transition: all 0.25s ease;
            color: var(--text-dark);
        }
        
        .form-control:focus {
            border-color: var(--azure);
            box-shadow: 0 0 0 4px var(--halo-glow);
            outline: none;
            background-color: white;
        }
        
        .btn-primary {
            background: linear-gradient(105deg, var(--sage) 0%, var(--azure) 100%);
            border: none;
            border-radius: 60px;
            padding: 12px 20px;
            font-weight: 600;
            width: 100%;
            color: var(--text-dark);
            transition: all 0.25s ease;
        }
        
        .btn-primary:hover {
            background: linear-gradient(105deg, #b3d0b2 0%, #96c8df 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(168, 216, 234, 0.3);
        }
        
        .btn-secondary {
            background-color: #f4f2f7;
            border: 1px solid #e6e2ed;
            border-radius: 60px;
            padding: 12px 20px;
            width: 100%;
            margin-top: 12px;
            color: var(--text-dark);
            font-weight: 500;
        }
        
        .btn-secondary:hover {
            background-color: var(--cloud);
            border-color: var(--rose);
        }
        
        .info-box {
            background: linear-gradient(110deg, var(--cream) 0%, #fffaf2 100%);
            border-left: 5px solid <?php echo ($role == 'guru') ? 'var(--peach)' : 'var(--sage)'; ?>;
            padding: 16px 18px;
            border-radius: 24px;
            margin-bottom: 28px;
        }
        
        .info-box .text-muted {
            color: var(--text-soft) !important;
            font-size: 0.7rem;
        }
        
        .info-box strong {
            color: var(--text-dark);
            font-weight: 600;
        }
        
        .alert-danger {
            background-color: #ffe6e8;
            border-color: var(--rose);
            color: #a15c5c;
            border-radius: 20px;
            padding: 12px 18px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background-color: #e3f5ec;
            border-color: var(--sage);
            color: #527a5a;
            border-radius: 20px;
            padding: 12px 18px;
            margin-bottom: 20px;
        }
        
        .alert-warning {
            background-color: #fff3e0;
            border-color: var(--peach);
            color: #a87c3e;
            border-radius: 20px;
            padding: 12px 18px;
            margin-bottom: 20px;
        }
        
        small.text-muted {
            color: var(--text-soft) !important;
            font-size: 0.7rem;
            margin-top: 6px;
            display: inline-block;
        }
        
        @media (max-width: 480px) {
            .card-body {
                padding: 24px 20px;
            }
            .card-header h3 {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-hands-helping"></i> HALO Connect</h3>
            <p>Ganti password • <?= ucfirst($role) ?> • aman & terpercaya</p>
        </div>
        <div class="card-body">
            <?php if($is_default_password): ?>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> <strong>Peringatan!</strong> Anda masih menggunakan password default (<?= $password_default ?>). Silakan ganti password Anda sekarang!
                </div>
            <?php endif; ?>
            
            <?php if($error): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-times-circle"></i> <?= $error ?>
                </div>
            <?php endif; ?>
            
            <?php if($success): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?= $success ?>
                </div>
                <script>
                    setTimeout(function() {
                        window.location.href = '../index.php';
                    }, 2000);
                </script>
            <?php endif; ?>
            
            <div class="info-box">
                <div class="row">
                    <div class="col-6">
                        <small class="text-muted"><i class="fas fa-id-card"></i> <?= $info_pertama ?></small><br>
                        <strong><?= htmlspecialchars($username) ?></strong>
                    </div>
                    <div class="col-6">
                        <small class="text-muted"><i class="<?= $icon ?>"></i> <?= $info_kedua ?></small><br>
                        <strong><?= htmlspecialchars($nama) ?></strong>
                    </div>
                </div>
                <?php if($role == 'siswa' && !empty($kelas_siswa)): ?>
                <div class="row mt-2">
                    <div class="col-12">
                        <small class="text-muted"><i class="fas fa-school"></i> Kelas</small><br>
                        <strong><?= htmlspecialchars($kelas_siswa) ?></strong>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            
            <form method="POST">
                <div class="form-group">
                    <label><i class="fas fa-lock"></i> Password Lama</label>
                    <input type="password" name="password_lama" class="form-control" placeholder="Masukkan password lama" required autofocus>
                    <?php if($is_default_password): ?>
                        <small class="text-muted"><i class="fas fa-info-circle"></i> Password default Anda adalah: <?= $password_default ?></small>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-key"></i> Password Baru</label>
                    <input type="password" name="password_baru" class="form-control" placeholder="Masukkan password baru" required>
                    <small class="text-muted"><i class="fas fa-info-circle"></i> Minimal 4 karakter</small>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-check-circle"></i> Konfirmasi Password Baru</label>
                    <input type="password" name="konfirmasi_password" class="form-control" placeholder="Konfirmasi password baru" required>
                </div>
                <button type="submit" name="ganti_password" class="btn btn-primary">
                    <i class="fas fa-save"></i> Ganti Password
                </button>
                <a href="../index.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                </a>
            </form>
        </div>
    </div>
</body>
</html>