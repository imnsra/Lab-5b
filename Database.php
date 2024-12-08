<?php
class Database
{
    private $host = "localhost";
    private $db_name = "lab_5b";
    private $username = "root";
    private $password = "";
    public $conn;

    // Cara untuk bergabung dengan database
    public function getConnection()
    {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);

        // Check the connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        } else {
            // echo "Connected successfully";
        }

        return $this->conn;
    }
}