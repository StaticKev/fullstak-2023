<?php
    require_once ("conn.php");

    $nrp = $_GET['nrp'];

    $sql = "SELECT m.nrp, m.nama, m.gender, m.tanggal_lahir, m.angkatan, m.foto_extention, a.password FROM mahasiswa m INNER JOIN akun a ON m.nrp = a.nrp_mahasiswa WHERE m.nrp=?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $nrp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $NRP = $row['nrp'];
        $nama = $row['nama'];
        $gender = $row['gender'];
        $tanggal_lahir = $row['tanggal_lahir'];
        $angkatan = $row['angkatan'];
        $foto_extention = $row['foto_extention'];
        $password = $row['password'];
    } else {
        echo "Data mahasiswa tidak ditemukan.";
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
	<title>Projek UTS - Edit Mahasiswa</title>

    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #0e0e0e;
            color: #fff;
            font-family: "Segoe UI", sans-serif;
            background-image: radial-gradient(circle at top left, #1c1c1c 0%, #000 80%);
        }

        form {
            background: rgba(30, 30, 30, 0.95);
            padding: 40px 50px;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
            width: 400px;
            text-align: left;
        }

        input[type="text"],
        input[type="date"],
        input[type="file"],
        input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            margin: 8px 0 20px 0;
            border: none;
            border-radius: 8px;
            background: #1e1e1e;
            color: #fff;
            font-size: 15px;
            outline: none;
            transition: 0.2s ease;
        }

        input[type="text"]:focus,
        input[type="date"]:focus,
        input[type="file"]:focus,
        input[type="password"]:focus {
            background: #2c2c2c;
            box-shadow: 0 0 5px #00bcd4;
        }

        label, p {
            font-weight: 600;
            font-size: 15px;
            color: #ddd;
        }

        input[type="radio"] {
            margin-right: 5px;
            transform: scale(1.1);
        }

        input[type="submit"] {
            background: linear-gradient(135deg, #00bcd4, #0097a7);
            color: #fff;
            font-weight: bold;
            border: none;
            border-radius: 10px;
            padding: 10px 15px;
            width: 100%;
            cursor: pointer;
            transition: 0.3s ease;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            transform: scale(1.05);
            background: linear-gradient(135deg, #0097a7, #00bcd4);
        }

        form br {
            display: none;
        }

        form > *:not(:last-child) {
            display: block;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
	<form method="post" enctype="multipart/form-data" action="editmahasiswa_proses.php">
		Nama: <input type="text" name="txt_nama" value="<?php echo $nama; ?>"><br>
		NRP: <input type="text" name="txt_nrp" maxlength="9" value="<?php echo $NRP; ?>" readonly><br>
		Password: <input type="text" name="txt_password" placeholder="buat password " value="<?php echo $password; ?>"><br>
        Gender: 
        <input type="radio" name="rad_gender" value="Pria" <?php if($gender == "Pria") echo "checked"; ?>>Pria
        <input type="radio" name="rad_gender" value="Wanita" <?php if($gender == "Wanita") echo "checked"; ?>>Wanita
        <br>
        Tanggal Lahir: <input type="date" name="date_tanggal_lahir" value="<?php echo $tanggal_lahir; ?>"><br>
        Angkatan: <input type="text" name="txt_angkatan" value="<?php echo $angkatan; ?>"><br>
		Gambar: <input type="file" name="img_gambar" accept="image/*"><br>
		<input type="submit" name="submit" value="Edit Mahasiswa">
	</form>
</body>
</html>
