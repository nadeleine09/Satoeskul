<?php
include '../koneksi.php';
session_start();

$id_pembina = $_SESSION['id_pembina'];

// TOTAL SISWA khusus ekskul pembina
$q_siswa = mysqli_query($conn, "
    SELECT COUNT(*) AS total
    FROM tbdaftar
    JOIN tbekskul ON tbdaftar.id_ekskul = tbekskul.id_ekskul
    WHERE tbdaftar.status = 'Diterima'
    AND tbekskul.id_pembina = '$id_pembina'
");
$d_siswa = mysqli_fetch_assoc($q_siswa);


// TOTAL PENDAFTAR khusus ekskul pembina
$q_daftar = mysqli_query($conn, "
    SELECT COUNT(*) AS total 
    FROM tbdaftar
    LEFT JOIN tbekskul ON tbdaftar.id_ekskul = tbekskul.id_ekskul
    WHERE tbekskul.id_pembina = '$id_pembina'
");
$d_daftar = mysqli_fetch_assoc($q_daftar);

// TOTAL EKSKUL milik pembina ini saja
$q_ekskul = mysqli_query($conn, "
    SELECT COUNT(*) AS total 
    FROM tbekskul
    WHERE id_pembina = '$id_pembina'
");
$d_ekskul = mysqli_fetch_assoc($q_ekskul);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <title>Document</title>
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

    <!-- TITLE -->
  <div class="dashboard-title">DASHBOARD</div>

  <div class="cards-row">
    <div class="card">
        <h3>TOTAL SISWA :</h3>
        <div class="count"><?= $d_siswa['total'] ?></div>
        <button class="btn" onclick="window.location.href='data_siswa.php'">kelola data</button>
    </div>

    <div class="card">
        <h3>TOTAL PENDAFTAR :</h3>
        <div class="count"><?= $d_daftar['total'] ?></div>
        <button class="btn" onclick="window.location.href='pembina3.php'">kelola data</button>
    </div>
</div>

<div class="cards-row">
    <div class="card card-large">
        <h3>INFORMASI EKSTRAKURIKULER :</h3>
        <img src="../edit1.png" class="icon">
        <button class="btn" onclick="window.location.href='pembina4.php'">kelola data</button>
    </div>
</div>

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

.cards-row {
            display: flex;
            gap: 20px;
            margin: 20px 30px;
        }

        .card {
            background: #ffffff;
            padding: 25px;
            border-radius: 15px;
            flex: 1;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            font-family: 'Raleway', sans-serif;
        }

        .card-large {
            width: 100%;
        }

        .card h3 {
            font-size: 17px;
            margin-bottom: 60px;
            font-family: 'Raleway', sans-serif;
            font-weight: 400;
            margin-top: 0px;
        }

        .count {
            font-size: 45px;
            font-weight: bold;
            margin: 5px 0 20px;
            font-family: 'Raleway', sans-serif;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;

        }

        .icon {
    width: 60px;
    height: auto; 
    display: block;
    margin: 10px auto;
}


        .btn {
            background: #cddaf3;
            border: none;
            padding: 8px 20px;
            border-radius: 8px;
            cursor: pointer;
            float: right;
            font-family: 'Raleway', sans-serif;
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