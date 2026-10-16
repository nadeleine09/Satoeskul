<?php
include '../koneksi.php';

$id = $_GET['id'];

$query = mysqli_query($conn, "
    SELECT tbekskul.*, tbpembina.nama_pembina 
    FROM tbekskul 
    JOIN tbpembina ON tbekskul.id_pembina = tbpembina.id_pembina
    WHERE tbekskul.id_ekskul='$id'
");

$data = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Ekskul</title>

<style>
body{
    margin:0;
    background:#0E3E91;
    font-family:Raleway,sans-serif
}

.form-container{
    width:420px;
    background:#fff;
    margin:50px auto;
    padding:20px 40px;
    border-radius:15px;
    box-shadow:0 4px 12px rgba(0,0,0,.2)
}

h2{
    text-align:center;
    margin-bottom:25px
}

.input-box{
    width:100%;
    padding:12px;
    margin-bottom:15px;
    background:#ececec;
    border:none;
    border-radius:8px;
    box-sizing:border-box
}

.btn-row{
    display:flex;
    justify-content:space-between;
    gap:10px
}

.btn{
    width:48%;
    padding:14px 0;
    border:none;
    border-radius:8px;
    color:#fff;
    cursor:pointer;

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:16px;
    font-weight:600;
    font-family: inherit;   /* 🔥 INI PENTING */
    line-height:1;          /* 🔥 INI PENTING */

    text-decoration:none;
}


.back-btn{
    background:#0E3E91
}

.back-btn:hover{
    background:#0b2f6d
}

.submit-btn{
    background:#00367A;
    border:none
}

.submit-btn:hover{
    background:#00285c
}

img{
    margin-top:5px;
    border-radius:5px
}
</style>
</head>

<body>

<div class="form-container">
<h2>EDIT DATA EKSTRAKURIKULER</h2>

<form action="prosesedit_ekskul.php" method="POST" enctype="multipart/form-data">

<input type="hidden" name="id_ekskul" value="<?= $data['id_ekskul'] ?>">

<input type="text" name="nama_ekskul" class="input-box"
value="<?= htmlspecialchars($data['nama_ekskul']) ?>" required>

<input type="text" name="deskripsi" class="input-box"
value="<?= htmlspecialchars($data['deskripsi']) ?>" required>

<input type="text" name="jadwal" class="input-box"
value="<?= htmlspecialchars($data['jadwal']) ?>" required>

<input type="text" name="lokasi" class="input-box"
value="<?= htmlspecialchars($data['lokasi']) ?>" required>

<select name="id_pembina" class="input-box" required>
    <option value="<?= $data['id_pembina'] ?>">
        <?= $data['nama_pembina'] ?>
    </option>
    <?php
    $q = mysqli_query($conn,"SELECT * FROM tbpembina ORDER BY nama_pembina ASC");
    while($p = mysqli_fetch_assoc($q)){
        echo "<option value='{$p['id_pembina']}'>{$p['nama_pembina']}</option>";
    }
    ?>
</select>

<input type="file" name="foto" class="input-box">

<?php if($data['foto']): ?>
<small>
    Foto sekarang:<br>
    <img src="../uploads/<?= $data['foto'] ?>" width="60">
</small>
<?php endif; ?>

<div class="btn-row">
    <!-- BACK YANG BENAR -->
    <a href="pembina4.php" class="btn back-btn">BACK</a>

    <!-- SUBMIT -->
    <button type="submit" class="btn submit-btn">UBAH</button>
</div>

</form>
</div>

</body>
</html>
