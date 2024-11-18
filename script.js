// Arreglo para almacenar las tareas
const tasks = [];

// Manejar el evento de clic en el botón "Agregar Tarea"
document.getElementById('add-task-button').addEventListener('click', function() {
    const taskInput = document.getElementById('task-input');
    const taskText = taskInput.value;

    if (taskText) {
        // Enviar la tarea al servidor usando fetch
        fetch('task.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                'task_text': taskText // Asegúrate de que el nombre coincida con el que esperas en PHP
            })
        })
        .then(response => {
            if (response.ok) {
                taskInput.value = ''; // Limpiar el campo de entrada
                location.reload(); // Recargar la página para mostrar la nueva tarea
            } else {
                console.error('Error al agregar la tarea');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    } else {
        alert("Por favor, ingresa una tarea."); // Mensaje de alerta si el campo está vacío
    }
});

// Manejar el evento de clic en el botón "Completar"
document.querySelectorAll('.complete-task').forEach(button => {
    button.addEventListener('click', function() {
        const taskId = this.getAttribute('data-id');

        // Enviar la solicitud para marcar la tarea como completada
        fetch('complete_task.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                'task_id': taskId // Enviar el ID de la tarea
            })
        })
        .then(response => {
            if (response.ok) {
                location.reload(); // Recargar la página para mostrar la tarea actualizada
            } else {
                console.error('Error al completar la tarea');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});

// Manejar el evento de clic en el botón "Eliminar"
document.querySelectorAll('.delete-task').forEach(button => {
    button.addEventListener('click', function() {
        const taskId = this.getAttribute('data-id');

        // Enviar la solicitud para eliminar la tarea
        fetch('delete_task.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                'task_id': taskId // Enviar el ID de la tarea
            })
        })
        .then(response => {
            if (response.ok) {
                location.reload(); // Recargar la página para mostrar la lista de tareas actualizada
            } else {
                console.error('Error al eliminar la tarea');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});