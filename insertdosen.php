<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Projek UTS - Input Dosen</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<?php include('header.php'); ?>
	<div class="style">

		<div class="container">
			<h2>Input Dosen</h2>
			<form method="post" enctype="multipart/form-data" action="insertdosen_proses.php">
				<div>
					<label for="nama">Nama:</label>
					<input type="text" id="nama" name="txtnama" required>
				</div>

				<div>
					<label for="npk">NPK:</label>
					<input type="text" id="npk" name="txtnpk" maxlength="6" required>
				</div>

				<div>
					<label for="password">Password:</label>
					<input type="text" id="password" name="txtpassword" placeholder="buat password" required>
				</div>

				<div>
					<label for="gambar">Gambar:</label>
					<input type="file" id="gambar" name="gambar" accept="image/*">
				</div>

				<input type="submit" name="submit" value="Insert Dosen">
			</form>

			<a href="index.php">⬅ Kembali ke Home</a>
		</div>
	</div>
</body>

</html>