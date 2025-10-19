<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Projek UTS - Tampilan Dosen</title>
    <style>
        body {
            margin: 0;
            height: 100vh;
            font-family: 'Segoe UI', sans-serif;
            background: #111;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='40' height='40' viewBox='0 0 40 40'%3E%3Cg fill='none' stroke='%23333' stroke-width='1'%3E%3Cpath d='M20 0v40M0 20h40'/%3E%3C/g%3E%3C/svg%3E");
            background-size: 40px 40px;
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 0;
        }

        h2 {
            text-align: center;
            font-size: 28px;
            letter-spacing: 2px;
            margin-bottom: 30px;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            background: rgba(20, 20, 20, 0.9);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 0 10px #fff2;
            backdrop-filter: blur(6px);
        }

        th, td {
            border-bottom: 1px solid #333;
            padding: 15px;
            text-align: center;
        }

        th {
            background: linear-gradient(135deg, #ffffff, #cccccc);
            color: #000;
        }

        tr:hover {
            background-color: #222;
        }

        img {
            border-radius: 10px;
            box-shadow: 0 0 6px #000;
        }

        a {
            text-decoration: none;
            color: #fff;
            margin: 0 5px;
            transition: 0.3s;
        }

        a:hover {
            color: #ccc;
        }

        .button-container {
            margin-top: 30px;
        }

        .btn {
            background: linear-gradient(135deg, #ffffff, #cccccc);
            color: #000;
            padding: 12px 25px;
            border: none;
            border-radius: 10px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            letter-spacing: 1px;
        }

        .btn:hover {
            transform: scale(1.05);
            background: linear-gradient(135deg, #cccccc, #ffffff);
        }
    </style>
</head>
<body>
    <h2>DAFTAR DOSEN</h2>
	<?php include('header.php'); ?> 

    <?php
        require_once("conn.php");

        $sql = "SELECT * FROM dosen";
        $stmt = $con->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();

        echo "<table>";
        echo "<tr>
                <th>Gambar</th>
                <th>NPK</th>
                <th>Nama</th>
                <th>Aksi</th>
              </tr>";

        while ($row = $result->fetch_assoc()) {
            $npk  = $row['npk'];
            $nama = $row['nama'];
            $ext  = $row['foto_extension'];

            echo "<tr>";
            echo "<td>";
            if ($ext != '') {
                $gambar = "gambar/dosen/$npk.$ext";
                echo "<img src='$gambar' width='50' height='50'>";
            } else {
                echo "Tidak ada foto";
            }
            echo "</td>";
            echo "<td>$npk</td>";
            echo "<td>$nama</td>";

            echo "<td>
                    <a href='editdosen.php?npk=$npk'>Edit</a> | 
                    <a href='deldosen.php?npk=$npk' onclick=\"return confirm('Yakin hapus dosen ini?');\">Delete</a>
                  </td>";
            echo "</tr>";
        }

        echo "</table>";

        $con->close();
    ?>

    <div class="button-container">
        <a href="insertdosen.php">
            <button class="btn">Insert Dosen Baru</button>
        </a>
    </div>
</body>
</html>
