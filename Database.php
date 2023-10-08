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

    public function executeDelete($table, $where){
        $conditions = [];
        foreach ($where as $key => $value){
            $conditions[] = "$key = :$key";
        }
        $whereClause = implode('AND',$conditions);
        $sql = "DELETE FROM $table WHERE $whereClause";
        $statement = $this->conn->prepare($sql);
        return $statement->execute($where);
        //return $statement->rowCount();
    }

    public function executeUpdate($table, $data, $where){
        $columns = [];
        foreach ($data as $key => $value){
            $columns[] = "$key = :$key";
        }
        $setColumns = implode(',', $columns);

        $conditions = [];
        foreach ($where as $key => $value){
            $conditions[] = "$key = :$key";
        }
        $whereClause = implode('AND',$conditions);

        $sql = "UPDATE $table SET $setColumns WHERE $whereClause";
        $statement = $this->conn->prepare($sql);
        return $statement->execute(array_merge($data, $where));

    }

}
?>