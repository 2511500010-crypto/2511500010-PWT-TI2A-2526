<?php
if (!isset($_SESSION['Role']) || $_SESSION['Role'] != 'admin') {
    header("location:../login.php");
    exit;
}

$id_jadwal = $_GET['id'];

// Ambil data jadwal
$j = mysqli_fetch_array(mysqli_query($koneksi, "SELECT j.*, k.nm_kelas 
    FROM jadwal_kelas j 
    JOIN kelas k ON j.Id_kelas = k.kd_kelas 
    WHERE j.Id_jadwal='$id_jadwal'"));

// Ambil detail jadwal
$d = mysqli_query($koneksi, "SELECT d.*, m.nm_mapel, g.Nm_guru 
    FROM detail_jadwal d 
    JOIN mapel m ON d.Kd_mapel=m.kd_mapel 
    JOIN guru g ON d.Kd_guru=g.Kd_guru 
    WHERE d.Id_jadwal='$id_jadwal' 
    ORDER BY FIELD(d.Hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'), d.Jam_mulai");
?>

<!DOCTYPE html>
<html>
<head>
    <title>CETAK JADWAL - <?= $j['nm_kelas'] ?></title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .judul { text-align: center; margin: 20px 0; }
        .info { margin: 20px 0; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; }
        th { background: #f0f0f0; }
        .footer { margin-top: 50px; text-align: right; }
        .btn-print { position: fixed; bottom: 20px; right: 20px; padding: 10px 20px; background: green; color: white; border: none; cursor: pointer; }
        @media print { .btn-print { display: none; } }
    </style>
</head>
<body>
    <div class="header">
        <h2>SEKOLAH MENENGAH KEJURUAN</h2>
        <h3>SMK BINA NUSANTARA</h3>
        <p>Jl. Pendidikan No. 123, Telp. (021) 1234567</p>
    </div>
    
    <div class="judul">
        <h3>JADWAL PELAJARAN</h3>
        <p>Tahun Ajaran <?= $j['Thn_ajaran'] ?> - Semester <?= ucfirst($j['Semester']) ?></p>
    </div>
    
    <div class="info">
        <strong>Kelas:</strong> <?= $j['nm_kelas'] ?> &nbsp;&nbsp;
        <strong>Tanggal Cetak:</strong> <?= date('d/m/Y H:i:s') ?>
    </div>
    
    <table>
        <thead>
            <tr><th>NO</th><th>HARI</th><th>JAM</th><th>KODE MAPEL</th><th>MATA PELAJARAN</th><th>GURU</th></tr>
        </thead>
        <tbody>
            <?php $no=1; while($row=mysqli_fetch_array($d)) { ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['Hari'] ?></td>
                <td><?= date('H:i',strtotime($row['Jam_mulai'])) ?> - <?= date('H:i',strtotime($row['Jam_selesai'])) ?></td>
                <td><?= $row['Kd_mapel'] ?></td>
                <td><?= $row['nm_mapel'] ?></td>
                <td><?= $row['Nm_guru'] ?></td>
            </tr>
            <?php } ?>
            <?php if($no==1) { ?>
            <tr><td colspan="6" style="text-align:center">Belum ada data jadwal pelajaran</td></tr>
            <?php } ?>
        </tbody>
    </table>
    
    <div class="footer">
        <p>Mengetahui,<br>Kepala Sekolah</p>
        <p><br><br>(________________________)</p>
    </div>
    
    <button class="btn-print" onclick="window.print()">🖨️ Cetak / Print</button>
</body>
</html>