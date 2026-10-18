<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/../koneksi.php';


if (!isset($_GET['id'])) {
    die("ID ekskul tidak ditemukan");
}

$id = $_GET['id'];

$query = mysqli_query($conn, "
    SELECT tbekskul.*, tbpembina.nama_pembina
    FROM tbekskul
    LEFT JOIN tbpembina 
        ON tbekskul.id_pembina = tbpembina.id_pembina
    WHERE tbekskul.id_ekskul = '$id'
");

if (!$query) {
    die(mysqli_error($conn));
}

$data = mysqli_fetch_assoc($query);
if (!$data) {
    die("Data tidak ditemukan");
}

$idEks = $data['id_ekskul'];

$qJumlah = mysqli_query($conn, "
    SELECT COUNT(*) AS total
    FROM tbdaftar
    WHERE id_ekskul = '$idEks'
    AND status = 'diterima'
");

$jumlah = mysqli_fetch_assoc($qJumlah);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Detail Ekskul</title>

<!-- ================= CSS ================= -->
<style>
body {
    margin: 0;
    padding: 0;
    background: #d9d4d4;
    font-family: 'Raleway', sans-serif;
}

.detail-container {
    width: 60%;
    background: #fff;
    margin: 60px auto;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
}

.detail-container h2 {
    text-align: center;
    margin-bottom: 25px;
    text-transform: uppercase;
    color: #0f3da1;
}

.detail-item {
    display: flex;
    margin-bottom: 15px;
    font-size: 15px;
}

.detail-item span {
    width: 180px;
    font-weight: bold;
    color: #333;
}

.btn-back {
    display: inline-block;
    margin-top: 25px;
    background: #0f3da1;
    color: white;
    padding: 10px 25px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 14px;
}

.btn-back:hover {
    background: #0b2d73;
}
</style>
</head>

<body>

<div class="detail-container">
    <h2>Detail Ekstrakurikuler</h2>

    <div class="detail-item">
        <span>Nama Ekskul</span> : <?= $data['nama_ekskul'] ?>
    </div>

    <div class="detail-item">
        <span>Pembina</span> : <?= $data['nama_pembina'] ?: 'Belum Ada' ?>
    </div>

    <div class="detail-item">
        <span>Jadwal</span> : <?= $data['jadwal'] ?>
    </div>

    <div class="detail-item">
        <span>Lokasi</span> : <?= $data['lokasi'] ?>
    </div>

    <div class="detail-item">
    <span>Jumlah Anggota</span> : <?= $jumlah['total'] ?> Orang
</div>


    <a href="admin3.php" class="btn-back">BACK</a>
</div>

</body>
</html>
