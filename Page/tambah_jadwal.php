<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Tambah Jadwal</h1>
            </div>
        </div>
    </div>
</div>

<?php
// Ambil data kelas untuk dropdown
$query_kelas = mysqli_query($koneksi, "SELECT * FROM kelas ORDER BY nm_kelas ASC");

// Proses simpan data jadwal
if(isset($_POST['tambah'])){
    $id_kelas = mysqli_real_escape_string($koneksi, $_POST['id_kelas']);
    $thn_ajaran = mysqli_real_escape_string($koneksi, $_POST['thn_ajaran']);
    $semester = mysqli_real_escape_string($koneksi, $_POST['semester']);
    
    // Cek apakah data sudah ada (kelas + tahun ajaran + semester yang sama)
    $cek = mysqli_query($koneksi, "SELECT * FROM Jadwal_kelas WHERE Id_kelas = '$id_kelas' AND Thn_ajaran = '$thn_ajaran' AND Semester = '$semester'");
    if(mysqli_num_rows($cek) > 0) {
        echo '<div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-exclamation-triangle"></i> Peringatan!</h5>
            Jadwal untuk kelas ini sudah ada pada tahun ajaran dan semester yang sama!
        </div>';
    } else {
        $insert = mysqli_query($koneksi, "INSERT INTO Jadwal_kelas (Id_kelas, Thn_ajaran, Semester) 
                                          VALUES ('$id_kelas', '$thn_ajaran', '$semester')");
        
        if ($insert){
            echo '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-check"></i> Sukses!</h5>
                Data Berhasil Disimpan
            </div>';
            echo '<script>setTimeout(function(){ window.location="index.php?page=jadwal"; }, 1000);</script>';
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
                <h3 class="card-title">Tambahkan data jadwal kelas 📅</h3>
            </div>
            <div class="card-body p-2">
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="id_kelas">Pilih Kelas</label>
                        <select name="id_kelas" id="id_kelas" class="form-control" required autofocus>
                            <option value="">-- Pilih Kelas --</option>
                            <?php while($kelas = mysqli_fetch_array($query_kelas)) { ?>
                                <option value="<?= $kelas['kd_kelas']; ?>"><?= $kelas['nm_kelas']; ?></option>
                            <?php } ?>
                        </select>
                        <small class="text-muted">Pilih kelas yang akan dijadwalkan</small>
                    </div>
                    <div class="form-group">
                        <label for="thn_ajaran">Tahun Ajaran</label>
                        <select name="thn_ajaran" id="thn_ajaran" class="form-control" required>
                            <option value="">-- Pilih Tahun Ajaran --</option>
                            <option value="2023/2024">2023/2024</option>
                            <option value="2024/2025">2024/2025</option>
                            <option value="2025/2026">2025/2026</option>
                            <option value="2026/2027">2026/2027</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="semester">Semester</label>
                        <select name="semester" id="semester" class="form-control" required>
                            <option value="">-- Pilih Semester --</option>
                            <option value="ganjil">Ganjil</option>
                            <option value="genap">Genap</option>
                        </select>
                    </div>
                    <div class="card-footer">
                        <input type="submit" class="btn btn-primary" name="tambah" value="Simpan">
                        <a href="index.php?page=jadwal" class="btn btn-default">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>