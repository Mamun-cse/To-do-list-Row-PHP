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
        if(empty($category_id)){
            $category_id = NULL;
        }
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
        $uncategorizedTasks = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $category = $row['category'];

            if (!isset($tasksByCategory[$category])) {
                $tasksByCategory[$category] = array();
            }
            if($category == null){
                $uncategorizedTasks[] = $row;
            }else{
                $tasksByCategory[$category][] = $row;
            }
        }
        // Append uncategorized tasks to the end of the array
        $tasksByCategory["No Category"] = $uncategorizedTasks;
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

    // Inside your Todo class
    public function updateTaskCategory($taskId, $category) {
        try {
            // Connect to your database (replace with your database credentials)
            $pdo = new PDO("mysql:host=localhost;dbname=todolist", "root", "");

            // Prepare the SQL query
            $stmt = $pdo->prepare("UPDATE todo_items SET category_id = :category WHERE id = :taskId");

            // Bind parameters
            $stmt->bindParam(':category', $category, PDO::PARAM_INT);
            $stmt->bindParam(':taskId', $taskId, PDO::PARAM_INT);

            // Execute the query
             return $stmt->execute();


        } catch (PDOException $e) {
            // Handle any database errors here (e.g., log or display an error message)
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }


}
?>
