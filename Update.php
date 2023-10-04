<?php
require_once 'Database.php';

class Update extends Database {

    public function updateTaskStatus($taskId, $completed){

        $sql = "UPDATE todo_items SET completed = :completed WHERE id = :task_id";

        $statement = $this->conn->prepare($sql);
        $statement->bindParam(':completed', $completed, PDO::PARAM_INT);
        $statement->bindParam(':task_id', $taskId, PDO::PARAM_INT);

        return $statement->execute();
    }

    public function updateTaskCategory($taskId, $categoryId){


        $sql = "UPDATE todo_items SET category_id = :categoryId WHERE id = :taskId";

        $statement = $this->conn->prepare($sql);

        // Bind parameters
        $statement->bindParam(':categoryId', $categoryId,PDO::PARAM_INT);

        $statement->bindParam(':taskId', $taskId, PDO::PARAM_INT);

        //return $statement->execute();
        if($statement->execute()){
            return json_encode(["success" => true, "message" => 'success']);
        } else {
            return json_encode(["success" => false, "message" => 'fail']);
        }
    }

}
?>
