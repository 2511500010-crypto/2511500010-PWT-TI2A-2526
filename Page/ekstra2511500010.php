<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data Ekstrakurikuler</h1>
            </div>
        </div>
    </div>
</div>

<?php
if(isset($_GET['action'])) {
    if($_GET['action'] == "hapus") {
        $id = $_GET['id'];
        $query = mysqli_query($koneksi, "DELETE FROM Ekstra_2511500010 WHERE id_ekstra_010 = '$id' ");
        if ($query){
            echo '
            <div class="alert alert-warning alert-dismissible">
            Berhasil Di Hapus</div>';
            echo '<meta http-equiv="refresh" content="1;url=index.php?page=ekstra2511500010">';
        }
    }
}
?>

<div class="content">
    <div class="container-fluid">
    <div class="card">
        <div class="card-body">
        <a href="index.php?page=tambah_ekstra2511500010" class="btn btn-primary btn-sm">Tambah Ekstrakurikuler</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>ID Ekstra</th>
                    <th>Nama Ekstrakurikuler</th>
                    <th>Keterangan</th>
                    <th>Semester</th>
                    <th>Tahun Ajaran</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $no = 0;
            $query = mysqli_query($koneksi, "SELECT * FROM Ekstra_2511500010");
            while ($result = mysqli_fetch_array($query)) {
            $no++;
            ?>
                <tr>
                    <td><?= $no; ?></td>
                    <td><?= $result['id_ekstra_010']; ?></td>
                    <td><?= $result['nama_ekstra_010']; ?></td>
                    <td><?= $result['ket_010']; ?></td>
                    <td><?= $result['semester_010']; ?></td>
                    <td><?= $result['thn_ajaran_010']; ?></td>
                    <td>
                        <a href="index.php?page=ekstra2511500010&action=hapus&id=<?= $result['id_ekstra_010'] ?>" class="badge badge-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                        <a href="index.php?page=edit_ekstra2511500010&id=<?= $result['id_ekstra_010'] ?>" class="badge badge-warning">Edit</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        </div>
    </div>
    </div>
</div>