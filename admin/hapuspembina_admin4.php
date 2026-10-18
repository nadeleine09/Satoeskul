<?php
require_once __DIR__ . '/../koneksi.php';


if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $sql = "DELETE FROM tbpembina WHERE id_pembina = '$id'";

    if (mysqli_query($conn, $sql)) {
        echo "
            <script>
                alert('Data berhasil dihapus!');
                window.location.href='admin4.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Gagal menghapus data!');
                window.location.href='admin4.php';
            </script>
        ";
    }

} else {
    header('Location: admin4.php');
    exit();
}
?>
