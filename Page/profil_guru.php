<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Profil Guru</h1>
            </div>
        </div>
    </div>
</div>

<?php
$username = $_SESSION['Username']; // ini adalah Kd_guru

$query = mysqli_query($koneksi, "SELECT * FROM guru WHERE Kd_guru = '$username'");
$data = mysqli_fetch_assoc($query);

if(!$data) {
    echo '<div class="alert alert-danger">Data profil tidak ditemukan</div>';
    exit;
}
?>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title">Informasi Profil Guru</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th width="40%">Kode Guru</th>
                                <td><?= $data['Kd_guru'] ?></td>
                            </tr>
                            <tr>
                                <th>Nama Lengkap</th>
                                <td><?= $data['Nm_guru'] ?></td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td><?= $data['Jenkel'] ?></td>
                            </tr>
                            <tr>
                                <th>Pendidikan Terakhir</th>
                                <td><?= $data['Pend_terakhir'] ?></td>
                            </tr>
                            <tr>
                                <th>Nomor HP</th>
                                <td><?= $data['Hp'] ?: '-' ?></td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td><?= $data['Alamat'] ?: '-' ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
</section>