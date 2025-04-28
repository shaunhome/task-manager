<?php include "conninfo.php"; 

$title = $_POST["title"];
$description = $_POST["description"];
$status = $_POST["status"];
$due_date = $_POST["due_datetime"];

$query = "INSERT INTO tasks(title, description, status, due_datetime) VALUES (?, ?, ?, ?)";
$stmt = mysqli_stmt_init($link);
mysqli_stmt_prepare($stmt, $query);
mysqli_stmt_bind_param($stmt, "ssss", $title, $description, $status, $due_date);
mysqli_stmt_execute($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task Submitted</title>
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
        <h1 class="dashboard-title">Task Submitted</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="dashboard.php">Dashboard</a>
            <a href="task-form.php">Add Task</a>
        </nav>
    </header>

    <main>
        <div class="task-edit-centered-container">
            <p class="search-field" style="font-size: 24px;">Task Added Successfully!</p>
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



