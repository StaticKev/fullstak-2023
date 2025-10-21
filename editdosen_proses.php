<?php
    require_once ("conn.php");

    $npk = $_POST['txt_npk'];
    $nama = $_POST['txt_nama'];
    $foto_extension = "";

	if (isset($_FILES['img_gambar']) && $_FILES['img_gambar']['error'] == 0) {
        $sql = "SELECT foto_extension FROM dosen WHERE npk=?";
        $stmt = $con->prepare($sql);
        $stmt -> bind_param("s", $npk);
        $stmt -> execute();

        $res = $stmt -> get_result();
        $row = $res->fetch_assoc();
        $old_extension = $row['foto_extension'];
        $gambar_old = "gambar/dosen/$npk.$old_extension";

        if (file_exists($gambar_old)) {
            unlink($gambar_old); 
            echo "File berhasil dihapus.";
        } else {
            echo "Gambar lama tidak ada.";
        }

		$gambar = $_FILES['img_gambar'];
		$ext = pathinfo($gambar['name'], PATHINFO_EXTENSION);
		$dst = "gambar/dosen/$npk.$ext";
		move_uploaded_file($gambar['tmp_name'], $dst);
		$foto_extension = $ext;
	} else {
        $sql = "SELECT foto_extension FROM dosen WHERE npk=?";
        $stmt = $con->prepare($sql);
        $stmt -> bind_param("s", $npk);
        $stmt -> execute();

        $res = $stmt -> get_result();
        $row = $res->fetch_assoc();
        $foto_extension = $row['foto_extension'];
    }

    $sql2 = "UPDATE dosen SET nama=?, foto_extension=? WHERE npk=?";
    $stmt2 = $con->prepare($sql2);
    $stmt2 -> bind_param('sss', $nama, $foto_extension, $npk);

	if ($stmt2->execute()) {   
		echo "Update Sukses.";
	}
	else {
		echo "Update Gagal.";
	}
	echo "<br><a href='tampilandosen.php'>Kembali ke tampilan Dosen</a>";
	
	$con->close();
?>