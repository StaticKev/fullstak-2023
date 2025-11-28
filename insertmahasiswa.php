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
	<title>Projek UTS - Input Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<?php include('header.php'); ?> <!-- Tambahin ini aja -->
	<div class="style">
		<div class="container">
			<h2>Input Data Mahasiswa</h2>
			<form method="post" enctype="multipart/form-data" action="insertmahasiswa_proses.php" onsubmit="return validateForm()">
				<label>NRP:</label>
				<input type="text" maxlength="9" name="txt_nrp" id="txt_nrp">

				<label>Nama:</label>
				<input type="text" name="txt_nama" id="txt_nama">

				<label>Password:</label>
				<input type="password" name="txt_password" placeholder="buat password"required>

				<label>Gender:</label><br>
				<div style="display: flex; gap: 10px; align-items: center;">
					<label><input type="radio" name="rad_gender" value="Pria"> Pria</label>
					<label><input type="radio" name="rad_gender" value="Wanita"> Wanita</label>
				</div>
				<br><br>

				<label>Tanggal Lahir:</label>
				<input type="date" name="date_tanggal_lahir" id="date_tanggal_lahir">

				<label>Angkatan:</label>
				<input type="text" name="txt_angkatan" id="txt_angkatan">

				<label>Gambar:</label>
				<input type="file" name="img_gambar" accept="image/*">

				<input type="submit" name="submit" value="Insert Mahasiswa">
			</form>
		</div>
	</div>

	<script>
	function validateForm() {
		const nrp = document.getElementById('txt_nrp').value;
		const nama = document.getElementById('txt_nama').value;
		const angkatan = document.getElementById('txt_angkatan').value;
		const gender = document.querySelector('input[name="rad_gender"]:checked');
		const tanggal = document.getElementById('date_tanggal_lahir').value;

		
		// Cek NRP harus angka
		if (nrp === "" || isNaN(nrp)) {
			alert("NRP harus berupa angka!");
			return false;
		}

		// Cek nama
		if (nama === "") {
			alert("Nama tidak boleh kosong!");
			return false;
		}
		
		// Cek gender
		if (!gender) {
			alert("Harap pilih gender!");
			return false;
		}

		// Cek tanggal lahir
		if (tanggal === "") {
			alert("Tanggal lahir harus diisi!");
			return false;
		}


		// Cek angkatan maksimal 2155
		if (angkatan === "" || isNaN(angkatan) || parseInt(angkatan) > 2155) {
			alert("Angkatan harus angka dan maksimal 2155!");
			return false;
		}

		return true; 
	}
	</script>
</body>
</html>