<?php
    session_start();
    include_once('service/event.php'); 
    include_once('service/grup.php'); 

    $objEvent = new event();
    $objGrup = new grup(); 

    if (!isset($_SESSION['login'])) {
        header("Location: login_temp.php"); 
        exit();
    } elseif (($_SESSION['username'][0] === 'D') == false) {
        header("Location: index.php"); 
        exit();
    }
    
    $listGrup = $objGrup->getAllGrup(); 

    $message = '';
    if (isset($_POST['submit'])) {
        if (
            isset($_POST['txtidgrup']) && 
            isset($_POST['txtjudul']) && 
            isset($_POST['txttanggal']) && 
            isset($_POST['txtketerangan']) && 
            isset($_POST['rad_jenis'])
        ) {
            $idgrup = $_POST['txtidgrup'];
            $judul = $_POST['txtjudul'];
            $tanggal = $_POST['txttanggal'];
            $keterangan = $_POST['txtketerangan'];
            $jenis = $_POST['rad_jenis'];
            
            $judul_slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $judul));

            $poster_extension = '';
            $upload_success = true;
            $uploadDir = 'posters/'; 

            if (isset($_FILES['fileposter']) && $_FILES['fileposter']['error'] == 0) {
                $fileInfo = pathinfo($_FILES['fileposter']['name']);
                $poster_extension = strtolower($fileInfo['extension']);
                
                if (strlen($poster_extension) > 4) {
                     $message = "<div class='error'>Ekstensi file terlalu panjang!</div>";
                     $upload_success = false;
                } else {
                    $temp_file_name = $judul_slug . '-' . time() . '.' . $poster_extension;
                    $uploadPath = $uploadDir . $temp_file_name;
                    
                    if (!move_uploaded_file($_FILES['fileposter']['tmp_name'], $uploadPath)) {
                        $message = "<div class='error'>Gagal mengunggah file poster!</div>";
                        $upload_success = false;
                    }
                }
            } else if (isset($_FILES['fileposter']) && $_FILES['fileposter']['error'] !== 4) {
                 $message = "<div class='error'>Terjadi kesalahan unggahan file: Error " . $_FILES['fileposter']['error'] . "</div>";
                 $upload_success = false;
            }

            if ($upload_success) {
                if($objEvent->createEvent(
                    $idgrup,
                    $judul,
                    $judul_slug,
                    $tanggal,
                    $keterangan,
                    $jenis,
                    $poster_extension
                )){
                    
                    echo "<script>
                        alert('Event berhasil dibuat!');
                        window.location.href = 'index.php'; 
                    </script>";
                }
                else {
                    if ($poster_extension != '' && file_exists($uploadPath)) {
                        unlink($uploadPath);
                    }
                    $message = "<div class='error'>Event gagal dibuat! Terjadi kesalahan database.</div>";
                }
            }
        } else {
            $message = "<div class='error'>Mohon lengkapi semua field yang diperlukan.</div>";
        }
    }
    $jenis_event_options = ['Workshop', 'Seminar', 'Webinar', 'Lainnya']; 
    
    $tglDefault = date("Y-m-d\TH:i");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Event Baru</title>
    <link rel="stylesheet" href="style.css">
    <style>
        textarea {
            width: 100%;
            padding: 10px;
            border-radius: 10px;
            border: none;
            background: #2e2e2e;
            color: #fff;
            box-sizing: border-box;
            font-size: 15px;
            resize: vertical;
        }

        textarea:focus {
            outline: none;
            box-shadow: 0 0 8px #ffffff;
        }
    </style>
</head>

<body>
    <?php include('header.php'); ?>

    <div class="style">
        <div class="container">
            <h2>Buat Event Baru</h2>
            <?php echo $message; ?>
            
            <form method="post" action="insertevent.php" enctype="multipart/form-data" onsubmit="return validateForm()">
                <div>
                    <label for="idgrup">Pilih Grup:</label>
                    <select id="idgrup" name="txtidgrup" required 
                        style="width: 100%; padding: 10px; border-radius: 10px; border: none; background: #2e2e2e; color: #fff; box-sizing: border-box; font-size: 15px;">
                        <option value="">-- Pilih Grup --</option>
                        <?php 
                        if (is_array($listGrup) && count($listGrup) > 0) {
                            foreach ($listGrup as $grup) {
                                echo "<option value='{$grup['idgrup']}'>{$grup['namagrup']}</option>";
                            }
                        } else {
                            echo "<option value='' disabled>Tidak ada Grup tersedia</option>";
                        }
                        ?>
                    </select>
                </div>

                <div>
                    <label for="judul">Judul Event:</label>
                    <input type="text" id="judul" name="txtjudul" maxlength="45" required>
                </div>

                <div>
                    <label for="tanggal">Tanggal & Waktu Event:</label>
                    <input type="datetime-local" id="tanggal" name="txttanggal" value="<?php echo $tglDefault; ?>" required>
                </div>

                <div>
                    <label for="keterangan">Keterangan/Deskripsi:</label>
                    <textarea id="keterangan" name="txtketerangan" rows="5" required></textarea>
                </div>

                <label>Jenis Event:</label>
                <div style="display: flex; gap: 10px; align-items: center;">
                    <?php 
                    foreach ($jenis_event_options as $jenis_opt) {
                        echo "<label><input type='radio' name='rad_jenis' value='{$jenis_opt}' required> {$jenis_opt}</label>";
                    }
                    ?>
                </div>

                <div>
                    <label for="fileposter">Poster Event (Max 4MB):</label>
                    <input type="file" id="fileposter" name="fileposter" accept=".jpg,.jpeg,.png,.gif" required>
                </div>

                <input type="submit" name="submit" value="Insert Event">
            </form>

            <a href="tampilan_eventmu.php">⬅ Kembali ke Eventmu</a>
        </div>
    </div>

    <script>
    function validateForm() {
        const idGrup = document.getElementById('idgrup').value;
        const judul = document.getElementById('judul').value;
        const tanggal = document.getElementById('tanggal').value;
        const keterangan = document.getElementById('keterangan').value;
        const jenis = document.querySelector('input[name="rad_jenis"]:checked');
        const filePoster = document.getElementById('fileposter').value;

        if (idGrup === "") {
            alert("Harap pilih Grup!");
            return false;
        }

        if (judul.trim() === "") {
            alert("Judul Event tidak boleh kosong!");
            return false;
        }
        
        if (tanggal.trim() === "") {
            alert("Tanggal Event tidak boleh kosong!");
            return false;
        }

        if (keterangan.trim() === "") {
            alert("Keterangan tidak boleh kosong!");
            return false;
        }
        
        if (!jenis) {
            alert("Harap pilih Jenis Event!");
            return false;
        }

        if (filePoster === "") {
            alert("Harap unggah Poster Event!");
            return false;
        }
        
        const maxFileSize = 4 * 1024 * 1024; 
        if (document.getElementById('fileposter').files.length > 0 && document.getElementById('fileposter').files[0].size > maxFileSize) {
            alert("Ukuran file poster terlalu besar. Maksimal 4MB.");
            return false;
        }

        return true; 
    }
    </script>

</body>

</html>