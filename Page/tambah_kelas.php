<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Tambah Kelas</h1>
            </div>
        </div>
    </div>
</div>

<?php
// proses simpan data kelas
if(isset($_POST['tambah'])){
    $nm_kelas = mysqli_real_escape_string($koneksi, $_POST['nm_kelas']);
    
    // Cek apakah nama kelas sudah ada
    $cek = mysqli_query($koneksi, "SELECT * FROM kelas WHERE nm_kelas = '$nm_kelas'");
    if(mysqli_num_rows($cek) > 0) {
        echo '<div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-exclamation-triangle"></i> Peringatan!</h5>
            Nama Kelas sudah ada!
        </div>';
    } else {
        // Hanya insert nm_kelas, karena kd_kelas AUTO_INCREMENT
        $insert = mysqli_query($koneksi, "INSERT INTO kelas (nm_kelas) VALUES ('$nm_kelas')");
        
        if ($insert){
            echo '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-check"></i> Sukses!</h5>
                Data Berhasil Disimpan
            </div>';
            echo '<script>setTimeout(function(){ window.location="index.php?page=kelas"; }, 1000);</script>';
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
                <h3 class="card-title">Tambahkan data kelas ❤️❤️❤️</h3>
            </div>
            <div class="card-body p-2">
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="nm_kelas">Nama Kelas</label>
                        <input type="text" name="nm_kelas" id="nm_kelas" placeholder="Nama Kelas (contoh: X RPL 1, XI RPL 2, XII TKJ)" class="form-control" required autofocus>
                    </div>
                    <div class="card-footer">
                        <input type="submit" class="btn btn-primary" name="tambah" value="Simpan">
                        <a href="index.php?page=kelas" class="btn btn-default">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>