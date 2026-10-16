<?php
include '../koneksi.php';

$id_siswa   = $_POST['id_siswa'];
$nama       = $_POST['nama'];
$kelas      = $_POST['kelas'];
$jurusan    = $_POST['jurusan'];
$username   = $_POST['nis'];
$notelp     = $_POST['notelp'];

$sql = "UPDATE tbsiswa SET
            nama='$nama',
            kelas='$kelas',
            jurusan='$jurusan',
            nis='$username',
            notelp='$notelp'
        WHERE id_siswa='$id_siswa'";

if (mysqli_query($conn, $sql)) {
    echo "
        <script>
        alert('Data siswa berhasil diubah!');
        window.location.href='admin2.php';
        </script>
    ";
} else {
    echo "
        <script>
        alert('Gagal mengubah data!');
        window.location.href='admin2.php?id=$id_siswa';
        </script>
    ";
}
?>
