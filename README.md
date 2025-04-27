# Task Manager - MOJ

A PHP and MySQL-based task management application featuring CRUD operations, search functionality, and a responsive user interface.

## Project Structure

- **Frontend**:
  - Landing page (home)
  - Dashboard displaying all tasks
  - Modals for edit and delete confirmations
  - Search bar for filtering tasks
  - Responsive CSS design

- **Backend**:
  - PHP scripts for:
    - Creating, reading, updating, deleting tasks (CRUD)
    - Searching tasks
  - Unit tests for each CRUD function and search functionality
  - Cleanup scripts for maintaining test database state

- **Database**:
  - MySQL database storing task data (title, description, due date, status)

## Setup Instructions

1. Clone or download the repository.
2. Create a MySQL database and import the provided schema.
3. Update `conninfo.php` with your database connection details.
4. Place the project files into your web server directory (e.g., `htdocs` if using XAMPP).
5. Access `index.php` through your browser to start using the app.

## Features

- Add new tasks with title, description, due date, and status.
- Edit and delete tasks.
- Search tasks by keyword, date range, and status.
- Responsive design for desktop and mobile devices.
- User confirmation modals for sensitive actions.
- Unit tests covering CRUD operations and search functionality.
- Test data cleanup after testing to maintain a clean database.

## Development Approach

### Planning
- Outline front-end display and back-end PHP logic.
- Define CRUD operations and search conditions in pseudocode.

### Implementation
- Build base templates for the landing page and dashboard.
- Develop CRUD features first, testing manually after each step.
- Apply CSS styling for responsiveness and usability.
- Add confirmation modals for edit/delete actions.
- Implement search functionality with multiple filters.

### Testing
- Create unit tests for create, read, update, delete, and search functions.
- Ensure the database remains clean after each test run.

### Finalisation
- Organise project files into logical folders.
- Clean and review code for clarity and maintainability.

## Technologies Used

- PHP
- MySQL
- HTML / CSS
- JavaScript (for search bar functionality)

