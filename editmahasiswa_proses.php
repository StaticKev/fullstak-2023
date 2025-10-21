<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Projek UTS - Proses Edit Mahasiswa</title>
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <div class="style">
        <div class="container">
            <?php
            require_once("conn.php");

            $nrp = $_POST['txt_nrp'];
            $nama = $_POST['txt_nama'];
            $gender = $_POST['rad_gender'];
            $tanggal_lahir = $_POST['date_tanggal_lahir'];
            $angkatan = $_POST['txt_angkatan'];
            $foto_extention = "";

            if (isset($_FILES['img_gambar']) && $_FILES['img_gambar']['error'] == 0) {
                $sql = "SELECT foto_extention FROM mahasiswa WHERE nrp=?";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("s", $nrp);
                $stmt->execute();

                $res = $stmt->get_result();
                $row = $res->fetch_assoc();
                $old_extention = $row['foto_extention'];
                $gambar_old = "gambar/mahasiswa/$nrp.$old_extention";

                if (file_exists($gambar_old)) {
                    unlink($gambar_old);
                }

                $gambar = $_FILES['img_gambar'];
                $ext = pathinfo($gambar['name'], PATHINFO_EXTENSION);
                $dst = "gambar/mahasiswa/$nrp.$ext";
                move_uploaded_file($gambar['tmp_name'], $dst);
                $foto_extention = $ext;
            } else {
                $sql = "SELECT foto_extention FROM mahasiswa WHERE nrp=?";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("s", $nrp);
                $stmt->execute();

                $res = $stmt->get_result();
                $row = $res->fetch_assoc();
                $foto_extention = $row['foto_extention'];
            }

            $sql2 = "UPDATE mahasiswa SET nama=?, gender=?, tanggal_lahir=?, angkatan=?, foto_extention=? WHERE nrp=?";
            $stmt2 = $con->prepare($sql2);
            $stmt2->bind_param('ssssss', $nama, $gender, $tanggal_lahir, $angkatan, $foto_extention, $nrp);

            if ($stmt2->execute()) {
                echo "<h2>Update Sukses.</h2>";
            } else {
                echo "<h2>Update Gagal.</h2>";
            }
            echo "<a href='tampilanmahasiswa.php' class='back-btn'>Kembali ke tampilan Mahasiswa</a>";

            $con->close();
            ?>

        </div>
    </div>
</body>

</html>