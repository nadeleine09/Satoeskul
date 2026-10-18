<?php
require_once __DIR__ . '/../koneksi.php';

session_start();

if (!isset($_SESSION['id_admin'])) {
    header("Location: ../login.php");
    exit;
}

// ===== SEARCH =====
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

// ===== QUERY =====
$sql = "
SELECT 
    s.id_siswa,
    s.nama,
    s.kelas,
    s.jurusan,
    s.nis,
    s.notelp,
    CASE
        WHEN d.status = 'Diterima' THEN e.nama_ekskul
        WHEN d.status = 'Menunggu' THEN 'Sedang mendaftar'
        ELSE 'Belum mendaftar'
    END AS status_ekskul
FROM tbsiswa s
LEFT JOIN (
    SELECT *
    FROM tbdaftar
    WHERE id_daftar IN (
        SELECT MAX(id_daftar)
        FROM tbdaftar
        GROUP BY id_siswa
    )
) d ON s.id_siswa = d.id_siswa
LEFT JOIN tbekskul e ON d.id_ekskul = e.id_ekskul
WHERE
    s.nama LIKE '%$keyword%' OR
    s.nis LIKE '%$keyword%' OR
    s.kelas LIKE '%$keyword%' OR
    s.jurusan LIKE '%$keyword%' OR
    e.nama_ekskul LIKE '%$keyword%'
ORDER BY s.nama ASC
";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Siswa</title>

<style>
body {
    margin: 0;
    background: #d9d4d4;
    font-family: 'Raleway', sans-serif;
}

/* HEADER */
nav {
    background: #105298;
    height: 70px;
    padding: 0 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
nav img {
    width: 70px;
    border-radius: 50%;
}
nav a {
    color: white;
    text-decoration: none;
}

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
    text-decoration: none;
    font-size: 16px;
    color: #777;
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
    width: 95%;
    margin: 0 auto;
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    overflow: hidden;
    padding-bottom: 30px;
}

/* TABLE */
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
    text-align: center;
    border-bottom: 1px solid #ddd;
}

/* OPSI */
.opsi a {
    padding: 6px 12px;
    border-radius: 5px;
    color: white;
    text-decoration: none;
    font-size: 13px;
}
.detail { background: #0c811f; }
.edit { background: #002399; }
.hapus { background: #b30000; }

/* BACK */
.back-wrapper {
    width: 95%;
    margin: 25px auto 40px auto;
    display: flex;
    justify-content: flex-end;
}
.back-btn {
    background: #0f3da1;
    color: white;
    padding: 12px 30px;
    border-radius: 8px;
    text-decoration: none;
}
</style>
</head>

<body>

<nav>
    <img src="../Rules!.png">
    <a href="../logout.php">LOG OUT</a>
</nav>

<div class="dashboard-title">DATA SISWA</div>

<!-- SEARCH + CLEAR -->
<div class="search-wrapper">
    <form method="GET">
        <input type="text" name="keyword"
               placeholder="Cari nama / NIS / kelas / jurusan / ekskul"
               value="<?= htmlspecialchars($keyword) ?>">

        <?php if (!empty($keyword)) { ?>
            <a href="admin2.php" class="clear-btn" title="Hapus pencarian">✖</a>
        <?php } ?>

        <button type="submit">Cari</button>
    </form>
</div>

<!-- TABLE -->
<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>NAMA</th>
                <th>KELAS</th>
                <th>JURUSAN</th>
                <th>NIS</th>
                <th>NO.TELP</th>
                <th>EKSTRAKURIKULER</th>
                <th>OPSI</th>
            </tr>
        </thead>
        <tbody>
        <?php if (mysqli_num_rows($result) > 0) { ?>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $row['nama'] ?></td>
                <td><?= $row['kelas'] ?></td>
                <td><?= $row['jurusan'] ?></td>
                <td><?= $row['nis'] ?></td>
                <td><?= $row['notelp'] ?></td>
                <td><?= $row['status_ekskul'] ?></td>
                <td class="opsi">
                    <a class="detail" href="lihatdetail_admin2.php?id=<?= $row['id_siswa'] ?>">DETAIL</a>
                    <a class="edit" href="editsiswa_admin2.php?id=<?= $row['id_siswa'] ?>">EDIT</a>
                    <a class="hapus" href="hapussiswa_admin2.php?id=<?= $row['id_siswa'] ?>"
                       onclick="return confirm('Yakin hapus?')">HAPUS</a>
                </td>
            </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="7">Data tidak ditemukan</td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<div class="back-wrapper">
    <a href="admin1.php" class="back-btn">BACK</a>
</div>

</body>
</html>
