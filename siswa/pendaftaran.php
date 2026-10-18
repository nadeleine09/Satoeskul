<?php
session_start();
require_once __DIR__ . '/../koneksi.php';


if(!isset($_SESSION['nis'])){
    header("Location: ../login.php");
    exit;
}

$nis = $_SESSION['nis'];

// Ambil data siswa berdasarkan NIS
$qSiswa = mysqli_query($conn, "SELECT * FROM tbsiswa WHERE nis='$nis'");
$dataSiswa = mysqli_fetch_assoc($qSiswa);
$id_siswa = $dataSiswa['id_siswa'];

// Ambil data ekskul untuk dropdown
$ekskul = mysqli_query($conn, "SELECT * FROM tbekskul");

// ==========================
//     PROSES FORM
// ==========================
if(isset($_POST['kirim'])){
    $id_ekskul = $_POST['id_ekskul'];
    $alasan = $_POST['alasan'];
    $tanggal = $_POST['tanggal_daftar'];

    // CEK Jumlah ekskul aktif (Menunggu / Diterima)
    $cekJumlah = mysqli_query($conn, 
        "SELECT COUNT(*) AS total FROM tbdaftar 
         WHERE id_siswa='$id_siswa' AND status != 'Ditolak'"
    );
    $dataJumlah = mysqli_fetch_assoc($cekJumlah);

    if($dataJumlah['total'] >= 2){
        echo "<script>
                alert('Batas maksimal 2 ekskul aktif! Kamu tidak bisa daftar ekskul lain.');
                window.location='pendaftaran.php';
              </script>";
        exit;
    }

    // CEK apakah sudah daftar ekskul yang sama
    $cek = mysqli_query($conn, 
        "SELECT * FROM tbdaftar 
         WHERE id_siswa='$id_siswa' AND id_ekskul='$id_ekskul'"
    );

    if(mysqli_num_rows($cek) > 0){
        echo "<script>
                alert('Kamu sudah daftar ekskul ini sebelumnya!');
                window.location='pendaftaran.php';
              </script>";
        exit;
    }

    // INSERT Data Pendaftaran
    $insert = mysqli_query($conn, 
        "INSERT INTO tbdaftar (id_siswa, id_ekskul, alasan, tanggal_daftar, status)
         VALUES ('$id_siswa', '$id_ekskul', '$alasan', '$tanggal', 'Menunggu')"
    );

    if($insert){
        echo "<script>
                alert('Pendaftaran sedang diproses! Tunggu konfirmasi pembina.');
                window.location='home1.php';
              </script>";
        exit;
    } else {
        echo "<script>alert('Gagal mendaftar!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Form Pendaftaran Ekskul</title>

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family: 'Raleway', sans-serif;}

body{
    background:#105298;
    color:white;
}

.wrapper{
    width:550px;
    margin:50px auto;
    background:white;
    color:black;
    border-radius:12px;
    padding:30px;
    box-shadow:0 0 15px rgba(0,0,0,0.3);
}

h2{
    text-align:center;
    color:#0f3da1;
    margin-bottom:20px;
}

input, select{
    width:100%;
    padding:12px;
    margin:10px 0;
    border-radius:6px;
    border:1px solid #ccc;
}

button{
    width:48%;
    padding:12px;
    border:none;
    border-radius:6px;
    font-weight:700;
    cursor:pointer;
}

.back{
    background:#0f3da1;
    color:white;
    width: 200px;
}

.kirim{
    background:#0f3da1;
    color:white;
}

button:hover{
    opacity:0.9;
}

.btn-box{
    display:flex;
    justify-content:space-between;
    margin-top:15px;
}
</style>
</head>
<body>

<div class="wrapper">
    <h2>PENDAFTARAN EKSTRAKURIKULER</h2>

    <form method="POST">

        <label>NIS</label>
        <input type="text" value="<?= $nis ?>" disabled>

        <label>Pilih Ekskul</label>
        <select name="id_ekskul" required>
            <option value="">-- PILIH EKSKUL --</option>
            <?php while($row = mysqli_fetch_assoc($ekskul)){ ?>
                <option value="<?= $row['id_ekskul'] ?>">
                    <?= $row['nama_ekskul'] ?>
                </option>
            <?php } ?>
        </select>

        <label>Alasan Mengikuti Ekskul</label>
        <input type="text" name="alasan" placeholder="Ketik alasan..." required>

        <label>Tanggal Pendaftaran</label>
        <input type="date" name="tanggal_daftar" required>

        <div class="btn-box">
            <a href="home1.php"><button type="button" class="back">BACK</button></a>
            <button type="submit" name="kirim" class="kirim">KIRIM</button>
        </div>

    </form>
</div>

</body>
</html>
