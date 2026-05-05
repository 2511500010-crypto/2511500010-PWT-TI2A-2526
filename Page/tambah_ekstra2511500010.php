<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Tambah Ekstrakurikuler</h1>
            </div>
        </div>
    </div>
</div>

<?php
$carikode = mysqli_query($koneksi, "SELECT max(id_ekstra_010) FROM Ekstra_2511500010") or die(mysqli_error($koneksi));
$datakode = mysqli_fetch_array($carikode);

if($datakode[0]) {
    $nilaikode = substr($datakode[0], 2);
    $kode = (int) $nilaikode;
    $kode = $kode + 1;
    $hasilkode = "E-".str_pad($kode, 3, "0", STR_PAD_LEFT);
} else {
    $hasilkode = "E-001";
}
$_SESSION["KODE"] = $hasilkode;

if(isset($_POST['tambah'])){
    $id_ekstra_010 = mysqli_real_escape_string($koneksi, $_POST['id_ekstra_010']);
    $nama_ekstra_010 = mysqli_real_escape_string($koneksi, $_POST['nama_ekstra_010']);
    $ket_010 = mysqli_real_escape_string($koneksi, $_POST['ket_010']);
    $semester_010 = mysqli_real_escape_string($koneksi, $_POST['semester_010']);
    $thn_ajaran_010 = mysqli_real_escape_string($koneksi, $_POST['thn_ajaran_010']);

    $cek = mysqli_query($koneksi, "SELECT * FROM Ekstra_2511500010 WHERE id_ekstra_010 = '$id_ekstra_010'");
    if(mysqli_num_rows($cek) > 0) {
        echo '<div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-exclamation-triangle"></i> Peringatan!</h5>
            ID Ekstra sudah ada!
        </div>';
    } else {
        $insert = mysqli_query($koneksi, "INSERT INTO Ekstra_2511500010 (id_ekstra_010, nama_ekstra_010, ket_010, semester_010, thn_ajaran_010) VALUES ('$id_ekstra_010','$nama_ekstra_010','$ket_010','$semester_010','$thn_ajaran_010')");
        if ($insert){
            echo '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-check"></i> Sukses!</h5>
                Data Berhasil Disimpan
            </div>';
            echo '<script>setTimeout(function(){ window.location="index.php?page=ekstra2511500010"; }, 1000);</script>';
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
                <h3 class="card-title">Tambahkan Ekstrakurikuler ❤️❤️❤️</h3>
            </div>
            <div class="card-body p-2">
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="id_ekstra_010">ID Ekstra</label>
                        <input type="text" name="id_ekstra_010" value="<?= $hasilkode; ?>" placeholder="ID Ekstra" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nama_ekstra_010">Nama Ekstrakurikuler</label>
                        <input type="text" name="nama_ekstra_010" id="nama_ekstra_010" placeholder="Nama Ekstrakurikuler" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="ket_010">Keterangan</label>
                        <input type="text" name="ket_010" id="ket_010" placeholder="Keterangan" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="semester_010">Semester</label>
                        <select name="semester_010" id="semester_010" class="form-control" required>
                            <option value="">Pilih Semester</option>
                            <option value="1">Semester 1</option>
                            <option value="2">Semester 2</option>
                            <option value="3">Semester 3</option>
                            <option value="4">Semester 4</option>
                            <option value="5">Semester 5</option>
                            <option value="6">Semester 6</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="thn_ajaran_010">Tahun Ajaran</label>
                        <select name="thn_ajaran_010" id="thn_ajaran_010" class="form-control" required>
                            <option value="">Pilih Tahun Ajaran</option>
                            <option value="2023/2024">2023/2024</option>
                            <option value="2024/2025">2024/2025</option>
                            <option value="2025/2026">2025/2026</option>
                        </select>
                    </div>
                    <div class="card-footer">
                        <input type="submit" class="btn btn-primary" name="tambah" value="Simpan">
                        <a href="index.php?page=ekstra2511500010" class="btn btn-default">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>