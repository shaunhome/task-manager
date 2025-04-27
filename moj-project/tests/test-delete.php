<?php
include "../conninfo.php";

// Setup: Add a dummy task to delete
$title = 'Unit Test Task - Delete';
$description = 'This is a task to be deleted.';
$status = 'Not started';
$due_datetime = date('Y-m-d H:i:s', strtotime('+1 day'));

$insertQuery = "INSERT INTO tasks (title, description, due_datetime, status) 
                VALUES ('$title', '$description', '$due_datetime', '$status')";
mysqli_query($link, $insertQuery);

$task_id = mysqli_insert_id($link);

// Test: Delete the inserted task
$deleteQuery = "DELETE FROM tasks WHERE id = $task_id LIMIT 1";
mysqli_query($link, $deleteQuery);

// Verify: Check if the task was deleted
$checkResult = mysqli_query($link, "SELECT * FROM tasks WHERE id = $task_id");

if (mysqli_num_rows($checkResult) === 0) {
    echo "Task deletion test passed.<br>";
} else {
    echo "Task deletion test failed.<br>";
}

// No cleanup needed because the task should already be deleted
?>
