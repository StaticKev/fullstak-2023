<?php
require_once("conn.php");

class dosen extends connection
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllDosen($pNPK = "0")
    {
        if ($pNPK != "0") {
            $sql = "SELECT * FROM dosen WHERE npk = ?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("s", $pNPK);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            $sql = "SELECT * FROM dosen";
            $stmt = $this->con->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
        }

        return $result;
    }

    public function getDosenLimit($offset = 0, $limit = 0)
    {
        $sql = "SELECT * FROM dosen LIMIT ?,?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("ii", $offset, $limit);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function insertDosen($pNPK, $pNAMA, $pFotoExtention)
    {
        $sql = "INSERT INTO dosen(npk, nama, foto_extension) VALUES(?,?,?)";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('sss', $pNPK, $pNAMA, $pFotoExtention);
        return $stmt->execute();
    }

    public function deleteDosen($pNPK)
    {
        $sqlDosen = "DELETE FROM dosen WHERE npk=?";
        $stmtDosen = $this->con->prepare($sqlDosen);
        $stmtDosen->bind_param("s", $pNPK);
        return $stmtDosen->execute();
    }

    public function updateDosen($pNPK, $pNAMA, $pFotoExtention)
    {
        $sql = "UPDATE dosen SET nama=?, foto_extension=? WHERE npk=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('sss', $pNAMA, $pFotoExtention, $pNPK);
        return $stmt->execute();
    }
}