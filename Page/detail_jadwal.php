<?php
// Proses hapus data jadwal
if(isset($_GET['action'])) {
    if($_GET['action'] == "hapus") {
        $id_jadwal = mysqli_real_escape_string($koneksi, $_GET['id']);
        $query = mysqli_query($koneksi, "DELETE FROM Jadwal_kelas WHERE Id_jadwal = '$id_jadwal'");
        if ($query){
            echo '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <i class="icon fas fa-check"></i> Data Berhasil Dihapus
            </div>';
            echo '<meta http-equiv="refresh" content="1;url=index.php?page=jadwal">';
        } else {
            echo '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <i class="icon fas fa-ban"></i> Gagal Menghapus Data: '.mysqli_error($koneksi).'
            </div>';
        }
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
            <div class="col-sm-6 text-right">
                <a href="index.php?page=jadwal" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Jadwal
                </a>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card shadow border-0 rounded-3">
            <div class="card-header bg-primary text-white py-3">
                <h3 class="card-title mb-0">
                    <i class="fas fa-chalkboard-teacher mr-2"></i>Jadwal Kelas
                </h3>
            </div>
           
            <div class="card-body p-4">
                <?php
                $tampiljadwal = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM jadwal_kelas
                JOIN kelas ON jadwal_kelas.Id_kelas = kelas.kd_kelas LIMIT 1"));
                ?>
               
                <!-- Informasi Cards - Versi Diupgrade -->
                <div class="row g-4 mb-5">
                    <!-- Tahun Ajaran -->
                    <div class="col-md-4">
                        <div class="info-card p-4 rounded-4 shadow-sm h-100">
                            <div class="d-flex align-items-start">
                                <div class="icon-box bg-info text-white rounded-3 d-flex align-items-center justify-content-center me-4" style="width: 72px; height: 72px;">
                                    <i class="fas fa-calendar-alt fa-3x"></i>
                                </div>
                                <div>
                                    <small class="text-muted fw-bold">Tahun Ajaran</small>
                                    <h4 class="mb-0 fw-bold"><?= $tampiljadwal['Thn_ajaran'] ?? '-' ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Semester -->
                    <div class="col-md-4">
                        <div class="info-card p-4 rounded-4 shadow-sm h-100">
                            <div class="d-flex align-items-start">
                                <div class="icon-box bg-success text-white rounded-3 d-flex align-items-center justify-content-center me-4" style="width: 72px; height: 72px;">
                                    <i class="fas fa-exchange-alt fa-3x"></i>
                                </div>
                                <div>
                                    <small class="text-muted fw-bold">Semester</small>
                                    <?php
                                    $sem = strtolower($tampiljadwal['Semester'] ?? '');
                                    $sem_text = ($sem == 'ganjil') ? 'Ganjil' : 'Genap';
                                    ?>
                                    <h4 class="mb-0">
                                        <span class="badge bg-success px-4 py-2 fs-5"><?= $sem_text ?></span>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kelas -->
                    <div class="col-md-4">
                        <div class="info-card p-4 rounded-4 shadow-sm h-100">
                            <div class="d-flex align-items-start">
                                <div class="icon-box bg-warning text-white rounded-3 d-flex align-items-center justify-content-center me-4" style="width: 72px; height: 72px;">
                                    <i class="fas fa-users fa-3x"></i>
                                </div>
                                <div>
                                    <small class="text-muted fw-bold">Kelas</small>
                                    <h4 class="mb-0 fw-bold"><?= $tampiljadwal['nm_kelas'] ?? '-' ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Jadwal Pelajaran -->
                <h5 class="mb-3 fw-bold">
                    <i class="fas fa-list mr-2"></i>Jadwal Pelajaran
                </h5>
               
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center" width="5%">NO</th>
                                <th>KODE MAPEL</th>
                                <th>NAMA MATA PELAJARAN</th>
                                <th>NAMA GURU</th>
                                <th>HARI</th>
                                <th>JAM PELAJARAN</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 0;
                            $query = mysqli_query($koneksi, "SELECT * FROM jadwal_kelas
                            JOIN detail_jadwal ON jadwal_kelas.Id_jadwal=detail_jadwal.Id_jadwal
                            JOIN mapel ON mapel.kd_mapel = detail_jadwal.Kd_mapel
                            JOIN guru ON guru.Kd_guru = detail_jadwal.Kd_guru");
                           
                            if($query && mysqli_num_rows($query) > 0) {
                                while ($result = mysqli_fetch_array($query)) {
                                    $no++;
                            ?>
                                <tr>
                                    <td class="text-center fw-bold"><?= $no ?></td>
                                    <td><?= $result['kd_mapel'] ?></td>
                                    <td><strong><?= $result['nm_mapel'] ?: '-' ?></strong></td>
                                    <td><?= $result['Nm_guru'] ?></td>
                                    <td>
                                        <span class="badge badge-pill badge-secondary"><?= ucfirst($result['Hari']) ?></span>
                                    </td>
                                    <td><?= $result['Jam_mulai'] ?> — <?= $result['Jam_selesai'] ?></td>
                                </tr>
                            <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fas fa-calendar-xmark fa-3x mb-3"></i><br>
                                        Belum ada jadwal pelajaran
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CSS Tambahan - Diupgrade -->
<style>
    .card { border-radius: 16px; overflow: hidden; }
    
    .info-card {
        background: #fff;
        transition: all 0.3s ease;
        border: 1px solid #f0f0f0;
    }
    
    .info-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12) !important;
    }
    
    .icon-box {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        flex-shrink: 0;
    }
    
    .table th { 
        text-transform: uppercase; 
        font-size: 0.9rem; 
        letter-spacing: 0.5px; 
    }
    .badge-pill { font-weight: 500; }
</style>