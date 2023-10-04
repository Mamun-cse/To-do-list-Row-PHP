<?php
require_once 'Database.php';
class Task extends Database
{
    // Add task parts
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

    // Get taskByCategory wise
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

    // Delete task parts
    public function deleteTask($id) {
        $sql = "DELETE FROM todo_items WHERE id = :id";
        $statement = $this->conn->prepare($sql);
        $statement->bindParam(':id', $id);
        return $statement->execute();
    }

    // Edit task parts
    public function editTask($id, $editedTask) {
        $sql = "UPDATE todo_items SET task = :editedTask WHERE id = :id";
        $statement = $this->conn->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->bindParam(':editedTask', $editedTask);
        return $statement->execute();
    }

}
?>