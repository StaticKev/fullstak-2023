<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home</title>
</head>

<body>
	<?php
		if(!isset($_COOKIE['login'])){
			header("Location: login_temp.php");
		}
		elseif ($_COOKIE['login'] == "admin") {
			echo "tampilan admin"; ?>

			<a href="insertdosen.php"> <button>TAMBAH DOSEN</button></a><br><br>
			<a href="tampilandosen.php"><button>LIST DOSEN</button></a><br><br>
			<a href="insertmahasiswa.php"><button>TAMBAH MAHASISWA</button></a><br><br>
			<a href="tampilanmahasiswa.php"><button>LIST MAHASISWA</button></a>
		
		<?php }
		else{
			echo "tampilan user"; ?>

			<!-- tampilan user -->

		<?php }
	?>
</body>

</html>