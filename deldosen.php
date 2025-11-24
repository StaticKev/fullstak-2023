<?php
    require_once ("service/dosen.php");
    require_once ("service/akun.php");
    $objDosen = new dosen();
    $objAkun = new akun();

    $npk = $_GET['npk'];
    $username = "D".$npk;
    
    $result = $objDosen->getAllDosen($npk);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $nama = $row['nama'];
        $ext = $row['foto_extension'];
    
        if($objAkun->deleteAkun($username) && $objDosen->deleteDosen($npk)) {

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

?>