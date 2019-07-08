<?php
    $task = $this->results[0];
    $completed = $task->isCompleted == 1 ? 'success' : 'warning';
    setlocale(LC_TIME, 'es_ES', 'Spanish_Spain', 'Spanish (International)');
?>
<h2>Tarea ID <?php echo $task->id ?></h2>

<ul class="list-group">
    <li id="<?php echo 'task' . $task->id ?>" class="list-group-item list-group-item-<?php echo $completed ?>" data-created-at="<?php echo $task->createdAt ?>">
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
        <?php
            echo '<span class="badge badge-info">' . strftime('%a %d-%b-%y %H:%M', $task->createdAt) . '</span>';
            echo '<p id="task' . $task->id . '_text">' . $task->task . '</p>'
        ?>
        </li>
</ul>

<?php require_once(__DIR__ . '/edit.php') ?>
<a href="./" class="btn btn-info"> Volver al Gestor de Tareas</a><br><br>
