<?php
    require_once ("conn.php");

    session_start();

    if(!isset($_SESSION['login'])){
        header("Location: login_temp.php");
    }

    $username = $_SESSION['username'];

    if (isset($_POST['btnSubmit'])) {
        $currentPassword = $_POST['currentPassword'];
        $newPassword1 = $_POST['newPassword1'];
        $newPassword2 = $_POST['newPassword2'];
        $newPassword = password_hash($newPassword1, PASSWORD_DEFAULT);

        $sql = "SELECT password FROM akun WHERE username = ?";
        $stmt = $con->prepare($sql);
        $stmt -> bind_param("s", $username);
        $stmt -> execute();
        $stmt -> bind_result($storedPassword);
        $stmt -> fetch();
        $stmt -> close();

        if (password_verify($currentPassword, $storedPassword)) {
            if ($newPassword1 === $newPassword2) {
                $sql2 = "UPDATE akun SET password = ? WHERE username = ?";
                $stmt = $con->prepare($sql2);
                $stmt -> bind_param("ss", $newPassword, $username);
                if ($stmt -> execute()) {
                    echo "Update password berhasil!";
                } else {
                    echo "Update password gagal!";
                }
            } else {
                echo "Password baru yang dimasukkan tidak cocok!";
            }
        } else {
            echo "Password salah!";
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
        Username: <input type="text" name="username" value="<?php echo $username?>" readonly><br>
        Masukkan password saat ini: <input type="password" name="currentPassword"><br><br>
        Password Baru<br>
        Password: <input type="password" name="newPassword1"><br>
        Masukkan password kembali: <input type="password" name="newPassword2"><br> 
        <input type="submit" value="Ubah" name="btnSubmit">
    </form>
</body>
</html>