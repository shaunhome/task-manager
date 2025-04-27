<?php
include "conninfo.php";

$id = $_POST["id"];
$title = $_POST["title"];
$description = $_POST["description"];
$due_datetime = $_POST["due_datetime"];
$status = $_POST["status"];

$query = "UPDATE tasks SET title = ?, description = ?, due_datetime = ?, status = ? WHERE id = ?";
$stmt = $link->prepare($query);
$stmt->bind_param("ssssi", $title, $description, $due_datetime, $status, $id);
$stmt->execute();

header("Location: dashboard.php");
exit;
