<?php
    require_once ("service/grup.php");
    $objGrup = new grup();

    $id = $_GET['id'];

    if (isset($_GET['user'])) {
        $username = $_GET['user'];
        
        if($objGrup->removeMember($username, $id)){
            $msg = "Berhasil keluar dari grup.";
            echo "<script>alert('Berhasil keluar dari grup.');</script>";
            header("Location: index.php");
            exit();
        }
        else{
            $msg = "Gagal keluar dari grup.";
            echo "<script>alert('Gagal keluar dari grup.');</script>";
            header("Location: index.php");
            exit();
        }
    }
    else{
        if ($objGrup->deleteGrup($id)) {
            $msg = "Grup berhasil dihapus.";
            echo "<script>alert('Grup berhasil dihapus.');</script>";
            header("Location: index.php");
            exit();
        } else {
            $msg = "Grupgagal dihapus.";
            echo "<script>alert(Grup gagal dihapus dari grup )";
            header("Location: index.php");
            exit();
        }
    }


?>