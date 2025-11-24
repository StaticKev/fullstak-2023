<?php
    require_once ("service/mahasiswa.php");
    require_once ("service/akun.php");
    $objMahasiswa = new mahasiswa();
    $objAkun = new akun();

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