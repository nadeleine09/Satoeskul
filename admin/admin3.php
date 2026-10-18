<?php
require_once __DIR__ . '/../koneksi.php';

// SEARCH
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

// QUERY EKSKUL
$query = mysqli_query($conn, "
    SELECT tbekskul.*, tbpembina.nama_pembina
    FROM tbekskul
    LEFT JOIN tbpembina ON tbekskul.id_pembina = tbpembina.id_pembina
    WHERE
        tbekskul.nama_ekskul LIKE '%$keyword%' OR
        tbpembina.nama_pembina LIKE '%$keyword%' OR
        tbekskul.jadwal LIKE '%$keyword%' OR
        tbekskul.lokasi LIKE '%$keyword%'
    ORDER BY tbekskul.nama_ekskul ASC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Ekstrakurikuler</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

<style>
html, body {
    margin: 0;
    padding: 0;
    background: #d9d4d4;
    font-family: 'Raleway', sans-serif;
}

/* NAVBAR */
nav {
    height: 70px;
    background: #105298;
    padding: 0 40px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.logo { width: 70px; border-radius: 50%; }
nav a { color: white; text-decoration: none; font-size: 13px; }

/* TITLE */
.dashboard-title {
    padding: 25px;
    font-size: 24px;
    font-weight: bold;
}

/* SEARCH */
.search-wrapper {
    width: 95%;
    margin: 0 auto 15px auto;
}
.search-wrapper form {
    display: flex;
    align-items: center;
    gap: 6px;
    position: relative;
}
.search-wrapper input {
    padding: 10px 35px 10px 10px;
    width: 300px;
    border-radius: 6px;
    border: 1px solid #ccc;
}
.clear-btn {
    position: absolute;
    left: 265px;
    font-size: 16px;
    color: #777;
    text-decoration: none;
}
.search-wrapper button {
    padding: 10px 20px;
    border: none;
    border-radius: 6px;
    background: #0f3da1;
    color: white;
    cursor: pointer;
}

/* TABLE CONTAINER */
.table-container {
    background: #fff;
    padding: 0 0 60px 0;
    border-radius: 10px;
    width: 95%;
    margin: 0 auto;
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    position: relative;
}

table {
    width: 100%;
    border-collapse: collapse;
}
thead {
    background: #0f3da1;
    color: white;
}
th, td {
    padding: 14px;
    border-bottom: 1px solid #dcdcdc;
    text-align: center;
}

/* BUTTON OPSI */
.opsi .btn {
    padding: 6px 14px;
    font-size: 13px;
    border-radius: 6px;
    text-decoration: none;
    color: white;
    font-weight: bold;
    margin: 0 4px;
}
.detail { background: #0c811f; }
.edit   { background: #0f3da1; }
.hapus  { background: #b30000; }

/* ADD BUTTON */
.add-btn {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: #000;
    color: #fff;
    border: none;
    font-size: 25px;
    position: absolute;
    right: 20px;
    bottom: 10px;
    cursor: pointer;
}

/* BACK AREA (DI LUAR PUTIH) */
.back-wrapper {
    width: 95%;
    margin: 20px auto 40px auto;
    display: flex;
    justify-content: flex-end;
}
.back-btn {
    background: #0f3da1;
    color: white;
    border: none;
    padding: 10px 25px;
    border-radius: 8px;
    cursor: pointer;
    font-family: 'Raleway', sans-serif;
}
</style>
</head>

<body>

<nav>
    <img class="logo" src="../Rules!.png">
    <a href="../logout.php">LOG OUT</a>
</nav>

<div class="dashboard-title">DATA EKSTRAKURIKULER</div>

<!-- SEARCH -->
<div class="search-wrapper">
    <form method="GET">
        <input type="text" name="keyword"
               placeholder="Cari ekskul / pembina / jadwal / lokasi"
               value="<?= htmlspecialchars($keyword) ?>">
        <?php if (!empty($keyword)) { ?>
            <a href="admin3.php" class="clear-btn">✖</a>
        <?php } ?>
        <button type="submit">Cari</button>
    </form>
</div>

<!-- TABLE -->
<div class="table-container">
<table>
<thead>
<tr>
    <th>NAMA EKSKUL</th>
    <th>PEMBINA</th>
    <th>JADWAL</th>
    <th>LOKASI</th>
    <th>JUMLAH ANGGOTA</th>
    <th>OPSI</th>
</tr>
</thead>
<tbody>

<?php
if (mysqli_num_rows($query) > 0) {
while ($row = mysqli_fetch_assoc($query)) {

    $idEks = $row['id_ekskul'];
    $qJumlah = mysqli_query($conn, "
        SELECT COUNT(*) AS total
        FROM tbdaftar
        WHERE id_ekskul='$idEks' AND status='diterima'
    ");
    $hitung = mysqli_fetch_assoc($qJumlah);
?>
<tr>
    <td><?= $row['nama_ekskul'] ?></td>
    <td><?= $row['nama_pembina'] ?: 'Belum Ada Pembina' ?></td>
    <td><?= $row['jadwal'] ?></td>
    <td><?= $row['lokasi'] ?></td>
    <td><?= $hitung['total'] ?></td>
    <td class="opsi">
        <a class="btn detail" href="lihatdetail_admin3.php?id=<?= $row['id_ekskul'] ?>">DETAIL</a>
        <a class="btn edit" href="editekskul_admin3.php?id=<?= $row['id_ekskul'] ?>">EDIT</a>
        <a class="btn hapus" href="hapusekskul_admin3.php?id=<?= $row['id_ekskul'] ?>"
           onclick="return confirm('Hapus data ini?')">HAPUS</a>
    </td>
</tr>
<?php } } else { ?>
<tr>
    <td colspan="6">Data tidak ditemukan</td>
</tr>
<?php } ?>

</tbody>
</table>

<button class="add-btn" onclick="location.href='tambahekskul_admin3.php'">+</button>
</div>

<!-- BACK (TETAP POJOK KANAN & DI BAWAH PUTIH) -->
<div class="back-wrapper">
    <a href="admin1.php">
        <button class="back-btn">BACK</button>
    </a>
</div>

</body>
</html>
