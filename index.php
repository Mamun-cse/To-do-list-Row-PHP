<?php
require_once  'Task.php';
require_once 'Category.php';
require_once 'TodoList.php';

$todoList = new TodoList();

$todoList->handleCategoryForm();
// Get a list of categories
$categories = $todoList->getCategories();

// Add new task
$todoList->handelTaskForm();

// Get tasks grouped by category
$tasksByCategory = $todoList->getTasksByCategory();

// Edit task
$todoList->handleEditTask();

// Delete task
$todoList->handleDeleteTask();

// UpdateTaskCategory
$todoList->handelUpdateTaskCategory();

// UpdateTaskStatus
$todoList->handelUpdateTaskStatus();

// HTML template
require_once 'template.php';
?>
