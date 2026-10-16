<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['id_pembina'])) {
    header("Location: ../login.php");
    exit;
}

$id = $_GET['id'];

$query = mysqli_query($conn, "
    SELECT 
        tbsiswa.nama,
        tbsiswa.kelas,
        tbsiswa.jurusan,
        tbsiswa.nis,
        tbsiswa.notelp,
        tbdaftar.alasan,
        tbdaftar.tanggal_daftar,
        tbdaftar.status,
        tbekskul.nama_ekskul
    FROM tbdaftar
    JOIN tbsiswa ON tbdaftar.id_siswa = tbsiswa.id_siswa
    JOIN tbekskul ON tbdaftar.id_ekskul = tbekskul.id_ekskul
    WHERE tbdaftar.id_daftar = '$id'
");

$data = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Detail Pendaftar</title>
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
            width:170px;
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
    <h2>Detail Pendaftar</h2>

    <div class="detail-item"><span>Nama</span>: <?= $data['nama'] ?></div>
    <div class="detail-item"><span>Kelas</span>: <?= $data['kelas'] ?></div>
    <div class="detail-item"><span>Jurusan</span>: <?= $data['jurusan'] ?></div>
    <div class="detail-item"><span>NIS</span>: <?= $data['nis'] ?></div>
    <div class="detail-item"><span>Nomor Telepon</span>: <?= $data['notelp'] ?></div>
    <div class="detail-item"><span>Ekstrakurikuler</span>: <?= $data['nama_ekskul'] ?></div>
    <div class="detail-item"><span>Alasan</span>: <?= $data['alasan'] ?></div>
    <div class="detail-item"><span>Tanggal Daftar</span>: <?= $data['tanggal_daftar'] ?></div>
    <div class="detail-item"><span>Status</span>: <?= $data['status'] ?></div>

    <a href="pembina3.php" class="btn-back">BACK</a>
</div>

</body>
</html>
