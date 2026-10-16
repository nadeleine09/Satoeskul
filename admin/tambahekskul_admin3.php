<?php
include '../koneksi.php';

// Ambil semua pembina untuk dropdown
$pembina = mysqli_query($conn, "SELECT id_pembina, nama_pembina FROM tbpembina ORDER BY nama_pembina ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Ekskul</title>
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
        .back-btn { background: #0E3E91; 
        width: 200px;}
        .submit-btn { background: #00367A; }
    </style>
</head>
<body>

<div class="form-container">
    <h2>TAMBAH EKSTRAKURIKULER</h2>

    <form action="prosestambah_admin3.php" method="POST">

        <input type="text" name="nama_ekskul" placeholder="Nama Ekskul" class="input-box" required>

        <!-- Dropdown pilih pembina -->
        <select name="id_pembina" class="input-box" required>
            <option value="">-- Pilih Pembina --</option>
            <?php while($row = mysqli_fetch_assoc($pembina)) { ?>
                <option value="<?= $row['id_pembina'] ?>"><?= $row['nama_pembina'] ?></option>
            <?php } ?>
        </select>

        <input type="text" name="jadwal" placeholder="Jadwal" class="input-box" required>
        <input type="text" name="lokasi" placeholder="Lokasi" class="input-box" required>

        <div class="btn-row">
            <a href="admin3.php"><button type="button" class="btn back-btn">BACK</button></a>
            <button type="submit" class="btn submit-btn">TAMBAH</button>
        </div>

    </form>
</div>

</body>
</html>
