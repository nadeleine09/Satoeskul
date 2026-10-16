<?php
include '../koneksi.php';

$id = $_GET['id'] ?? '';

$query = mysqli_query($conn, "
    SELECT tbpembina.*, tbekskul.nama_ekskul
    FROM tbpembina
    LEFT JOIN tbekskul ON tbpembina.id_pembina = tbekskul.id_pembina
    WHERE tbpembina.id_pembina = '$id'
");

$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "Data tidak ditemukan";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Pembina</title>
    <style>
        body {
            background: #d9d4d4;
            font-family: 'Raleway', sans-serif;
        }

        .detail-container {
            background: white;
            width: 400px;
            margin: 100px auto;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        .detail-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .detail-item {
            margin-bottom: 12px;
        }

        .detail-item span {
            font-weight: bold;
            display: inline-block;
            width: 120px;
        }

        .btn-back {
            display: inline-block;
            margin-top: 20px;
            background: #0f3da1;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            text-align: center;
        }
    </style>
</head>

<body>

<div class="detail-container">
    <h2>Detail Pembina</h2>

    <div class="detail-item">
        <span>Nama</span>: <?= $data['nama_pembina'] ?>
    </div>

    <div class="detail-item">
        <span>NIP</span>: <?= $data['nip'] ?>
    </div>

    <div class="detail-item">
        <span>Ekskul</span>: <?= $data['nama_ekskul'] ?: 'Belum punya ekskul' ?>
    </div>

    <div class="detail-item">
        <span>Kontak</span>: <?= $data['telepon'] ?>
    </div>

    <a href="admin4.php" class="btn-back">BACK</a>
</div>

</body>
</html>
