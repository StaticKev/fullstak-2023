<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Projek UTS - Proses Insert Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
    </style>
</head>

<body>
    <div class="style">
        <div class="container">
            <?php
            require_once("service/dosen.php");
            $objDosen = new dosen();

            $npk = $_POST['txt_npk'];
            $nama = $_POST['txt_nama'];
            $foto_extension = "";

            if ($_FILES['img_gambar']['error'] == 0) {
                $stmt = $objDosen->getAllDosen($npk);
                $row = $stmt->fetch_assoc();
                $foto_extension = $row['foto_extension'];

                if(isset($_FILES['img_gambar'])){
                    $gambar_old = "gambar/dosen/$npk.$foto_extension";
    
                    if (file_exists($gambar_old)) {
                        unlink($gambar_old);
                    }
    
                    $gambar = $_FILES['img_gambar'];
                    $ext = pathinfo($gambar['name'], PATHINFO_EXTENSION);
                    $dst = "gambar/dosen/$npk.$ext";
                    move_uploaded_file($gambar['tmp_name'], $dst);
                    $foto_extension = $ext;

                }

            } else {
                #error upload file
                echo "<h2>Gagal mengupload gambar.</h2>";
            }

            if ($objDosen->updateDosen($npk, $nama, $foto_extension)) {
                echo "<h2>Update Sukses.</h2>";
            } else {
                echo "<h2>Update Gagal.</h2>";
            }
            echo "<br><a href='tampilandosen.php' class='back-btn'>Kembali ke tampilan Dosen</a>";

            ?>

        </div>
    </div>
</body>

</html>