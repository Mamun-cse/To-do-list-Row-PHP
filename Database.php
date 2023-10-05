<?php

class Database{
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $dbname = 'todolist';

    public $conn;
    public function __construct(){
        try{
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname",$this->username,$this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function executeInsert($table, $data) {
        $columns = implode(', ', array_keys($data));
        $values = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        $statement = $this->conn->prepare($sql);
        return $statement->execute($data);
    }

}
?>