<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Projek UTS - Input Mahasiswa</title>
</head>
<body>
	<form method="post" enctype="multipart/form-data" action="insertmahasiswa_proses.php">
        NRP: <input type="text" maxlength="9" name="txt_nrp"><br>
        Nama: <input type="text" name="txt_nama"><br>
        Password: <input type="password" name="txt_password" placeholder="buat password "><br>
        Gender: 
        <input type="radio" name="rad_gender" value="Pria">Pria
        <input type="radio" name="rad_gender" value="Wanita">Wanita
        <br>
        Tanggal Lahir: <input type="date" name="date_tanggal_lahir"><br>
        Angkatan: <input type="text" name="txt_angkatan"><br>
        Gambar: <input type="file" name="img_gambar" accept="image/*"><br>
		<input type="submit" name="submit" value="Insert Mahasiswa">
	</form>
</body>
</html>