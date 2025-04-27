<?php include "conninfo.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Task</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <header>
        <h1 class="dashboard-title">Task Manager</h1>
        <nav>
			<a href="index.php">Home</a>
			<a href="dashboard.php">Dashboard</a>
			<a href="task-form.php">Add Task</a>
        </nav>
    </header>

    <main>
        <h2>Add a New Task</h2>
        <form action="submit-task.php" method="POST">
            <label for="title">Task Title:</label>
            <input type="text" id="title" maxlength="30" name="title" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4"></textarea>

            <label for="due_datetime">Due Date & Time:</label>
            <input type="datetime-local" id="due_datetime" name="due_datetime" required min="<?= date('Y-m-d\TH:i') ?>" required>

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="Not started">Not started</option>
                <option value="In progress">In progress</option>
                <option value="Complete">Complete</option>
            </select>

            <input type="submit" value="Add Task">
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Task Manager - MOJ. All rights reserved.</p>
    </footer>
</body>
</html>
