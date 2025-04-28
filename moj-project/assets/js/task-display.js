// Wait until the DOM is fully loaded
document.addEventListener("DOMContentLoaded", function() {
    // Get the modal and close button
    const modal = document.getElementById("taskModal");
    const span = document.getElementsByClassName("close")[0];

    // Get all Edit Task buttons
    const editButtons = document.querySelectorAll('.edit-task-btn');

    // Attach click event to each Edit Task button
    editButtons.forEach(button => {
        button.addEventListener('click', () => {
            const taskId = button.getAttribute('data-task-id');
            const taskTitle = button.getAttribute('data-task-title');

            // Update the modal with task details
            document.getElementById('taskModalMessage').innerText =
                `You are about to edit the task: ${taskTitle} (ID: ${taskId})`;
            document.getElementById('taskIdInput').value = taskId;

            // Show the modal
            modal.style.display = "block";
        });
    });

    // Close the modal when clicking the (x)
    span.onclick = function() {
        modal.style.display = "none";
    };

    // Close the modal when clicking outside the modal
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
});
