<?php
require_once 'Task.php';
require_once 'Category.php';
require_once 'Update.php';


class TodoList
{
    private $tasks;
    private $category;
    private $update;

    public function __construct()
    {
        $this->tasks = new Task();
        $this->category = new Category();
        $this->update = new Update();
    }

    //Category parts

    // Add new category
     public function handleCategoryForm(){
         // Check if the category form is submitted
         if (isset($_POST['newCategory'])) {
             $newCategory = $_POST['newCategory'];
             $this->category->addCategory($newCategory);

             header('Location: index.php');
             exit;
         }
     }
     public function getCategories(){
         return $this->category->getCategories();
     }

     //Task parts

    // Add new task
    public function handelTaskForm(){
        if (isset($_POST['task']) && isset($_POST['category'])) {
            $categoryId = $_POST['category'];
            $task = $_POST['task'];
            $this->tasks->insertTask($categoryId, $task);
            header('Location: index.php');
            exit;
        }
    }

    // Get task by category wise
    public function getTasksByCategory(){
        return $this->tasks->getTasksByCategory();
    }

    // Edit task parts
    public function handleEditTask(){
        if (isset($_POST['editedTask']) && isset($_GET['edit'])) {
            $editedTask = $_POST['editedTask'];
            $editedId = $_GET['edit'];
            $this->tasks->editTask($editedId, $editedTask);
            // Redirect back to the same page after updating the task
            header('Location: index.php');
            exit;
        }
    }

    // Delete task parts
    public function handleDeleteTask(){
        if (isset($_GET['delete'])) {
            $id = $_GET['delete'];
            $this->tasks->deleteTask($id);
            header('Location: index.php');
            exit;
        }

    }

    // Update checkbox and drag and drop

    // Update check box is it completed or not
    public function handelUpdateTaskStatus(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $taskId = $_POST['task_id'];
            $completed = $_POST['completed'];

            return $this->update->updateTaskStatus($taskId, $completed);

        }else{
            return false;
        }
    }

    //Update Category when drag and drop
    public function handelUpdateTaskCategory(){
        if (isset($_POST['taskId']) && isset($_POST['categoryId'])) {
            $taskId = $_POST['taskId'];
            $categoryId = $_POST['categoryId'];

            return $this->update->updateTaskCategory($taskId, $categoryId);

        }else{
            return false;
        }
    }


}