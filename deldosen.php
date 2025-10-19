<?php
require_once("conn.php");

$npk = $_GET['npk'];
$username = "D" . $npk;

$sqlNama = "SELECT nama, foto_extension FROM dosen WHERE npk=?";
$stmt = $con->prepare($sqlNama);
$stmt->bind_param("s", $npk);
$stmt->execute();
$result = $stmt->get_result();

ob_start(); // Buffer output untuk ditaruh di HTML
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $nama = $row['nama'];
    $ext = $row['foto_extension'];

    $sqlAkun = "DELETE FROM akun WHERE username=?";
    $stmtAkun = $con->prepare($sqlAkun);
    $stmtAkun->bind_param("s", $username);

    $sqlDosen = "DELETE FROM dosen WHERE npk=?";
    $stmtDosen = $con->prepare($sqlDosen);
    $stmtDosen->bind_param("s", $npk);

    if ($stmtAkun->execute() && $stmtDosen->execute()) {
        $filePath = "gambar/dosen/$npk.$ext";
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        echo "<p class='success'>✅ Dosen <b>$nama</b> berhasil dihapus.</p>";
    } else {
        echo "<p class='error'>❌ Gagal menghapus Dosen <b>$nama</b>.</p>";
    }
} else {
    echo "<p class='error'>⚠️ Data dosen dengan NPK <b>$npk</b> tidak ditemukan.</p>";
}

echo "<a href='tampilandosen.php' class='back-btn'>← Kembali ke Tampilan Dosen</a>";

$stmt->close();
$con->close();

$content = ob_get_clean();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Dosen</title>
    <style>
        body {
            background-color: #121212;
            color: #eee;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            margin-top: 100px; /* biar gak nempel navbar */
            background: rgba(31, 31, 31, 0.95);
            border-radius: 12px;
            padding: 40px 60px;
            text-align: center;
            box-shadow: 0 0 20px rgba(255,255,255,0.05);
            max-width: 600px;
        }

        .success {
            color: #4caf50;
            font-size: 1.2em;
            margin-bottom: 10px;
        }

        .error {
            color: #ff5252;
            font-size: 1.2em;
            margin-bottom: 10px;
        }

        .back-btn {
            display: inline-block;
            margin-top: 25px;
            text-decoration: none;
            color: #fff;
            background: linear-gradient(135deg, #00bcd4, #0097a7);
            padding: 12px 28px;
            border-radius: 8px;
            transition: 0.3s;
            font-weight: bold;
        }

        .back-btn:hover {
            transform: scale(1.05);
            background: linear-gradient(135deg, #0097a7, #00bcd4);
        }
    </style>
</head>
<body>
    <?php include('header.php'); ?>
    <div class="container">
        <?= $content ?>
    </div>
</body>
</html>
