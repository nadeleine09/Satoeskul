<?php
session_start();
require_once __DIR__ . '/../koneksi.php';

if (!isset($_SESSION['id_pembina'])) {
    header("Location: ../login_pembina.php");
    exit;
}

$id = $_GET['id'] ?? '';

$query = mysqli_query($conn, "
    SELECT 
        tbekskul.nama_ekskul,
        tbekskul.deskripsi,
        tbekskul.jadwal,
        tbekskul.lokasi,
        tbekskul.foto,
        tbpembina.nama_pembina,
        tbpembina.telepon
    FROM tbekskul
    JOIN tbpembina
        ON tbekskul.id_pembina = tbpembina.id_pembina
    WHERE tbekskul.id_ekskul = '$id'
");

if (!$query) {
    die("Query gagal: " . mysqli_error($conn));
}

$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Data ekstrakurikuler tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Ekstrakurikuler</title>
    <style>
        body {
            background: #d9d4d4;
            font-family: 'Raleway', sans-serif;
        }

        .detail-container {
            background: #fff;
            width: 65%;
            margin: 50px auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }

        h2 {
            margin-bottom: 25px;
        }

        .detail-item {
            display: flex;
            margin-bottom: 14px;
            font-size: 15px;
        }

        .detail-item .label {
            font-weight: bold;
            width: 170px;
            flex-shrink: 0;
        }

        .detail-item .value {
            flex: 1;
        }

        .foto {
            margin-top: 20px;
        }

        .foto img {
            width: 200px;
            border-radius: 10px;
        }

        .btn-back {
            display: inline-block;
            margin-top: 25px;
            background: #0f3da1;
            color: white;
            padding: 10px 25px;
            border-radius: 8px;
            text-decoration: none;
        }

        .btn-back:hover {
            background: #0c2f7a;
        }
    </style>
</head>
<body>

<div class="detail-container">
    <h2>Detail Ekstrakurikuler</h2>

    <div class="detail-item">
        <div class="label">Nama Ekskul</div>
        <div class="value">: <?= $data['nama_ekskul']; ?></div>
    </div>

    <div class="detail-item">
        <div class="label">Deskripsi</div>
        <div class="value">: <?= $data['deskripsi']; ?></div>
    </div>

    <div class="detail-item">
        <div class="label">Jadwal</div>
        <div class="value">: <?= $data['jadwal']; ?></div>
    </div>

    <div class="detail-item">
        <div class="label">Lokasi</div>
        <div class="value">: <?= $data['lokasi']; ?></div>
    </div>

    <div class="detail-item">
        <div class="label">Pembina</div>
        <div class="value">: <?= $data['nama_pembina']; ?></div>
    </div>

    <div class="detail-item">
        <div class="label">Kontak</div>
        <div class="value">: <?= $data['telepon']; ?></div>
    </div>

    <div class="foto">
        <?php if (!empty($data['foto'])): ?>
            <img src="../uploads/<?= $data['foto']; ?>" alt="Foto Ekskul">
        <?php else: ?>
            <p>Tidak ada foto</p>
        <?php endif; ?>
    </div>

    <a href="pembina4.php" class="btn-back">BACK</a>
</div>

</body>
</html>
