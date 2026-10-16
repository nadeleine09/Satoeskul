<?php
include "../koneksi.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Update status jadi Ditolak
    $update = mysqli_query($conn, 
        "UPDATE tbdaftar SET status='Ditolak' WHERE id_daftar='$id'"
    );

    if ($update) {
        echo "<script>
                alert('Pendaftaran berhasil DITOLAK!');
                window.location='pembina3.php';
              </script>";
    } else {
        echo "<script>alert('Gagal memproses!'); window.history.back();</script>";
    }
}
?>
