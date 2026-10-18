<?php
require_once __DIR__ . '/../koneksi.php';


$id         = $_POST['id_ekskul'];
$nama       = $_POST['nama_ekskul'];
$deskripsi  = $_POST['deskripsi'];
$jadwal     = $_POST['jadwal'];
$lokasi     = $_POST['lokasi'];
$id_pembina = $_POST['id_pembina'];

$fotoSQL = "";

/* ambil foto lama */
$q = mysqli_query($conn,"SELECT foto FROM tbekskul WHERE id_ekskul='$id'");
$d = mysqli_fetch_assoc($q);
$fotoLama = $d['foto'];

/* upload foto baru */
if(!empty($_FILES['foto']['name'])){
    $ext = strtolower(pathinfo($_FILES['foto']['name'],PATHINFO_EXTENSION));
    $allow = ['jpg','jpeg','png','gif'];

    if(!in_array($ext,$allow)){
        echo "<script>alert('Format foto tidak diizinkan!');history.back();</script>";
        exit;
    }

    $namaBaru = uniqid('foto_').'.'.$ext;
    move_uploaded_file($_FILES['foto']['tmp_name'], "../uploads/".$namaBaru);

    if($fotoLama && file_exists("../uploads/".$fotoLama)){
        unlink("../uploads/".$fotoLama);
    }

    $fotoSQL = ", foto='$namaBaru'";
}

/* update */
$sql = "UPDATE tbekskul SET
        nama_ekskul='$nama',
        deskripsi='$deskripsi',
        jadwal='$jadwal',
        lokasi='$lokasi',
        id_pembina='$id_pembina'
        $fotoSQL
        WHERE id_ekskul='$id'";

if(mysqli_query($conn,$sql)){
    echo "
    <script>
        alert('Data ekstrakurikuler berhasil diubah!');
        window.location='pembina4.php';
    </script>
    ";
}else{
    echo "
    <script>
        alert('Gagal mengubah data!');
        history.back();
    </script>
    ";
}
