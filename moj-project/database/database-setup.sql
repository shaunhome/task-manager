-- 1. Create the database
CREATE DATABASE IF NOT EXISTS hmcts_task_manager;
USE hmcts_task_manager;

-- 2. Drop the tasks table if it already exists (for reset/testing)
DROP TABLE IF EXISTS tasks;

-- 3. Create the tasks table
CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    status ENUM('Not started', 'In progress', 'Completed') NOT NULL DEFAULT 'Not started',
    due_datetime DATETIME NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


CREATE INDEX idx_due_datetime ON tasks (due_datetime);
