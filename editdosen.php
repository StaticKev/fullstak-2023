<?php
    require_once ("conn.php");

    $npk = $_GET['npk'];

    $sql = "SELECT d.nama, d.npk, a.password FROM dosen d INNER JOIN akun a ON d.npk = a.npk_dosen WHERE d.npk=?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $npk);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $nama = $row['nama'];
        $password = $row['password'];
        $NPK = $row['npk'];
    } else {
        echo "Data dosen tidak ditemukan.";
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
	<title>Projek UTS - Edit Dosen</title>
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

		.edit-container {
			background: rgba(20, 20, 20, 0.9);
			padding: 40px;
			border-radius: 20px;
			box-shadow: 0 0 16px #ccc;
			width: 400px;
			backdrop-filter: blur(6px);
			text-align: center;
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

		form {
			display: flex;
			flex-direction: column;
			gap: 15px;
		}

		input[type="text"],
		input[type="file"],
		input[type="password"] {
			width: 100%;
			padding: 12px;
			border-radius: 10px;
			border: none;
			background: #2e2e2e;
			color: #fff;
			box-sizing: border-box;
		}

		input[type="text"]:focus {
			outline: none;
			box-shadow: 0 0 8px #ffffff;
		}

		input[type="submit"] {
			background: linear-gradient(135deg, #ffffff, #cccccc);
			color: #000;
			font-weight: bold;
			cursor: pointer;
			border: none;
			border-radius: 10px;
			padding: 12px;
			transition: 0.3s;
			letter-spacing: 1px;
		}

		input[type="submit"]:hover {
			transform: scale(1.05);
			background: linear-gradient(135deg, #cccccc, #ffffff);
		}

		a {
			display: block;
			margin-top: 20px;
			color: #aaa;
			text-decoration: none;
			font-size: 14px;
			transition: color 0.3s;
		}

		a:hover {
			color: #fff;
		}
	</style>
</head>
<body>
    <?php include('header.php'); ?> 
	<div class="edit-container">
		<h2>EDIT DOSEN</h2>
		<form method="post" enctype="multipart/form-data" action="editdosen_proses.php">
			<input type="text" name="txt_nama" value="<?php echo $nama; ?>" placeholder="Nama">
			<input type="text" name="txt_npk" maxlength="6" value="<?php echo $NPK; ?>" readonly>
			<input type="text" name="txt_password" placeholder="Password" value="<?php echo $password; ?>">
			<input type="file" name="img_gambar" accept="image/*">
			<input type="submit" name="submit" value="Edit Dosen">
		</form>
		<a href="tampilandosen.php">Kembali ke Daftar Dosen</a>
	</div>
</body>
</html>
