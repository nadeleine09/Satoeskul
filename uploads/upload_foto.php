<?php
include '../koneksi.php';

if(isset($_FILES['foto']) && isset($_POST['id_ekskul'])) {
    $id_ekskul = $_POST['id_ekskul'];
    
    $file_name = $_FILES['foto']['name'];
    $file_tmp = $_FILES['foto']['tmp_name'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    // Boleh batasi ekstensi
    $allowed = ['jpg','jpeg','png','gif'];
    if(in_array($file_ext, $allowed)) {
        // Nama file unik supaya tidak overwrite
        $new_name = uniqid('foto_', true) . '.' . $file_ext;
        $upload_dir = '../uploads/'; // folder tempat menyimpan
        $upload_path = $upload_dir . $new_name;

        if(move_uploaded_file($file_tmp, $upload_path)) {
            // Update nama file di db
            $sql = "UPDATE tbekskul SET foto='$new_name' WHERE id_ekskul='$id_ekskul'";
            if(mysqli_query($conn, $sql)) {
                echo "Upload berhasil!";
                header("Location: pembina4.php"); // redirect ke halaman daftar ekskul
            } else {
                echo "Gagal update database: " . mysqli_error($conn);
            }
        } else {
            echo "Gagal upload file";
        }
    } else {
        echo "Ekstensi file tidak diperbolehkan!";
    }
} else {
    echo "Tidak ada file yang diunggah";
}
?>
