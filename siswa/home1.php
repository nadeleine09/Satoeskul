<?php
session_start();
include "../koneksi.php";

if(!isset($_SESSION['nis'])){
    header("Location: ../login.php");
    exit;
}

$nis = $_SESSION['nis'];
$nis_esc = mysqli_real_escape_string($conn, $nis);

/*
 * 1) Ambil semua status pendaftaran + nama ekskul (butuh JOIN ke tbekskul)
 */
$sqlStatus = "
    SELECT tbdaftar.status, tbekskul.nama_ekskul
    FROM tbdaftar
    JOIN tbsiswa ON tbdaftar.id_siswa = tbsiswa.id_siswa
    JOIN tbekskul ON tbdaftar.id_ekskul = tbekskul.id_ekskul
    WHERE tbsiswa.nis = '$nis_esc'
";
$qStatus = mysqli_query($conn, $sqlStatus);
if(!$qStatus){
    die("Query status error: " . mysqli_error($conn));
}

$statuses = [];
while($row = mysqli_fetch_assoc($qStatus)){
    // pastikan kolom yang dipakai memang ada (nama_ekskul + status)
    $statuses[] = htmlspecialchars($row['nama_ekskul']) . " - " . htmlspecialchars($row['status']);
}

$statusText = count($statuses) > 0
    ? implode("<br>", $statuses)
    : "Belum melakukan pendaftaran, silahkan mendaftar terlebih dahulu.";

/*
 * 2) Hitung jumlah ekskul yang sudah didaftar untuk siswa ini
 *    (harus JOIN ke tbsiswa karena tbdaftar menyimpan id_siswa, bukan nis)
 */
$qCount = mysqli_query($conn, "
    SELECT COUNT(*) as total
    FROM tbdaftar
    JOIN tbsiswa ON tbdaftar.id_siswa = tbsiswa.id_siswa
    WHERE tbsiswa.nis = '$nis_esc'
    AND tbdaftar.status != 'Ditolak'
");
$count = mysqli_fetch_assoc($qCount)['total'];


/*
 * 3) Ambil daftar ekskul untuk menu (urut agar rapi)
 */
$ekskul = mysqli_query($conn, "SELECT * FROM tbekskul ORDER BY nama_ekskul ASC");
if(!$ekskul){
    die("Query ekskul error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Siswa</title>
<!-- (CSS sama seperti sebelumnya) -->
<style>
    html, body {
    margin: 0;
    padding: 0;
    background:url('../satoe.jpg') no-repeat center center/cover;
    min-height:100vh;color:white;
    font-family: 'Raleway', sans-serif;
}

        .logo {
    width: 70px;
    border-radius: 50%;
}

nav {
    width: 99,9%;
    background-color: #105298;
    height:70px;
    padding: 0px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

nav ul {
    display: flex;
}

nav ul li {
    list-style: none;
    padding: 30px 15px;
}

nav ul li a {
    color: white;
    text-decoration: none;
    font-size: 13px;
    font-family: 'Raleway', sans-serif;
    text-transform: uppercase;
}

header ul li a:hover {
    color: white;
    text-decoration: underline;
}

.container{text-align:center;margin-top:80px;}
.menu{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:20px;
    max-width:750px;
    margin:0 auto;
}
.menu a{
    background:white;
    padding:10px 40px;
    border-radius:6px;
    display:block;
    color:black;
    text-decoration:none;
    font-weight:600;
}
.menu a:hover{
    background:#123c87;
    color:white;
}
.daftar button{
    padding:12px 80px;
    background:white;color:black;border:none;
    border-radius:6px;font-weight:700;margin-top:30px;cursor:pointer;
    width: 500px;
}
.daftar button:hover{
    background:#123c87;color:white;
}
.status-box{
    background:white;
    color:black;
    margin:30px auto;
    width:80%;padding:12px;
    border-radius:6px;
}
</style>

<script>
function openLogoutPopup() {
    document.getElementById('logoutPopup').style.display = 'block';
}

function closeLogoutPopup() {
    document.getElementById('logoutPopup').style.display = 'none';
}
</script>


<!-- POPUP LOGOUT -->
<div id="logoutPopup" style="
    display:none;
    position:fixed;
    top:0; left:0;
    width:100%; height:100%;
    background:rgba(0,0,0,0.5);
    backdrop-filter: blur(2px);
    z-index: 999;
">
    <div style="
        background:white;
        width:320px;
        padding:20px;
        margin:150px auto;
        border-radius:12px;
        text-align:center;
        font-family:'Raleway', sans-serif;
    ">
        <h3 style="margin-bottom:10px; color:black;">Konfirmasi Logout</h3>
        <p style="color:black;">Apakah Anda yakin ingin logout?</p>

        <button onclick="location.href='../logout.php'" style="
            background:#0f3da1;
            color:white;
            border:none;
            padding:10px 25px;
            margin-top:15px;
            border-radius:8px;
            cursor:pointer;
            font-size:14px;
        ">LOG OUT</button>

        <button onclick="closeLogoutPopup()" style="
            background:#aaa;
            color:white;
            border:none;
            padding:10px 25px;
            margin-left:10px;
            border-radius:8px;
            cursor:pointer;
            font-size:14px;
        ">CANCEL</button>
    </div>
</div>



</head>
<body>

<header>
    <nav>
            <img class="logo" src="../Rules!.png">
            <ul>
                <li><a href="#" onclick="openLogoutPopup()">LOG OUT</a></li>
            </ul>
        </nav>
</header>

<div class="container">
    <h1>PILIH MINATMU!</h1>

    <div class="menu">
        <?php while($row = mysqli_fetch_assoc($ekskul)){ ?>
            <a href="detail_ekskul.php?id=<?= htmlspecialchars($row['id_ekskul']) ?>">
                <?= htmlspecialchars($row['nama_ekskul']) ?>
            </a>
        <?php } ?>
    </div>

    <div class="daftar">
        <?php if((int)$count < 2){ ?>
            <a href="pendaftaran.php"><button>PENDAFTARAN</button></a>
        <?php } else { ?>
            <button disabled style="background:gray;cursor:not-allowed;">BATAS TERPENUHI</button>
        <?php } ?>
    </div>

    <div class="status-box">
        <b>STATUS PENDAFTARAN :</b><br><br>
        <?= $statusText ?>
    </div>
</div>


</body>
</html>
