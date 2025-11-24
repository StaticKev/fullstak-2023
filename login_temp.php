<?php
session_start();
require_once("service/akun.php");
$objAkun = new akun();


if (isset($_SESSION['login'])) {
    header("Location: index.php");
    exit();
}
else {    
    $objAkun->makeAdmin();
}

if (isset($_POST['loginAttempt'])) {
    $user = $objAkun -> login($_POST['username'], $_POST['password']);

        if ($user) {
            $_SESSION['login'] = true;
            $_SESSION['username'] = $user['username'];
            $_SESSION['admin'] = $user['isadmin'];

            header("Location: index.php");
            exit();
        } else {
            echo "<script>alert('invalid username or password')</script>";
        }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class ="styleTampilan">
        <div class="login-container">
            <h2>LOGIN</h2>
            <form action="" method="post">
                <input type="text" name="username" placeholder="Username" required maxlength="10">
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="loginAttempt">Masuk</button>
            </form>

            <!-- <a href="#">Daftar</a> -->
        </div>

    </div>
</body>
</html>
