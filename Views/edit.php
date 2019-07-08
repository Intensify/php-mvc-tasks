<br>
<button class="btn btn-info" data-toggle="collapse" data-target="#taskForm">Editar tarea</button>

<form action="./?view=<?php echo $task->id ?>" method="post" id="taskForm" class="collapse">
    <hr>
    <div class="form-group">
        <label for="updateTask">Editar tarea</label>
        <textarea class="form-control" id="updateTask" name="task" rows="4" maxlength="300" placeholder="Entrar tarea..."><?php echo $this->results[0]->task ?></textarea>
        <small id="updateTaskSmall" class="form-text text-muted">Añade una descripción para la nueva tarea. Máximo de carácteres: 300</small>
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="createdAt" value="<?php echo $task->createdAt ?>">
        <input type="hidden" name="isCompleted" value="<?php echo $task->isCompleted ?>">
        <input type="hidden" name="id" value="<?php echo $task->id ?>">
        <input type="hidden" name="view" value="<?php echo $task->id ?>">
    </div>
    <div class="form-group">
        <input type="hidden" id="csrftoken" name="csrf" value="<?php echo $_SESSION['csrftoken']; ?>">
        <input type="submit" class="btn btn-info" value="Enviar">
    </div>
</form>

<hr>
