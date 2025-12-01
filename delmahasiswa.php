<?php
    require_once ("service/mahasiswa.php");
    require_once ("service/akun.php");
    $objMahasiswa = new mahasiswa();
    $objAkun = new akun();

    $nrp = $_GET['nrp'];
    $username = "M".$nrp;
    
    $result = $objMahasiswa->getAllMahasiswa($nrp);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $nama = $row['nama'];
        $ext = $row['foto_extention'];

        if($objAkun->deleteAkun($username) && $objMahasiswa->deleteMahasiswa($nrp)) {
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

?>