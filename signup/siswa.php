<?php
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $username = $_POST['nis'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $kelas = $_POST['kelas'];
    $jurusan = $_POST['jurusan'];
    $notelp = $_POST['notelp'];

    $sql = "INSERT INTO tbsiswa (nama, nis, kelas, jurusan, notelp, password)
            VALUES ('$nama', '$username','$kelas', '$jurusan', '$notelp', '$password')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Pendaftaran berhasil! Silakan login.'); window.location='../login.php';</script>";
    } else {
        echo "<script>alert('Gagal daftar!'); window.history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Sign Up Siswa</title>
  <style>
    body {
      margin: 0;
      font-family: "Poppins", sans-serif;
      background-color: #474fa0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .container {
      background-color: white;
      padding: 40px 50px;
      border-radius: 20px;
      box-shadow: 6px 6px 0px rgba(0,0,0,0.3);
      text-align: center;
      width: 300px;
    }

    h2 {
      margin-bottom: 20px;
      color: #111;
      letter-spacing: 1px;
    }

    form {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    input, select {
      width: 90%;
      padding: 10px;
      margin: 8px 0;
      border: none;
      background-color: #eaeaea;
      border-radius: 6px;
      font-size: 14px;
      outline: none;
      box-sizing: border-box;
    }

    button {
      width: 100%;
      background-color: #474fa0;
      color: white;
      padding: 10px;
      border: none;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
      margin-top: 10px;
    }

    button:hover {
      background-color: #373d87;
    }

    a {
      text-decoration: none;
      color: #474fa0;
      font-size: 14px;
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

  <a href="../index.html" class="back">«</a>

  <div class="container">
    <h2>SIGN UP</h2>
    <form method="POST">
      <input type="text" name="nama" placeholder="NAMA" required>
      
      <select name="kelas" required>
        <option value="">Pilih Kelas</option>
        <option value="X">X</option>
        <option value="XI">XI</option>
        <option value="XII">XII</option>
      </select>

      <select name="jurusan" required>
        <option value="">Pilih Jurusan</option>
        <option value="RPL">Rekayasa Perangkat Lunak</option>
        <option value="TKJ">Teknik Komputer dan Jaringan</option>
        <option value="DKV">Desain Komunikasi Visual</option>
        <option value="AKL">Akuntansi dan Keuangan Lembaga</option>
        <option value="DPB">Desain Produksi Busana</option>
        <option value="TPFL">Teknik Pengelasan dan Fibrasi Logam</option>
        <option value="TP">Teknik Pemesinan</option>
        <option value="TKR">Teknik Kendaraan Ringan</option>
      </select>

      <input type="text" name="nis" placeholder="NIS" required>
      <input type="text" name="notelp" placeholder="NO. TELP" required>
      <input type="password" name="password" placeholder="PASSWORD" required>
      <button type="submit">SIGN UP</button>
    </form>
  </div>

</body>
</html>