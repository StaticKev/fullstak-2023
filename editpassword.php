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
                    echo "<script>
                        alert('Update password berhasil!');
                    </script>";
                } else {
                    echo "<script>
                        alert('Update password gagal!');
                    </script>";
                }
            } else {
                echo "<script>
                        alert('Password baru yang dimasukkan tidak cocok!');
                    </script>";
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
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body>
    <div class="style">
        <div class="container">
            <h2>Ubah Password</h2>
            <form action="" method="post">
                <label>Username:</label>
                <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" readonly>

                <label>Password Saat Ini:</label>
                <input type="password" name="currentPassword" required>

                <label>Password Baru:</label>
                <input type="password" name="newPassword1" required>

                <label>Ulangi Password Baru:</label>
                <input type="password" name="newPassword2" required>

                <input type="submit" value="Ubah Password" name="btnSubmit">
            </form>
            <a href="index.php" class="back-btn">⬅ Kembali ke Home</a>
        </div>
    </div>
</body>
</html>