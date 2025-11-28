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


    
    $isDosen = ($_SESSION['username'][0] === 'D');
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
    <div class="styleTampilan">

        
            
        <?php

            if (isset($_GET['search'])) {
                $jumlahData = $objGrup->getAllGrup()->num_rows;
                $result = $objGrup->getGrupLimit($start, $perpage);

            } elseif (isset($_GET['list'])) {
                $jumlahData = $objAkun->getGrupList($_SESSION['username'])->num_rows;
                $result = $objAkun->getGrupLimit($_SESSION['username'],$start, $perpage); //data yang didapat adalah data diaman user adalah member grup, BUKAN PEMBUAT GRUP
            }

            if($type == "search"){
                echo "<h2>CARI GRUP</h2>";
            } else {
                echo "<h2>GRUPMU</h2>";
            }

            if ($isDosen && $type == "list") echo '<a href="insertgrup.php"><button>BUAT GRUP</button></a>';

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
                    echo "<a href='tampilangrup.php?p=$x&search=$perpage'>Next</a> ";
                }

                echo "<a href='tampilangrup.php?p=$totalpage&search=$perpage'>Last</a><br><br><br>";

                //! search bar blm berfungsi
                echo "<input type='text' onchange='' placeholder='Search...'>";

            echo"</div>";
        ?>
    </div>


    <div class="styleGrup">
        <?php while($grup = $result->fetch_assoc()) {
            if ($_SESSION['username'] == $grup['username_pembuat']){
                echo '<div class="grup" style="background: rgba(75, 75, 75, 0.9);">';
            }
            else {
                echo '<div class="grup" >';
            }

            echo '
                <div class="image">
                    <img src="https://w7.pngwing.com/pngs/288/840/png-transparent-computer-icons-user-crowd-social-group-others-miscellaneous-monochrome-social-group-thumbnail.png" alt="Profile Grup">
                </div>
                <div class="grupDesc">
                    <h2>'.$grup['nama'].'</h2>
                    <p>'.$grup['deskripsi'].'</p>
                    <div class="infoGrup">
                        <p>Dibuat oleh : '.$grup['namaPembuat'].'</p> 
                        <p>Dibuat pada : '.$grup['tanggal_pembentukan'].'</p> ';

                        if ($_SESSION['username'] == $grup['username_pembuat']){
                            echo '<p>kode : '.$grup['kode_pendaftaran'].'</p>';
                        }
            echo'   </div>
                    <a href="detilgrup.php?id='.$grup['idgrup'].'"><button>Lihat Detail</button></a>
                </div>
            </div>
            ';

        } ?>
        
    </div>

</body>

</html>