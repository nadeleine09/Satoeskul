<?php
require_once __DIR__ . '/../koneksi.php';


// Ambil semua ekskul untuk dropdown
$ekskul = mysqli_query($conn, "SELECT * FROM tbekskul ORDER BY nama_ekskul ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tambah Pembina</title>
<style>
body {
    margin: 0;
    padding: 0;
    background: #0E3E91;
    font-family: 'Raleway', sans-serif;
}
.form-container {
    width: 420px;
    background: white;
    margin: 80px auto;
    border-radius: 15px;
    padding: 20px 40px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}
h2 {
    text-align: center;
    margin-bottom: 25px;
    font-size: 22px;
    font-weight: bold;
    text-transform: uppercase;
}
.input-box, select {
    width: 100%;
    padding: 12px;
    background: #ececec;
    border-radius: 8px;
    border: none;
    margin-bottom: 15px;
    font-size: 14px;
    box-sizing: border-box;
}
.btn-row {
    display: flex;
    justify-content: space-between;
    margin-top: 15px;
}
.btn {
    width: 48%;
    padding: 12px;
    border: none;
    border-radius: 8px;
    color: white;
    font-size: 15px;
    cursor: pointer;
}
.back-btn { 
    background: #0E3E91; 
    width: 200px;
}
.submit-btn { background: #00367A; }
</style>
</head>

<body>
<div class="form-container">
    <h2>TAMBAH PEMBINA</h2>

    <form action="prosestambah_admin4.php" method="POST">
    <input type="text" name="nama_pembina" placeholder="Nama Pembina" class="input-box" required>
    <input type="text" name="nip" placeholder="NIP" class="input-box" required>
    <input type="text" name="telepon" placeholder="Kontak" class="input-box" required>
    <input type="password" name="password" placeholder="Password" class="input-box" required>

    <div class="btn-row">
        <a href="admin4.php"><button type="button" class="btn back-btn">BACK</button></a>
        <button type="submit" class="btn submit-btn">TAMBAH</button>
    </div>
</form>

</div>
</body>
</html>
