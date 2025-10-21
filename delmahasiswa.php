<?php
    require_once ("conn.php");

    $nrp = $_GET['nrp'];
    $username = "M".$nrp;
    
    $sqlNama = "SELECT nama, foto_extention FROM mahasiswa WHERE nrp=?";
    $stmt = $con->prepare($sqlNama);
    $stmt->bind_param("s", $nrp);
    $stmt->execute();
    $result = $stmt->get_result();

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
            echo "Mahasiswa $nama berhasil dihapus.<br>";
        } else {
            echo "Gagal menghapus Mahasiswa $nama .<br>";
        }
    }
    else {
        echo "Data mahasiswa dengan NPK $npk tidak ditemukan.";
        exit();
    }

    echo "<a href='tampilanmahasiswa.php'>Kembali ke Tampilan Mahasiswa</a>";

    $stmt->close();
    $con->close();
?>