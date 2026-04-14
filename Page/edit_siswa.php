<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Siswa</h1>
            </div>
        </div>
    </div>
</div>

<?php
$nis = $_GET['nis'];
$query = mysqli_query($koneksi, "SELECT * FROM siswa WHERE Nis = '$nis'");
$data = mysqli_fetch_array($query);

if(!$data) {
    echo '<div class="alert alert-danger">Data tidak ditemukan</div>';
    echo '<script>setTimeout(function(){ window.location="index.php?page=siswa"; }, 1000);</script>';
    exit;
}

// Ambil data kelas untuk dropdown
$query_kelas = mysqli_query($koneksi, "SELECT * FROM kelas ORDER BY nm_kelas ASC");

// Proses update data siswa
if(isset($_POST['edit'])){
    $nm_siswa = mysqli_real_escape_string($koneksi, $_POST['nm_siswa']);
    $jenkel = mysqli_real_escape_string($koneksi, $_POST['jenkel']);
    $hp = mysqli_real_escape_string($koneksi, $_POST['hp']);
    $id_kelas = mysqli_real_escape_string($koneksi, $_POST['id_kelas']);
    
    $update = mysqli_query($koneksi, "UPDATE siswa SET 
                                        Nm_siswa = '$nm_siswa',
                                        Jenkel = '$jenkel',
                                        Hp = '$hp',
                                        Id_kelas = '$id_kelas'
                                      WHERE Nis = '$nis'");
    
    if ($update){
        echo '<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> Sukses!</h5>
            Data Berhasil Diupdate
        </div>';
        echo '<script>setTimeout(function(){ window.location="index.php?page=siswa"; }, 1000);</script>';
    } else {
        echo '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-ban"></i> Gagal!</h5>
            Data Gagal Diupdate: '.mysqli_error($koneksi).'
        </div>';
    }
}
?>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit data siswa ✏️</h3>
            </div>
            <div class="card-body p-2">
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="nis">NIS</label>
                        <input type="text" name="nis" value="<?= $data['Nis']; ?>" class="form-control" readonly>
                        <small class="text-muted">NIS tidak dapat diubah</small>
                    </div>
                    <div class="form-group">
                        <label for="nm_siswa">Nama Siswa</label>
                        <input type="text" name="nm_siswa" id="nm_siswa" value="<?= $data['Nm_siswa']; ?>" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="jenkel">Jenis Kelamin</label>
                        <select name="jenkel" id="jenkel" class="form-control" required>
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="Laki-laki" <?= ($data['Jenkel'] == 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                            <option value="Perempuan" <?= ($data['Jenkel'] == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="hp">Nomor HP</label>
                        <input type="text" name="hp" id="hp" value="<?= $data['Hp']; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="id_kelas">Kelas</label>
                        <select name="id_kelas" id="id_kelas" class="form-control">
                            <option value="">-- Pilih Kelas --</option>
                            <?php while($kelas = mysqli_fetch_array($query_kelas)) { ?>
                                <option value="<?= $kelas['kd_kelas']; ?>" <?= ($data['Id_kelas'] == $kelas['kd_kelas']) ? 'selected' : ''; ?>>
                                    <?= $kelas['nm_kelas']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="card-footer">
                        <input type="submit" class="btn btn-primary" name="edit" value="Update">
                        <a href="index.php?page=siswa" class="btn btn-default">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>