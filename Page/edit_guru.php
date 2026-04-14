<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Guru</h1>
            </div>
        </div>
    </div>
</div>

<?php
$kd_guru = $_GET['kd'];
$query = mysqli_query($koneksi, "SELECT * FROM guru WHERE Kd_guru = '$kd_guru'");
$data = mysqli_fetch_array($query);

if(!$data) {
    echo '<div class="alert alert-danger">Data tidak ditemukan</div>';
    echo '<script>setTimeout(function(){ window.location="index.php?page=guru"; }, 1000);</script>';
    exit;
}

// Proses update data guru
if(isset($_POST['edit'])){
    $nm_guru = mysqli_real_escape_string($koneksi, $_POST['nm_guru']);
    $jenkel = mysqli_real_escape_string($koneksi, $_POST['jenkel']);
    $pend_terakhir = mysqli_real_escape_string($koneksi, $_POST['pend_terakhir']);
    $hp = mysqli_real_escape_string($koneksi, $_POST['hp']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    
    $update = mysqli_query($koneksi, "UPDATE guru SET 
                                        Nm_guru = '$nm_guru',
                                        Jenkel = '$jenkel',
                                        Pend_terakhir = '$pend_terakhir',
                                        Hp = '$hp',
                                        Alamat = '$alamat'
                                      WHERE Kd_guru = '$kd_guru'");
    
    if ($update){
        echo '<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> Sukses!</h5>
            Data Berhasil Diupdate
        </div>';
        echo '<script>setTimeout(function(){ window.location="index.php?page=guru"; }, 1000);</script>';
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
                <h3 class="card-title">Edit data guru ✏️</h3>
            </div>
            <div class="card-body p-2">
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="kd_guru">Kode Guru</label>
                        <input type="text" name="kd_guru" value="<?= $data['Kd_guru']; ?>" class="form-control" readonly>
                        <small class="text-muted">Kode guru tidak dapat diubah</small>
                    </div>
                    <div class="form-group">
                        <label for="nm_guru">Nama Guru</label>
                        <input type="text" name="nm_guru" id="nm_guru" value="<?= $data['Nm_guru']; ?>" class="form-control" required autofocus>
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
                        <label for="pend_terakhir">Pendidikan Terakhir</label>
                        <select name="pend_terakhir" id="pend_terakhir" class="form-control" required>
                            <option value="">-- Pilih Pendidikan Terakhir --</option>
                            <option value="SMA/Sederajat" <?= ($data['Pend_terakhir'] == 'SMA/Sederajat') ? 'selected' : ''; ?>>SMA/Sederajat</option>
                            <option value="D3" <?= ($data['Pend_terakhir'] == 'D3') ? 'selected' : ''; ?>>D3</option>
                            <option value="S1" <?= ($data['Pend_terakhir'] == 'S1') ? 'selected' : ''; ?>>S1</option>
                            <option value="S2" <?= ($data['Pend_terakhir'] == 'S2') ? 'selected' : ''; ?>>S2</option>
                            <option value="S3" <?= ($data['Pend_terakhir'] == 'S3') ? 'selected' : ''; ?>>S3</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="hp">Nomor HP</label>
                        <input type="text" name="hp" id="hp" value="<?= $data['Hp']; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea name="alamat" id="alamat" rows="3" class="form-control"><?= $data['Alamat']; ?></textarea>
                    </div>
                    <div class="card-footer">
                        <input type="submit" class="btn btn-primary" name="edit" value="Update">
                        <a href="index.php?page=guru" class="btn btn-default">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>