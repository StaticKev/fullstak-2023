<?php
require_once ("conn.php");

if(!isset($btnSubmit)){
    session_start();
    $username = $_SESSION['username'];
} else {
    $sql = "UPDATE akun SET password=? WHERE username=?;";
    $stmt = $con -> prepare($sql);
    $stmt -> bind_param("s", $username);
    if($stmt -> execute()){
        echo "berhasil mengubah password";
    } else {
        echo "gagal mengubah password";
    }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Account Password</title>
</head>

<body>
    <form action="" method="post">
        <input type="text" name="username" value="<?php echo $username?>" readonly>
        <input type="password" name="newPassword" placeholder="masukan password baru">    
        <input type="submit" value="ubah" name="btnSubmit">
    </form>
</body>
</html>