<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Projek UTS - Input Dosen</title>
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
			font-size: 26px;
			letter-spacing: 1px;
		}

		form {
			display: flex;
			flex-direction: column;
			gap: 15px;
			text-align: left;
		}

		label {
			font-size: 14px;
			margin-bottom: 3px;
			color: #ccc;
		}

		input[type="text"],
		input[type="file"],
		input[type="password"] {
			width: 100%;
			padding: 10px;
			border-radius: 10px;
			border: none;
			background: #2e2e2e;
			color: #fff;
			box-sizing: border-box;
			font-size: 15px;
		}

		input:focus {
			outline: none;
			box-shadow: 0 0 8px #ffffff;
		}

		input[type="submit"] {
			background: linear-gradient(135deg, #ffffff, #cccccc);
			color: #000;
			font-weight: bold;
			cursor: pointer;
			transition: 0.3s ease;
			border: none;
			border-radius: 10px;
			height: 45px;
			font-size: 16px;
			letter-spacing: 1px;
		}

		input[type="submit"]:hover {
			background: linear-gradient(135deg, #cccccc, #ffffff);
			transform: scale(1.03);
		}

		a {
			display: block;
			margin-top: 20px;
			color: #aaa;
			text-decoration: none;
			font-size: 14px;
			transition: color 0.3s;
			text-align: center;
		}

		a:hover {
			color: #fff;
		}
	</style>
</head>
<body>
	<div class="container">
		<?php include('header.php'); ?> 
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
</body>
</html>
