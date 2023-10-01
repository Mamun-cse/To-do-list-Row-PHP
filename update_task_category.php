<?php
require_once 'Todo.php'; // Include your database connection and task management code
if (isset($_POST['taskId']) && isset($_POST['categoryId'])) {
    $taskId = $_POST['taskId'];
    $categoryId = $_POST['categoryId'];

    $todo = new Todo(); // Replace with your class name
    $success = $todo->updateTaskCategory($taskId, $categoryId); // Implement this function
    var_dump($success);
    return $success;

} else {
    return false;
}
?>
