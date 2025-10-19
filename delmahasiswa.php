<?php
    require_once ("conn.php");

    $nrp = $_GET['nrp'];
    $username = "M".$nrp;
    
    $sqlNama = "SELECT nama, foto_extention FROM mahasiswa WHERE nrp=?";
    $stmt = $con->prepare($sqlNama);
    $stmt->bind_param("s", $nrp);
    $stmt->execute();
    $result = $stmt->get_result();

    ob_start(); // mulai buffer output agar echo bisa ditaruh dalam <div>
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $nama = $row['nama'];
        $ext = $row['foto_extention'];

        $sqlAkun = "DELETE FROM akun WHERE username=?";
        $stmtAkun = $con->prepare($sqlAkun);
        $stmtAkun->bind_param("s", $username);
        
        $sqlMhs = "DELETE FROM mahasiswa WHERE nrp=?";
        $stmtMhs = $con->prepare($sqlMhs);
        $stmtMhs->bind_param("s", $nrp);
    
        if($stmtAkun->execute() && $stmtMhs->execute()) {
            $filePath = "gambar/mahasiswa/$nrp.$ext";
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            echo "<p class='success'>Mahasiswa <b>$nama</b> berhasil dihapus.</p>";
        } else {
            echo "<p class='error'>Gagal menghapus Mahasiswa <b>$nama</b>.</p>";
        }
    }
    else {
        echo "<p class='error'>Data mahasiswa dengan NRP $nrp tidak ditemukan.</p>";
        exit();
    }

    echo "<a href='tampilanmahasiswa.php' class='back-btn'>Kembali ke Tampilan Mahasiswa</a>";

    $stmt->close();
    $con->close();

    $content = ob_get_clean();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hapus Mahasiswa</title>
    <style>
        body {
            background-color: #121212;
            color: #eee;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 60px;
        }
        .container {
            background: #1f1f1f;
            border-radius: 10px;
            padding: 30px 50px;
            text-align: center;
            box-shadow: 0 0 15px rgba(0,0,0,0.4);
        }
        .success { color: #eee; font-size: 1.2em; }
        .error { color: #ff5252; font-size: 1.2em; }
        .back-btn {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: white;
            background: #2196f3;
            padding: 10px 20px;
            border-radius: 6px;
            transition: 0.2s;
        }
        .back-btn:hover { background: #0d8bf2; }
    </style>
</head>
<body>
    <?php include('header.php'); ?> 
    <div class="container">
        <?= $content ?>
    </div>
</body>
</html>
