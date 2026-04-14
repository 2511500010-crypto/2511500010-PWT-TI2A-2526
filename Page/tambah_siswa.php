<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Tambah Siswa</h1>
            </div>
        </div>
    </div>
</div>

<?php
// Ambil data kelas untuk dropdown
$query_kelas = mysqli_query($koneksi, "SELECT * FROM kelas ORDER BY nm_kelas ASC");

// Proses simpan data siswa
if(isset($_POST['tambah'])){
    $nis = mysqli_real_escape_string($koneksi, $_POST['nis']);
    $nm_siswa = mysqli_real_escape_string($koneksi, $_POST['nm_siswa']);
    $jenkel = mysqli_real_escape_string($koneksi, $_POST['jenkel']);
    $hp = mysqli_real_escape_string($koneksi, $_POST['hp']);
    $id_kelas = mysqli_real_escape_string($koneksi, $_POST['id_kelas']);
    
    // Cek apakah NIS sudah ada
    $cek = mysqli_query($koneksi, "SELECT * FROM siswa WHERE Nis = '$nis'");
    if(mysqli_num_rows($cek) > 0) {
        echo '<div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-exclamation-triangle"></i> Peringatan!</h5>
            NIS sudah ada! Gunakan NIS yang berbeda.
        </div>';
    } else {
        $insert = mysqli_query($koneksi, "INSERT INTO siswa (Nis, Nm_siswa, Jenkel, Hp, Id_kelas) 
                                          VALUES ('$nis', '$nm_siswa', '$jenkel', '$hp', '$id_kelas')");
        
        if ($insert){
            echo '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-check"></i> Sukses!</h5>
                Data Berhasil Disimpan
            </div>';
            echo '<script>setTimeout(function(){ window.location="index.php?page=siswa"; }, 1000);</script>';
        } else {
            echo '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-ban"></i> Gagal!</h5>
                Data Gagal Disimpan: '.mysqli_error($koneksi).'
            </div>';
        }
    }
}
?>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tambahkan data siswa 👨‍🎓👩‍🎓</h3>
            </div>
            <div class="card-body p-2">
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="nis">NIS</label>
                        <input type="text" name="nis" id="nis" placeholder="Contoh: 2024001" class="form-control" required autofocus>
                        <small class="text-muted">Nomor Induk Siswa (10 digit maksimal)</small>
                    </div>
                    <div class="form-group">
                        <label for="nm_siswa">Nama Siswa</label>
                        <input type="text" name="nm_siswa" id="nm_siswa" placeholder="Nama Lengkap" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="jenkel">Jenis Kelamin</label>
                        <select name="jenkel" id="jenkel" class="form-control" required>
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="hp">Nomor HP</label>
                        <input type="text" name="hp" id="hp" placeholder="Contoh: 08123456789" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="id_kelas">Kelas</label>
                        <select name="id_kelas" id="id_kelas" class="form-control">
                            <option value="">-- Pilih Kelas --</option>
                            <?php while($kelas = mysqli_fetch_array($query_kelas)) { ?>
                                <option value="<?= $kelas['kd_kelas']; ?>"><?= $kelas['nm_kelas']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="card-footer">
                        <input type="submit" class="btn btn-primary" name="tambah" value="Simpan">
                        <a href="index.php?page=siswa" class="btn btn-default">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>