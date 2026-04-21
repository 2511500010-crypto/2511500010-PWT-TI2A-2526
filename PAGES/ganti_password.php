<?php
session_start();
require_once("../config/koneksi.php");  

if(!isset($_SESSION['Username'])) {
    header("location:../login.php");
    exit;
}

if($_SESSION['Role'] != 'guru') {
    header("location:../index.php");
    exit;
}

$username = $_SESSION['Username'];

$error = '';
$success = '';

if(isset($_POST['ganti_password'])){
    $password_lama = $_POST['password_lama'];
    $password_baru = $_POST['password_baru'];
    $konfirmasi = $_POST['konfirmasi_password'];
    
    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE Username = '$username'");
    $user = mysqli_fetch_assoc($query);
    
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

$query_guru = mysqli_query($koneksi, "SELECT * FROM guru WHERE Kd_guru = '$username'");
$data_guru = mysqli_fetch_assoc($query_guru);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Password - Guru | HALO Connect</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* ===== ULTRA COLOR PALETTE ===== */
        :root {
            /* Core Colors */
            --rose: #e8b4b8;      /* Rhea - Rose */
            --azure: #a8d8ea;     /* Aether - Azure */
            --peach: #ffd7b5;     /* Eos - Peach */
            --sage: #c1d5c0;      /* Zephyr - Sage */
            --cream: #fff5e6;     /* Cream Base */
            
            /* Mood Pastels (Breeze, Cloud) */
            --breeze: #c9e9f6;    /* Soft Breeze */
            --cloud: #f0f0f0;     /* Soft Cloud */
            --halo-glow: rgba(168, 216, 234, 0.4);
            
            /* Typography Colors */
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
            background: linear-gradient(145deg, var(--azure) 0%, var(--rose) 50%, var(--peach) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            font-family: 'Segoe UI', 'Poppins', system-ui, -apple-system, sans-serif;
            position: relative;
        }
        
        /* Soft Diffused Halo Effect */
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
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.08), 0 2px 6px rgba(0, 0, 0, 0.02);
            overflow: hidden;
            background: var(--white-soft);
            backdrop-filter: blur(2px);
            position: relative;
            z-index: 1;
            transition: transform 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-4px);
        }
        
        /* Card Header dengan Gradient ultra-pastel */
        .card-header {
            background: linear-gradient(125deg, var(--rose) 0%, var(--peach) 40%, var(--cream) 100%);
            padding: 28px 25px;
            text-align: center;
            border-bottom: none;
        }
        
        .card-header h3 {
            margin: 0;
            font-size: 26px;
            font-weight: 600;
            color: var(--text-dark);
            letter-spacing: -0.3px;
        }
        
        .card-header h3 i {
            color: var(--sage);
            margin-right: 8px;
            text-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }
        
        .card-header p {
            margin: 12px 0 0;
            opacity: 0.85;
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
            color: var(--rose);
            margin-right: 8px;
            width: 18px;
        }
        
        .form-control {
            border-radius: 60px;
            border: 1.5px solid #edeef2;
            padding: 12px 18px;
            font-size: 14px;
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
            font-size: 1rem;
            transition: all 0.25s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.03);
        }
        
        .btn-primary:hover {
            background: linear-gradient(105deg, #b3d0b2 0%, #96c8df 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(168, 216, 234, 0.3);
            color: #2d2d4a;
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
            transition: all 0.2s;
        }
        
        .btn-secondary:hover {
            background-color: var(--cloud);
            border-color: var(--rose);
            transform: translateY(-1px);
        }
        
        .info-box {
            background: linear-gradient(110deg, var(--cream) 0%, #fffaf2 100%);
            border-left: 5px solid var(--peach);
            padding: 16px 18px;
            border-radius: 24px;
            margin-bottom: 28px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
        }
        
        .info-box .text-muted {
            color: var(--text-soft) !important;
            font-size: 0.7rem;
            letter-spacing: 0.5px;
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
            font-size: 0.9rem;
        }
        
        .alert-success {
            background-color: #e3f5ec;
            border-color: var(--sage);
            color: #527a5a;
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
        
        /* Ripple / Breeze efek ringan di card */
        .card-body::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 180px;
            height: 180px;
            background: radial-gradient(circle, var(--breeze) 0%, transparent 70%);
            opacity: 0.2;
            pointer-events: none;
            border-radius: 50%;
            z-index: 0;
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
            <p>Ganti password • aman & terpercaya</p>
        </div>
        <div class="card-body">
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
                        <small class="text-muted"><i class="fas fa-user-circle"></i> Username</small><br>
                        <strong><?= htmlspecialchars($username) ?></strong>
                    </div>
                    <div class="col-6">
                        <small class="text-muted"><i class="fas fa-chalkboard-teacher"></i> Nama Guru</small><br>
                        <strong><?= htmlspecialchars($data_guru['Nm_guru'] ?? '-') ?></strong>
                    </div>
                </div>
            </div>
            
            <form method="POST">
                <div class="form-group">
                    <label><i class="fas fa-lock"></i> Password Lama</label>
                    <input type="password" name="password_lama" class="form-control" placeholder="Masukkan password lama" required autofocus>
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