<?php
    require_once ("conn.php");

    $npk = $_GET['npk'];
    $username = "D".$npk;
    
    $sqlNama = "SELECT nama, foto_extension FROM dosen WHERE npk=?";
    $stmt = $con->prepare($sqlNama);
    $stmt->bind_param("s", $npk);
    $stmt->execute();
    $result = $stmt->get_result();

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
    
        if($stmtAkun->execute() && $stmtDosen->execute()) {
            $filePath = "gambar/dosen/$npk.$ext";
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            echo "Dosen $nama berhasil dihapus.<br>";
        } else {
            echo "Gagal menghapus Dosen $nama .<br>";
        }
    }
    else {
        echo "Data dosen dengan NPK $npk tidak ditemukan.";
        exit();
    }

    echo "<a href='tampilandosen.php'>Kembali ke Tampilan Dosen</a>";

    $stmt->close();
    $con->close();
?>