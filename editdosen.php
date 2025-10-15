<?php
    require_once ("conn.php");

    $npk = $_GET['npk'];

    $sql = "SELECT d.nama, d.npk, d.foto_extension FROM dosen d WHERE d.npk=?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $npk);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $nama = $row['nama'];
        $NPK = $row['npk'];
        $ext = $row['foto_extension'];

        $gambar = "gambar/dosen/$NPK.$ext";
    } else {
        echo "Data dosen tidak ditemukan.";
        exit();
    }
    $stmt->close();
    $con->close();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Projek UTS - Edit Dosen</title>
</head>
<body>
	<form method="post" enctype="multipart/form-data" action="editdosen_proses.php">
		Nama: <input type="text" name="txt_nama" value="<?php echo $nama; ?>"><br>
		NPK: <input type="text" name="txt_npk" maxlength="6" value="<?php echo $NPK; ?>" readonly><br>
		Gambar: <input type="file" name="img_gambar" accept="image/*"><br>
        <img src="<?php echo $gambar; ?>" width="100" height="100"><br>
		<input type="submit" name="submit" value="Edit Dosen">
	</form>
</body>
</html>