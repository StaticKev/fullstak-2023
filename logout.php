<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

// Jika tombol logout ditekan
if (isset($_POST['logout'])) {
    session_unset();      // Hapus semua variabel session
    session_destroy();    // Hapus session dari server
    header("Location: login_temp.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Logout</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Apakah Anda yakin ingin logout?</h2>

        <form method="post">
            <button type="submit" name="logout" class="btn">Logout</button>
            <a href="index.php" class="btn" style="display:inline-block; text-align:center;">Batal</a>
        </form>

        <a href="index.php" class="logout">← Kembali ke Home</a>
    </div>
</body>
</html>
