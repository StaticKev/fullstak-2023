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

	ob_start();
	if ($stmt) {
		echo "<p>Insert Sukses.</p>";
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
			echo "<p>Akun berhasil ditambahkan.</p>";
		} else {
			echo "<p>Gagal insert akun: " . $con->error . "</p>";
		}
	}
	else {
		echo "<p>Insert Gagal.</p>";
	}
	echo "<a href='index.php'>Back to Index</a>";

	$output = ob_get_clean();
	$con->close();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Projek UTS - Proses Insert Mahasiswa</title>
<style>
	body {
		margin: 0;
		height: 100vh;
		display: flex;
		justify-content: center;
		align-items: center;
		font-family: 'Segoe UI', sans-serif;
		background: #111;
		background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='40' height='40' viewBox='0 0 40 40'%3E%3Cg fill='none' stroke='%23333' stroke-width='1'%3E%3Cpath d='M20 0v40M0 20h40'/%3E%3C/g%3E%3C/svg%3E");
		background-size: 40px 40px;
		color: #fff;
	}
	.result-box {
		background: rgba(20, 20, 20, 0.9);
		padding: 40px;
		border-radius: 20px;
		width: 400px;
		text-align: center;
		box-shadow: 0 0 16px #ccc;
		backdrop-filter: blur(6px);
		animation: glow 2s infinite alternate;
	}
	@keyframes glow {
		0%   { box-shadow: 0 0 8px #ffffff; }
		50%  { box-shadow: 0 0 16px #cccccc; }
		100% { box-shadow: 0 0 8px #ffffff; }
	}
	h2 {
		margin-bottom: 25px;
		color: #ffffff;
		font-size: 26px;
		letter-spacing: 2px;
	}
	p {
		font-size: 18px;
		margin: 15px 0;
	}
	a {
		display: inline-block;
		margin-top: 20px;
		padding: 10px 20px;
		background: linear-gradient(135deg, #ffffff, #cccccc);
		color: #000;
		font-weight: bold;
		border-radius: 10px;
		text-decoration: none;
		transition: 0.3s;
	}
	a:hover {
		transform: scale(1.05);
		background: linear-gradient(135deg, #cccccc, #ffffff);
	}
</style>
</head>
<body>
    <?php include('header.php'); ?> 
	<div class="result-box">
		<h2>HASIL INSERT MAHASISWA</h2>
		<?php echo $output; ?>
	</div>
</body>
</html>
