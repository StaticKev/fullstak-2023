<?php
session_start();
include_once('service/grup.php');
include_once('service/akun.php');
$objGrup = new grup();
$objAkun = new akun();

if (!isset($_GET['search']) && !isset($_GET['list'])) {
    header("Location: index.php");
    exit();
}

if (!isset($_SESSION['login'])) {
    header("Location: login_temp.php");
    exit();
}

if (isset($_GET['search'])) {
    $perpage = $_GET['search'];
    $type = "search";
} elseif (isset($_GET['list'])) {
    $perpage = $_GET['list'];
    $type = "list";
}

if (isset($_GET['p'])) {
    $p = $_GET['p'];
    $start = ($p - 1) * $perpage;
} else {
    $p = 1;
    $start = 0;
}

if (isset($_GET['search'])) {
    $jumlahData = $objGrup->getAllGrup()->num_rows;
    $result = $objGrup->getGrupLimit($start, $perpage);

} elseif (isset($_GET['list'])) {
    $jumlahData = $objAkun->getGrupLimit($_SESSION['username'],$start, $perpage)->num_rows;
    $result = $objGrup->getGrupLimit($start, $perpage);
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grup</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include('header.php'); ?>
    <h2></h2>
    <div class="styleTampilan">

        <h2>CARI GRUP</h2>
        <?php
        echo //pagging
        "<div class='paging'>
            <form method='get' action='tampilangrup.php'>
                Per Page
                <select name='" . $type . "' onchange='this.form.submit()'>
                    <option value='2' " . ($perpage == 2 ? "selected" : "") . ">2</option>
                    <option value='3' " . ($perpage == 3 ? "selected" : "") . ">3</option>
                    <option value='4' " . ($perpage == 4 ? "selected" : "") . ">4</option>
                    <option value='5' " . ($perpage == 5 ? "selected" : "") . ">5</option>
                </select>
            </form>";

            $totalpage = ceil($jumlahData / $perpage);

            echo "<a href='tampilangrup.php?p=1&search=$perpage'>First</a> ";
            if ($p == 1) {
                echo "Prev ";
            } else {
                $x = $p - 1;
                echo "<a href='tampilangrup.php?p=$x&search=$perpage'>Prev</a> ";
            }

            for ($i = 1; $i <= $totalpage; $i++) {
                echo "<a href='tampilangrup.php?p=$i&search=$perpage'>$i</a> ";
            }

            if ($p == $totalpage) {
                echo "Next ";
            } else {
                $x = $p + 1;
                echo "<a href='tampilandosen.php?p=$x&cboPage=$perpage'>Next</a> ";
            }

            echo "<a href='tampilandosen.php?p=$totalpage&cboPage=$perpage'>Last</a><br><br><br>";

            //! search bar blm berfungsi
            echo "<input type='text' onchange='' placeholder='Search...'>";

        echo"</div>";
        
        ?>

    </div>


    <div class="styleGrup">
        <!-- tinggal nanti di looping yang div dgn class grup dibawah -->
        <div class="grup">
            <div class="image">
                <img src="https://www.imatest.com/wp-content/uploads/2022/01/sfrreg_center_chart_90h.png" alt="Profile Grup">
            </div>
            <div class="grupDesc">
                <h2>Nama Grup</h2>
                <p>Deskripsi grup ini</p>
                <div class="infoGrup">
                    <p>Dibuat oleh : </p> <!-- //! masukin pembuatnya dan tgl -->
                    <p>Dibuat pada : </p> 
                </div>
                <a href="detilgrup.php?id=???"><button>Lihat Detail</button></a> <!-- //! kirim id grupnya pake GET -->
            </div>
        </div>
        
    </div>

</body>

</html>