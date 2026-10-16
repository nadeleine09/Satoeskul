<?php
include '../koneksi.php';
session_start();

if (!isset($_SESSION['id_pembina'])) {
    header("Location: ../login.php");
    exit;
}

$id_pembina = $_SESSION['id_pembina'];
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

$sql = "
SELECT 
    tbsiswa.*,
    tbdaftar.id_daftar,
    tbdaftar.status,
    tbekskul.nama_ekskul
FROM tbdaftar
JOIN tbsiswa ON tbdaftar.id_siswa = tbsiswa.id_siswa
JOIN tbekskul ON tbdaftar.id_ekskul = tbekskul.id_ekskul
WHERE tbdaftar.status = 'Diterima'
AND tbekskul.id_pembina = '$id_pembina'
AND (
    tbsiswa.nama LIKE '%$keyword%' OR
    tbsiswa.nis LIKE '%$keyword%' OR
    tbsiswa.kelas LIKE '%$keyword%' OR
    tbsiswa.jurusan LIKE '%$keyword%'
)
ORDER BY tbsiswa.nama ASC
";

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Siswa</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

<style>
html, body { margin:0; padding:0; background:#d9d4d4; font-family:'Raleway', sans-serif; }
.logo { width:70px; border-radius:50%; }

nav {
    height:70px;
    background:#105298;
    padding:0 20px;
    display:flex;
    align-items:center;
    justify-content:space-between;
}
nav a { color:white; text-decoration:none; font-size:13px; }

.dashboard-title {
    padding:25px;
    font-size:24px;
    font-weight:bold;
    text-transform:uppercase;
}

/* SEARCH */
.search-wrapper {
    width:95%;
    margin:0 auto 15px auto;
}
.search-wrapper form {
    display:flex;
    position:relative;
    gap:6px;
}
.search-wrapper input {
    width:300px;
    padding:10px 35px 10px 10px;
    border-radius:6px;
    border:1px solid #ccc;
}
.clear-btn {
    position:absolute;
    left:265px;
    top:9px;
    text-decoration:none;
    font-size:16px;
    color:#777;
}
.search-wrapper button {
    padding:10px 20px;
    background:#0f3da1;
    color:white;
    border:none;
    border-radius:6px;
    cursor:pointer;
}

/* TABLE */
.table-container {
    background:#fff;
    padding:0 0 60px 0;
    border-radius:10px;
    width:95%;
    margin:0 auto;
    box-shadow:0 4px 10px rgba(0,0,0,0.15);
}

table {
    width:100%;
    border-collapse:collapse;
}
thead {
    background:#0f3da1;
    color:white;
}
th, td {
    padding:14px;
    border-bottom:1px solid #dcdcdc;
    text-align:center;
}

/* OPSI */
.opsi .btn {
    padding:6px 14px;
    border-radius:6px;
    color:white;
    text-decoration:none;
    font-size:13px;
    margin:0 3px;
}
.detail { background:#0c811f; }
.edit   { background:#0f3da1; }
.hapus  { background:#b30000; }

/* BACK (TETAP PUNYAMU) */
.back-btn {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #0f3da1;
    color: white;
    padding: 12px 28px;
    border-radius: 8px;
    text-decoration: none;
}
</style>
</head>

<body>

<nav>
    <img src="../Rules!.png" class="logo">
    <a href="#" onclick="openLogoutPopup()">LOG OUT</a>
</nav>

<div class="dashboard-title">DATA SISWA</div>

<!-- SEARCH -->
<div class="search-wrapper">
<form method="GET">
    <input type="text" name="keyword"
           placeholder="Cari nama / NIS / kelas / jurusan"
           value="<?= htmlspecialchars($keyword) ?>">
    <?php if ($keyword != '') { ?>
        <a href="data_siswa.php" class="clear-btn">✖</a>
    <?php } ?>
    <button type="submit">Cari</button>
</form>
</div>

<div class="table-container">
<table>
<thead>
<tr>
    <th>NAMA</th>
    <th>KELAS</th>
    <th>JURUSAN</th>
    <th>NIS</th>
    <th>NO.TELP</th>
    <th>EKSKUL</th>
    <th>OPSI</th>
</tr>
</thead>
<tbody>

<?php if(mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
    <td><?= $row['nama'] ?></td>
    <td><?= $row['kelas'] ?></td>
    <td><?= $row['jurusan'] ?></td>
    <td><?= $row['nis'] ?></td>
    <td><?= $row['notelp'] ?></td>
    <td><?= $row['nama_ekskul'] ?></td>
    <td class="opsi">
        <a class="btn detail" href="detailsiswa_pembina.php?id=<?= $row['id_siswa'] ?>">DETAIL</a>
        <a class="btn edit" href="editsiswa_pembina2.php?id=<?= $row['id_siswa'] ?>">EDIT</a>
        <a class="btn hapus" href="hapus_pendaftar.php?id=<?= $row['id_daftar'] ?>"
           onclick="return confirm('Yakin hapus?')">HAPUS</a>
    </td>
</tr>
<?php }} else { ?>
<tr>
    <td colspan="7">Data tidak ditemukan</td>
</tr>
<?php } ?>

</tbody>
</table>
</div>

<a href="../pembina/pembina1.php" class="back-btn">BACK</a>

<script>
function openLogoutPopup() {
    document.getElementById('logoutPopup').style.display = 'block';
}
function closeLogoutPopup() {
    document.getElementById('logoutPopup').style.display = 'none';
}
</script>

</body>
</html>
