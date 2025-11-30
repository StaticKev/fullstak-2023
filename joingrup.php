<?php
    session_start();
    include_once('service/grup.php');
    $objGrup = new grup();

    if (!isset($_SESSION['login'])) {
        header("Location: login_temp.php");
        exit();
    } 

    $usernamePembuat = $_SESSION['username'];
    $namaGrup = $_SESSION['namaGrup']; // BELUM ADA YANG KIRIM 'namaGrup'!
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Grup</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include('header.php'); ?>

	<div class="style">

        <div class="container">
            <h2>Bergabung ke grup <?php echo $namaGrup; ?></h2>
            <form method="post" action="joingrup.php" onsubmit="return validateForm()">
                <div>
                    <label for="kodePendaftaran">Kode pendaftaran:</label>
                    <input type="text" id="kodePendaftaran" name="txtKodePendaftaran" >
                </div>

                <input type="submit" name="submit" value="Gabung">
            </form>

            <a href="tampilangrup.php">⬅ Kembali ke Cari Grup</a>
        </div>
    </div>

</body>

</html>