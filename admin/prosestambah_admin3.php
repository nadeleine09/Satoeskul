<?php
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama_ekskul = mysqli_real_escape_string($conn, $_POST['nama_ekskul']);
    $id_pembina  = mysqli_real_escape_string($conn, $_POST['id_pembina']);
    $jadwal      = mysqli_real_escape_string($conn, $_POST['jadwal']);
    $lokasi      = mysqli_real_escape_string($conn, $_POST['lokasi']);

    // Cek apakah id_pembina valid
    $cekPembina = mysqli_query($conn, "SELECT * FROM tbpembina WHERE id_pembina='$id_pembina'");
    if (mysqli_num_rows($cekPembina) == 0) {
        echo "<script>alert('Pembina tidak valid!'); window.location.href='tambahekskul_admin3.php';</script>";
        exit;
    }

    // Insert ke tbekskul
    $sql = "INSERT INTO tbekskul (nama_ekskul, id_pembina, jadwal, lokasi)
            VALUES ('$nama_ekskul', '$id_pembina', '$jadwal', '$lokasi')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Data ekstrakurikuler berhasil ditambahkan!'); window.location.href='admin3.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan data! ".mysqli_error($conn)."'); window.location.href='tambahekskul_admin3.php';</script>";
    }
} else {
    header("Location: tambahekskul_admin3.php");
    exit;
}
?>
