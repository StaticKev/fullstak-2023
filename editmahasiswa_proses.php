<?php
    require_once ("conn.php");

    $nrp = $_POST['txt_nrp'];
    $nama = $_POST['txt_nama'];
    $gender = $_POST['rad_gender'];
    $tanggal_lahir = $_POST['date_tanggal_lahir'];
    $angkatan = $_POST['txt_angkatan'];
    $password = $_POST['txt_password'];
    $foto_extention = "";

	if (isset($_FILES['img_gambar']) && $_FILES['img_gambar']['error'] == 0) {
        $sql = "SELECT foto_extention FROM mahasiswa WHERE nrp=?";
        $stmt = $con->prepare($sql);
        $stmt -> bind_param("s", $nrp);
        $stmt -> execute();

        $res = $stmt -> get_result();
        $row = $res->fetch_assoc();
        $old_extention = $row['foto_extention'];
        $gambar_old = "gambar/mahasiswa/$nrp.$old_extention";

        if (file_exists($gambar_old)) {
            unlink($gambar_old); 
            echo "File berhasil dihapus.";
        } else {
            echo "Gambar lama tidak ada.";
        }

		$gambar = $_FILES['img_gambar'];
		$ext = pathinfo($gambar['name'], PATHINFO_EXTENSION);
		$dst = "gambar/mahasiswa/$nrp.$ext";
		move_uploaded_file($gambar['tmp_name'], $dst);
		$foto_extention = $ext;
	} else {
        $sql = "SELECT foto_extention FROM mahasiswa WHERE nrp=?";
        $stmt = $con->prepare($sql);
        $stmt -> bind_param("s", $nrp);
        $stmt -> execute();

        $res = $stmt -> get_result();
        $row = $res->fetch_assoc();
        $foto_extention = $row['foto_extention'];
    }

    $sql2 = "UPDATE mahasiswa SET nama=?, gender=?, tanggal_lahir=?, angkatan=?, foto_extention=? WHERE nrp=?";
    $stmt2 = $con->prepare($sql2);
    $stmt2 -> bind_param('ssssss', $nama, $gender, $tanggal_lahir, $angkatan, $foto_extention, $nrp);

    $sql3 = "UPDATE akun SET password=? WHERE nrp_mahasiswa=?";
    $stmt3 = $con->prepare($sql3);
    $stmt3 -> bind_param('ss', $password, $nrp);

	ob_start();
	if ($stmt2->execute() && $stmt3->execute()) {   
		echo "<p>Update Sukses.</p>";
	}
	else {
		echo "<p>Update Gagal.</p>";
	}
	echo "<a href='tampilanmahasiswa.php'>Kembali ke tampilan Mahasiswa</a>";
	$output = ob_get_clean();
	$con->close();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Projek UTS - Proses Edit Mahasiswa</title>
	<style>
		body {
			margin: 0;
			height: 100vh;
			display: flex;
			justify-content: center;
			align-items: center;
			font-family: 'Segoe UI', sans-serif;
			background: #111;
			background-image: radial-gradient(circle at top left, #1c1c1c 0%, #000 80%);
			color: #fff;
		}

		.result-box {
			background: rgba(20, 20, 20, 0.9);
			padding: 40px;
			border-radius: 20px;
			width: 400px;
			text-align: center;
			box-shadow: 0 0 16px #00bcd4;
			backdrop-filter: blur(6px);
			animation: glow 2s infinite alternate;
		}

		@keyframes glow {
			0%   { box-shadow: 0 0 8px #00bcd4; }
			50%  { box-shadow: 0 0 16px #0097a7; }
			100% { box-shadow: 0 0 8px #00bcd4; }
		}

		h2 {
			margin-bottom: 25px;
			color: #00e5ff;
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
			background: linear-gradient(135deg, #00bcd4, #0097a7);
			color: #fff;
			font-weight: bold;
			border-radius: 10px;
			text-decoration: none;
			transition: 0.3s;
		}

		a:hover {
			transform: scale(1.05);
			background: linear-gradient(135deg, #0097a7, #00bcd4);
		}
	</style>
</head>
<body>
	<div class="result-box">
		<h2>HASIL UPDATE MAHASISWA</h2>
		<?php echo $output; ?>
	</div>
</body>
</html>
