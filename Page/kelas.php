<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data Kelas</h1>
            </div>
        </div>
    </div>
</div>

<?php
// Proses hapus data kelas
if(isset($_GET['action'])) {
    if($_GET['action'] == "hapus") {
        $kd = $_GET['kd'];
        $query = mysqli_query($koneksi, "DELETE FROM kelas WHERE kd_kelas = '$kd' ");
        if ($query){
            echo '
            <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="icon fas fa-trash"></i> Data Berhasil Dihapus
            </div>';
            echo '<meta http-equiv="refresh" content="1;url=index.php?page=kelas">';
        } else {
            echo '
            <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="icon fas fa-ban"></i> Gagal Menghapus Data
            </div>';
        }
    }
}
?>

<div class="content">
    <div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Kelas</h3>
        </div>
        <div class="card-body">
        <a href="index.php?page=tambah_kelas" class="btn btn-primary btn-sm mb-3">Tambah Kelas</a>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
            <tr>
                <th>NO</th>
                <th>Kode Kelas</th>
                <th>Nama Kelas</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $no = 0;
            $query = mysqli_query($koneksi, "SELECT * FROM kelas ORDER BY kd_kelas ASC");
            if(mysqli_num_rows($query) > 0) {
                while ($result = mysqli_fetch_array($query)) {
                $no++;
            ?>
            <tr>
                <td><?= $no; ?></td>
                <td><?= $result['kd_kelas']; ?></td>
                <td><?= $result['nm_kelas']; ?></td>
                <td>
                    <a href="index.php?page=kelas&action=hapus&kd=<?= $result['kd_kelas'] ?>" 
                       onclick="return confirm('Apakah Anda yakin ingin menghapus data kelas <?= $result['nm_kelas']; ?>?')" 
                       title="Hapus">
                        <span class="badge badge-danger">Hapus</span>
                    </a>
                    <a href="index.php?page=edit_kelas&kd=<?= $result['kd_kelas'] ?>" 
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
                    <td colspan="3" class="text-center">Belum ada data kelas</td>
                </tr>';
            }
            ?>
            </tbody>
        </table>
        </div>
    </div>
    </div>
</div>