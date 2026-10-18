<?php
require_once __DIR__ . '/../koneksi.php';


if (!isset($_GET['id'])) {
    echo "<script>alert('ID daftar tidak ditemukan'); window.location='data_siswa.php';</script>";
    exit;
}

$id = $_GET['id'];

$delete = mysqli_query($conn, "DELETE FROM tbdaftar WHERE id_daftar='$id'");

if ($delete) {
    echo "<script>alert('Siswa berhasil dikeluarkan dari ekskul'); window.location='data_siswa.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus'); window.location='data_siswa.php';</script>";
}
?>
