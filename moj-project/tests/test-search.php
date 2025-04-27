<?php
// Include the database connection file
include "../conninfo.php";

// Helper function to insert tasks into the database
function insert_task($title, $description, $due_datetime, $status) {
    global $link;
    $query = "INSERT INTO tasks (title, description, due_datetime, status) 
              VALUES ('$title', '$description', '$due_datetime', '$status')";
    mysqli_query($link, $query);
}

// Helper function to clean up tasks after test
function delete_task($title) {
    global $link;
    $query = "DELETE FROM tasks WHERE title = '$title'";
    mysqli_query($link, $query);
}

// Insert sample tasks for testing
insert_task("Task 1", "Task 1 description", "2025-04-27 12:00:00", "Not started");
insert_task("Task 2", "Task 2 description", "2025-04-28 12:00:00", "In progress");
insert_task("Task 3", "Task 3 description", "2025-04-29 12:00:00", "Completed");
insert_task("Task 4", "Task 4 description", "2025-04-30 12:00:00", "Not started");

// Simulate the POST request with search filters
$_POST['search'] = "Task 1";
$_POST['start_date'] = "2025-04-27";
$_POST['end_date'] = "2025-04-29";
$_POST['status'] = "Not started";

// Your search function logic here (without modification)
$query = "SELECT * FROM tasks WHERE 1";

if (isset($_POST['search']) || isset($_POST['start_date']) || isset($_POST['end_date']) || isset($_POST['status'])) {
    $conditions = [];

    if (isset($_POST['search']) && $_POST['search'] !== '') {
        $search = mysqli_real_escape_string($link, $_POST['search']);
        $conditions[] = "(title LIKE '%$search%' OR description LIKE '%$search%' OR status LIKE '%$search%')";
    }

    if (isset($_POST['start_date']) && $_POST['start_date'] !== '') {
        $start_date = mysqli_real_escape_string($link, $_POST['start_date']);
        $conditions[] = "DATE(due_datetime) >= '$start_date'";
    }
    if (isset($_POST['end_date']) && $_POST['end_date'] !== '') {
        $end_date = mysqli_real_escape_string($link, $_POST['end_date']);
        $conditions[] = "DATE(due_datetime) <= '$end_date'";
    }

    if (isset($_POST['status']) && $_POST['status'] !== '') {
        $status = mysqli_real_escape_string($link, $_POST['status']);
        $conditions[] = "status = '$status'";
    }

    if (count($conditions) > 0) {
        $query .= " AND " . implode(" AND ", $conditions);
    }
}

// Execute the query
$result = mysqli_query($link, $query);

// Check if the task is found
$tasks_found = false;
while ($row = mysqli_fetch_assoc($result)) {
    if ($row['title'] === "Task 1") {
        $tasks_found = true;
        break;
    }
}

// Check the result of the test
if ($tasks_found) {
    echo "Search test passed: Task found as expected.\n";
} else {
    echo "Search test failed: Task not found as expected.\n";
}

// Clean up the test data by deleting tasks
delete_task("Task 1");
delete_task("Task 2");
delete_task("Task 3");
delete_task("Task 4");
?>
