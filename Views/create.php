<form action="./" method="post" id="taskForm" class="collapse">
    <hr>
    <div class="form-group">
        <label for="createTask">Descripción de la tarea</label>
        <textarea class="form-control" id="createTask" name="task" rows="4" maxlength="300" placeholder="Entrar tarea..."></textarea>
        <small id="createTaskSmall" class="form-text text-muted">Añade una descripción para la nueva tarea. Máximo de carácteres: 300</small>
        <input type="hidden" name="action" value="create">
    </div>
    <div class="form-group">
        <input type="hidden" id="csrftoken" name="csrf" value="<?php echo $_SESSION['csrftoken']; ?>">
        <input type="submit" class="btn btn-info" value="Enviar">
    </div>
</form>
