<?php
include '../koneksi.php';

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $sql = "DELETE FROM tbekskul WHERE id_ekskul = '$id'";

    if (mysqli_query($conn, $sql)) {
        echo "
            <script>
                alert('Data berhasil dihapus!');
                window.location.href='admin3.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Gagal menghapus data!');
                window.location.href='admin3.php';
            </script>
        ";
    }

} else {
    header('Location: admin3.php');
    exit();
}
?>
