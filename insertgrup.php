<?php
    session_start();
    include_once('service/grup.php');
    include_once('service/akun.php');
    $objGrup = new grup();
    $objAkun = new akun();

    if (!isset($_SESSION['login'])) {
        header("Location: login_temp.php");
        exit();
    }elseif (($_SESSION['username'][0] === 'D') == false){
        header("Location: index.php");
        exit();
    } elseif (isset($_POST['submit'])){
        if($objGrup->createGrup(
            $_POST['txtusernamepembuat'],
            $_POST['txtnamagrup'],
            $_POST['txtdeskripsi'],
            $_POST['txttglbentuk'],
            $_POST['rad_jenis']
            )
        ){
            echo "<script>
                alert('Grup berhasil dibuat!');
                window.location.href = 'index.php';
            </script>";
        }
        else {
            echo "<script>
                alert('Grup gagal dibuat!');
                window.location.href = 'insertgrup.php';
            </script>";
        }
    }

    $usernamePembuat = $_SESSION['username'];
    $tglBentuk = date("Y-m-d H:i:s");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Grup</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include('header.php'); ?>

	<div class="style">

        <div class="container">
            <h2>Buat Grup Baru</h2>
            <form method="post" action="insertgrup.php" onsubmit="return validateForm()">
                <div>
                    <label for="username">Id Pembuat:</label>
                    <input type="text" id="username" name="txtusernamepembuat" value="<?php echo $usernamePembuat; ?>" readonly>
                </div>

                <div>
                    <label for="namagrup">Nama Grup:</label>
                    <input type="text" id="namagrup" name="txtnamagrup" maxlength="45" required>
                </div>

                <div>
                    <label for="deskripsi">Deskripsi:</label>
                    <input type="text" id="deskripsi" name="txtdeskripsi" maxlength="45" required>
                </div>

                <div>
                    <label for="tglbentuk">Tanggal pembentukan:</label> 
                    <input type="text" id="tglbentuk" name="txttglbentuk" value="<?php echo $tglBentuk; ?>" readonly>
                </div>

                <label>Jenis:</label>
                <div style="display: flex; gap: 10px; align-items: center;">
					<label><input type="radio" name="rad_jenis" value="Privat"> Privat</label>
					<label><input type="radio" name="rad_jenis" value="Publik"> Publik</label>
				</div>

                <input type="submit" name="submit" value="Insert Grup">
            </form>

            <a href="tampilangrup.php">⬅ Kembali ke Grupmu</a>
        </div>
    </div>

    <script>
	function validateForm() {
		const namaGrup = document.getElementById('namagrup').value;
		const jenis = document.querySelector('input[name="rad_jenis"]:checked');

		if (namaGrup === "") {
			alert("Nama Grup tidak boleh kosong!");
			return false;
		}
		
		if (!jenis) {
			alert("Harap pilih jenis grup!");
			return false;
		}

		return true; 
	}
	</script>

</body>

</html>