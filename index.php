<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home</title>
	<style>
		body {
			margin: 0;
			height: 100vh;
			display: flex;
			justify-content: center;
			align-items: center;
			font-family: 'Segoe UI', sans-serif;
			background: #111;
			background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='40' height='40' viewBox='0 0 40 40'%3E%3Cg fill='none' stroke='%23333' stroke-width='1'%3E%3Cpath d='M20 0v40M0 20h40'/%3E%3C/g%3E%3C/svg%3E");
			background-size: 40px 40px;
			color: #fff;
		}

		.container {
			background: rgba(20, 20, 20, 0.9);
			padding: 40px;
			border-radius: 20px;
			width: 400px;
			text-align: center;
			backdrop-filter: blur(6px);
			animation: glow 2s infinite alternate;
		}

		@keyframes glow {
			0%   { box-shadow: 0 0 8px #ffffff; }
			50%  { box-shadow: 0 0 16px #cccccc; }
			100% { box-shadow: 0 0 8px #ffffff; }
		}

		h2 {
			margin-bottom: 25px;
			color: #ffffff;
			font-size: 28px;
			letter-spacing: 2px;
		}

		button {
			width: 100%;
			height: 45px;
			padding: 0 12px;
			margin: 10px 0;
			border: none;
			border-radius: 10px;
			box-sizing: border-box;
			font-size: 16px;
			background: linear-gradient(135deg, #ffffff, #cccccc);
			color: #000;
			font-weight: bold;
			cursor: pointer;
			transition: 0.3s ease;
			letter-spacing: 1px;
		}

		button:hover {
			background: linear-gradient(135deg, #cccccc, #ffffff);
			transform: scale(1.03);
		}

		a {
			text-decoration: none;
		}

		.logout {
			display: block;
			margin-top: 20px;
			color: #aaa;
			font-size: 14px;
			text-decoration: none;
			transition: color 0.3s;
		}

		.logout:hover {
			color: #fff;
		}
	</style>
</head>

<body>
	<div class="container">
	<?php
		if(!isset($_SESSION['login'])){
			header("Location: login_temp.php");
		}
		elseif ($_SESSION['admin'] == 1) {
			echo "<h2>Selamat Datang Admin</h2>";
			?>
			<a href="insertdosen.php"><button>TAMBAH DOSEN</button></a>
			<a href="tampilandosen.php"><button>LIST DOSEN</button></a>
			<a href="insertmahasiswa.php"><button>TAMBAH MAHASISWA</button></a>
			<a href="tampilanmahasiswa.php"><button>LIST MAHASISWA</button></a>
			<a href="editPasswordAkun.php"><button>GANTI PASSWORD</button></a>
			<a class="logout" href="logout.php">Logout</a>
		<?php }
		else {
			echo "<h2>Selamat Datang, " . htmlspecialchars($_SESSION['username']) . "</h2>";
			?>
			<!-- tampilan user -->
			<p>Anda login sebagai <strong>user</strong></p>
			<a href="editPasswordAkun.php"><button>GANTI PASSWORD</button></a>
			<a class="logout" href="logout.php">Logout</a>
		<?php }
	?>
	</div>
</body>
</html>
