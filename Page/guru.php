<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data Guru</h1>
            </div>
        </div>
    </div>
</div>

<?php
// Proses hapus data guru
if(isset($_GET['action'])) {
    if($_GET['action'] == "hapus") {
        $kd_guru = $_GET['kd'];
        $query = mysqli_query($koneksi, "DELETE FROM guru WHERE Kd_guru = '$kd_guru'");
        if ($query){
            echo '
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <i class="icon fas fa-trash"></i> Data Berhasil Dihapus
            </div>';
            echo '<meta http-equiv="refresh" content="1;url=index.php?page=guru">';
        } else {
            echo '
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <i class="icon fas fa-ban"></i> Gagal Menghapus Data: '.mysqli_error($koneksi).'
            </div>';
        }
    }
}
?>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Guru</h3>
            </div>
            <div class="card-body">
                <a href="index.php?page=tambah_guru" class="btn btn-primary btn-sm mb-3">Tambah Guru</a>
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>NO</th>
                            <th>Kode Guru</th>
                            <th>Nama Guru</th>
                            <th>Jenis Kelamin</th>
                            <th>Pendidikan Terakhir</th>
                            <th>HP</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        $query = mysqli_query($koneksi, "SELECT * FROM guru ORDER BY Kd_guru ASC");
                        if(mysqli_num_rows($query) > 0) {
                            while ($result = mysqli_fetch_array($query)) {
                                $no++;
                        ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <td><?= $result['Kd_guru']; ?></td>
                                <td><?= $result['Nm_guru']; ?></td>
                                <td><?= $result['Jenkel']; ?></td>
                                <td><?= $result['Pend_terakhir']; ?></td>
                                <td><?= $result['Hp']; ?></td>
                                <td><?= $result['Alamat']; ?></td>
                                <td>
                                    <a href="index.php?page=guru&action=hapus&kd=<?= $result['Kd_guru'] ?>" 
                                       onclick="return confirm('Apakah Anda yakin ingin menghapus data guru <?= $result['Nm_guru']; ?>?')" 
                                       title="Hapus">
                                        <span class="badge badge-danger">Hapus</span>
                                    </a>
                                    <a href="index.php?page=edit_guru&kd=<?= $result['Kd_guru'] ?>" 
                                       title="Edit">
                                        <span class="badge badge-warning">Edit</span>
                                    </a>
                                </td>
                            </tr>
                        <?php 
                            }
                        } else {
                            echo '
                            <tr>
                                <td colspan="8" class="text-center">Belum ada data guru</td>
                            </tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>