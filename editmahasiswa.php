<?php
    require_once ("service/mahasiswa.php");
    $objMahasiswa = new mahasiswa();

    $nrp = $_GET['nrp'];

    $result = $objMahasiswa->getAllMahasiswa($nrp);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $NRP = $row['nrp'];
        $nama = $row['nama'];
        $gender = $row['gender'];
        $tanggal_lahir = $row['tanggal_lahir'];
        $angkatan = $row['angkatan'];
        $ext = $row['foto_extention'];

        $gambar = "gambar/mahasiswa/$NRP.$ext";
    } else {
        echo "Data mahasiswa tidak ditemukan.";
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Projek UTS - Edit Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="style">
        <div class="container">
            <form method="post" enctype="multipart/form-data" action="editmahasiswa_proses.php">
                Nama: <input type="text" name="txt_nama" value="<?php echo $nama; ?>"><br>
                NRP: <input type="text" name="txt_nrp" maxlength="9" value="<?php echo $NRP; ?>" readonly><br>
                Gender: 
                <input type="radio" name="rad_gender" value="Pria" <?php if($gender == "Pria") echo "checked"; ?>>Pria
                <input type="radio" name="rad_gender" value="Wanita" <?php if($gender == "Wanita") echo "checked"; ?>>Wanita
                <br>
                Tanggal Lahir: <input type="date" name="date_tanggal_lahir" value="<?php echo $tanggal_lahir; ?>"><br>
                Angkatan: <input type="text" name="txt_angkatan" value="<?php echo $angkatan; ?>"><br>
                Gambar: <input type="file" name="img_gambar" accept="image/*"><br>
                <img src="<?php echo $gambar; ?>" width="100" height="100" alt="profile"><br>
                <input type="submit" name="submit" value="Edit Mahasiswa">
            </form>
        </div>
    </div>
</body>
</html>