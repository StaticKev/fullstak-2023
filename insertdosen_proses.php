<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Insert Dosen</title>
	<link rel="stylesheet" href="style.css">
	<style>

	</style>
</head>

<body>
	<?php
	include('header.php');
	require_once("conn.php");

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

	// Cek apakah NPK sudah ada
	$sql_check = "SELECT npk FROM dosen WHERE npk = ?";
	$stmt_check = $con->prepare($sql_check);
	$stmt_check->bind_param("s", $npk);
	$stmt_check->execute();
	$result = $stmt_check->get_result();

	if ($result->num_rows > 0) {
		// NPK sudah ada → tampilkan alert dan kembali ke form
		echo "<script>
				alert('NPK sudah terdaftar!');
				window.location.href = 'insertdosen.php';
			</script>";
		exit();
	}


	$sql = "INSERT INTO dosen(npk, nama, foto_extension) VALUES(?,?,?)";
	$stmt = $con->prepare($sql);
	$stmt->bind_param('sss', $npk, $nama, $foto_extention);
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
		$stmtAkun->execute(); ?>

		<div class="style">
			<div class="container">

		<?php
		if ($stmtAkun) {
			echo "<p class='success'>Akun dosen <b>$nama</b> berhasil ditambahkan.</p>";
		} else {
			echo "<p class='error'>Gagal insert akun: " . $con->error . "</p>";
		}
	} 
	else {
		echo "<p class='error'>Insert Gagal.</p>";
	}
	echo "<a href='index.php' class='back-btn'>Kembali ke Home</a>";

	$con->close();
	?>
		</div>
	</div>

</body>

</html>