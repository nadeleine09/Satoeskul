<?php
// Jika file ini di folder signup/, gunakan include '../koneksi.php';
include '../koneksi.php'; // ganti path sesuai lokasi koneksi.php

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ambil input dan bersihkan sederhana
    $nama = trim($_POST['nama']);
    $username = trim($_POST['username']);
    $password_plain = $_POST['password'];
    $notelp = trim($_POST['notelp']);

    // validasi sederhana
    if ($nama === '' || $username === '' || $password_plain === '') {
        $error = "Nama, username, dan password wajib diisi.";
    } else {
        // cek username sudah ada di tb_pembina?
        $check = mysqli_prepare($conn, "SELECT username FROM tbpembina WHERE username = ?");
        mysqli_stmt_bind_param($check, "s", $username);
        mysqli_stmt_execute($check);
        mysqli_stmt_store_result($check);

        if (mysqli_stmt_num_rows($check) > 0) {
            $error = "Username sudah terpakai. Pilih username lain.";
            mysqli_stmt_close($check);
        } else {
            mysqli_stmt_close($check);

            // hash password
            $password_hashed = password_hash($password_plain, PASSWORD_DEFAULT);

            // insert aman dengan prepared statement
            $stmt = mysqli_prepare($conn, "INSERT INTO tbpembina (nama, username, password, notelp) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "ssss", $nama, $username, $password_hashed, $notelp);

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                echo "<script>alert('Pendaftaran pembina berhasil. Silakan login.'); window.location = '../login.php';</script>";
                exit;
            } else {
                $error = "Gagal menyimpan data: " . htmlspecialchars(mysqli_error($conn));
                mysqli_stmt_close($stmt);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Sign Up Guru</title>
<style>
    body {
        margin: 0;
        font-family: 'Poppins', sans-serif;
        background-color: #464ba3;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    form {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .card {
        background: #fff;
        width: 320px;
        padding: 40px 30px;
        border-radius: 20px;
        box-shadow: 6px 6px 0 #2f3170;
        text-align: center;
    }
    h2 {
        margin-bottom: 25px;
        font-size: 22px;
        font-weight: 700;
        letter-spacing: 1px;
    }
    input {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: none;
        border-radius: 6px;
        background-color: #eaeaea;
        font-size: 13px;
        box-sizing: border-box;
    }
    input::placeholder {
        color: #888;
    }
    button {
        width: 100%;
        padding: 10px;
        background-color: #464ba3;
        color: #fff;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
    }
    button:hover {
        background-color: #353a8a;
    }
    a {
        text-decoration: none;
        color: #333;
        font-size: 13px;
    }
</style>
</head>
<body>
    <div class="card">
        <h2>SIGN UP</h2>
        <form method="POST">
            <input type="text" name="nama" placeholder="NAMA" required>
            <input type="text" name="username" placeholder="NIP" required>
            <input type="text" name="ekstra" placeholder="EKSTRAKURIKULER YANG DIBINA" required>
            <input type="email" name="email" placeholder="EMAIL" required>
            <input type="text" name="notelp" placeholder="NO.TELP" required>
            <input type="password" name="password" placeholder="PASSWORD" required>
            <button type="submit">SIGN UP</button>
        </form>
    </div>
</body>
</html>