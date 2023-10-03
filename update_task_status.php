<?php
require_once 'Todo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $taskId = $_POST['task_id'];
    $completed = $_POST['completed'];

    //$database = new Database();
    $todo = new Todo();
    $result = $todo->updateTaskStatus($taskId, $completed);
    echo $result;

    //header('Location: index.php');
    //exit;
    }
?>
