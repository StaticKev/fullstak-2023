<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home</title>
</head>

<body>
	<?php
		if(!isset($_SESSION['login'])){
			header("Location: login_temp.php");
		}
		elseif ($_SESSION['admin'] == 1) {
			echo "tampilan admin"; ?>

			<a href="insertdosen.php"> <button>TAMBAH DOSEN</button></a><br><br>
			<a href="tampilandosen.php"><button>LIST DOSEN</button></a><br><br>
			<a href="insertmahasiswa.php"><button>TAMBAH MAHASISWA</button></a><br><br>
			<a href="tampilanmahasiswa.php"><button>LIST MAHASISWA</button></a><br><br>
			<a href="editPasswordAkun.php"><button>Ganti Password</button></a><br><br>

		
		<?php }
		else{
			echo "tampilan user"; 
			echo $_SESSION['login']; 
			echo $_SESSION['username']; 
			echo $_SESSION['admin']; 
			echo "tampilan user"; ?>


			<!-- tampilan user -->

		<?php }
	?>
</body>

</html>