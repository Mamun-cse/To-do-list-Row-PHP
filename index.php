<?php
require_once  'Task.php';
require_once 'Category.php';

//$todo = new Todo();
$tasks = new Task();
$category = new Category();

// Check if the category form is submitted
if (isset($_POST['new_category'])) {
    $newCategory = $_POST['new_category'];
    $category->addCategory($newCategory);

    header('Location: index.php');
    exit;
}
// Get a list of categories
$categories = $category->getCategories();


// Add new task
if (isset($_POST['task']) && isset($_POST['category'])) {
    $categoryId = $_POST['category'];
    $task = $_POST['task'];
    $tasks->insertTask($categoryId, $task);
    header('Location: index.php');
    exit;
}

// Get tasks grouped by category
$tasksByCategory = $tasks->getTasksByCategory();

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $tasks->deleteTask($id);
    header('Location: index.php');
    exit;
}

if (isset($_POST['edited_task']) && isset($_GET['edit'])) {
    $editedTask = $_POST['edited_task'];
    $editedId = $_GET['edit'];
    $tasks->editTask($editedId, $editedTask);
    // Redirect back to the same page after updating the task
    header('Location: index.php');
    exit;
}

//$tasks = $todo->getTasks();
require_once 'template.php';
?>
