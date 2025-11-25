<?php
require_once("conn.php");

class mahasiswa extends connection
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllMahasiswa($pNRP = "0")
    {
        if ($pNRP != "0") {
            $sql = "SELECT * FROM mahasiswa WHERE nrp = ?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("s", $pNRP);
            $stmt->execute();
            $result = $stmt->get_result();

        } else {
            $sql = "SELECT * FROM mahasiswa";
            $stmt = $this->con->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
        }

        return $result;
    }

    public function getMahasiswaLimit($offset = 0, $limit = 0)
    {
        $sql = "SELECT * FROM mahasiswa LIMIT ?,?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("ii", $offset, $limit);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function insertMahasiswa($pNRP, $pNAMA, $pGender, $pTanggalLahir, $pAngkatan, $pFotoExtention)
    {
        $sql = "INSERT INTO mahasiswa(nrp, nama, gender, tanggal_lahir, angkatan, foto_extention) VALUES(?,?,?,?,?,?)";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('ssssss', $pNRP, $pNAMA, $pGender, $pTanggalLahir, $pAngkatan, $pFotoExtention);
        return $stmt->execute();
    }

    public function deleteMahasiswa($pNRP)
    {
        $sqlMahasiswa = "DELETE FROM mahasiswa WHERE nrp=?";
        $stmtMahasiswa = $this->con->prepare($sqlMahasiswa);
        $stmtMahasiswa->bind_param("s", $pNRP);
        return $stmtMahasiswa->execute();
    }

    public function updateMahasiswa($pNRP, $pNAMA, $pGender, $pTanggalLahir, $pAngkatan, $pFotoExtention)
    {
        $sql = "UPDATE mahasiswa SET nama=?, gender=?, tanggal_lahir=?, angkatan=?, foto_extention=? WHERE nrp=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('ssssss', $pNAMA, $pGender, $pTanggalLahir, $pAngkatan, $pFotoExtention, $pNRP);
        return $stmt->execute();
    }
}
