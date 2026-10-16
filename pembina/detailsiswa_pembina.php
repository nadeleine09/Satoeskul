<?php
include '../koneksi.php';
session_start();

if (!isset($_SESSION['id_pembina'])) {
    header("Location: ../login.php");
    exit;
}

$id = $_GET['id'];

$query = mysqli_query($conn, "
    SELECT 
        tbsiswa.*,
        tbekskul.nama_ekskul
    FROM tbsiswa
    LEFT JOIN tbdaftar ON tbsiswa.id_siswa = tbdaftar.id_siswa
    LEFT JOIN tbekskul ON tbdaftar.id_ekskul = tbekskul.id_ekskul
    WHERE tbsiswa.id_siswa = '$id'
");

$data = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Detail Siswa</title>
    <style>
        body {
            background:#d9d4d4;
            font-family:'Raleway', sans-serif;
        }
        .detail-container {
            background:#fff;
            width:60%;
            margin:50px auto;
            padding:30px;
            border-radius:12px;
            box-shadow:0 4px 10px rgba(0,0,0,0.15);
        }
        .detail-item {
            margin-bottom:12px;
            font-size:15px;
        }
        .detail-item span {
            font-weight:bold;
            width:160px;
            display:inline-block;
        }
        .btn-back {
            display:inline-block;
            margin-top:20px;
            background:#0f3da1;
            color:white;
            padding:10px 25px;
            border-radius:8px;
            text-decoration:none;
        }
    </style>
</head>
<body>

<div class="detail-container">
    <h2>Detail Siswa</h2>

    <div class="detail-item">
        <span>Nama</span>: <?= $data['nama'] ?>
    </div>
    <div class="detail-item">
        <span>Kelas</span>: <?= $data['kelas'] ?>
    </div>
    <div class="detail-item">
        <span>Jurusan</span>: <?= $data['jurusan'] ?>
    </div>
    <div class="detail-item">
        <span>NIS</span>: <?= $data['nis'] ?>
    </div>
    <div class="detail-item">
        <span>Nomor Telepon</span>: <?= $data['notelp'] ?>
    </div>
    <div class="detail-item">
        <span>Ekstrakurikuler</span>: <?= $data['nama_ekskul'] ?: 'Belum Terdaftar' ?>
    </div>

    <a href="data_siswa.php" class="btn-back">BACK</a>
</div>

</body>
</html>
