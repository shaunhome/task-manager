<?php
include "conninfo.php";

$id = $_POST["id"];
$query = "SELECT * FROM tasks WHERE id = ?";
$stmt = $link->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$task = $result->fetch_assoc();

if (!$task) {
    echo "Task not found.";
    exit;
}
?>

<link rel="stylesheet" href="../assets/css/styles.css">
<main>
    <h2>Edit Task</h2>
    <form action="do-edit.php" method="POST">
        <label for="title">Title:</label>
        <input type="text" id="title" maxlength="30" name="title" value="<?= htmlspecialchars($task['title']) ?>" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description"><?= htmlspecialchars($task['description']) ?></textarea>

        <label for="due_datetime">Due Date and Time:</label>
        <input type="datetime-local" id="due_datetime" name="due_datetime" value="<?= date('Y-m-d\TH:i', strtotime($task['due_datetime'])) ?>" required min="<?= date('Y-m-d\TH:i') ?>"required>

        <label for="status">Status:</label>
        <select id="status" name="status" required>
            <?php
            $statuses = ['Not started', 'In progress', 'Completed'];
            foreach ($statuses as $status) {
                $selected = ($task['status'] === $status) ? 'selected' : '';
                echo "<option value=\"$status\" $selected>$status</option>";
            }
            ?>
        </select>

        <input type="hidden" name="id" value="<?= $task['id'] ?>">
        <input type="submit" value="Update Task">
    </form>
</main>
