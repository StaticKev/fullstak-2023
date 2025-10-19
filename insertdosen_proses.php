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

	ob_start(); // mulai tampung output biar bisa dimasukkan ke dalam HTML nanti

	if ($stmt) {
		$password = $_POST['txtpassword']; 
		$username = "D$npk";
		$nrp_mahasiswa = NULL; 
		$npk_dosen = $npk; 
		$isadmin = 0;

		$sqlAkun = "INSERT INTO akun(username, password, nrp_mahasiswa, npk_dosen, isadmin) 
					VALUES (?, ?, ?, ?, ?)";
		$stmtAkun = $con->prepare($sqlAkun);
		$stmtAkun->bind_param("ssssi", $username, $password, $nrp_mahasiswa, $npk_dosen, $isadmin);
		$stmtAkun->execute();

		if ($stmtAkun) {
			echo "<p class='success'>Akun dosen <b>$nama</b> berhasil ditambahkan.</p>";
		} else {
			echo "<p class='error'>Gagal insert akun: " . $con->error . "</p>";
		}
	}
	else {
		echo "<p class='error'>Insert Gagal.</p>";
	}

	echo "<a href='index.php' class='back-btn'>Kembali ke Index</a>";
	
	$con->close();
	$content = ob_get_clean();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Insert Dosen</title>
	<style>
		body {
			background-color: #121212;
			color: #eee;
			font-family: 'Segoe UI', sans-serif;
			display: flex;
			justify-content: center;
			align-items: center;
			height: 100vh;
			margin: 0;
		}
		.container {
			background: #1f1f1f;
			border-radius: 10px;
			padding: 30px 50px;
			text-align: center;
			box-shadow: 0 0 15px rgba(0,0,0,0.4);
			max-width: 500px;
		}
		.success { color: #eee; font-size: 1.1em; margin-bottom: 10px; }
		.error { color: #ff5252; font-size: 1.1em; margin-bottom: 10px; }
		.back-btn {
			display: inline-block;
			margin-top: 15px;
			text-decoration: none;
			color: white;
			background: #2196f3;
			padding: 10px 20px;
			border-radius: 6px;
			transition: 0.2s;
		}
		.back-btn:hover { background: #0d8bf2; }
	</style>
</head>
<body>
	<?php include('header.php'); ?> 
	<div class="container">
		<?= $content ?>
	</div>
</body>
</html>
