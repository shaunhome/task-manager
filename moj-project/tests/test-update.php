<?php
include "../conninfo.php";

// Setup: Add a fake task to update
$title = 'Unit Test Task - Update';
$description = 'This task will be updated in the test.';
$status = 'Not started';
$due_datetime = date('Y-m-d H:i:s', strtotime('+1 day'));

$insertQuery = "INSERT INTO tasks (title, description, due_datetime, status) 
                VALUES ('$title', '$description', '$due_datetime', '$status')";
mysqli_query($link, $insertQuery);

$task_id = mysqli_insert_id($link);

// Update: Change the task details
$updated_title = 'Updated Task Title';
$updated_description = 'The task description has been updated.';
$updated_status = 'In progress';
$updated_due_datetime = date('Y-m-d H:i:s', strtotime('+2 days'));

$updateQuery = "UPDATE tasks 
                SET title = '$updated_title', description = '$updated_description', 
                    due_datetime = '$updated_due_datetime', status = '$updated_status' 
                WHERE id = $task_id";
mysqli_query($link, $updateQuery);

// Verify: Fetch the updated task and check if the update is correct
$selectQuery = "SELECT * FROM tasks WHERE id = $task_id";
$selectResult = mysqli_query($link, $selectQuery);
$updated_task = mysqli_fetch_assoc($selectResult);

if ($updated_task['title'] === $updated_title && 
    $updated_task['description'] === $updated_description &&
    $updated_task['status'] === $updated_status &&
    $updated_task['due_datetime'] === $updated_due_datetime) {
    echo "Task update test passed.<br>";
} else {
    echo "Task update test failed.<br>";
}

// Cleanup: Delete the task after the test
$deleteQuery = "DELETE FROM tasks WHERE id = $task_id";
mysqli_query($link, $deleteQuery);

echo "Task deleted after test.<br>";

?>
