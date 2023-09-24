<?php
require_once 'Database.php';

class Todo extends Database {
    public function addTask($task) {
        $sql = "INSERT INTO todo_items (task) VALUES (:task)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':task', $task);
        return $stmt->execute();
    }

    public function getTasks() {
        $sql = "SELECT * FROM todo_items ORDER BY created_at ASC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
