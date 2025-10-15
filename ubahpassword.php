<?php
    
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
        <input type="password" name="currentPassword" placeholder="masukkan password saat ini">
        <input type="submit" value="ubah" name="btnSubmit">
    </form>
</body>
</html>