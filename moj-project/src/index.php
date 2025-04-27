<?php
include "conninfo.php";

// Get the current date for comparison
$current_date = date('Y-m-d H:i:s');

// Query to fetch the top 5 tasks based on priority:
$query = "
SELECT id, title, due_datetime, status 
FROM tasks
WHERE status != 'complete' 
AND (due_datetime < '$current_date' OR due_datetime >= '$current_date')
ORDER BY 
    CASE 
        WHEN due_datetime < '$current_date' THEN 1 
        ELSE 2 
    END, 
    due_datetime ASC, 
    FIELD(status, 'not started', 'in progress') ASC
LIMIT 5
";

$result = mysqli_query($link, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager - Dashboard</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <style>
        /* Modal Styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
            text-align: center;
        }

        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
		
		.carousel-description {
		font-size: 16px;
		color: #333;
		text-align: center;
		margin-top: 20px;
		padding: 10px;
		background-color: #f7f7f7;
		border-radius: 8px;
		box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
		width: 80%;
		margin-left: auto;
		margin-right: auto;
		}	

		.carousel-description p {
			margin: 0;
			font-size: 14px;
			color: #555;
		}
    </style>
</head>
<body>

    <header>
        <h1 class="dashboard-title">Ministry of justice</h1>
		<nav>
			<a href="index.php">Home</a>
			<a href="dashboard.php">Dashboard</a>
			<a href="task-form.php">Add Task</a>
        </nav>
    </header>

<main>
    <h1>Welcome to the Task Manager</h1>
    
    <!-- Dynamic Task Carousel -->
    <div class="slider" style="--width: 300px; --height: 200px; --quantity: 5;">
        <div class="list">
            <?php
            $position = 1;
            while ($row = mysqli_fetch_array($result)) {
                $task_id = $row['id'];
                $task_title = $row['title'];
                $task_due = $row['due_datetime'];
                $task_status = $row['status'];

                // Background colors based on task status
                $bg_color = $task_status == 'not started' ? 'linear-gradient(to right, #ff7e5f, #feb47b)' : 
                            ($task_status == 'in progress' ? 'linear-gradient(to right, #6a11cb, #2575fc)' : 
                            'linear-gradient(to right, #00c6ff, #0072ff)');
            ?>
				<div class="item" style="--position: <?= $position ?>">
					<div class="card" style="background: <?= $bg_color ?>">
						<p><?= $task_title ?></p>
						<p>Due: <?= date('F j, Y, g:i a', strtotime($task_due)) ?></p>
						<p>Status: <?= ucfirst($task_status) ?></p>
						<!-- Button to trigger the popup with task title and task ID -->
						<button class="edit-task-btn" data-task-id="<?= $task_id ?>" data-task-title="<?= $task_title ?>">Edit Task</button>
						
					</div>
				</div>
			
            <?php
                $position++;
            }
            ?>
        </div>
    </div>

    <p class="carousel-description">The carousel displays the top 5 tasks that are either overdue or upcoming, sorted by urgency and due date. Only tasks that are not marked as completed and are in 'not started' or 'in progress' statuses will be shown.</p>

</main>

<!-- Footer -->
<footer>
    <p>&copy; 2025 Task Manager - All rights reserved.</p>
</footer>

<!-- Pop-up Modal for Task ID -->
<div id="taskModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <p id="taskModalMessage"></p>
        <form action="enter-edit.php" method="POST" style="display:inline;">
            <input type="hidden" name="id" id="taskIdInput">
            <input type="submit" value="Go to Edit">
        </form>
    </div>
</div>

<script>
    // Get the modal
var modal = document.getElementById("taskModal");
var span = document.getElementsByClassName("close")[0];

// Get all edit buttons
var editButtons = document.querySelectorAll('.edit-task-btn');

// Add click event listeners to each button
editButtons.forEach(function(button) {
    button.addEventListener('click', function() {
        var taskId = button.getAttribute('data-task-id');  // Get task ID
        var taskTitle = button.getAttribute('data-task-title');  // Get task title
        var modalMessage = "You are about to edit the task: " + taskTitle + " (ID: " + taskId + ")";
        
        document.getElementById('taskModalMessage').innerText = modalMessage; // Set modal message
        document.getElementById('taskIdInput').value = taskId; // Set task ID in hidden input field
        modal.style.display = "block"; // Show the modal
    });
});

// When the user clicks on the close button, close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

</body>
</html>
