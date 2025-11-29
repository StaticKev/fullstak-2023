<?php
require_once("conn.php");

class grup extends connection
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getMemberList($pIdGrup, $pNomor = 0){
        if($pNomor != 0){
            $sql = "SELECT a.username FROM member_grup m INNER JOIN akun a ON m.username = a.username WHERE m.idgrup = ? AND CONCAT(a.nrp_mahasiswa, a.npk_dosen) LIKE ?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("ss", $pIdGrup, '%'.$pNomor.'%');

        }
        else {
            $sql = "SELECT a.username, a.nrp_mahasiswa, a.npk_dosen FROM member_grup m INNER JOIN akun a ON m.username = a.username WHERE m.idgrup = ?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("s", $pIdGrup);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    public function createGrup($pPembuat, $pNama, $pDeskripsi, $pTanggal, $pJenis)
    {
        $input = microtime(true); //bisa pake daftar huruf dan angka tapi ini lebih unik lalu di hash juga
        $hash = hash('sha256', $input); // Hash (64 karakter)
        $kode = '';
        $max = strlen($hash) - 1;
        for ($i = 0; $i < 6; $i++) {
            $randomIndex = random_int(0, $max); // Ambil 1 index karakter acak dari hash, lalu di concat ke kode
            $kode .= $hash[$randomIndex];
        }

        $sql = "INSERT INTO grup(username_pembuat, nama, deskripsi, tanggal_pembentukan, jenis, kode_pendaftaran) VALUES(?,?,?,?,?,?)";
        $stmt1 = $this->con->prepare($sql);
        $stmt1->bind_param('ssssss', $pPembuat, $pNama, $pDeskripsi, $pTanggal, $pJenis, $kode);
        if (!$stmt1->execute()) {
            return false;
        }

        $groupId = $stmt1->insert_id; 

        $sql = "INSERT INTO member_grup(username, idgrup) VALUES(?,?)";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("si", $pPembuat, $groupId);
        
        return $stmt->execute();
    }

    public function deleteGrup($pIdGrup)
    {
        $sql = "DELETE FROM grup WHERE idgrup=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $pIdGrup);
        return $stmt->execute();
    }

    public function addMember($pNomor, $pIdGrup){  //! ini untuk admin atau dosen yang mau edit - edit gitu || PAKE NOMOR KARENA SEARCHNYA PAKE NPK ATAU NRP => SESUAI DOCS
        $sql = "INSERT INTO member_grup(username, idgrup) VALUES( (SELECT username FROM akun WHERE CONCAT(nrp_mahasiswa, npk_dosen) LIKE ?,?)";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("si", '%'.$pNomor.'%', $pIdGrup);
        return $stmt->execute();
    }

    public function removeMember($pUsername, $pIdGrup){ //! ini untuk admin atau dosen yang mau edit - edit gitu
        $sql = "DELETE FROM member_grup WHERE username=? AND idgrup=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("si", $pUsername, $pIdGrup);
        return $stmt->execute();
    }

    public function getAllGrup($pSearch = "")
    {
        if ($pSearch != "") {
            $sql = "SELECT * FROM grup WHERE judul LIKE ?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("s", '%'.$pSearch.'%');
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            $sql = "SELECT * FROM grup";
            $stmt = $this->con->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
        }

        return $result;
    }

    public function getGrupLimit($offset = 0, $limit = 0)
    {
        $sql = 
        "SELECT (SELECT d.nama
                 FROM akun a 
                 INNER JOIN dosen d ON a.npk_dosen = d.npk 
                 WHERE a.username = g.username_pembuat) 
                AS namaPembuat,
        g.* FROM grup g LIMIT ?,?
        
        ";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("ii", $offset, $limit);
        $stmt->execute();
        return $stmt->get_result();
    }
}
