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
	require_once("service/dosen.php");
	require_once("service/akun.php");
	$objDosen = new dosen();
	$objAkun = new akun();

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
	$result = $objDosen->getAllDosen($npk);

	if ($result->num_rows > 0) {
		// NPK sudah ada → tampilkan alert dan kembali ke form
		echo "<script>
				alert('NPK sudah terdaftar!');
				window.location.href = 'insertdosen.php';
			</script>";
		exit();
	}


	if ($objDosen -> insertDosen($npk, $nama, $foto_extention)) {
		$hashed_password = password_hash($_POST['txtpassword'], PASSWORD_DEFAULT);
		$username = "D$npk";
		$nrp_mahasiswa = NULL;
		$npk_dosen = $npk;
		$isadmin = 0;
		$objAkun->insertAkun($username, $hashed_password, $nrp_mahasiswa, $npk_dosen, $isadmin);

		?>

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

	?>
		</div>
	</div>

</body>

</html>