<?php
session_start();
require_once __DIR__ . '/../koneksi.php';


// Ambil data dari form
$nis        = $_POST['nis'];
$id_ekskul  = $_POST['id_ekskul'];
$alasan     = $_POST['alasan'];
$tanggal    = $_POST['tgl_daftar'];

// Ambil id_siswa dari tabel tbsiswa
$qSiswa = mysqli_query($conn, "SELECT id_siswa FROM tbsiswa WHERE nis='$nis'");
$dSiswa = mysqli_fetch_assoc($qSiswa);
$id_siswa = $dSiswa['id_siswa'];

// Input ke tabel tbdaftar
$query = mysqli_query($conn,
    "INSERT INTO tbdaftar (id_siswa, id_ekskul, alasan, tgl_daftar, status)
     VALUES ('$id_siswa', '$id_ekskul', '$alasan', '$tanggal', 'Diproses')"
);

// Redirect ke notifikasi
if($query){
    header("Location: sukses.php");
} else {
    echo "Gagal menyimpan data!";
}
?>
