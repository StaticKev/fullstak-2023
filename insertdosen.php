<?php
session_start();

if($_SESSION['admin'] == 0) {
	require_once ('service/404.php');
}

?>

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
			<form method="post" enctype="multipart/form-data" action="insertdosen_proses.php" onsubmit="return validateForm()">
				<div>
					<label for="nama">Nama:</label>
					<input type="text" id="nama" name="txtnama">
				</div>

				<div>
					<label for="npk">NPK:</label>
					<input type="text" id="npk" name="txtnpk" maxlength="6">
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

	<script>
	function validateForm() {
		const nama = document.getElementById('nama').value;
		const npk = document.getElementById('npk').value;

		// Cek nama
		if (nama === "") {
			alert("Nama tidak boleh kosong!");
			return false;
		}

		// Cek NPK harus angka dan tidak kosong
		if (npk === "" || isNaN(npk)) {
			alert("NPK harus berupa angka!");
			return false;
		}

		return true; 
	}
	</script>

</body>

</html>