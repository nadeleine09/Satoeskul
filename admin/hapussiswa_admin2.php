<?php
include '../koneksi.php';

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $sql = "DELETE FROM tbsiswa WHERE id_siswa = '$id'";

    if (mysqli_query($conn, $sql)) {
        echo "
            <script>
                alert('Data siswa berhasil dihapus!');
                window.location.href='admin2.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Gagal menghapus data!');
                window.location.href='admin2.php';
            </script>
        ";
    }

} else {
    header("Location: admin2.php");
    exit();
}
?>
