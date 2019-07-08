<h2>Gestor de Tareas</h2>

<button class="btn btn-info" data-toggle="collapse" data-target="#taskForm">Crear nueva tarea</button>
<a href="./" class="btn btn-info" id="reload">Refrescar lista</a>

<?php
    include_once(__DIR__ . '/create.php');
    if(count($this->results) > 0):
    setlocale(LC_TIME, 'es_ES', 'Spanish_Spain', 'Spanish (International)');
?>
<hr>

<h2>Lista de Tareas</h2>
<span class="small form-text text-muted">Pulsa en cualquier tarea para abrir la vista</span>

<ul class="list-group">
    <?php
        foreach ($this->results as $task):
            $completed = $task->isCompleted == 1 ? 'success' : 'warning';
    ?>
        <li id="<?php echo 'task' . $task->id ?>" class="task list-group-item list-group-item-<?php echo $completed ?>" data-created-at="<?php echo $task->createdAt ?>">
            <span class="fa-pull-right">
                <button class="btn btn-<?php echo $completed ?> fas fa-check"
                        id="check" onclick="taskToggleCompletion(<?php echo $task->id ?>, 1)"
                        title="Marcar tarea como completada" <?php echo ($task->isCompleted == 1) ? 'disabled' : '' ?>>
                </button>
                <button class="btn btn-<?php echo $completed ?> fas fa-undo"
                        id="uncheck" onclick="taskToggleCompletion(<?php echo $task->id ?>, 0)"
                        title="Marcar tarea como pendiente" <?php echo ($task->isCompleted == 1) ? '' : 'disabled' ?>>
                </button>
                <button class="btn btn-danger fas fa-trash"
                        id="delete" onclick="taskDelete(<?php echo $task->id ?>)"
                        title="Eliminar tarea">
                </button>
            </span>
            <a href="./?view=<?php echo $task->id ?>">
            <?php
                echo '<span class="badge badge-info">' . strftime('%a %d-%b-%y %H:%M', $task->createdAt) . '</span>';
                echo '<p id="task' . $task->id . '_text">' . $task->task . '</p>'
            ?>
            </a>

        </li>
    <?php endforeach; ?>
<?php endif; ?>
</ul>
