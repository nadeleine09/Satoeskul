<?php
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama = mysqli_real_escape_string($conn, $_POST['nama_pembina']);
    $nip = mysqli_real_escape_string($conn, $_POST['nip']);
    $telepon = mysqli_real_escape_string($conn, $_POST['telepon']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "
        INSERT INTO tbpembina (nama_pembina, nip, telepon, password)
        VALUES ('$nama', '$nip', '$telepon', '$password')
    ";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Data pembina berhasil ditambahkan!');
                window.location.href='admin4.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menambahkan data!');
                window.location.href='tambahpembina_admin4.php';
              </script>";
    }

} else {
    header("Location: tambahpembina_admin4.php");
    exit;
}
?>
