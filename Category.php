<?php
require_once 'Database.php';
class Category extends Database
{

    public function addCategory($category) {
        $data = [
            'name' => $category
        ];
        return $this->executeInsert('categories', $data);

    }

    public function getCategories() {
        $sql = "SELECT * FROM categories";
        $statement = $this->conn->query($sql);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


}