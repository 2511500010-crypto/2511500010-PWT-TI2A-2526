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
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-gradient-primary text-white py-3">
                <h3 class="card-title">
                    <i class="fas fa-list mr-2"></i>Daftar Jadwal Kelas
                </h3>
            </div>
            
            <div class="card-body">
                <!-- TOMBOL TAMBAH -->
                <a href="index.php?page=tambah_jadwal" class="btn btn-primary btn-lg mb-4 shadow-sm">
                    <i class="fas fa-plus mr-2"></i> Tambah Jadwal
                </a>
               
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered" id="jadwalTable">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th width="5%">NO</th>
                                <th width="10%">ID Jadwal</th>
                                <th>Kelas</th>
                                <th>Tahun Ajaran</th>
                                <th width="12%">Semester</th>
                                <th width="25%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 0;
                            $query = mysqli_query($koneksi, "SELECT
                                                                j.Id_jadwal,
                                                                j.Id_kelas,
                                                                k.nm_kelas,
                                                                j.Thn_ajaran,
                                                                j.Semester
                                                            FROM Jadwal_kelas j
                                                            LEFT JOIN kelas k ON j.Id_kelas = k.kd_kelas
                                                            ORDER BY j.Thn_ajaran DESC, j.Semester ASC");
                           
                            if($query && mysqli_num_rows($query) > 0) {
                                while ($result = mysqli_fetch_array($query)) {
                                    $no++;
                            ?>
                                <tr class="align-middle">
                                    <td class="text-center font-weight-bold"><?= $no; ?></td>
                                    <td class="text-center"><?= $result['Id_jadwal']; ?></td>
                                    <td>
                                        <strong><?= $result['nm_kelas'] ?: '-'; ?></strong>
                                    </td>
                                    <td><?= $result['Thn_ajaran']; ?></td>
                                    <td>
                                        <?php
                                        $semester = $result['Semester'];
                                        if($semester == 'ganjil') {
                                            echo '<span class="badge badge-pill badge-info px-3 py-2">🌟 Ganjil</span>';
                                        } else {
                                            echo '<span class="badge badge-pill badge-success px-3 py-2">🌱 Genap</span>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="index.php?page=jadwal&action=hapus&id=<?= $result['Id_jadwal'] ?>" 
                                               onclick="return confirm('Yakin ingin menghapus jadwal ini?')"
                                               class="btn btn-danger btn-sm shadow-sm">
                                                <i class="fas fa-trash"></i> Hapus
                                            </a>
                                            <a href="index.php?page=detail_jadwal&kd=<?= $result['Id_jadwal'] ?>" 
                                               class="btn btn-warning btn-sm shadow-sm">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                            <!-- TOMBOL CETAK -->
                                            <a href="index.php?page=cetak_jadwal&id=<?= $result['Id_jadwal'] ?>" 
                                               class="btn btn-success btn-sm shadow-sm" 
                                               target="_blank">
                                                <i class="fas fa-print"></i> Cetak
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                                }
                            } else {
                                echo '
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fas fa-calendar-times fa-3x mb-3"></i><br>
                                        Belum ada data jadwal
                                    </td>
                                </tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 15px;
        overflow: hidden;
    }
    
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }
    
    .table td {
        vertical-align: middle;
    }
    
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
        transform: scale(1.01);
        transition: all 0.2s;
    }
    
    .badge-pill {
        font-weight: 500;
    }
    
    .btn-group .btn {
        border-radius: 6px;
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, #007bff, #0056b3);
    }
</style>