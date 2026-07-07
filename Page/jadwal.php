<?php
// Page/jadwal.php
// Proses hapus data jadwal
if(isset($_GET['action']) && $_GET['action'] == "hapus") {
    $id_jadwal = mysqli_real_escape_string($koneksi, $_GET['id']);
    
    // Cek apakah Id_jadwal ada di tabel Jadwal_kelas
    $cek = mysqli_query($koneksi, "SELECT Id_jadwal FROM Jadwal_kelas WHERE Id_jadwal = '$id_jadwal'");
    if(mysqli_num_rows($cek) > 0) {
        // Hapus dari detail_jadwal dulu (karena foreign key)
        mysqli_query($koneksi, "DELETE FROM detail_jadwal WHERE Id_jadwal = '$id_jadwal'");
        // Hapus dari Jadwal_kelas
        $hapus_jadwal = mysqli_query($koneksi, "DELETE FROM Jadwal_kelas WHERE Id_jadwal = '$id_jadwal'");
        
        if($hapus_jadwal){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <i class="fas fa-check-circle"></i> Data Berhasil Dihapus
            </div>';
            echo '<meta http-equiv="refresh" content="1;url=index.php?page=jadwal">';
        } else {
            echo '<div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle"></i> Gagal Menghapus Data: '.mysqli_error($koneksi).'
            </div>';
        }
    } else {
        echo '<div class="alert alert-warning">Data tidak ditemukan!</div>';
    }
}
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">
                    <i class="fas fa-calendar-alt mr-2"></i>Data Jadwal
                </h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <a href="index.php?page=tambah_jadwal" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah Jadwal
                </a>
                <br><br>
               
                <table class="table table-bordered table-hover">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>No</th>
                            <th>ID Jadwal</th>
                            <th>Kelas</th>
                            <th>Tahun Ajaran</th>
                            <th>Semester</th>
                            <th>Detail Jadwal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        // Query untuk mengambil data jadwal beserta kelas dan detailnya
                        $query = mysqli_query($koneksi, "SELECT 
                            j.Id_jadwal,
                            j.Thn_ajaran,
                            j.Semester,
                            k.nm_kelas,
                            (SELECT COUNT(*) FROM detail_jadwal WHERE Id_jadwal = j.Id_jadwal) as jumlah_detail
                        FROM Jadwal_kelas j
                        LEFT JOIN kelas k ON j.Id_kelas = k.kd_kelas
                        ORDER BY j.Id_jadwal DESC");
                        
                        if($query && mysqli_num_rows($query) > 0) {
                            while ($row = mysqli_fetch_assoc($query)) {
                                $no++;
                                
                                // Ambil detail jadwal untuk ditampilkan
                                $detail_query = mysqli_query($koneksi, "SELECT 
                                    d.*,
                                    m.nm_mapel,
                                    g.Nm_guru
                                FROM detail_jadwal d
                                LEFT JOIN mapel m ON d.Kd_mapel = m.kd_mapel
                                LEFT JOIN guru g ON d.Kd_guru = g.Kd_guru
                                WHERE d.Id_jadwal = '" . $row['Id_jadwal'] . "'
                                ORDER BY FIELD(d.Hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'), d.Jam_mulai");
                        ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <td><?= $row['Id_jadwal']; ?></td>
                                <td><strong><?= htmlspecialchars($row['nm_kelas'] ?: 'Kelas tidak ditemukan'); ?></strong></td>
                                <td><?= htmlspecialchars($row['Thn_ajaran']); ?></td>
                                <td class="text-center">
                                    <?php
                                    $semester = strtolower(trim($row['Semester']));
                                    if($semester == 'ganjil') {
                                        echo '<span class="badge badge-info">Ganjil</span>';
                                    } else {
                                        echo '<span class="badge badge-success">Genap</span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php if(mysqli_num_rows($detail_query) > 0): ?>
                                        <div style="max-height: 200px; overflow-y: auto;">
                                            <table class="table table-sm table-bordered" style="margin:0; font-size:12px;">
                                                <thead>
                                                    <tr>
                                                        <th>Hari</th>
                                                        <th>Jam</th>
                                                        <th>Mapel</th>
                                                        <th>Guru</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php while($detail = mysqli_fetch_assoc($detail_query)): ?>
                                                    <tr>
                                                        <td><?= $detail['Hari']; ?></br>
                                                        <td><?= date('H:i', strtotime($detail['Jam_mulai'])); ?> - <?= date('H:i', strtotime($detail['Jam_selesai'])); ?></br>
                                                        <td><?= htmlspecialchars($detail['nm_mapel'] ?: $detail['Kd_mapel']); ?></br>
                                                        <td><?= htmlspecialchars($detail['Nm_guru'] ?: $detail['Kd_guru']); ?></br>
                                                    </tr>
                                                    <?php endwhile; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted"><i class="fas fa-clock"></i> Belum ada detail</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <!-- Tombol Cetak (ditambahkan) -->
                                    <a href="index.php?page=cetak_jadwal&id=<?= $row['Id_jadwal'] ?>" 
                                       target="_blank"
                                       class="btn btn-success btn-sm" title="Cetak Jadwal">
                                        <i class="fas fa-print"></i> Cetak
                                    </a>
                                    <!-- Tombol Detail -->
                                    <a href="index.php?page=detail_jadwal&id=<?= $row['Id_jadwal'] ?>" 
                                       class="btn btn-info btn-sm" title="Detail Jadwal">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    <!-- Tombol Hapus -->
                                    <a href="index.php?page=jadwal&action=hapus&id=<?= $row['Id_jadwal'] ?>" 
                                       onclick="return confirm('Yakin ingin menghapus jadwal ini? Semua detail jadwal juga akan terhapus!')"
                                       class="btn btn-danger btn-sm" title="Hapus Jadwal">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                 </div>
                                </td>
                            </tr>
                        <?php
                            }
                        } else {
                            echo '<tr><td colspan="7" class="text-center">Belum ada data jadwal</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .table td {
        vertical-align: middle;
    }
    .btn-sm {
        margin: 2px;
    }
</style>