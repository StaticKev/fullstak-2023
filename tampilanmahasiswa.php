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

		$sql = "SELECT * FROM mahasiswa";
		$stmt = $con->prepare($sql);
		$stmt->execute();

		$result = $stmt->get_result();

		echo "<table border='1'>";
		echo "<tr>
		        <th>Gambar</th>
		        <th>NRP</th>
		        <th>Nama</th>
                <th>Gender</th>
                <th>Tanggal Lahir</th>
                <th>Angkatan</th>
		        <th>Aksi</th>
		      </tr>";

		while ($row = $result->fetch_assoc()) {
		    $nrp = $row['nrp'];
            $nama = $row['nama'];
            $gender = $row['gender'];
            $tanggal_lahir = $row['tanggal_lahir'];
            $angkatan = $row['angkatan'];
            $ext = $row['foto_extention'];

		    echo "<tr>";
		    echo "<td>";
		    if ($ext != "") {
		        $gambar = "gambar/mahasiswa/$nrp.$ext";
		        echo "<img src='$gambar' width='50' height='50'>";
		    } else {
		        echo "Tidak ada foto";
		    }
		    echo "</td>";
		    echo "<td>$nrp</td>";
		    echo "<td>$nama</td>";
            echo "<td>$gender</td>";
            echo "<td>$tanggal_lahir</td>";
            echo "<td>$angkatan</td>";

		    echo "<td>
		            <a href='editmahasiswa.php?nrp=$nrp'>Edit</a> | 
		            <a href='delmahasiswa.php?nrp=$nrp' onclick=\"return confirm('Yakin hapus mahasiswa ini?');\">Delete</a>
		          </td>";
		    echo "</tr>";
		}

		echo "</table>";

		$con->close();
	?>
<br>
<a href="insertmahasiswa.php">Insert Mahasiswa Baru</a>
</body>
</html>