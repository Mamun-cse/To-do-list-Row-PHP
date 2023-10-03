<?php
require_once 'Database.php';
class Task extends Database
{
    public function insertTask($category_id, $task) {
        $sql = "INSERT INTO todo_items (category_id, task) VALUES (:category_id, :task)";
        if(empty($category_id)){
            $category_id = NULL;
        }
        $statement = $this->conn->prepare($sql);
        $statement->bindParam(':category_id', $category_id);
        $statement->bindParam(':task', $task);
        return $statement->execute();
    }

    public function getTasksByCategory() {
        $sql = "SELECT categories.name AS category, todo_items.* FROM todo_items
                LEFT JOIN categories ON todo_items.category_id = categories.id
                ORDER BY categories.name ASC, todo_items.created_at ASC";

        $statement = $this->conn->query($sql);
        $tasksByCategory = array();
        $uncategorizedTasks = array();

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
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
        $statement = $this->conn->prepare($sql);
        $statement->bindParam(':id', $id);
        return $statement->execute();
    }
    public function editTask($id, $editedTask) {
        $sql = "UPDATE todo_items SET task = :editedTask WHERE id = :id";
        $statement = $this->conn->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->bindParam(':editedTask', $editedTask);
        return $statement->execute();
    }

    /*public function getTasks() {
       $sql = "SELECT t.id, t.task, c.name as category, t.created_at FROM todo_items t LEFT JOIN categories c ON t.category_id = c.id ORDER BY t.created_at ASC";
       $stmt = $this->conn->query($sql);
       return $stmt->fetchAll(PDO::FETCH_ASSOC);
   }*/
}
?>