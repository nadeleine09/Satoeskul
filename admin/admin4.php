<?php
include '../koneksi.php';

// SEARCH
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

// QUERY PEMBINA
$query = mysqli_query($conn, "
    SELECT 
        tbpembina.id_pembina,
        tbpembina.nama_pembina,
        tbpembina.nip,
        tbpembina.telepon,
        tbekskul.nama_ekskul
    FROM tbpembina
    LEFT JOIN tbekskul ON tbpembina.id_pembina = tbekskul.id_pembina
    WHERE
        tbpembina.nama_pembina LIKE '%$keyword%' OR
        tbpembina.nip LIKE '%$keyword%' OR
        tbekskul.nama_ekskul LIKE '%$keyword%'
    ORDER BY tbpembina.nama_pembina ASC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Pembina</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

<style>
html, body {
    margin: 0;
    padding: 0;
    background: #d9d4d4;
    font-family: 'Raleway', sans-serif;
}

/* NAV */
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
    text-transform: uppercase;
}

/* SEARCH */
.search-wrapper {
    width: 95%;
    margin: 0 auto 15px auto;
}
.search-wrapper form {
    display: flex;
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
    top: 10px;
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

/* TABLE */
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

/* OPSI */
.opsi .btn {
    padding: 6px 12px;
    font-size: 13px;
    border-radius: 5px;
    text-decoration: none;
    color: white;
    margin: 2px;
}
.detail { background: #0c811f; }
.edit   { background: #002399; }
.hapus  { background: #b30000; }

/* ADD */
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

/* BACK DI LUAR PUTIH */
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
}
</style>
</head>

<body>

<nav>
    <img class="logo" src="../Rules!.png">
    <a href="#" onclick="openLogoutPopup()">LOG OUT</a>
</nav>

<div class="dashboard-title">DATA PEMBINA</div>

<!-- SEARCH -->
<div class="search-wrapper">
<form method="GET">
    <input type="text" name="keyword"
           placeholder="Cari pembina / NIP / ekskul"
           value="<?= htmlspecialchars($keyword) ?>">
    <?php if (!empty($keyword)) { ?>
        <a href="admin4.php" class="clear-btn">✖</a>
    <?php } ?>
    <button type="submit">Cari</button>
</form>
</div>

<!-- TABLE -->
<div class="table-container">
<table>
<thead>
<tr>
    <th>PEMBINA</th>
    <th>NIP</th>
    <th>EKSTRAKURIKULER</th>
    <th>KONTAK</th>
    <th>OPSI</th>
</tr>
</thead>
<tbody>

<?php
if (mysqli_num_rows($query) > 0) {
while ($row = mysqli_fetch_assoc($query)) {
?>
<tr>
    <td><?= $row['nama_pembina'] ?></td>
    <td><?= $row['nip'] ?></td>
    <td><?= $row['nama_ekskul'] ?: 'Belum punya ekskul' ?></td>
    <td><?= $row['telepon'] ?></td>
    <td class="opsi">
        <a class="btn detail" href="lihatdetail_admin4.php?id=<?= $row['id_pembina'] ?>">DETAIL</a>
        <a class="btn edit" href="editpembina_admin4.php?id=<?= $row['id_pembina'] ?>">EDIT</a>
        <a class="btn hapus" href="hapuspembina_admin4.php?id=<?= $row['id_pembina'] ?>"
           onclick="return confirm('Yakin ingin menghapus data?')">HAPUS</a>
    </td>
</tr>
<?php } } else { ?>
<tr>
    <td colspan="5">Data tidak ditemukan</td>
</tr>
<?php } ?>

</tbody>
</table>

<button class="add-btn" onclick="location.href='tambahpembina_admin4.php'">+</button>
</div>

<!-- BACK -->
<div class="back-wrapper">
    <a href="admin1.php"><button class="back-btn">BACK</button></a>
</div>

<!-- LOGOUT POPUP -->
<script>
function openLogoutPopup() {
    document.getElementById('logoutPopup').style.display = 'block';
}
function closeLogoutPopup() {
    document.getElementById('logoutPopup').style.display = 'none';
}
</script>

<div id="logoutPopup" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,.5);">
    <div style="background:white; width:320px; padding:20px; margin:150px auto; border-radius:12px; text-align:center;">
        <h3>Konfirmasi Logout</h3>
        <p>Apakah Anda yakin ingin logout?</p>
        <button onclick="location.href='../logout.php'">LOG OUT</button>
        <button onclick="closeLogoutPopup()">CANCEL</button>
    </div>
</div>

</body>
</html>
