<?php
session_start();
require_once __DIR__ . '/../koneksi.php';


// Pastikan pembina sudah login
if (!isset($_SESSION['id_pembina'])) {
    header("Location: ../login.php");
    exit;
}

$id_pembina = $_SESSION['id_pembina'];

// Query pendaftar khusus ekskul yg dibina pembina ini
$query = "SELECT 
        tbsiswa.nama,
        tbsiswa.kelas,
        tbsiswa.jurusan,
        tbsiswa.nis,
        tbsiswa.notelp,
        tbdaftar.alasan,
        tbdaftar.tanggal_daftar,
        tbdaftar.status,
        tbdaftar.id_daftar,
        tbekskul.nama_ekskul
    FROM tbdaftar
    JOIN tbsiswa ON tbdaftar.id_siswa = tbsiswa.id_siswa
    JOIN tbekskul ON tbdaftar.id_ekskul = tbekskul.id_ekskul
    WHERE tbekskul.id_pembina = '$id_pembina'
    ORDER BY tbdaftar.tanggal_daftar DESC";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Data Pendaftar</title>

</head>
<body>

<header>
    <nav>
        <img class="logo" src="../Rules!.png" alt="Logo">
        <ul>
            <li><a href="#" onclick="openLogoutPopup()">LOG OUT</a></li>
        </ul>
    </nav>
</header>

<div class="dashboard-title">DATA PENDAFTAR</div>

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>NAMA</th>
                <th>KELAS</th>
                <th>JURUSAN</th>
                <th>NIS</th>
                <th>NO.TELP</th>
                <th>ALASAN</th>
                <th>TANGGAL DAFTAR</th>
                <th>STATUS</th>
            </tr>
        </thead>
        <tbody>
            <?php if(mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nama']); ?></td>
                        <td><?= htmlspecialchars($row['kelas']); ?></td>
                        <td><?= htmlspecialchars($row['jurusan']); ?></td>
                        <td><?= htmlspecialchars($row['nis']); ?></td>
                        <td><?= htmlspecialchars($row['notelp']); ?></td>
                        <td><?= htmlspecialchars($row['alasan']); ?></td>
                        <td><?= htmlspecialchars($row['tanggal_daftar']); ?></td>
                        <td class="opsi">
<?php if ($row['status'] == 'Menunggu'): ?>

    <a href="terima.php?id=<?= $row['id_daftar']; ?>" class="btn edit">
        TERIMA
    </a>

    <a href="tolak.php?id=<?= $row['id_daftar']; ?>" 
       class="btn hapus"
       onclick="return confirm('Tolak pendaftar ini?')">
        TOLAK
    </a>
<?php else: ?>
    <span class="status"><?= $row['status']; ?></span>
<?php endif; ?>
</td>


                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9">Belum ada pendaftar</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<button class="back-btn" onclick="window.location.href='pembina1.php'">BACK</button>

<style>
            html, body {
    margin: 0;
    padding: 0;
    background: #d9d4d4;
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

.dashboard-title {
      padding: 25px;
      font-size: 24px;
      font-weight: bold;
      font-family: 'Raleway', sans-serif;
      text-transform: uppercase;
}

.table-container {
    background: #fff;
    padding: 0 0 60px 0;
    border-radius: 10px;
    width: 95%;
    margin: 0 auto;
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    overflow: hidden;
    position: relative;
    font-family: 'Raleway', sans-serif;
    min-height: 100px;
}

/* HEADER */
.data-table thead {
    background: #0f3da1;
    color: white;
    font-family: 'Raleway', sans-serif;
}

.data-table th {
    padding: 12px;
    font-size: 14px;
    font-family: 'Raleway', sans-serif;
}

/* ISI TABEL */
.data-table td {
    padding: 14px;
    font-size: 14px;
    border-bottom: 1px solid #dcdcdc;
    text-align: center;
    font-family: 'Raleway', sans-serif;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    font-family: 'Raleway', sans-serif;
}

/* OPSI */
.opsi .btn {
    display: inline-block;
    padding: 6px 14px;
    font-size: 13px;
    font-family: 'Raleway', sans-serif;
    text-decoration: none;
    border-radius: 6px;
    color: white;
    font-weight: bold;
    margin: 0 4px;
    transition: 0.2s ease;
}

/* DETAIL */

/* TERIMA */
.opsi .edit {
    background-color: #1b5e20;
}
.opsi .edit:hover {
    background-color: #1b5e20;
}

/* TOLAK */
.opsi .hapus {
    background-color: #b30000;
}
.opsi .hapus:hover {
    background-color: #800000;
}

/* STATUS */
.status {
    color: gray;
    font-weight: bold;
}


/* TOMBOL TAMBAH */
.add-btn {
    position: absolute;
    bottom: 20px;     /* jarak dari bawah kotak putih */
    right: 20px;      /* jarak dari kanan kotak putih */

    width: 55px;
    height: 55px;
    background: #000;
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 30px;
    text-decoration: none;
    cursor: pointer;
    z-index: 10; /* biar tetap di atas */
}



/* TOMBOL BACK */
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
    font-family: 'Raleway', sans-serif;
    font-size: 14px;
    text-decoration: none;
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
        <h3 style="margin-bottom:10px;">Konfirmasi Logout</h3>
        <p>Apakah Anda yakin ingin logout?</p>

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


</body>
</html>
