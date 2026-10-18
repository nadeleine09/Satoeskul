<?php
session_start();
require_once __DIR__ . '/../koneksi.php';


if (!isset($_GET['id'])) {
    die("Ekskul tidak ditemukan.");
}

$id = $_GET['id'];
$id = mysqli_real_escape_string($conn, $id);

// Ambil data ekskul
$q = mysqli_query($conn, "
    SELECT tbekskul.*, tbpembina.nama_pembina AS pembina, tbpembina.telepon
    FROM tbekskul
    LEFT JOIN tbpembina ON tbekskul.id_pembina = tbpembina.id_pembina
    WHERE tbekskul.id_ekskul = '$id'
");

if (mysqli_num_rows($q) == 0) {
    die("Ekskul tidak ditemukan.");
}

$data = mysqli_fetch_assoc($q);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title><?= $data['nama_ekskul']; ?></title>

<style>
body {
    font-family: Arial, sans-serif;
    background: #eee;
    margin: 0;
}
.header {
    background: #0a338bff;
    padding: 20px;
    color: white;
    text-align: center;
}
.container {
    width: 90%;
    max-width: 900px;
    background: white;
    padding: 20px;
    margin: 20px auto;
    border-radius: 10px;
}
.back {
    display: inline-block;
    padding: 10px 20px;
    background: #0f3da1;
    color: white;
    border-radius: 8px;
    text-decoration: none;
}
.back:hover {
    background: #062a6d;
}
.img-head {
    width: 100%;
    border-radius: 10px;
}
</style>

</head>
<body>

<div class="header">
    <h1><?= $data['nama_ekskul']; ?></h1>
</div>

<div class="container">

    <img src="../uploads/<?= $data['foto']; ?>" class="img-head">

    <h3>Deskripsi</h3>
    <p><?= $data['deskripsi']; ?></p>

    <h3>Jadwal</h3>
    <p><?= $data['jadwal']; ?></p>

    <h3>Lokasi</h3>
    <p><?= $data['lokasi']; ?></p>

    <h3>Pembina</h3>
    <p>
        Nama : <?= $data['pembina']; ?><br>
        Kontak : <?= $data['telepon']; ?>
    </p>

    <br>
    <a href="home1.php" class="back">BACK</a>

</div>

</body>
</html>
