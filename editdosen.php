<?php
    require_once ("service/dosen.php");
    $objDosen = new dosen();

    $npk = $_GET['npk'];

    $result = $objDosen->getAllDosen($npk);

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
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Projek UTS - Edit Dosen</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="style">
        <div class="container">
            <form method="post" enctype="multipart/form-data" action="editdosen_proses.php">
                Nama: <input type="text" name="txt_nama" value="<?php echo $nama; ?>"><br>
                NPK: <input type="text" name="txt_npk" maxlength="6" value="<?php echo $NPK; ?>" readonly><br>
                Gambar: <input type="file" name="img_gambar" accept="image/*"><br>
                <img src="<?php echo $gambar; ?>" width="100" height="100" alt="profile"><br>
                <input type="submit" name="submit" value="Edit Dosen">
            </form>
        </div>
    </div>
</body>
</html>