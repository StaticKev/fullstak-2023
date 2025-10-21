<?php
    require_once ("conn.php");

    $npk = $_GET['npk'];

    $sql = "SELECT d.nama, d.npk, a.password FROM dosen d INNER JOIN akun a ON d.npk = a.npk_dosen WHERE d.npk=?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $npk);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $nama = $row['nama'];
        $password = $row['password'];
        $NPK = $row['npk'];
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
		Password: <input type="text" name="txt_password" placeholder="buat password " value="<?php echo $password; ?>"><br>
		Gambar: <input type="file" name="img_gambar" accept="image/*"><br>
		<input type="submit" name="submit" value="Edit Dosen">
	</form>
</body>
</html>