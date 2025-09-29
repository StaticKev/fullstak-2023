<?php
    require_once ("conn.php");

    $nrp = $_GET['nrp'];

    $sql = "SELECT m.nrp, m.nama, m.gender, m.tanggal_lahir, m.angkatan, m.foto_extention, a.password FROM mahasiswa m INNER JOIN akun a ON m.nrp = a.nrp_mahasiswa WHERE m.nrp=?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $nrp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $NRP = $row['nrp'];
        $nama = $row['nama'];
        $gender = $row['gender'];
        $tanggal_lahir = $row['tanggal_lahir'];
        $angkatan = $row['angkatan'];
        $foto_extention = $row['foto_extention'];
        $password = $row['password'];
    } else {
        echo "Data mahasiswa tidak ditemukan.";
        exit();
    }
    $stmt->close();
    $con->close();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Projek UTS - Edit Mahasiswa</title>
</head>
<body>
	<form method="post" enctype="multipart/form-data" action="editmahasiswa_proses.php">
		Nama: <input type="text" name="txt_nama" value="<?php echo $nama; ?>"><br>
		NRP: <input type="text" name="txt_nrp" maxlength="9" value="<?php echo $NRP; ?>" readonly><br>
		Password: <input type="text" name="txt_password" placeholder="buat password " value="<?php echo $password; ?>"><br>
        Gender: 
        <input type="radio" name="rad_gender" value="Pria" <?php if($gender == "Pria") echo "checked"; ?>>Pria
        <input type="radio" name="rad_gender" value="Wanita" <?php if($gender == "Wanita") echo "checked"; ?>>Wanita
        <br>
        Tanggal Lahir: <input type="date" name="date_tanggal_lahir" value="<?php echo $tanggal_lahir; ?>"><br>
        Angkatan: <input type="text" name="txt_angkatan" value="<?php echo $angkatan; ?>"><br>
		Gambar: <input type="file" name="img_gambar" accept="image/*"><br>
		<input type="submit" name="submit" value="Edit Mahasiswa">
	</form>
</body>
</html>