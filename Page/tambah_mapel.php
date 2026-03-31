<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Tambah Mata Pelajaran</h1>
            </div>
        </div>
    </div>
</div>

<?php
// kode otomatis untuk kd_mapel
$carikode = mysqli_query($koneksi, "SELECT max(kd_mapel) FROM mapel") or die(mysqli_error($koneksi));
$datakode = mysqli_fetch_array($carikode);

if($datakode[0]) {
    // Ambil angka setelah "M-"
    $nilaikode = substr($datakode[0], 2);
    $kode = (int) $nilaikode;
    $kode = $kode + 1;
    $hasilkode = "M-".str_pad($kode, 3, "0", STR_PAD_LEFT);
} else {
    $hasilkode = "M-001";
}
$_SESSION["KODE"] = $hasilkode;

// proses simpan data mapel
if(isset($_POST['tambah'])){
    $kd_mapel = mysqli_real_escape_string($koneksi, $_POST['kd_mapel']);
    $nm_mapel = mysqli_real_escape_string($koneksi, $_POST['nm_mapel']);
    $kkm = mysqli_real_escape_string($koneksi, $_POST['kkm']);
    
    // Cek apakah kode mapel sudah ada
    $cek = mysqli_query($koneksi, "SELECT * FROM mapel WHERE kd_mapel = '$kd_mapel'");
    if(mysqli_num_rows($cek) > 0) {
        echo '<div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-exclamation-triangle"></i> Peringatan!</h5>
            Kode Mapel sudah ada!
        </div>';
    } else {
        $insert = mysqli_query($koneksi, "INSERT INTO mapel (kd_mapel, nm_mapel, kkm) VALUES ('$kd_mapel','$nm_mapel','$kkm')");
        if ($insert){
            echo '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-check"></i> Sukses!</h5>
                Data Berhasil Disimpan
            </div>';
            echo '<script>setTimeout(function(){ window.location="index.php?page=mapel"; }, 1000);</script>';
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
                <h3 class="card-title">Tambahkan mata pelajaran ❤️❤️❤️</h3>
            </div>
            <div class="card-body p-2">
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="kd_mapel">Kode Mapel</label>
                        <input type="text" name="kd_mapel" value="<?= $hasilkode; ?>" placeholder="Kode Mapel" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nm_mapel">Nama Mapel</label>
                        <input type="text" name="nm_mapel" id="nm_mapel" placeholder="Nama Mapel" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="kkm">KKM</label>
                        <input type="number" name="kkm" id="kkm" placeholder="KKM" class="form-control" required>
                    </div>
                    <div class="card-footer">
                        <input type="submit" class="btn btn-primary" name="tambah" value="Simpan">
                        <a href="index.php?page=mapel" class="btn btn-default">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>