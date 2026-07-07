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
// Ambil data untuk dropdown
$query_kelas = mysqli_query($koneksi, "SELECT * FROM kelas ORDER BY nm_kelas ASC");
$query_guru = mysqli_query($koneksi, "SELECT * FROM guru ORDER BY Nm_guru ASC");
$query_mapel = mysqli_query($koneksi, "SELECT * FROM mapel ORDER BY nm_mapel ASC");

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
        // Insert ke tabel Jadwal_kelas
        $insert = mysqli_query($koneksi, "INSERT INTO Jadwal_kelas (Id_kelas, Thn_ajaran, Semester) 
                                          VALUES ('$id_kelas', '$thn_ajaran', '$semester')");
        
        if ($insert){
            // Ambil ID jadwal yang baru saja dibuat
            $id_jadwal_baru = mysqli_insert_id($koneksi);
            
            // Insert detail jadwal jika ada
            if(isset($_POST['kd_mapel']) && count($_POST['kd_mapel']) > 0) {
                $all_success = true;
                for($i = 0; $i < count($_POST['kd_mapel']); $i++) {
                    $kd_mapel = mysqli_real_escape_string($koneksi, $_POST['kd_mapel'][$i]);
                    $kd_guru = mysqli_real_escape_string($koneksi, $_POST['kd_guru'][$i]);
                    $hari = mysqli_real_escape_string($koneksi, $_POST['hari'][$i]);
                    $jam_mulai = mysqli_real_escape_string($koneksi, $_POST['jam_mulai'][$i]);
                    $jam_selesai = mysqli_real_escape_string($koneksi, $_POST['jam_selesai'][$i]);
                    
                    $insert_detail = mysqli_query($koneksi, "INSERT INTO detail_jadwal (Id_jadwal, Kd_mapel, Kd_guru, Hari, Jam_mulai, Jam_selesai) 
                                                              VALUES ('$id_jadwal_baru', '$kd_mapel', '$kd_guru', '$hari', '$jam_mulai', '$jam_selesai')");
                    if(!$insert_detail) {
                        $all_success = false;
                    }
                }
                
                if($all_success) {
                    echo '<div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-check"></i> Sukses!</h5>
                        Data Jadwal Berhasil Disimpan
                    </div>';
                    echo '<script>setTimeout(function(){ window.location="index.php?page=jadwal"; }, 1500);</script>';
                } else {
                    echo '<div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Peringatan!</h5>
                        Jadwal utama berhasil disimpan, tetapi sebagian detail gagal disimpan.
                    </div>';
                }
            } else {
                echo '<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Sukses!</h5>
                    Data Jadwal Berhasil Disimpan (belum ada detail)
                </div>';
                echo '<script>setTimeout(function(){ window.location="index.php?page=jadwal"; }, 1500);</script>';
            }
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
            <div class="card-header bg-primary text-white">
                <h3 class="card-title">
                    <i class="fas fa-calendar-plus"></i> Form Tambah Jadwal Kelas
                </h3>
            </div>
            <div class="card-body">
                <form method="POST" action="" id="formJadwal">
                    <!-- Informasi Jadwal Utama -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="id_kelas">Kelas <span class="text-danger">*</span></label>
                                <select name="id_kelas" id="id_kelas" class="form-control" required>
                                    <option value="">-- Pilih Kelas --</option>
                                    <?php while($kelas = mysqli_fetch_array($query_kelas)) { ?>
                                        <option value="<?= $kelas['kd_kelas']; ?>"><?= htmlspecialchars($kelas['nm_kelas']); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="thn_ajaran">Tahun Ajaran <span class="text-danger">*</span></label>
                                <select name="thn_ajaran" id="thn_ajaran" class="form-control" required>
                                    <option value="">-- Pilih Tahun Ajaran --</option>
                                    <option value="2023/2024">2023/2024</option>
                                    <option value="2024/2025">2024/2025</option>
                                    <option value="2025/2026">2025/2026</option>
                                    <option value="2026/2027">2026/2027</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="semester">Semester <span class="text-danger">*</span></label>
                                <select name="semester" id="semester" class="form-control" required>
                                    <option value="">-- Pilih Semester --</option>
                                    <option value="ganjil">Ganjil</option>
                                    <option value="genap">Genap</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Detail Jadwal -->
                    <h5><i class="fas fa-list"></i> Detail Jadwal Pelajaran</h5>
                    <p class="text-muted small">Isi detail mata pelajaran yang akan dijadwalkan</p>

                    <div id="detail-jadwal-container">
                        <div class="detail-jadwal-row row mb-3">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Hari</label>
                                    <select name="hari[]" class="form-control" required>
                                        <option value="">-- Hari --</option>
                                        <option value="Senin">Senin</option>
                                        <option value="Selasa">Selasa</option>
                                        <option value="Rabu">Rabu</option>
                                        <option value="Kamis">Kamis</option>
                                        <option value="Jumat">Jumat</option>
                                        <option value="Sabtu">Sabtu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Jam Mulai</label>
                                    <input type="time" name="jam_mulai[]" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Jam Selesai</label>
                                    <input type="time" name="jam_selesai[]" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Mata Pelajaran</label>
                                    <select name="kd_mapel[]" class="form-control" required>
                                        <option value="">-- Pilih Mapel --</option>
                                        <?php 
                                        mysqli_data_seek($query_mapel, 0);
                                        while($mapel = mysqli_fetch_array($query_mapel)) { 
                                        ?>
                                            <option value="<?= $mapel['kd_mapel']; ?>"><?= htmlspecialchars($mapel['nm_mapel']); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Guru Pengajar</label>
                                    <select name="kd_guru[]" class="form-control" required>
                                        <option value="">-- Pilih Guru --</option>
                                        <?php 
                                        mysqli_data_seek($query_guru, 0);
                                        while($guru = mysqli_fetch_array($query_guru)) { 
                                        ?>
                                            <option value="<?= $guru['Kd_guru']; ?>"><?= htmlspecialchars($guru['Nm_guru']); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-danger btn-sm remove-row" style="margin-bottom: 15px;" title="Hapus Baris">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="tambah-detail" class="btn btn-info btn-sm mb-3">
                        <i class="fas fa-plus"></i> Tambah Detail Jadwal
                    </button>

                    <div class="card-footer text-right">
                        <button type="submit" name="tambah" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Jadwal
                        </button>
                        <a href="index.php?page=jadwal" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
// Fungsi untuk menambah baris detail jadwal
document.getElementById('tambah-detail').addEventListener('click', function() {
    const container = document.getElementById('detail-jadwal-container');
    const originalRow = container.querySelector('.detail-jadwal-row');
    const newRow = originalRow.cloneNode(true);
    
    // Reset semua nilai input/select di baris baru
    newRow.querySelectorAll('select').forEach(select => select.value = '');
    newRow.querySelectorAll('input').forEach(input => input.value = '');
    
    container.appendChild(newRow);
});

// Fungsi untuk menghapus baris detail jadwal
document.addEventListener('click', function(e) {
    if(e.target && e.target.closest('.remove-row')) {
        const rows = document.querySelectorAll('.detail-jadwal-row');
        if(rows.length > 1) {
            e.target.closest('.detail-jadwal-row').remove();
        } else {
            alert('Minimal harus ada 1 detail jadwal!');
        }
    }
});
</script>

<style>
.detail-jadwal-row {
    background-color: #f9f9f9;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 15px;
}
.detail-jadwal-row:hover {
    background-color: #f0f0f0;
}
</style>