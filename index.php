<?php
require_once 'Todo.php';

$todo = new Todo();

// Get a list of categories
$categories = $todo->getCategories();
// Check if the category form is submitted
if (isset($_POST['new_category'])) {
    $newCategory = $_POST['new_category'];

    // Add the new category to the database
    $todo->addCategory($newCategory);

    // Redirect back to the same page after adding the category
    header('Location: index.php');
    exit;
}

// Get tasks grouped by category
$tasksByCategory = $todo->getTasksByCategory();
 // Add new task
if (isset($_POST['task']) && isset($_POST['category'])) {
    $categoryId = $_POST['category'];
    $task = $_POST['task'];
    $todo->insertTask($categoryId, $task);
    header('Location: index.php');
    exit;
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $todo->deleteTask($id);
    header('Location: index.php');
    exit;
}

if (isset($_POST['edited_task']) && isset($_GET['edit'])) {
    $editedTask = $_POST['edited_task'];
    $editedId = $_GET['edit'];
    $todo->editTask($editedId, $editedTask);
    // Redirect back to the same page after updating the task
    header('Location: index.php');
    exit;
}

$tasks = $todo->getTasks();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>To-Do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .completed {
            text-decoration: line-through;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title text-center">To-Do List</h1>
                    <!-- Category form -->
                    <form method="post">
                        <div class="input-group mb-3">
                            <input type="text" name="new_category" class="form-control" placeholder="New Category">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                        </div>
                    </form>
                    <form method="post">
                        <div class="input-group mb-3">
                            <select name="category" class="form-control">
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                                <?php endforeach; ?>
                                <option value="">No Category</option>
                            </select>
                            <input type="text" name="task" class="form-control" placeholder="Add a new task" required>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-success">Add</button>
                            </div>
                        </div>
                    </form>

                    <!-- Display tasks grouped by category -->
                    <?php foreach ($tasksByCategory as $category => $categoryTasks): ?>
                        <h2><?php echo $category; ?></h2>
                        <ul class="list-group">
                            <?php foreach ($categoryTasks as $task): ?>

                                <li class="list-group-item d-flex justify-content-between align-items-center <?php echo ($task['completed'] ? 'completed' : ''); ?>">
                                    <div>
                                        <?php if (isset($_GET['edit']) && $_GET['edit'] == $task['id']): ?>
                                            <form method="post" action="?edit=<?php echo $task['id']; ?>">
                                                <div class="input-group">
                                                    <input type="text" name="edited_task" class="form-control" value="<?php echo $task['task']; ?>" required>
                                                    <div class="input-group-append">
                                                        <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                                    </div>
                                                </div>
                                            </form>
                                        <?php else: ?>
                                            <input type="checkbox" class="task-checkbox" data-task-id="<?php echo $task['id']; ?>" <?php echo ($task['completed'] ? 'checked' : ''); ?>>
                                            <label class="task-label <?php echo ($task['completed'] ? 'completed' : ''); ?>">
                                                <?php echo $task['task']; ?>
                                            </label>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <?php if (!isset($_GET['edit']) || $_GET['edit'] != $task['id']): ?>
                                            <a href="?edit=<?php echo $task['id']; ?>" class="btn btn-warning btn-sm ml-2"><i class="fas fa-pencil-alt"></i></a>
                                        <?php endif; ?>
                                        <a href="?delete=<?php echo $task['id']; ?>" class="btn btn-danger btn-sm ml-2"><i class="fas fa-trash-alt"></i></a>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var checkboxes = document.querySelectorAll('.task-checkbox');

        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                var taskId = this.getAttribute('data-task-id');
                var completed = this.checked ? 1 : 0;

                // Send a request to the server to update the task status
                fetch('update_task_status.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'task_id=' + taskId + '&completed=' + completed,
                })
                    .then(function(response) {
                        if (response.ok) {
                            return response.text();
                        } else {
                            throw new Error('Network response was not ok');
                        }
                    })
                    .then(function(data) {
                        // Handle the response from the server (if needed)
                        console.log(data);
                    })
                    .catch(function(error) {
                        console.error('Fetch error:', error);
                    });
            });
        });
    });
</script>



</body>
</html>

