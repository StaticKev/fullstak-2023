<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Projek UTS - Tampilan Mahasiswa</title>
    <style>
        body {
            background-color: #111;
            color: #f1f1f1;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='40' height='40' viewBox='0 0 40 40'%3E%3Cg fill='none' stroke='%23333' stroke-width='1'%3E%3Cpath d='M20 0v40M0 20h40'/%3E%3C/g%3E%3C/svg%3E");
        }

        header {
            background: #1e1e1e;
            padding: 20px 40px;
            box-shadow: 0 0 15px rgba(0,0,0,0.6);
            text-align: center;
        }

        header h1 {
            color: #00bcd4;
            margin: 0;
            font-size: 24px;
            letter-spacing: 2px;
        }

        table {
            width: 90%;
            margin: 50px auto;
            border-collapse: collapse;
            background: rgba(30, 30, 30, 0.95);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(255,255,255,0.1);
        }

        th, td {
            padding: 12px 16px;
            text-align: center;
            border-bottom: 1px solid #333;
        }

        th {
            background-color: #00bcd4;
            color: #000;
            text-transform: uppercase;
            font-weight: bold;
        }

        tr:hover {
            background-color: rgba(255,255,255,0.1);
            transition: 0.3s;
        }

        a {
            color: #00bcd4;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            color: #0097a7;
        }

        .btn-insert {
            display: inline-block;
            margin: 30px auto;
            padding: 12px 25px;
            background: linear-gradient(135deg, #00bcd4, #0097a7);
            color: #000;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-insert:hover {
            transform: scale(1.05);
            background: linear-gradient(135deg, #0097a7, #00bcd4);
        }

        img {
            border-radius: 8px;
        }

        .container {
            text-align: center;
            padding-bottom: 50px;
        }
    </style>
</head>
<body>
	<?php include('header.php'); ?> 
    <header>
        <h1>Data Mahasiswa</h1>
    </header>

    <div class="container">
        <?php
            require_once("conn.php");

            $sql = "SELECT * FROM mahasiswa";
            $stmt = $con->prepare($sql);
            $stmt->execute();

            $result = $stmt->get_result();

            echo "<table>";
            echo "<tr>
                    <th>Gambar</th>
                    <th>NRP</th>
                    <th>Nama</th>
                    <th>Gender</th>
                    <th>Tanggal Lahir</th>
                    <th>Angkatan</th>
                    <th>Aksi</th>
                  </tr>";

            while ($row = $result->fetch_assoc()) {
                $nrp = $row['nrp'];
                $nama = $row['nama'];
                $gender = $row['gender'];
                $tanggal_lahir = $row['tanggal_lahir'];
                $angkatan = $row['angkatan'];
                $ext = $row['foto_extention'];

                echo "<tr>";
                echo "<td>";
                if ($ext != "") {
                    $gambar = "gambar/mahasiswa/$nrp.$ext";
                    echo "<img src='$gambar' width='50' height='50'>";
                } else {
                    echo "Tidak ada foto";
                }
                echo "</td>";
                echo "<td>$nrp</td>";
                echo "<td>$nama</td>";
                echo "<td>$gender</td>";
                echo "<td>$tanggal_lahir</td>";
                echo "<td>$angkatan</td>";

                echo "<td>
                        <a href='editmahasiswa.php?nrp=$nrp'>Edit</a> | 
                        <a href='delmahasiswa.php?nrp=$nrp' onclick=\"return confirm('Yakin hapus mahasiswa ini?');\">Delete</a>
                      </td>";
                echo "</tr>";
            }

            echo "</table>";

            $con->close();
        ?>

        <a href="insertmahasiswa.php" class="btn-insert">+ Insert Mahasiswa Baru</a>
    </div>
</body>
</html>
