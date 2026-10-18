<?php
require_once __DIR__ . '/../koneksi.php';


// pastikan ada id
if (!isset($_GET['id'])) {
    echo "<script>alert('ID tidak ditemukan'); window.location='informasi_ekskul.php';</script>";
    exit;
}

$id = $_GET['id'];

// ambil dulu data foto
$q = mysqli_query($conn, "SELECT foto FROM tbekskul WHERE id_ekskul='$id'");
$data = mysqli_fetch_assoc($q);

// hapus foto jika ada
if (!empty($data['foto'])) {
    $filePath = "../uploads/" . $data['foto'];
    if (file_exists($filePath)) {
        unlink($filePath); // hapus file
    }
}

// hapus data dari database
$delete = mysqli_query($conn, "DELETE FROM tbekskul WHERE id_ekskul='$id'");

if ($delete) {
    echo "<script>alert('Data berhasil dihapus'); window.location='pembina4.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus data'); window.location='pembina4.php';</script>";
}
?>
