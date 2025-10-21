<?php
	require_once ("conn.php");

    $nrp = $_POST['txt_nrp'];
    $nama = $_POST['txt_nama'];
    $gender = $_POST['rad_gender'];
    $tanggal_lahir = $_POST['date_tanggal_lahir'];
    $angkatan = $_POST['txt_angkatan'];
    $foto_extention = "";

	if (isset($_FILES['img_gambar']) && $_FILES['img_gambar']['error'] == 0) {
		$gambar = $_FILES['img_gambar'];
		$ext = pathinfo($gambar['name'], PATHINFO_EXTENSION);
		$dst = "gambar/mahasiswa/$nrp.$ext";
		move_uploaded_file($gambar['tmp_name'], $dst);
		$foto_extention = $ext;
	}

    $sql = "INSERT INTO mahasiswa (nrp, nama, gender, tanggal_lahir, angkatan, foto_extention) VALUES (?,?,?,?,?,?)";
    $stmt = $con->prepare($sql);
	$stmt -> bind_param('ssssss', $nrp, $nama, $gender, $tanggal_lahir, $angkatan, $foto_extention);
	$stmt -> execute();

	if ($stmt) {
		echo "Insert Sukses.";
		$password = $_POST['txt_password']; 
		$username = "M$nrp";
		$nrp_mahasiswa = $nrp; 
		$npk_dosen = NULL; 
		$isadmin = 0;

		$sqlAkun = "INSERT INTO akun(username, password, nrp_mahasiswa, npk_dosen, isadmin) 
					VALUES (?, ?, ?, ?, ?)";
		$stmtAkun = $con->prepare($sqlAkun);
		$stmtAkun->bind_param("sssii", $username, $password, $nrp_mahasiswa, $npk_dosen, $isadmin);
		$stmtAkun->execute();

		if ($stmtAkun) {
			echo " Akun berhasil ditambahkan.";
		} else {
			echo " Gagal insert akun: " . $con->error;
		}
	}
	else {
		echo "Insert Gagal.";
	}
	echo "<br><a href='index.php'>Back to Index</a>";
	
	$con->close();
?>