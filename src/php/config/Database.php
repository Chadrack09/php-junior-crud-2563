<?php

class Database {
    private $host = "localhost";
    private $db_name = "id20151739_juniordb";
    private $username = "id20151739_root";
    private $password = "{1H6ky=wCC*CjnJu";
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>
