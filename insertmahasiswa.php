<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Projek UTS - Input Mahasiswa</title>
	<style>
		body {
			background-color: #121212;
			color: #f1f1f1;
			font-family: "Segoe UI", sans-serif;
			display: flex;
			flex-direction: column;
			align-items: center;
			min-height: 100vh;
			margin: 0;
		}
		.container {
			background: #1e1e1e;
			padding: 40px 60px;
			border-radius: 12px;
			box-shadow: 0 0 15px rgba(0,0,0,0.5);
			max-width: 500px;
			width: 100%;
			text-align: left;
			margin-top: 6px; /* jarak dari header */
		}
		h2 {
			text-align: center;
			color: #00bcd4;
			margin-bottom: 25px;
		}
		input[type="text"],
		input[type="password"],
		input[type="date"],
		input[type="file"] {
			width: 100%;
			padding: 10px;
			margin: 8px 0 16px 0;
			background: #2a2a2a;
			border: none;
			border-radius: 6px;
			color: white;
		}
		input[type="radio"] {
			margin-right: 5px;
		}
		label {
			font-weight: 500;
		}
		input[type="submit"] {
			background-color: #00bcd4;
			color: white;
			padding: 12px 20px;
			border: none;
			border-radius: 6px;
			cursor: pointer;
			width: 100%;
			font-weight: bold;
			transition: 0.2s;
		}
		input[type="submit"]:hover {
			background-color: #0097a7;
		}
	</style>
</head>
<body>
	<?php include('header.php'); ?> <!-- Tambahin ini aja -->

	<div class="container">
		<h2>Input Data Mahasiswa</h2>
		<form method="post" enctype="multipart/form-data" action="insertmahasiswa_proses.php">
			<label>NRP:</label>
			<input type="text" maxlength="9" name="txt_nrp">

			<label>Nama:</label>
			<input type="text" name="txt_nama">

			<label>Password:</label>
			<input type="text" name="txt_password" placeholder="buat password">

			<label>Gender:</label><br>
			<input type="radio" name="rad_gender" value="Pria">Pria
			<input type="radio" name="rad_gender" value="Wanita">Wanita
			<br><br>

			<label>Tanggal Lahir:</label>
			<input type="date" name="date_tanggal_lahir">

			<label>Angkatan:</label>
			<input type="text" name="txt_angkatan">

			<label>Gambar:</label>
			<input type="file" name="img_gambar" accept="image/*">

			<input type="submit" name="submit" value="Insert Mahasiswa">
		</form>
	</div>
</body>
</html>
