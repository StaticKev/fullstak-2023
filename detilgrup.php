<?php
    session_start();
    include_once('service/grup.php');
    $objGrup = new grup();

    if (!isset($_SESSION['login'])) {
        header("Location: login_temp.php");
        exit();
    } 

    // Ini semua nanti diganti hasil query
    $namaGrup = "Grup Kuliah";
    $deskripsi = "bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla";
    $pembuat = "Pak Dosen";
    $tanggalPembentukan = "";
    $jenis = "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Grup</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<h2><?= $namaGrup ?></h2>

    <p><strong>Deskripsi:</strong> <?= $deskripsi ?></p>

    <table style="margin-top: 10px;">
        <tr>
            <td><strong>Pembuat</strong></td>
            <td> <?= $pembuat ?></td>
        </tr>
        <tr>
            <td><strong>Tanggal Dibentuk</strong></td>
            <td> <?= $tanggalPembentukan ?></td>
        </tr>
        <tr>
            <td><strong>Jenis Grup</strong></td>
            <td> <?= $jenis ?></td>
        </tr>
    </table>


<div style="display: flex; gap: 20px;">
    <table border="1">
        <tr><th>Table 1</th></tr>
        <tr><td>A</td></tr>
    </table>

    <table border="1">
        <tr><th>Table 2</th></tr>
        <tr><td>B</td></tr>
    </table>
</div>


</body>

</html>