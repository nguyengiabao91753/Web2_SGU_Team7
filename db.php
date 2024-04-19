<?php
Class DbConnect{
    private $servername= "localhost:3306";
    private $username= "root";
    private $password= "123456";
    private $dbname= "web2";
    public $conn;
    public function __construct() {
        // Create connection
        $this->conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);
        
    }
    public function getConnect(){
        return $this->conn;
    }

}
