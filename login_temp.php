<?php
session_start();
require_once("conn.php");


if (isset($_SESSION['login'])) {
    header("Location: index.php");
    exit();
}
else {    
    $cek = $con->query("SELECT 1 FROM akun WHERE username = 'admin' LIMIT 1");

    if ($cek && $cek->num_rows === 0) {
        // Kalau belum ada, baru insert
        $hashed_password = password_hash('password', PASSWORD_DEFAULT);
        $sqlAkun = "INSERT INTO akun(username, password, isadmin) VALUES ('admin', ?, 1)";
        $stmtAkun = $con->prepare($sqlAkun);
        $stmtAkun->bind_param("s", $hashed_password);
        $stmtAkun->execute();
    }
}

if (isset($_POST['loginAttempt'])) {

    // Prepare the SQL statement
    $sql = "SELECT username, password, isadmin FROM akun WHERE username=?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $_POST['username']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $valid_username = $user['username'];
        $valid_password = $user['password'];

        // Kalau belum ada user admin yang passwordnya sudah di hash, gunakan kondisi ini dulu
        // if ($_POST['username'] === $valid_username && $_POST['password'] === $valid_password) {
        
        if ($_POST['username'] === $valid_username && password_verify($_POST['password'], $valid_password)) {
            $_SESSION['login'] = true;
            $_SESSION['username'] = $valid_username;
            $_SESSION['admin'] = $user['isadmin'];

            header("Location: index.php");
            exit();
        } else {
            echo "<script>alert('invalid username or password')</script>";
        }
    } else {
        echo "<script>alert('user not found')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
            background: #111;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='40' height='40' viewBox='0 0 40 40'%3E%3Cg fill='none' stroke='%23333' stroke-width='1'%3E%3Cpath d='M20 0v40M0 20h40'/%3E%3C/g%3E%3C/svg%3E");
            background-size: 40px 40px;
            color: #fff;
        }

        .login-container {
            background: rgba(20, 20, 20, 0.9);
            padding: 40px;
            border-radius: 20px;
            animation: glow 2s infinite alternate;
            width: 350px;
            text-align: center;
            backdrop-filter: blur(6px);
        }

        @keyframes glow {
            0%   { box-shadow: 0 0 8px #ffffff; }
            50%  { box-shadow: 0 0 16px #cccccc; }
            100% { box-shadow: 0 0 8px #ffffff; }
        }

        .login-container h2 {
            margin-bottom: 25px;
            color: #ffffff;
            font-size: 28px;
            letter-spacing: 2px;
        }

        .login-container input[type="text"],
        .login-container input[type="password"],
        .login-container button {
            width: 100%;
            height: 45px;
            padding: 0 12px;
            margin: 10px 0;
            border: none;
            border-radius: 10px;
            box-sizing: border-box;
            font-size: 16px;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            background: #2e2e2e;
            color: #fff;
        }

        .login-container input:focus {
            outline: none;
            box-shadow: 0 0 8px #ffffff;
        }

        .login-container button {
            background: linear-gradient(135deg, #ffffff, #cccccc);
            color: #000;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s ease;
            letter-spacing: 1px;
        }

        .login-container button:hover {
            background: linear-gradient(135deg, #cccccc, #ffffff);
            transform: scale(1.03);
        }

        .login-container a {
            display: block;
            margin-top: 20px;
            color: #aaa;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s;
        }

        .login-container a:hover {
            color: #ffffff;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>LOGIN</h2>
        <form action="" method="post">
            <input type="text" name="username" placeholder="Username" required maxlength="10">
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="loginAttempt">Masuk</button>
        </form>
        <!-- Uncomment if registration is needed -->
        <!-- <a href="#">Daftar</a> -->
    </div>
</body>
</html>
