<?php
require_once("conn.php");

// --- Proses insert data ---
$message = ""; // Variabel buat nampung pesan hasil

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nrp = $_POST['txt_nrp'];
    $nama = $_POST['txt_nama'];
    $gender = $_POST['rad_gender'];
    $tanggal_lahir = $_POST['date_tanggal_lahir'];
    $angkatan = $_POST['txt_angkatan'];
    $foto_extention = "";

    // Upload foto jika ada
    if (isset($_FILES['img_gambar']) && $_FILES['img_gambar']['error'] == 0) {
        $gambar = $_FILES['img_gambar'];
        $ext = pathinfo($gambar['name'], PATHINFO_EXTENSION);
        $dst = "gambar/mahasiswa/$nrp.$ext";
        move_uploaded_file($gambar['tmp_name'], $dst);
        $foto_extention = $ext;
    }

    // Insert ke tabel mahasiswa
    $sql = "INSERT INTO mahasiswa (nrp, nama, gender, tanggal_lahir, angkatan, foto_extention) VALUES (?,?,?,?,?,?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('ssssss', $nrp, $nama, $gender, $tanggal_lahir, $angkatan, $foto_extention);

    if ($stmt->execute()) {
        $message .= "<p>✅ Insert data mahasiswa berhasil.</p>";

        // Insert juga ke tabel akun
        $password = $_POST['txt_password'];
        $username = "M$nrp";
        $nrp_mahasiswa = $nrp;
        $npk_dosen = NULL;
        $isadmin = 0;

        $sqlAkun = "INSERT INTO akun(username, password, nrp_mahasiswa, npk_dosen, isadmin) VALUES (?, ?, ?, ?, ?)";
        $stmtAkun = $con->prepare($sqlAkun);
        $stmtAkun->bind_param("sssii", $username, $password, $nrp_mahasiswa, $npk_dosen, $isadmin);

        if ($stmtAkun->execute()) {
            $message .= "<p>✅ Akun mahasiswa berhasil dibuat.</p>";
        } else {
            $message .= "<p>❌ Gagal membuat akun: " . htmlspecialchars($con->error) . "</p>";
        }
    } else {
        $message .= "<p>❌ Gagal insert mahasiswa: " . htmlspecialchars($con->error) . "</p>";
    }

    $stmt->close();
    $con->close();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Projek UTS - Insert Mahasiswa</title>
<style>
	body {
		background-color: #121212;
		color: #f1f1f1;
		font-family: "Segoe UI", sans-serif;
		margin: 0;
		padding: 0;
	}
	header {
		background: #1e1e1e;
		padding: 20px 40px;
		display: flex;
		align-items: center;
		box-shadow: 0 0 20px rgba(0,0,0,0.6);
	}
	header h1 {
		color: #00bcd4;
		margin: 0;
		font-size: 22px;
	}
	.container {
		background: #1e1e1e;
		max-width: 700px;
		margin: 50px auto;
		padding: 30px;
		border-radius: 12px;
		box-shadow: 0 0 15px rgba(0,0,0,0.4);
		text-align: center;
	}
	a {
		color: #00bcd4;
		text-decoration: none;
		font-weight: bold;
	}
	a:hover {
		color: #0097a7;
	}
</style>
</head>
<body>
	<?php include('header.php'); ?> 
	<header>
		<h1>Confirm</h1>
	</header>
	<div class="container">
		<?php
			if (!empty($message)) {
				echo $message;
				echo "<br><a href='index.php'>⬅ Kembali ke Index</a>";
			} else {
				echo "<p>Tidak ada data yang dikirim.</p>";
				echo "<br><a href='index.php'>⬅ Kembali ke Index</a>";
			}
		?>
	</div>
</body>
</html>
