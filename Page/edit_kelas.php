<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Kelas</h1>
            </div>
        </div>
    </div>
</div>

<?php
$kd = $_GET['kd'];
$query = mysqli_query($koneksi, "SELECT * FROM kelas WHERE kd_kelas = '$kd'");
$data = mysqli_fetch_array($query);

if(!$data) {
    echo '<div class="alert alert-danger">Data tidak ditemukan</div>';
    echo '<script>setTimeout(function(){ window.location="index.php?page=kelas"; }, 1000);</script>';
    exit;
}

// proses update data kelas
if(isset($_POST['edit'])){
    $nm_kelas = mysqli_real_escape_string($koneksi, $_POST['nm_kelas']);
    
    // Cek apakah nama kelas sudah ada (kecuali untuk data ini sendiri)
    $cek = mysqli_query($koneksi, "SELECT * FROM kelas WHERE nm_kelas = '$nm_kelas' AND kd_kelas != '$kd'");
    if(mysqli_num_rows($cek) > 0) {
        echo '<div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-exclamation-triangle"></i> Peringatan!</h5>
            Nama Kelas sudah ada!
        </div>';
    } else {
        $update = mysqli_query($koneksi, "UPDATE kelas SET nm_kelas = '$nm_kelas' WHERE kd_kelas = '$kd'");
        
        if ($update){
            echo '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-check"></i> Sukses!</h5>
                Data Berhasil Diupdate
            </div>';
            echo '<script>setTimeout(function(){ window.location="index.php?page=kelas"; }, 1000);</script>';
        } else {
            echo '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-ban"></i> Gagal!</h5>
                Data Gagal Diupdate: '.mysqli_error($koneksi).'
            </div>';
        }
    }
}
?>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit data kelas ✏️</h3>
            </div>
            <div class="card-body p-2">
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="kd_kelas">Kode Kelas</label>
                        <input type="text" name="kd_kelas" value="<?= $data['kd_kelas']; ?>" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nm_kelas">Nama Kelas</label>
                        <input type="text" name="nm_kelas" id="nm_kelas" value="<?= $data['nm_kelas']; ?>" class="form-control" required autofocus>
                    </div>
                    <div class="card-footer">
                        <input type="submit" class="btn btn-primary" name="edit" value="Update">
                        <a href="index.php?page=kelas" class="btn btn-default">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>