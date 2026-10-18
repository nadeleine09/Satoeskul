<?php
require_once __DIR__ . '/../koneksi.php';


$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM tbpembina WHERE id_pembina='$id'");
$row = mysqli_fetch_assoc($data);

// Ambil semua ekskul untuk dropdown
$ekskul = mysqli_query($conn, "SELECT * FROM tbekskul ORDER BY nama_ekskul ASC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Pembina</title>
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
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 22px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .input-box,
        select {
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
    border-radius: 0; /* ujung rata */
    color: white;
    font-size: 15px;
    cursor: pointer;
    text-align: center;
    text-decoration: none; /* penting untuk <a> */
    display: inline-block;  /* biar ukuran sama kayak button */
}

.back-btn {
    background-color: #0E3E91; 
    width: 200px;
}

.submit-btn {
    background-color: #0E3E91;
}
    </style>
</head>

<body>

    <div class="form-container">

        <h2>EDIT DATA PEMBINA</h2>

        <form action="prosesedit_admin4.php" method="POST">

            <input type="hidden" name="id_pembina" value="<?= $row['id_pembina'] ?>">

            <input type="text" name="nama_pembina" class="input-box"
                value="<?= htmlspecialchars($row['nama_pembina']) ?>" placeholder="Nama Pembina" required>

            <input type="text" name="nip" class="input-box"
                value="<?= htmlspecialchars($row['nip']) ?>" placeholder="nip" required>

            <select name="id_ekskul" class="input-box" required>
                <option value="">-- Pilih Ekstrakurikuler --</option>
                <?php while ($e = mysqli_fetch_assoc($ekskul)) { ?>
                    <option value="<?= $e['id_ekskul'] ?>"
                        <?= ($row['id_ekskul'] ?? '') == $e['id_ekskul'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($e['nama_ekskul']) ?>
                    </option>
                <?php } ?>
            </select>

            <input type="text" name="telepon" class="input-box"
                value="<?= htmlspecialchars($row['telepon']) ?>" placeholder="Telepon" required>

            <div class="btn-row">
                <a href="admin4.php" class="back-btn">
                    <button type="button" class="btn back-btn">BACK</button>
                </a>
                <button type="submit" class="btn submit-btn">UBAH</button>
            </div>

        </form>

    </div>

</body>

</html>