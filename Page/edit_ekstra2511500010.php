<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Ekstrakurikuler</h1>
            </div>
        </div>
    </div>
</div>

<?php
$id = $_GET['id'];
$edit = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM Ekstra_2511500010 WHERE id_ekstra_010='$id'"));

if(isset($_POST['edit'])){
    $id_ekstra_010 = $_POST['id_ekstra_010'];
    $nama_ekstra_010 = $_POST['nama_ekstra_010'];
    $ket_010 = $_POST['ket_010'];
    $semester_010 = $_POST['semester_010'];
    $thn_ajaran_010 = $_POST['thn_ajaran_010'];

    $update = mysqli_query($koneksi,"UPDATE Ekstra_2511500010 SET nama_ekstra_010='$nama_ekstra_010', ket_010='$ket_010', semester_010='$semester_010', thn_ajaran_010='$thn_ajaran_010' WHERE id_ekstra_010='$id_ekstra_010' ");
    if($update){
        echo '<div class="alert alert-info-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
        <h5><i class="icon fas fa-info"></i> Info </h5>
        <h4>Berhasil Disimpan</h4></div>';
        echo '<meta http-equiv="refresh" content="1;url=index.php?page=ekstra2511500010">';
    }else{
        echo '<div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
        <h5><i class="icon fas fa-info"></i> Info </h5>
        <h4>Gagal Disimpan</h4></div>';
    }
}
?>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="card-body p-2">
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="id_ekstra_010">ID Ekstra</label>
                            <input type="text" name="id_ekstra_010" value="<?= $edit['id_ekstra_010']; ?>" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="nama_ekstra_010">Nama Ekstrakurikuler</label>
                            <input type="text" name="nama_ekstra_010" value="<?= $edit['nama_ekstra_010']; ?>" id="nama_ekstra_010" placeholder="Nama Ekstrakurikuler" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="ket_010">Keterangan</label>
                            <input type="text" name="ket_010" value="<?= $edit['ket_010']; ?>" id="ket_010" placeholder="Keterangan" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="semester_010">Semester</label>
                            <select name="semester_010" id="semester_010" class="form-control">
                                <option value="">Pilih Semester</option>
                                <option value="1" <?= ($edit['semester_010'] == '1') ? 'selected' : ''; ?>>Semester 1</option>
                                <option value="2" <?= ($edit['semester_010'] == '2') ? 'selected' : ''; ?>>Semester 2</option>
                                <option value="3" <?= ($edit['semester_010'] == '3') ? 'selected' : ''; ?>>Semester 3</option>
                                <option value="4" <?= ($edit['semester_010'] == '4') ? 'selected' : ''; ?>>Semester 4</option>
                                <option value="5" <?= ($edit['semester_010'] == '5') ? 'selected' : ''; ?>>Semester 5</option>
                                <option value="6" <?= ($edit['semester_010'] == '6') ? 'selected' : ''; ?>>Semester 6</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="thn_ajaran_010">Tahun Ajaran</label>
                            <select name="thn_ajaran_010" id="thn_ajaran_010" class="form-control">
                                <option value="">Pilih Tahun Ajaran</option>
                                <option value="2023/2024" <?= ($edit['thn_ajaran_010'] == '2023/2024') ? 'selected' : ''; ?>>2023/2024</option>
                                <option value="2024/2025" <?= ($edit['thn_ajaran_010'] == '2024/2025') ? 'selected' : ''; ?>>2024/2025</option>
                                <option value="2025/2026" <?= ($edit['thn_ajaran_010'] == '2025/2026') ? 'selected' : ''; ?>>2025/2026</option>
                            </select>
                        </div>
                        <div class="card-footer">
                            <input type="submit" class="btn btn-primary" name="edit" value="simpan">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>