<?php
session_start();
require_once __DIR__ . '/../koneksi.php';


if (!isset($_SESSION['id_pembina'])) {
    header("Location: ../login_pembina.php");
    exit;
}

$id_pembina = $_SESSION['id_pembina'];

$query = "SELECT 
    tbekskul.id_ekskul,
    tbekskul.nama_ekskul,
    tbekskul.deskripsi,
    tbekskul.jadwal,
    tbekskul.lokasi,
    tbpembina.nama_pembina,
    tbpembina.telepon,
    tbekskul.foto
FROM tbekskul
JOIN tbpembina ON tbekskul.id_pembina = tbpembina.id_pembina
WHERE tbekskul.id_pembina = '$id_pembina'
ORDER BY tbekskul.nama_ekskul ASC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Informasi Ekstrakurikuler</title>

<style>
/* ===== RESET ===== */
* {
    box-sizing: border-box;
}

body {
    margin: 0;
    background: #d9d4d4;
    font-family: 'Raleway', sans-serif;
}

/* ===== NAVBAR ===== */
nav {
    background: #105298;
    height: 70px;
    padding: 0 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo {
    width: 65px;
    border-radius: 50%;
}

nav a {
    color: white;
    text-decoration: none;
    font-size: 13px;
    font-weight: bold;
}


/* ===== TITLE ===== */
.dashboard-title {
    padding: 25px;
    font-size: 24px;
    font-weight: bold;
}

/* ===== TABLE BOX ===== */
.table-container {
    width: 95%;
    margin: auto;
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,.15);
    overflow-x: auto;
}

/* ===== TABLE ===== */
.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table thead {
    background: #0f3da1;
    color: white;
}

.data-table th,
.data-table td {
    padding: 14px;
    text-align: center;
    border-bottom: 1px solid #ddd;
    vertical-align: middle;
}

/* ===== OPSI BUTTON FIX ===== */
.opsi-btn {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
}

.btn {
    padding: 6px 14px;
    border-radius: 6px;
    color: white;
    font-size: 13px;
    font-weight: bold;
    text-decoration: none;
}

/* warna tombol */
.btn.detail { background: #2e7d32; }
.btn.detail:hover { background: #1b5e20; }

.btn.edit { background: #0f3da1; }
.btn.edit:hover { background: #0b2d73; }

.btn.hapus { background: #b30000; }
.btn.hapus:hover { background: #800000; }

/* ===== BACK BUTTON ===== */
.back-btn {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #0f3da1;
    color: white;
    border: none;
    padding: 12px 28px;
    border-radius: 8px;
    cursor: pointer;
}
</style>
</head>

<body>

<nav>
    <img src="../Rules!.png" class="logo">
    <a href="../logout.php">LOG OUT</a>
</nav>



<div class="dashboard-title">INFORMASI EKSTRAKURIKULER</div>

<div class="table-container">
<table class="data-table">
    <thead>
        <tr>
            <th>EKSKUL</th>
            <th>DESKRIPSI</th>
            <th>JADWAL</th>
            <th>LOKASI</th>
            <th>PEMBINA</th>
            <th>KONTAK</th>
            <th>FOTO</th>
            <th>OPSI</th>
        </tr>
    </thead>
    <tbody>
    <?php if(mysqli_num_rows($result) > 0): ?>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= htmlspecialchars($row['nama_ekskul']); ?></td>
            <td><?= htmlspecialchars($row['deskripsi']); ?></td>
            <td><?= htmlspecialchars($row['jadwal']); ?></td>
            <td><?= htmlspecialchars($row['lokasi']); ?></td>
            <td><?= htmlspecialchars($row['nama_pembina']); ?></td>
            <td><?= htmlspecialchars($row['telepon']); ?></td>
            <td>
                <?php if($row['foto']): ?>
                    <img src="../uploads/<?= $row['foto']; ?>" width="55">
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>

            <!-- OPSI FIX -->
            <td>
                <div class="opsi-btn">
                    <a href="detailekskul_pembina.php?id=<?= $row['id_ekskul']; ?>" class="btn detail">DETAIL</a>
                    <a href="edit_ekskul.php?id=<?= $row['id_ekskul']; ?>" class="btn edit">EDIT</a>
                    <a href="hapus_pembina.php?id=<?= $row['id_ekskul']; ?>" 
                       class="btn hapus"
                       onclick="return confirm('Yakin hapus?')">
                       HAPUS
                    </a>
                </div>
            </td>
        </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="8">Belum ada data</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>
</div>

<button class="back-btn" onclick="location.href='pembina1.php'">BACK</button>

</body>
</html>
