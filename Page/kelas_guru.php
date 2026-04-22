<?php
// PAGE/kelas_guru.php
if (!isset($_SESSION['Username'])) {
    header("location:../login.php");
    exit;
}

$role = $_SESSION['Role'];
if($role != 'guru') {
    header("location:../index.php");
    exit;
}

// Cek koneksi database
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Ambil data kelas
$query = mysqli_query($koneksi, "SELECT * FROM kelas ORDER BY kd_kelas");

if (!$query) {
    echo '<div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1 class="m-0 text-dark">Data Kelas</h1>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="alert alert-danger">Error Query: ' . mysqli_error($koneksi) . '</div>
            </section>
          </div>';
    exit;
}
?>

<style>
    /* CSS SAMA SEPERTI PROFIL GURU */
    .page-header {
        max-width: 1200px;
        margin: 0 auto 20px auto;
        width: 100%;
        padding: 0 20px;
    }
    
    .page-header h1 {
        margin: 0;
        font-size: 28px;
        font-weight: 600;
        color: #32325d;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        display: inline-block;
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
    
    .content-header {
        display: none;
    }
    
    /* Card Utama */
    .kelas-card {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        background: white;
        width: 100%;
        max-width: 1200px;
        margin: 20px auto;
    }
    
    /* Header Card - GRADIENT SAMA SEPERTI PROFIL GURU */
    .kelas-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 20px 25px;
        color: white;
    }
    
    .kelas-header h3 {
        margin: 0;
        font-size: 20px;
        font-weight: 600;
    }
    
    .kelas-header i {
        margin-right: 10px;
    }
    
    /* Body Card */
    .kelas-body {
        padding: 30px;
    }
    
    /* Info Box */
    .info-box-custom {
        background: #e8f0fe;
        border-left: 4px solid #667eea;
        padding: 15px 20px;
        border-radius: 12px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
    }
    
    .info-box-custom i {
        font-size: 20px;
        color: #667eea;
        margin-right: 15px;
    }
    
    .info-box-custom p {
        margin: 0;
        color: #555;
    }
    
    /* Tabel */
    .table-kelas {
        width: 100%;
        border-collapse: collapse;
    }
    
    .table-kelas thead tr {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .table-kelas th {
        padding: 14px 15px;
        text-align: left;
        font-weight: 600;
        font-size: 14px;
    }
    
    .table-kelas td {
        padding: 12px 15px;
        border-bottom: 1px solid #e9ecef;
        color: #555;
        font-size: 14px;
    }
    
    .table-kelas tbody tr:hover {
        background: #f8f9fa;
        cursor: pointer;
    }
    
    /* Badge Warna-warni untuk Kode Kelas */
    .badge-kelas {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .badge-kelas-1 { background: #e3f2fd; color: #1976d2; }
    .badge-kelas-2 { background: #e8f5e9; color: #388e3c; }
    .badge-kelas-3 { background: #fce4ec; color: #c2185b; }
    .badge-kelas-4 { background: #fff3e0; color: #f57c00; }
    .badge-kelas-5 { background: #f3e5f5; color: #7b1fa2; }
    .badge-kelas-6 { background: #e0f7fa; color: #0097a7; }
    
    /* Empty Data */
    .empty-data {
        text-align: center;
        padding: 50px;
        color: #8898aa;
    }
    
    .empty-data i {
        font-size: 60px;
        margin-bottom: 15px;
        color: #ddd;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .kelas-body {
            padding: 20px;
            overflow-x: auto;
        }
        .table-kelas th, .table-kelas td {
            padding: 8px 10px;
            font-size: 12px;
        }
        .page-header h1 {
            font-size: 22px;
        }
        .info-box-custom {
            flex-direction: column;
            text-align: center;
        }
        .info-box-custom i {
            margin-right: 0;
            margin-bottom: 10px;
        }
    }
</style>

<div class="content-wrapper">
    <!-- Header sama persis dengan profil guru -->
    <div class="page-header">
        <h1><i class="fas fa-building"></i> Data Kelas</h1>
        <ul class="page-breadcrumb">
            <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
            <li>Data Kelas</li>
        </ul>
    </div>

    <section class="content">
        <div class="kelas-card">
            <div class="kelas-header">
                <h3><i class="fas fa-school"></i> Daftar Seluruh Kelas</h3>
            </div>
            <div class="kelas-body">
                <!-- Info Box -->
                <div class="info-box-custom">
                    <i class="fas fa-info-circle"></i>
                    <p><strong>Informasi:</strong> Sebagai guru, Anda hanya dapat melihat daftar kelas. Untuk pengelolaan data kelas (tambah/edit/hapus), silakan hubungi Administrator.</p>
                </div>
                
                <!-- Tabel Data Kelas -->
                <?php if(mysqli_num_rows($query) > 0): ?>
                <table class="table-kelas">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Kode Kelas</th>
                            <th>Nama Kelas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        $warna = ['badge-kelas-1', 'badge-kelas-2', 'badge-kelas-3', 'badge-kelas-4', 'badge-kelas-5', 'badge-kelas-6'];
                        while($row = mysqli_fetch_assoc($query)):
                            $index = ($no - 1) % count($warna);
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <span class="badge-kelas <?= $warna[$index] ?>">
                                    <?= htmlspecialchars($row['kd_kelas']) ?>
                                </span>
                            </br>
                            <td><?= htmlspecialchars($row['nm_kelas']) ?></br>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <div class="empty-data">
                    <i class="fas fa-folder-open"></i>
                    <p>Belum ada data kelas yang tersedia.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>