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
                    location.reload();
                })
                .catch(function(error) {
                    console.error('Fetch error:', error);
                });
        });
    });
});

// JavaScript code for drag-and-drop functionality
$(document).ready(function() {
    $(".draggable").draggable({
        helper: "clone"
    });

    $(".list-group").sortable({
        connectWith: ".list-group",
        tolerance: "pointer",
        receive: function(event, ui) {
            var taskId = ui.item.find(".draggable").data("task-id");
            var categoryId = $(this).prev("h2.droppable").data("category_id");
            console.log(taskId);
            console.log(categoryId);

            $.post("update_task_category.php", { taskId: taskId, categoryId: categoryId },function(data,status){
                console.log('tested');
                console.log(data);
                if (data) {
                    alert("Success to update task category.");
                    location.reload();
                } else {
                    alert("Failed to update task category.");
                }
            });
        }
    });
});
