<?php
    session_start();
    include_once('service/event.php'); 

    $objEvent = new event();

    if (!isset($_SESSION['login'])) {
        header("Location: login_temp.php"); 
        exit();
    } elseif (($_SESSION['username'][0] === 'D') == false) {
        header("Location: index.php"); 
        exit();
    } elseif (!isset($_GET['id'])){
        header("Location: index.php"); 
        exit();
    }

    if (isset($_GET['id'])){
        $idevent = $_GET['id']? : 0;
    
        $result = $objEvent->getEventDetail($idevent);
        $dataEvent = $result->fetch_assoc();
    }
    $message ="";
    

    if (isset($_POST['submit'])) {
            $idevent = $_POST['txtidevent'];
            $judul = $_POST['txtjudul'];
            $tanggal = $_POST['txttanggal'];
            $keterangan = $_POST['txtketerangan'];
            $jenis = $_POST['rad_jenis'];
            $judul_slug = $_POST['txtslug'];
            
            $poster_extension_lama = $dataEvent['poster_extension'];
            $poster_extension_baru = $poster_extension_lama; 

            $upload_success = true;
            $uploadDir = 'posters/event/'; 
            $temp_file_name = '';

            if (isset($_FILES['fileposter']) && $_FILES['fileposter']['error'] == 0) {
                $fileInfo = pathinfo($_FILES['fileposter']['name']);
                $ekstensi_file = strtolower($fileInfo['extension']);
                
                if (strlen($ekstensi_file) > 4) {
                     $message = "<div class='error'>Ekstensi file terlalu panjang!</div>";
                     $upload_success = false;
                } else {
                    $poster_extension_baru = $ekstensi_file;

                    $temp_file_name = $idevent . "." . $poster_extension_baru;
                    $uploadPath = $uploadDir . $temp_file_name;
                    
                    if (!move_uploaded_file($_FILES['fileposter']['tmp_name'], $uploadPath)) {
                        $message = "<div class='error'>Gagal mengunggah file poster baru!</div>";
                        $upload_success = false;
                    } 
                    
                    if ($poster_extension_lama && $poster_extension_lama !== $poster_extension_baru) {
                        $file_lama = $uploadDir . $idevent . "." . $poster_extension_lama;
                        if (file_exists($file_lama)) {
                            unlink($file_lama);
                        }
                    }
                }
            } else if (isset($_FILES['fileposter']) && $_FILES['fileposter']['error'] !== 4) {
                 $message = "<div class='error'>Terjadi kesalahan unggahan file: Error " . $_FILES['fileposter']['error'] . "</div>";
                 $upload_success = false;
                 $poster_extension_baru = $poster_extension_lama;
            }

            if ($upload_success) {
                if($objEvent->updateEvent(
                    $idevent,
                    $judul,
                    $judul_slug,
                    $tanggal,
                    $keterangan,
                    $jenis,
                    $poster_extension_baru 
                )){
                    
                    echo "<script>
                        alert('Event berhasil diperbarui!');
                        window.location.href = 'index.php'; // Ganti ke halaman tampilan event
                    </script>";
                    exit();
                }
                else {
                    $message = "<div class='error'>Event gagal diperbarui! Terjadi kesalahan database atau tidak ada perubahan data.</div>";
                    if ($poster_extension_baru !== $poster_extension_lama && $temp_file_name != '' && file_exists($uploadPath)) {
                        unlink($uploadPath);
                    }
                }
            }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
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

        textarea:focus,
        select:focus {
            outline: none;
            box-shadow: 0 0 8px #ffffff;
        }

        select {
            width: 100%; 
            padding: 10px; 
            border-radius: 10px; 
            border: none; 
            background: #2e2e2e; 
            color: #fff; 
            box-sizing: border-box; 
            font-size: 15px;
        }

        .poster-info {
            font-size: 0.9em;
            color: #aaa;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <?php include('header.php'); ?>

    <div class="style">
        <div class="container">
            <h2>Edit Event: <?php echo htmlspecialchars($dataEvent['judul']); ?></h2>
            <?php echo $message; ?>
            
            <form method="post" action="editevent.php" enctype="multipart/form-data" onsubmit="return validateForm()">
                <input type="hidden" name="txtidevent" value="<?php $idevent; ?>">
                
                <div>
                    <label for="judul">Judul Event:</label>
                    <input type="text" id="judul" name="txtjudul" maxlength="45" required 
                           value="<?php echo htmlspecialchars($dataEvent['judul']); ?>">
                </div>

                <div>
                    <label for="tanggal">Tanggal & Waktu Event:</label>
                    <?php 
                    $tanggal_input = (isset($dataEvent['tanggal'])) ? date('Y-m-d\TH:i', strtotime($dataEvent['tanggal'])) : '';
                    ?>
                    <input type="datetime-local" id="tanggal" name="txttanggal" required 
                           value="<?php echo htmlspecialchars($tanggal_input); ?>">
                </div>

                <div>
                    <label for="keterangan">Keterangan/Deskripsi:</label>
                    <textarea id="keterangan" name="txtketerangan" rows="5" required><?php echo htmlspecialchars($dataEvent['keterangan']); ?></textarea>
                </div>

                <label>Jenis:</label>
                <div style="display: flex; gap: 10px; align-items: center;">
					<label><input type="radio" name="rad_jenis" value="Privat" <?php echo ($dataEvent['jenis'] == 'Privat') ? 'checked' : ''; ?>> Privat</label>
					<label><input type="radio" name="rad_jenis" value="Publik" <?php echo ($dataEvent['jenis'] == 'Publik') ? 'checked' : ''; ?>> Publik</label>
				</div>

                <div>
                    <label for="fileposter">Poster Event (Biarkan kosong jika tidak ingin mengubah):</label>
                    <input type="file" id="fileposter" name="fileposter" accept=".jpg,.jpeg,.png,.gif">
                    <p class="poster-info">
                        File poster saat ini: <?php echo htmlspecialchars($dataEvent['poster_extension'] ? "event_{$idevent}.{$dataEvent['poster_extension']}" : "Belum ada"); ?>
                    </p>
                </div>

                <input type="submit" name="submit" value="Update Event">
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
        const filePoster = document.getElementById('fileposter');

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

        const maxFileSize = 4 * 1024 * 1024; 
        if (filePoster.files.length > 0 && filePoster.files[0].size > maxFileSize) {
            alert("Ukuran file poster terlalu besar. Maksimal 4MB.");
            return false;
        }

        return true; 
    }
    </script>

</body>

</html>