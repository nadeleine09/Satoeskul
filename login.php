<?php
session_start();
include 'koneksi.php'; // pastikan path benar

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 1) cek di tb_admin
    // cek admin
$qAdmin = mysqli_query($conn, "SELECT * FROM tbadminn WHERE id_admin='$username'");
if (mysqli_num_rows($qAdmin) > 0) {
    $data = mysqli_fetch_assoc($qAdmin);

    if (password_verify($password, $data['password'])) {
        $_SESSION['role'] = 'admin';
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['id_admin'] = $data['id_admin'];
        header("Location: admin/admin1.php");
        exit;
    } else {
        echo "<script>alert('Password salah!'); window.history.back();</script>";
        exit;
    }
}

    // 2) cek di tbsiswa
    $qSiswa = mysqli_query($conn, "SELECT * FROM tbsiswa WHERE nis='$username'");
    if (mysqli_num_rows($qSiswa) > 0) {
        $data = mysqli_fetch_assoc($qSiswa);
        if (password_verify($password, $data['password'])) {
            $_SESSION['role'] = 'siswa';
            $_SESSION['nama'] = $data['nama'];
            $_SESSION['nis'] = $data['nis'];
            header("Location: siswa/home1.php"); // ganti sesuai dashboard siswa
            exit;
        } else {
            echo "<script>alert('Password salah!'); window.history.back();</script>";
            exit;
        }
    }

    // 3) cek di tbpembina
    $qPembina = mysqli_query($conn, "SELECT * FROM tbpembina WHERE nip='$username'");

if (mysqli_num_rows($qPembina) > 0) {

    $data = mysqli_fetch_assoc($qPembina);

    if (password_verify($password, $data['password'])) {

        // SET SESSION PENTING
        $_SESSION['role'] = 'pembina';
        $_SESSION['nama_pembina'] = $data['nama_pembina'];
        $_SESSION['nip'] = $data['nip'];
        $_SESSION['id_pembina'] = $data['id_pembina']; // <-- INI WAJIB ADA

        // Pindah ke dashboard pembina
        header("Location: pembina/pembina1.php");
        exit;
        
    } else {
        echo "<script>alert('Password salah!'); window.history.back();</script>";
        exit;
    }
}


    // Kalau username tidak ditemukan di semua tabel
    echo "<script>alert('Username tidak ditemukan!'); window.history.back();</script>";
}
?>



<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <style>
    body {
      background-color: #3f4bb8;
      font-family: Arial, sans-serif;
    }
    .login-box {
      background: #fff;
      width: 350px;
      margin: 100px auto;
      padding: 30px;
      border-radius: 20px;
      box-shadow: 0 8px 10px rgba(0,0,0,0.2);
      text-align: center;
    }
    input {
      width: 80%;
      padding: 10px;
      margin: 8px 0;
      border: none;
      background: #ddd;
      border-radius: 5px;
    }
    button {
      width: 84%;
      padding: 10px;
      border: none;
      background: #5a67ff;
      color: white;
      font-weight: bold;
      border-radius: 6px;
      cursor: pointer;
    }
    button:hover {
      background: #4a54e1;
    }

    .back {
      position: absolute;
      top: 20px;
      left: 30px;
      font-size: 80px;
      text-decoration: none;
      color: black;
      width: 20px;
    }
  </style>
</head>
<body>
  <a href="index.html" class="back">«</a>
  <div class="login-box">
    <h2>LOGIN</h2>
    <form method="POST" action="">
      <input type="text" name="nama" placeholder="NAMA" required><br>
      <input type="text" name="username" placeholder="NIS/ID" required><br>
      <input type="password" name="password" placeholder="PASSWORD" required><br>
      <button type="submit" name="login">LOGIN</button>
    </form>
  </div>
</body>
</html>