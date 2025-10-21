<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Projek UTS - Input Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<?php include('header.php'); ?> <!-- Tambahin ini aja -->
<div class="style">
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

</div>
</body>
</html>