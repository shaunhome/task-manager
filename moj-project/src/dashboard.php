<?php
include "conninfo.php";

$query = "SELECT * FROM tasks WHERE 1";

if (isset($_POST['search']) || isset($_POST['start_date']) || isset($_POST['end_date']) || isset($_POST['status'])) {
    $conditions = [];

    if (isset($_POST['search']) && $_POST['search'] !== '') {
        $search = mysqli_real_escape_string($link, $_POST['search']);
        $conditions[] = "(title LIKE '%$search%' OR description LIKE '%$search%' OR status LIKE '%$search%')";
    }

    if (isset($_POST['start_date']) && $_POST['start_date'] !== '') {
        $start_date = mysqli_real_escape_string($link, $_POST['start_date']);
        $conditions[] = "due_datetime >= '$start_date'";
    }
    if (isset($_POST['end_date']) && $_POST['end_date'] !== '') {
        $end_date = mysqli_real_escape_string($link, $_POST['end_date']);
        $conditions[] = "due_datetime <= '$end_date'";
    }

    if (isset($_POST['status']) && $_POST['status'] !== '') {
        $status = mysqli_real_escape_string($link, $_POST['status']);
        $conditions[] = "status = '$status'";
    }

    if (count($conditions) > 0) {
        $query .= " AND " . implode(" AND ", $conditions);
    }
}

$result = mysqli_query($link, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Dashboard</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fff;
            margin: auto;
            padding: 20px;
            border-radius: 8px;
            width: 80%;
            max-width: 500px;
            text-align: center;
        }

        .close {
            float: right;
            font-size: 24px;
            cursor: pointer;
        }

        .modal form {
            margin-top: 15px;
        }

        .search-bar {
			width: 100%;
			background-color: #e0e0e0;
			padding: 20px;
			display: flex;
			flex-wrap: wrap;
			justify-content: space-around;
			gap: 20px;
			box-sizing: border-box;
			margin: 0;
			border-bottom: 1px solid #ccc;
        }

        .search-bar .search-field {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .search-bar input[type="text"], .search-bar input[type="date"], .search-bar select {
            padding: 8px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 200px;
        }

        .search-bar label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .search-bar .description {
            font-size: 12px;
            color: #777;
            text-align: center;
            margin-top: 5px;
        }

        .search-bar input[type="submit"] {
            padding: 8px 20px;
            font-size: 16px;
            border: none;
            background-color: #0072ff;
            color: white;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 20px;
        }

        .search-bar input[type="submit"]:hover {
            background-color: #005ecb;
        }
    </style>
</head>
<body>
    <header>
        <h1 class="dashboard-title">Task Dashboard</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="dashboard.php">Dashboard</a>
            <a href="task-form.php">Add Task</a>
        </nav>
    </header>

    <main>
        <!-- Dropdown Toggle -->
        <div style="margin: 20px 0;">
            <select id="searchToggle" style="padding: 8px; font-size: 16px;">
                <option value="hide">Hide Search</option>
                <option value="show">Show Search</option>
            </select>
        </div>

        <!-- Search Bar -->
        <div class="search-bar" id="searchBar" style="display: none;">
            <form method="POST" action="dashboard.php">
                <div class="search-field">
                    <label for="search">Search Tasks</label>
                    <input type="text" name="search" id="search" placeholder="Search by word" value="<?= isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '' ?>">
                    <div class="description">Search tasks by title, description, or status.</div>
                </div>

                <div class="search-field">
                    <label for="start_date">Start Date</label>
                    <input type="date" name="start_date" id="start_date" value="<?= isset($_POST['start_date']) ? htmlspecialchars($_POST['start_date']) : '' ?>">
                    <div class="description">Filter tasks by start date.</div>
                </div>

                <div class="search-field">
                    <label for="end_date">End Date</label>
                    <input type="date" name="end_date" id="end_date" value="<?= isset($_POST['end_date']) ? htmlspecialchars($_POST['end_date']) : '' ?>">
                    <div class="description">Filter tasks by end date.</div>
                </div>

                <div class="search-field">
                    <label for="status">Status</label>
                    <select name="status" id="status">
                        <option value="">-- Select Status --</option>
                        <option value="Not started" <?= isset($_POST['status']) && $_POST['status'] == 'Not started' ? 'selected' : '' ?>>Not started</option>
                        <option value="In progress" <?= isset($_POST['status']) && $_POST['status'] == 'In progress' ? 'selected' : '' ?>>In progress</option>
                        <option value="Completed" <?= isset($_POST['status']) && $_POST['status'] == 'Completed' ? 'selected' : '' ?>>Completed</option>
                    </select>
                    <div class="description">Filter tasks by their status.</div>
                </div>

                <input type="submit" value="Search">
            </form>
        </div>
		<br><br>

        <!-- Task Table -->
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Due Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_array($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['title']) ?></td>
                        <td><?= htmlspecialchars($row['description']) ?></td>
                        <td><?= date('d-M y H:i', strtotime($row['due_datetime'])) ?></td>
                        <td><?= htmlspecialchars($row['status']) ?></td>
                        <td>
                            <form class="edit-form" data-task-id="<?= $row['id'] ?>" data-task-title="<?= htmlspecialchars($row['title']) ?>" style="display:inline;">
                                <input type="submit" class="edit-button" value="Edit">
                            </form><br><br>
                            <form class="delete-form" data-task-id="<?= $row['id'] ?>" data-task-title="<?= htmlspecialchars($row['title']) ?>" style="display:inline;">
                                <input type="submit" class="delete-button" value="Delete">
                            </form>

                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>

    <div id="taskModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p id="modalMessage"></p>
            <form id="modalForm" method="POST">
                <input type="hidden" name="id" id="modalTaskId">
                <input type="submit" value="Confirm">
            </form>
        </div>
    </div>
	<script src="../assets/js/search-bar.js"></script>

</body>
</html>
