<?php
    session_start();
    
    if (!isset($_SESSION['login'])) {
        header("Location: login_temp.php");
        exit();
    } 
    
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        include_once('service/akun.php');
        $objakun= new akun();

        if ($objakun->addGrup($_SESSION['username'],$_POST['idGrup'],$_POST['txtKodePendaftaran'])){
            echo "<script>
                    alert('berhasil bergabung!');
                </script>";
            header("location:index.php");
            exit();
        }
        else {
            echo "<script>
                    alert('gagal bergabung!');
                </script>";
            exit();
        }
        
    }
    else {
        $idGrup = $_GET['id'];
        $namaGrup = $_GET['namaGrup'];
    }

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
            <form method="post" action="joingrup.php">
                <div>
                    <label for="kodePendaftaran">Kode pendaftaran:</label>
                    <input type="text" id="kodePendaftaran" name="txtKodePendaftaran" required >
                </div>
                <input type="hidden" name="idGrup" value="<?php $idGrup; ?>">

                <input type="submit" name="submit" value="Gabung">
            </form>

            <a href="tampilangrup.php">⬅ Kembali ke Cari Grup</a>
        </div>
    </div>

</body>

</html>