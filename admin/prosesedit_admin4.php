<?php
require_once __DIR__ . '/../koneksi.php';


// ambil data dari form
$id_pembina = $_POST['id_pembina'];
$nama = $_POST['nama_pembina'];
$nip = $_POST['nip'];
$id_ekskul = $_POST['id_ekskul'];
$telepon = $_POST['telepon'];

// QUERY UPDATE (tanpa ubah password)
$sql = "UPDATE tbpembina SET 
            nama_pembina='$nama',
            nip='$nip',
            telepon='$telepon'
        WHERE id_pembina='$id_pembina'";
mysqli_query($conn, $sql);

// Update ekskul yang dibina
mysqli_query($conn, "UPDATE tbekskul SET id_pembina=NULL WHERE id_pembina='$id_pembina'");
mysqli_query($conn, "UPDATE tbekskul SET id_pembina='$id_pembina' WHERE id_ekskul='$id_ekskul'");


if (mysqli_query($conn, $sql)) {
    echo "
        <script>
            alert('Data pembina berhasil diubah!');
            window.location.href='admin4.php';
        </script>
    ";
} else {
    echo "
        <script>
            alert('Gagal mengubah data!');
            window.location.href='admin4.php';
        </script>
    ";
}

?>
