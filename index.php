<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<div class="style">

		<div class="container">

			<?php
			if (!isset($_SESSION['login'])) {
				header("Location: login_temp.php");
			} elseif ($_SESSION['admin'] == 1) {
				echo "<h2>Selamat Datang Admin</h2>";
			?>
				<a href="insertdosen.php"><button>TAMBAH DOSEN</button></a>
				<a href="tampilandosen.php"><button>LIST DOSEN</button></a>
				<a href="insertmahasiswa.php"><button>TAMBAH MAHASISWA</button></a>
				<a href="tampilanmahasiswa.php"><button>LIST MAHASISWA</button></a>
				<a href="editPasswordAkun.php"><button>GANTI PASSWORD</button></a>
				<a class="logout" href="logout.php">Logout</a>



			<?php } else {
				echo "<h2>Selamat Datang, " . htmlspecialchars($_SESSION['username']) . "</h2>"; ?>

				<p>Anda login sebagai <strong>user</strong></p>
				<a href="editPasswordAkun.php"><button>GANTI PASSWORD</button></a>
				<!-- <a class="logout" href="logout.php">Logout</a> -->

			<?php }
			?>
		</div>
	</div>

</body>

</html>