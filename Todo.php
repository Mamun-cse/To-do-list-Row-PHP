<?php
require_once 'Database.php';

class Todo extends Database {
    public function addCategory($category) {
        $sql = "INSERT INTO categories (name) VALUES (:category)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':category', $category);
        return $stmt->execute();
    }
    public function insertTask($category_id, $task) {
        $sql = "INSERT INTO todo_items (category_id, task) VALUES (:category_id, :task)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':task', $task);
        return $stmt->execute();
    }
    public function getCategories() {
        $sql = "SELECT * FROM categories";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTasks() {
        $sql = "SELECT t.id, t.task, c.name as category, t.created_at FROM todo_items t LEFT JOIN categories c ON t.category_id = c.id ORDER BY t.created_at ASC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getTasksByCategory() {
        $sql = "SELECT categories.name AS category, todo_items.* FROM todo_items
                LEFT JOIN categories ON todo_items.category_id = categories.id
                ORDER BY categories.name ASC, todo_items.created_at ASC";

        $stmt = $this->conn->query($sql);
        $tasksByCategory = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $category = $row['category'];

            if (!isset($tasksByCategory[$category])) {
                $tasksByCategory[$category] = array();
            }

            $tasksByCategory[$category][] = $row;
        }

        return $tasksByCategory;
    }
    public function deleteTask($id) {
        $sql = "DELETE FROM todo_items WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    public function editTask($id, $editedTask) {
        $sql = "UPDATE todo_items SET task = :editedTask WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':editedTask', $editedTask);
        return $stmt->execute();
    }

}
?>
