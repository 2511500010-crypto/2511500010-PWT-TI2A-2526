<?php
if (!isset($_SESSION['Username']) || $_SESSION['Role'] != 'siswa') {
    header("location:../login.php");
    exit;
}

$username = $_SESSION['Username'];

// Cari siswa berdasarkan Username ATAU Nama ATAU NIS
$query_siswa = mysqli_query($koneksi, "SELECT s.*, k.nm_kelas 
    FROM siswa s
    LEFT JOIN kelas k ON s.Id_kelas = k.kd_kelas
    WHERE s.Nis = '$username' OR s.Nm_siswa = '$username'");
$siswa = mysqli_fetch_assoc($query_siswa);

// Jika tidak ditemukan, coba cari di users
if(!$siswa) {
    // Ambil dari tabel users, lalu cari siswa berdasarkan nama yang mirip
    $query_user = mysqli_query($koneksi, "SELECT Username FROM users WHERE Username = '$username' AND Role = 'siswa'");
    $user = mysqli_fetch_assoc($query_user);
    
    if($user) {
        // Coba cari siswa dengan nama yang mengandung username
        $query_siswa2 = mysqli_query($koneksi, "SELECT s.*, k.nm_kelas 
            FROM siswa s
            LEFT JOIN kelas k ON s.Id_kelas = k.kd_kelas
            WHERE LOWER(s.Nm_siswa) LIKE LOWER('%$username%')");
        $siswa = mysqli_fetch_assoc($query_siswa2);
    }
}

if(!$siswa) {
    echo '<div class="alert alert-danger">';
    echo '<h4><i class="icon fas fa-ban"></i> Data siswa tidak ditemukan!</h4>';
    echo '<p>Username: ' . htmlspecialchars($username) . '</p>';
    echo '<p>Silakan hubungi administrator untuk memperbaiki data akun Anda.</p>';
    echo '<hr>';
    echo '<p><strong>Info:</strong> Username harus sesuai dengan NIS atau Nama siswa di tabel siswa.</p>';
    echo '</div>';
    
    // Tampilkan data untuk debugging (hapus setelah selesai)
    $cek = mysqli_query($koneksi, "SELECT * FROM siswa");
    echo '<div class="card mt-3"><div class="card-body"><h6>Data Siswa yang tersedia:</h6>';
    while($row = mysqli_fetch_array($cek)) {
        echo '- NIS: ' . $row['Nis'] . ' | Nama: ' . $row['Nm_siswa'] . '<br>';
    }
    echo '</div></div>';
    exit;
}

$id_kelas = $siswa['Id_kelas'];

// Ambil jadwal berdasarkan kelas siswa
$query = mysqli_query($koneksi, "SELECT d.*, m.nm_mapel, guru.Nm_guru, j.Thn_ajaran, j.Semester
    FROM jadwal_kelas j
    JOIN detail_jadwal d ON j.Id_jadwal = d.Id_jadwal
    JOIN mapel m ON d.Kd_mapel = m.kd_mapel
    JOIN guru ON d.Kd_guru = guru.Kd_guru
    WHERE j.Id_kelas = '$id_kelas'
    ORDER BY FIELD(d.Hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'), d.Jam_mulai");
?>

<!-- Sisanya sama seperti sebelumnya (HTML tabel) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">
                    <i class="fas fa-calendar-alt mr-2"></i>Jadwal Pelajaran
                </h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card shadow border-0 rounded-3">
            <div class="card-header bg-success text-white py-3">
                <h3 class="card-title mb-0">
                    <i class="fas fa-users mr-2"></i>Jadwal Kelas <?= $siswa['nm_kelas'] ?> - <?= $siswa['Nm_siswa'] ?>
                </h3>
            </div>
            <div class="card-body p-4">
                <?php if(empty($id_kelas)): ?>
                    <div class="alert alert-warning text-center">
                        <i class="fas fa-exclamation-triangle"></i> Anda belum memiliki kelas. Silakan hubungi admin.
                    </div>
                <?php elseif(mysqli_num_rows($query) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>NO</th>
                                <th>HARI</th>
                                <th>JAM</th>
                                <th>MATA PELAJARAN</th>
                                <th>GURU</th>
                                <th>TAHUN AJARAN</th>
                                <th>SEMESTER</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; while($row = mysqli_fetch_array($query)): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row['Hari'] ?></td>
                                <td><?= date('H:i', strtotime($row['Jam_mulai'])) ?> - <?= date('H:i', strtotime($row['Jam_selesai'])) ?></br>
                                <td><?= $row['nm_mapel'] ?></br>
                                <td><?= $row['Nm_guru'] ?></br>
                                <td><?= $row['Thn_ajaran'] ?></br>
                                <td><?= ucfirst($row['Semester']) ?></br>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="alert alert-info text-center py-5">
                    <i class="fas fa-calendar-times fa-3x mb-3"></i><br>
                    Belum ada jadwal untuk kelas <?= $siswa['nm_kelas'] ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>