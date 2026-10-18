<?php
require_once __DIR__ . '/../koneksi.php';


// Ambil data dari form
$id     = $_POST['id_ekskul'];
$nama   = $_POST['nama_ekskul'];
$pembina = $_POST['id_pembina']; // sementara pakai teks
$jadwal = $_POST['jadwal'];
$lokasi = $_POST['lokasi'];

// Query edit
$sql = "UPDATE tbekskul SET 
            nama_ekskul = '$nama',
            id_pembina = '$pembina',
            jadwal = '$jadwal',
            lokasi = '$lokasi'
        WHERE id_ekskul = '$id'";

if (mysqli_query($conn, $sql)) {
    echo "
        <script>
            alert('Data berhasil diperbarui!');
            window.location.href='admin3.php';
        </script>
    ";
} else {
    echo "
        <script>
            alert('Gagal memperbarui data!');
            window.location.href='admin3.php';
        </script>
    ";
}

?>
