<?php
include "../conninfo.php";

//Enter test task details
$title = 'Unit Test Task - Create';
$description = '';
$status = 'Not started';
$due_datetime = date('Y-m-d H:i:s', strtotime('+1 day'));

$query = "INSERT INTO tasks (title, description, due_datetime, status) 
          VALUES ('$title', '$description', '$due_datetime', '$status')";
mysqli_query($link, $query);
$task_id = mysqli_insert_id($link);

// Test: Verify it was inserted
$result = mysqli_query($link, "SELECT * FROM tasks WHERE id = $task_id");

if (mysqli_num_rows($result) === 1) {
    echo "Task creation test passed.<br>";
} else {
    echo "Task creation test failed.<br>";
}

// Clean up
mysqli_query($link, "DELETE FROM tasks WHERE id = $task_id");
?>
