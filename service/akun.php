<?php
require_once("conn.php");

class akun extends connection
{
    public function __construct()
    {
        parent::__construct();
    }

    public function makeAdmin()
    {
        $sql = "SELECT * FROM akun WHERE username = 'admin' LIMIT 1";

        if ($this->con->query($sql)->num_rows === 0) {
            $hashed_password = password_hash('password', PASSWORD_DEFAULT);
            $sqlAkun = "INSERT INTO akun(username, password, isadmin) VALUES ('admin', ?, 1)";
            $stmtAkun = $this->con->prepare($sqlAkun);
            $stmtAkun->bind_param("s", $hashed_password);
            $stmtAkun->execute();
        }
    }

    public function login($inputUsername, $inputPassword)
    {
        $sql = "SELECT username, password, isadmin FROM akun WHERE username=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $inputUsername);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($inputUsername === $user['username'] && password_verify($inputPassword, $user['password'])) {
            return $user;
        } else {
            return false;
        }
    }

    public function insertAkun($username, $hashed_password, $nrp_mahasiswa, $npk_dosen, $isadmin)
    {
        $sqlAkun = "INSERT INTO akun(username, password, nrp_mahasiswa, npk_dosen, isadmin) 
					VALUES (?, ?, ?, ?, ?)";
        $stmtAkun = $this->con->prepare($sqlAkun);
        $stmtAkun->bind_param("ssssi", $username, $hashed_password, $nrp_mahasiswa, $npk_dosen, $isadmin);
        $stmtAkun->execute();
    }

    public function deleteAkun($pUsername)
    {
        $sqlAkun = "DELETE FROM akun WHERE username=?";
        $stmtAkun = $this->con->prepare($sqlAkun);
        $stmtAkun->bind_param("s", $pUsername);
        return $stmtAkun->execute();
    }

    public function changePwd($pUsername, $pPassword)
    {
        $sql2 = "UPDATE akun SET password = ? WHERE username = ?";
        $stmt = $this->con->prepare($sql2);
        $stmt->bind_param("ss", $pPassword, $pUsername);
        return $stmt->execute();
    }

    public function getPassword($pUsername)
    {

        $sql = "SELECT password FROM akun WHERE username = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $pUsername);
        $stmt->execute();
        $stmt->bind_result($storedPassword);
        $stmt->fetch();
        $stmt->close();
        return $storedPassword;
    }

    public function getGrupList($pUsername){
        $sql = "SELECT g.* FROM member_grup m INNER JOIN grup g ON m.idgrup = g.idgrup WHERE m.username = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $pUsername);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result;
    }

    public function addGrup($pUsername, $pIdGrup, $kodeDaftar){ //! KURANG cek kodenya, kalo bener, maka masukin ke member_grup  || untuk mahasiswa yg mau gabung
        $sql = "INSERT INTO member_grup(username, idgrup) VALUES(?,?)";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("si", $pUsername, $pIdGrup);
        return $stmt->execute();
    }


}
