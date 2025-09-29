<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Projek UTS - Tampilan Dosen</title>
</head>
<body>
	<?php
		require_once("conn.php");

		$sql = "SELECT * FROM dosen";
		$stmt = $con->prepare($sql);
		$stmt->execute();

		$result = $stmt->get_result();

		echo "<table border='1'>";
		echo "<tr>
		        <th>Gambar</th>
		        <th>NPK</th>
		        <th>Nama</th>
		        <th>Aksi</th>
		      </tr>";

		while ($row = $result->fetch_assoc()) {
		    $npk  = $row['npk'];
		    $nama = $row['nama'];
		    $ext  = $row['foto_extension'];

		    echo "<tr>";
		    echo "<td>";
		    if ($ext != "") {
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

		$con->close();
	?>
<br>
<a href="insertdosen.php">Insert Dosen Baru</a>
</body>
</html>
