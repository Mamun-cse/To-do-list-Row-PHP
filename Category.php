<?php
require_once 'Database.php';
class Category extends Database
{
    public function addCategory($category) {
        $sql = "INSERT INTO categories (name) VALUES (:category)";
        $statement = $this->conn->prepare($sql);
        $statement->bindParam(':category', $category);
        return $statement->execute();
    }

    public function getCategories() {
        $sql = "SELECT * FROM categories";
        $statement = $this->conn->query($sql);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


}