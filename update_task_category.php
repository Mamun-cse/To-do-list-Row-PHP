<?php
require_once 'Todo.php';
//header("Content-type: application/json; charset=utf-8");
if (isset($_POST['taskId']) && isset($_POST['categoryId'])) {
    $taskId = $_POST['taskId'];
    $categoryId = $_POST['categoryId'];

    $todo = new Todo();
    $success = $todo->updateTaskCategory($taskId, $categoryId);
    //var_dump($success);
    echo $success;

}
?>
