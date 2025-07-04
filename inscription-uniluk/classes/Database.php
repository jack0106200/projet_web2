<?php
class Database {
    private $host = "localhost";
    private $dbname = "incription_uniluk";
    private $username = "root";
    private $password = "";
    private $conn; // ✅ On déclare la propriété ici

    public function getConnection() {
        if (!$this->conn) {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return $this->conn;
    }
}

