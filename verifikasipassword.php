<?php
    require_once ("conn.php");

    session_start();
    $username = $_SESSION['username'];

    if (isset($_POST['btnSubmit'])) {
        $currentPassword = $_POST['currentPassword'];

        $sql = "SELECT password FROM akun WHERE username = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($storedPassword);
        $stmt->fetch();
        $stmt->close();

        if ($currentPassword === $storedPassword) {
            header("Location: ubahpassword.php");
            exit;
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
        Masukkan password saat ini: <input type="password" name="currentPassword"><br>
        <input type="submit" value="Ubah" name="btnSubmit">
    </form>
</body>
</html>