<?php
if (!isset($_SESSION['Username'])) {
    header("location:../login.php");
    exit;
}

$role = $_SESSION['Role'];
if($role != 'guru') {
    header("location:../index.php");
    exit;
}

$username = $_SESSION['Username'];

// Cari data guru berdasarkan username
$query_guru = mysqli_query($koneksi, "SELECT * FROM guru WHERE Kd_guru = '$username' OR Nm_guru = '$username'");
$guru = mysqli_fetch_assoc($query_guru);

if(!$guru) {
    echo '<div class="alert alert-danger">Data guru tidak ditemukan!</div>';
    exit;
}

$kd_guru = $guru['Kd_guru'];

// Ambil jadwal mengajar guru
$query = mysqli_query($koneksi, "SELECT d.*, m.nm_mapel, k.nm_kelas, j.Thn_ajaran, j.Semester
    FROM detail_jadwal d
    JOIN mapel m ON d.Kd_mapel = m.kd_mapel
    JOIN jadwal_kelas j ON d.Id_jadwal = j.Id_jadwal
    JOIN kelas k ON j.Id_kelas = k.kd_kelas
    WHERE d.Kd_guru = '$kd_guru'
    ORDER BY FIELD(d.Hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'), d.Jam_mulai");
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">
                    <i class="fas fa-chalkboard-teacher mr-2"></i>Jadwal Mengajar
                </h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card shadow border-0 rounded-3">
            <div class="card-header bg-primary text-white py-3">
                <h3 class="card-title mb-0">
                    <i class="fas fa-calendar-alt mr-2"></i>Jadwal Mengajar - <?= $guru['Nm_guru'] ?>
                </h3>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>NO</th>
                                <th>HARI</th>
                                <th>JAM</th>
                                <th>MATA PELAJARAN</th>
                                <th>KELAS</th>
                                <th>TAHUN AJARAN</th>
                                <th>SEMESTER</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 0;
                            if(mysqli_num_rows($query) > 0) {
                                while($row = mysqli_fetch_array($query)) {
                                    $no++;
                            ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= $row['Hari'] ?></td>
                                    <td><?= date('H:i', strtotime($row['Jam_mulai'])) ?> - <?= date('H:i', strtotime($row['Jam_selesai'])) ?></br>
                                    <td><?= $row['nm_mapel'] ?></br>
                                    <td><?= $row['nm_kelas'] ?></br>
                                    <td><?= $row['Thn_ajaran'] ?></br>
                                    <td><?= ucfirst($row['Semester']) ?></br>
                                </tr>
                            <?php 
                                }
                            } else { 
                            ?>
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fas fa-calendar-times fa-3x mb-3"></i><br>
                                        Belum ada jadwal mengajar
                                    </br>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>