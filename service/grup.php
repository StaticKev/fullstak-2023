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

    public function createGrup($pIdGrup, $pJudul, $pSlug, $pTanggal, $pKeterangan, $pJenis, $pPosterExt)
    {
        $sql = "INSERT INTO event(idgrup, judul, judul-slug, tanggal, keterangan, jenis, poster_extension) VALUES(?,?,?,?,?,?,?)";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('issssss', $pIdGrup, $pJudul, $pSlug, $pTanggal, $pKeterangan, $pJenis, $pPosterExt);
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
        $sql = "SELECT * FROM grup LIMIT ?,?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("ii", $offset, $limit);
        $stmt->execute();
        return $stmt->get_result();
    }
}
