<?php
session_start();
include('service/dosen.php');
$objDosen = new dosen();

if($_SESSION['admin'] == 0) {
	require_once ('service/404.php');
}

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Projek UTS - Tampilan Dosen</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<?php include('header.php'); ?>
	<div class="styleTampilan">

		<h2>DAFTAR DOSEN</h2>

		<div class="button-container">
			<a href="insertdosen.php">
				<button class="btn">Insert Dosen Baru</button>
			</a>
		</div>

		<?php

		if (isset($_GET['cboPage'])) {
			$perpage = $_GET['cboPage'];
		}
		else {
			$perpage = 3;
		}		

        echo "<div class='paging'>
		<form method='get' action='tampilandosen.php'>
			Per Page
			<select name='cboPage' onchange='this.form.submit()'>
				<option value='2' ".($perpage==2?"selected":"").">2</option>
				<option value='3' ".($perpage==3?"selected":"").">3</option>
				<option value='4' ".($perpage==4?"selected":"").">4</option>
				<option value='5' ".($perpage==5?"selected":"").">5</option>
			</select>
		</form>
		";
		
		//ambil total data
		$jumlahData = $objDosen->getAllDosen()->num_rows;
		//set total hlm
		$totalpage = ceil($jumlahData / $perpage);

		if (isset($_GET['p'])) {
			$p = $_GET['p'];
			$start = ($p-1) * $perpage;
		}
		else {
			$p = 1;
			$start = 0;
		}

		echo "<a href='tampilandosen.php?p=1&cboPage=$perpage'>First</a> ";
		if ($p==1) {
			echo "Prev ";	
		}
		else {
			$x = $p-1;
			echo "<a href='tampilandosen.php?p=$x&cboPage=$perpage'>Prev</a> ";
		}
		
		for ($i = 1; $i <= $totalpage; $i++) {
			echo "<a href='tampilandosen.php?p=$i&cboPage=$perpage'>$i</a> ";
		}

		if ($p == $totalpage) {
			echo "Next ";
		} else {
			$x = $p + 1;
			echo "<a href='tampilandosen.php?p=$x&cboPage=$perpage'>Next</a> ";
		}

		echo "<a href='tampilandosen.php?p=$totalpage&cboPage=$perpage'>Last</a><br><br><br></div>";

		$result = $objDosen->getDosenLimit($start, $perpage);

		echo "<table>";
		echo "<tr>
					<th>Gambar</th>
					<th>NPK</th>
					<th>Nama</th>
					<th>Aksi</th>
				  </tr>";

		while ($row = $result->fetch_assoc()) 
		{
			$npk  = $row['npk'];
			$nama = $row['nama'];
			$ext  = $row['foto_extension'];

			echo "<tr>";
			echo "<td>";
			if ($ext != '') {
				$gambar = "gambar/dosen/$npk.$ext";
				echo "<img src='$gambar' width='50' height='50'>";
			} else {
				echo "Tidak ada foto";
			}
			echo "</td>";
			echo "<td>$npk</td>";
			echo "<td>$nama</td>";

			echo "<td>
					<a href='editdosen.php?npk=$npk'>Edit</a> |
						
					<a href='deldosen.php?npk=$npk' onclick=\"return confirm('Yakin hapus dosen ini?');\">Delete</a>
				</td>";
			echo "</tr>";
		}

		echo "</table>";

		?>


	</div>
</body>

</html>