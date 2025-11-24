<?php
	require_once ("service/mahasiswa.php");
	require_once ("service/akun.php");
	$objMahasiswa = new mahasiswa();
	$objAkun = new akun();

	$message ="";
    $nrp = $_POST['txt_nrp'];
    $nama = $_POST['txt_nama'];
    $gender = $_POST['rad_gender'];
    $tanggal_lahir = $_POST['date_tanggal_lahir'];
    $angkatan = $_POST['txt_angkatan'];
    $foto_extention = "";

	if (isset($_FILES['img_gambar']) && $_FILES['img_gambar']['error'] == 0) {
		$gambar = $_FILES['img_gambar'];
		$ext = pathinfo($gambar['name'], PATHINFO_EXTENSION);
		$dst = "gambar/mahasiswa/$nrp.$ext";
		move_uploaded_file($gambar['tmp_name'], $dst);
		$foto_extention = $ext;
	}

    // Cek apakah NPK sudah ada
	$check = $objMahasiswa->getAllMahasiswa($nrp);

	if ($check->num_rows > 0) {
		// NRP sudah ada → tampilkan alert dan kembali ke form
		echo "<script>
				alert('NRP sudah terdaftar!');
				window.location.href = 'insertmahasiswa.php';
			</script>";
		exit();
	}

    // Insert data mahasiswa
	$stmt = $objMahasiswa->insertMahasiswa($nrp, $nama, $gender, $tanggal_lahir, $angkatan, $foto_extention);

    if ($stmt) {
        $message =$message. "<p>✅ Insert data mahasiswa berhasil.</p>";

        // Insert juga ke tabel akun
		$hashed_password = password_hash($_POST['txt_password'], PASSWORD_DEFAULT); 
        $username = "M$nrp";
        $nrp_mahasiswa = $nrp;
        $npk_dosen = NULL;
        $isadmin = 0;

        $stmtAkun = $objAkun->insertAkun($username, $hashed_password, $nrp_mahasiswa, $npk_dosen, $isadmin);

        if ($stmtAkun) {
            $message =$message. "<p>✅ Akun mahasiswa berhasil dibuat.</p>";
        } else {
            $message =$message. "<p>❌ Gagal membuat akun: " . htmlspecialchars($con->error) . "</p>";
        }
    } else {
        $message .= "<p>❌ Gagal insert mahasiswa: " . htmlspecialchars($con->error) . "</p>";
    }

    $con->close();

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Projek UTS - Insert Mahasiswa</title>
<link rel="stylesheet" href="style.css">


</head>
<body>
	<?php include('header.php'); ?> 
	<div class="style">
		<div class="container">
			<h2>Confirm</h2>
			<?php
				if (!empty($message)) {
					echo $message;
					echo "<br><a href='index.php'>⬅ Kembali ke Home</a>";
				} else {
					echo "<p>Tidak ada data yang dikirim.</p>";
					echo "<br><a href='index.php'>⬅ Kembali ke Home</a>";
				}
			?>
		</div>
	</div>
</body>
</html>
