<?php
// Include your database connection code here
require_once 'Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $taskId = $_POST['task_id'];
    $completed = $_POST['completed'];

    // Update the task status in the database
    $database = new Database(); // Initialize your database connection
    $sql = "UPDATE todo_items SET completed = :completed WHERE id = :task_id";
    $stmt = $database->conn->prepare($sql);
    $stmt->bindParam(':completed', $completed, PDO::PARAM_INT);
    $stmt->bindParam(':task_id', $taskId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo 'Task status updated successfully.';
    } else {
        echo 'Failed to update task status.';
    }
    header('Location: index.php');
    exit;
    }
?>
