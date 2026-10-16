<?php
include '../koneksi.php';
session_start();

if (!isset($_SESSION['id_admin'])) {
    header("Location: ../login.php");
    exit;
}

$id = $_GET['id'];

$query = mysqli_query($conn, "
    SELECT s.*, e.nama_ekskul, d.status
    FROM tbsiswa s
    LEFT JOIN tbdaftar d ON s.id_siswa = d.id_siswa
    LEFT JOIN tbekskul e ON d.id_ekskul = e.id_ekskul
    WHERE s.id_siswa = '$id'
    ORDER BY d.id_daftar DESC
    LIMIT 1
");

$data = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Detail Siswa</title>
    <link href="https://fonts.googleapis.com/css2?family=Raleway&display=swap" rel="stylesheet">
</head>
<body>

<div class="detail-container">
    <h2>Detail Siswa</h2>

    <div class="detail-item"><span>Nama</span> : <?= $data['nama'] ?></div>
    <div class="detail-item"><span>Kelas</span> : <?= $data['kelas'] ?></div>
    <div class="detail-item"><span>Jurusan</span> : <?= $data['jurusan'] ?></div>
    <div class="detail-item"><span>NIS</span> : <?= $data['nis'] ?></div>
    <div class="detail-item"><span>No Telp</span> : <?= $data['notelp'] ?></div>
    <div class="detail-item"><span>Status Ekskul</span> : <?= $data['status'] ?: 'Belum mendaftar' ?></div>
    <div class="detail-item"><span>Ekskul</span> : <?= $data['nama_ekskul'] ?: '-' ?></div>

    <a href="admin2.php" class="btn-back">BACK</a>
</div>

<style>
body {
    background:#d9d4d4;
    font-family:'Raleway', sans-serif;
}

.detail-container {
    width: 65%;
    margin: 60px auto;
    background: white;
    padding: 35px 45px;
    border-radius: 14px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
}

.detail-container h2 {
    text-align: center;
    color: #0f3da1;
    margin-bottom: 30px;
}

.detail-item {
    margin-bottom: 15px;
    font-size: 15px;
}

.detail-item span {
    display: inline-block;
    width: 180px;
    font-weight: bold;
}

.btn-back {
    display: inline-block;
    margin-top: 35px;
    background: #0f3da1;
    color: white;
    padding: 10px 28px;
    border-radius: 8px;
    text-decoration: none;
}
</style>

</body>
</html>
