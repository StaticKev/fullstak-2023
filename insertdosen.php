<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Projek UTS - Input Dosen</title>
</head>
<body>
	<form method="post" enctype="multipart/form-data" action="insertdosen_proses.php">
		Nama: <input type="text" name="txtnama"><br>
		NPK: <input type="text" name="txtnpk" maxlength="6"><br>
		Password: <input type="text" name="txtpassword" placeholder="buat password "><br>
		Gambar: <input type="file" name="gambar" accept="image/*"><br>
		<input type="submit" name="submit" value="Insert Dosen">
	</form>
</body>
</html>