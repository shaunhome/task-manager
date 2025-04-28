<?php
include "conninfo.php";
$id = intval($_POST["id"]); // 

$query = "DELETE FROM tasks WHERE id=$id LIMIT 1";
mysqli_query($link, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task Deleted</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <style>
        .task-edit-centered-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 20vh;
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <h1 class="dashboard-title">Task Deleted</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="dashboard.php">Dashboard</a>
            <a href="task-form.php">Add Task</a>
        </nav>
    </header>

    <main>
        <div class="task-edit-centered-container">
            <p class="search-field" style="font-size: 24px;">Task Deleted Successfully!</p>
            <form action="dashboard.php" method="get" class="search-field" style="margin-top: 20px;">
                <input type="submit" class="edit-button" value="Back to Dashboard">
            </form>
        </div>
    </main>
</body>
	<footer>
		<p>&copy; 2025 Task Manager - All rights reserved.</p>
	</footer>
</html>
