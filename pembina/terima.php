<?php
require_once __DIR__ . '/../koneksi.php';


if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Update status jadi Diterima
    $update = mysqli_query($conn, 
        "UPDATE tbdaftar SET status='Diterima' WHERE id_daftar='$id'"
    );

    if ($update) {
        echo "<script>
                alert('Pendaftaran berhasil DITERIMA!');
                window.location='pembina3.php';
              </script>";
    } else {
        echo "<script>alert('Gagal memproses!'); window.history.back();</script>";
    }
}
?>
