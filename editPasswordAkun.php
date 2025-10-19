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
    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
            background-color: #121212;
            background-image: radial-gradient(circle at top left, #1c1c1c 0%, #000 80%);
            color: #f1f1f1;
        }

        .container {
            background: rgba(20, 20, 20, 0.95);
            padding: 40px 50px;
            border-radius: 16px;
            box-shadow: 0 0 20px #00bcd4;
            backdrop-filter: blur(8px);
            text-align: center;
            animation: glow 2s infinite alternate;
            width: 350px;
        }

        @keyframes glow {
            0%   { box-shadow: 0 0 10px #00bcd4; }
            50%  { box-shadow: 0 0 20px #0097a7; }
            100% { box-shadow: 0 0 10px #00bcd4; }
        }

        h2 {
            margin-bottom: 25px;
            color: #00e5ff;
            font-size: 24px;
            letter-spacing: 1px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0 16px 0;
            background: #2a2a2a;
            border: none;
            border-radius: 6px;
            color: white;
            font-size: 14px;
        }

        input[type="submit"] {
            background-color: #00bcd4;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
            font-weight: bold;
            transition: 0.2s;
        }

        input[type="submit"]:hover {
            background-color: #0097a7;
        }

        a {
            color: #00bcd4;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            color: #0097a7;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php include('header.php'); ?> 
        <h2>Ubah Password Akun</h2>
        <form action="" method="post">
            <input type="text" name="username" value="<?php echo $username?>" readonly>
            <input type="password" name="newPassword" placeholder="Masukkan password baru">
            <input type="submit" value="Ubah" name="btnSubmit">
        </form>
    </div>
</body>
</html>
