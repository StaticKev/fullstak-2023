<?php
	require_once ("conn.php");

	$npk = $_POST['txtnpk'];
	$nama = $_POST['txtnama'];
	$foto_extention = "";

	//UPLOAD GAMBAR
	if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
		$gambar = $_FILES['gambar'];
		$ext = pathinfo($gambar['name'], PATHINFO_EXTENSION);
		$dst = "gambar/dosen/$npk.$ext";
		move_uploaded_file($gambar['tmp_name'], $dst);
		$foto_extention = $ext;
	}


	$sql = "INSERT INTO dosen(npk, nama, foto_extension) VALUES(?,?,?)";
	$stmt = $con->prepare($sql);
	$stmt->bind_param('sss',$npk,$nama,$foto_extention);
	$stmt->execute();

	if ($stmt) {
		$hashed_password = password_hash($_POST['txtpassword'], PASSWORD_DEFAULT); 
		$username = "D$npk";
		$nrp_mahasiswa = NULL; 
		$npk_dosen = $npk; 
		$isadmin = 0;

		$sqlAkun = "INSERT INTO akun(username, password, nrp_mahasiswa, npk_dosen, isadmin) 
					VALUES (?, ?, ?, ?, ?)";
		$stmtAkun = $con->prepare($sqlAkun);
		$stmtAkun->bind_param("ssssi", $username, $hashed_password, $nrp_mahasiswa, $npk_dosen, $isadmin);
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
