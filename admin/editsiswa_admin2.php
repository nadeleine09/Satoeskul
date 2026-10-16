<?php
include '../koneksi.php';

$id = $_GET['id'];

// Ambil data siswa berdasarkan ID
$query = mysqli_query($conn, "SELECT * FROM tbsiswa WHERE id_siswa='$id'");
$data  = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Siswa</title>

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

        .input-box {
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

        .submit-btn {
            background: #00367A;
        }
    </style>
</head>

<body>

<div class="form-container">

    <h2>EDIT DATA SISWA</h2>

    <form action="prosesedit_admin2.php" method="POST">

        <input type="hidden" name="id_siswa" value="<?= $data['id_siswa'] ?>">

        <input type="text" name="nama" class="input-box"
               value="<?= $data['nama'] ?>" required>

        <input type="text" name="kelas" class="input-box"
               value="<?= $data['kelas'] ?>" required>

        <input type="text" name="jurusan" class="input-box"
               value="<?= $data['jurusan'] ?>" required>

        <input type="text" name="nis" class="input-box"
               value="<?= $data['nis'] ?>" required>

        <input type="text" name="notelp" class="input-box"
               value="<?= $data['notelp'] ?>" required>

        <div class="btn-row">
            <a href="admin2.php">
                <button type="button" class="btn back-btn">BACK</button>
            </a>

            <button type="submit" class="btn submit-btn">UBAH</button>
        </div>

    </form>

</div>

</body>
</html>
