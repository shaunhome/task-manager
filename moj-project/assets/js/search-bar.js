// Toggle Search Bar
        document.getElementById("searchToggle").addEventListener("change", function () {
            const searchBar = document.getElementById("searchBar");
            searchBar.style.display = this.value === "show" ? "flex" : "none";
        });

        const modal = document.getElementById('taskModal');
        const modalMessage = document.getElementById('modalMessage');
        const modalForm = document.getElementById('modalForm');
        const modalTaskId = document.getElementById('modalTaskId');
        const closeBtn = document.querySelector('.close');

        document.querySelectorAll('.edit-form').forEach(form => {
            form.addEventListener('submit', e => {
                e.preventDefault();
                const taskId = form.dataset.taskId;
                const taskTitle = form.dataset.taskTitle;
                modalTaskId.value = taskId;
                modalForm.action = 'enter-edit.php';
                modalMessage.textContent = `Are you sure you want to edit task: "${taskTitle}"?`;
                modal.style.display = 'block';
            });
        });

        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', e => {
                e.preventDefault();
                const taskId = form.dataset.taskId;
                const taskTitle = form.dataset.taskTitle;
                modalTaskId.value = taskId;
                modalForm.action = 'delete.php';
                modalMessage.textContent = `Are you sure you want to delete task: "${taskTitle}"?`;
                modal.style.display = 'block';
            });
        });

        closeBtn.onclick = function () {
            modal.style.display = 'none';
        }

        window.onclick = function (event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        }