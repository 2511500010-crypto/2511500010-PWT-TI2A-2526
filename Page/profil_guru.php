<?php
// PAGE/profil_guru.php
if (!isset($_SESSION['Username'])) {
    header("location:../login.php");
    exit;
}

$username_session = $_SESSION['Username'];

// Cari guru berdasarkan nama atau kode
$query = mysqli_query($koneksi, "SELECT * FROM guru WHERE Nm_guru = '$username_session'");
$data = mysqli_fetch_assoc($query);

if(!$data) {
    $query = mysqli_query($koneksi, "SELECT * FROM guru WHERE Kd_guru = '$username_session'");
    $data = mysqli_fetch_assoc($query);
}

if(!$data) {
    echo '<div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1 class="m-0 text-dark">Profil Guru</h1>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="alert alert-danger">Data profil tidak ditemukan!</div>
            </section>
          </div>';
    exit;
}
?>

<style>
    /* Container utama untuk centering sempurna */
    .profile-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: calc(100vh - 120px);
    }
    
    .profile-card-horizontal {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        background: white;
        width: 100%;
        max-width: 950px;
        margin: 20px;
    }
    
    /* Membuat kedua kolom sama tingginya dan seimbang */
    .profile-sidebar {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 40px 20px;
        text-align: center;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        min-height: 500px;
    }
    
    .profile-avatar-large {
        width: 140px;
        height: 140px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }
    
    .profile-avatar-large i {
        font-size: 70px;
        color: #667eea;
    }
    
    .profile-name {
        color: white;
        margin-bottom: 5px;
        font-size: 22px;
        font-weight: 600;
    }
    
    .profile-role {
        color: rgba(255,255,255,0.9);
        margin-bottom: 15px;
        font-size: 13px;
    }
    
    .badge-status {
        background: rgba(255,255,255,0.2);
        color: white;
        padding: 5px 12px;
        border-radius: 30px;
        font-size: 11px;
        display: inline-block;
    }
    
    .profile-info {
        padding: 30px 35px;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    .profile-info h4 {
        color: #32325d;
        margin-bottom: 25px;
        font-size: 18px;
        border-left: 4px solid #667eea;
        padding-left: 15px;
    }
    
    .info-row {
        display: flex;
        border-bottom: 1px solid #e9ecef;
        padding: 12px 0;
    }
    
    .info-label {
        width: 35%;
        font-weight: 600;
        color: #8898aa;
        font-size: 13px;
        display: flex;
        align-items: center;
    }
    
    .info-label i {
        width: 28px;
        color: #667eea;
        font-size: 14px;
    }
    
    .info-value {
        width: 65%;
        color: #32325d;
        font-weight: 500;
        font-size: 14px;
    }
    
    .action-buttons {
        margin-top: 30px;
        display: flex;
        gap: 12px;
    }
    
    .btn-ganti {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        color: white;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.3s;
        flex: 1;
        text-align: center;
        text-decoration: none;
        display: inline-block;
    }
    
    .btn-logout {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        color: white;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.3s;
        flex: 1;
        text-align: center;
        text-decoration: none;
        display: inline-block;
    }
    
    .btn-ganti:hover, .btn-logout:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        color: white;
    }
    
    /* Header - HANYA SATU, RAPI, TIDAK DOUBLE */
    .page-header {
        max-width: 950px;
        margin: 0 auto 20px auto;
        width: 100%;
        padding: 0 20px;
    }
    
    .page-header h1 {
        margin: 0;
        font-size: 28px;
        font-weight: 600;
        color: #32325d;
        display: inline-block;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .page-breadcrumb {
        margin: 8px 0 0 0;
        padding: 0;
        list-style: none;
        display: flex;
        flex-wrap: wrap;
    }
    
    .page-breadcrumb li {
        display: inline-block;
        font-size: 14px;
        color: #8898aa;
    }
    
    .page-breadcrumb li a {
        color: #667eea;
        text-decoration: none;
    }
    
    .page-breadcrumb li a:hover {
        text-decoration: underline;
    }
    
    .page-breadcrumb li + li::before {
        content: "/";
        padding: 0 8px;
        color: #8898aa;
    }
    
    /* HILANGKAN breadcrumb default AdminLTE */
    .content-header {
        display: none;
    }
    
    @media (max-width: 768px) {
        .profile-wrapper {
            min-height: auto;
        }
        .info-row {
            flex-direction: column;
        }
        .info-label, .info-value {
            width: 100%;
        }
        .info-label {
            margin-bottom: 5px;
        }
        .action-buttons {
            flex-direction: column;
        }
        .profile-sidebar {
            min-height: auto;
            padding: 30px 20px;
        }
        .page-header h1 {
            font-size: 22px;
        }
    }
</style>

<div class="content-wrapper">
    <!-- Header hanya SATU, rapi, tidak double -->
    <div class="page-header">
        <h1><i class="fas fa-chalkboard-teacher"></i> Profil Guru</h1>
        <ul class="page-breadcrumb">
            <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
            <li>Profil Guru</li>
        </ul>
    </div>

    <section class="content">
        <div class="profile-wrapper">
            <div class="profile-card-horizontal">
                <div class="row no-gutters">
                    <!-- Sidebar Kiri - Foto Profil -->
                    <div class="col-md-4">
                        <div class="profile-sidebar">
                            <div class="profile-avatar-large">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <h3 class="profile-name"><?= $data['Nm_guru'] ?></h3>
                            <p class="profile-role">Guru Professional</p>
                            <span class="badge-status">
                                <i class="fas fa-check-circle"></i> Aktif
                            </span>
                        </div>
                    </div>
                    
                    <!-- Sidebar Kanan - Informasi Detail -->
                    <div class="col-md-8">
                        <div class="profile-info">
                            <h4>
                                <i class="fas fa-address-card"></i> Informasi Lengkap
                            </h4>
                            
                            <div class="info-row">
                                <div class="info-label">
                                    <i class="fas fa-id-card"></i> Kode Guru
                                </div>
                                <div class="info-value"><?= $data['Kd_guru'] ?></div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">
                                    <i class="fas fa-user"></i> Nama Lengkap
                                </div>
                                <div class="info-value"><?= $data['Nm_guru'] ?></div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">
                                    <i class="fas fa-venus-mars"></i> Jenis Kelamin
                                </div>
                                <div class="info-value"><?= $data['Jenkel'] ?? '-' ?></div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">
                                    <i class="fas fa-graduation-cap"></i> Pendidikan Terakhir
                                </div>
                                <div class="info-value"><?= $data['Pend_terakhir'] ?? '-' ?></div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">
                                    <i class="fas fa-phone"></i> Nomor HP
                                </div>
                                <div class="info-value"><?= $data['Hp'] ?: '-' ?></div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">
                                    <i class="fas fa-map-marker-alt"></i> Alamat
                                </div>
                                <div class="info-value"><?= $data['Alamat'] ?: '-' ?></div>
                            </div>
                            
                            <div class="action-buttons">
                                <a href="ganti_password.php" class="btn-ganti">
                                    <i class="fas fa-key"></i> Ganti Password
                                </a>
                                <a href="../logout.php" class="btn-logout">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>