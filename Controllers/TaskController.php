<?php

use Monolog\Logger;
class TaskController
{

    private $database;
    private $logger;
    private $results;

    /**
     * TaskController constructor.
     * @param Logger $logger
     */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
        $db = new Database($this->logger);
        $this->database = $db->getDatabase();
    }

    public function getDatabase()
    {
        return $this->database;
    }

    public function setDatabase(Database $database)
    {
        $this->database = $database;
    }

    /**
     * Crea un nuevo objeto Task con los parametros pasados en $param y añade la tarea a la base da datos
     * @param $params Array de parámetros con los datos de la tarea
     */
    public function create($params)
    {
        $task = new Task($params, $this->logger);

        try {
            $statement = $this->database->prepare('INSERT INTO tasks (task, createdAt, isCompleted) VALUES (:task, :createdAt, :isCompleted)');
            $statement->bindValue(':task', $task->getTask());
            $statement->bindValue(':createdAt', $task->getCreatedAt());
            $statement->bindValue(':isCompleted', $task->getIsCompleted());

            $statement->execute();
        } catch (Exception $exception) {
            $this->logger->error('Error al crear una nueva tarea: ' . $exception->getMessage());
        }
    }

    /**
     * Devuelve la vista individual de una tarea usando como referencia el identificador de esta,
     * la vista individual también tiene opción para editar la tarea.
     * @param $id Integer con la id de la tarea
     */
    public function view($id)
    {
        try {
            $statement = $this->database->prepare('SELECT * FROM tasks WHERE (CAST(id AS CHAR) = :id)');
            $statement->bindValue(':id', $id);

            $statement->execute();
            $this->results = $statement->fetchAll();

            // Comprueba si hay resultados en la consulta a la base de datos
            if(count($this->results) === 0) {
                /*
                 * Al no haber resultados significa que la tarea no existe, posiblemente esto tansolo ocurra al insertar
                 * manualmente el valor por GET de la variable view (/?view=valorInventado)
                 */
                $this->taskNotFound($id);
            } else {
                // La tarea con id $id existe, carga la vista individual para mostrar y editar la tarea
                require('Views/task.php');
            }
        } catch (Exception $exception) {
            $this->logger->error('Error al cargar una tarea: ' . $exception->getMessage());
        }
    }

    /**
     * Crea un objeto Task con los parametros pasados en $param y actualiza los cambios en la tarea en la base da datos
     * @param $params
     */
    public function update($params)
    {
        $task = new Task($params, $this->logger);

        try {
            $statement = $this->database->prepare('UPDATE tasks SET task = :task, createdAt = :createdAt, isCompleted = :isCompleted WHERE id = :id');
            $statement->bindValue(':task', $task->getTask());
            $statement->bindValue(':createdAt', $task->getCreatedAt());
            $statement->bindValue(':isCompleted', $task->getIsCompleted());
            $statement->bindValue(':id', $params['id']);

            $statement->execute();
        } catch (Exception $exception) {
            $this->logger->error('Error al actualizar una tarea: ' . $exception->getMessage());
        }
    }

    /**
     * Elimina de la base de datos la tarea con el identificador pasador por parámetro
     * @param $id Integer con la id de la tarea
     */
    public function delete($id)
    {
        try {
            $statement = $this->database->prepare('DELETE FROM tasks WHERE (CAST(id AS CHAR) = :id)');
            $statement->bindValue(':id', $id);

            $statement->execute();
        } catch (Exception $exception) {
            $this->logger->error('Error al eliminar una tarea: ' . $exception->getMessage());
        }
    }

    /**
     * Lista todas las tareas de la base de datos y carga la vista principal para mostrarlas
     */
    public function listTasks()
    {
        try {
            $statement = $this->database->prepare('SELECT * FROM tasks ORDER BY createdAt DESC');

            $statement->execute();
            $this->results = $statement->fetchAll();
        } catch (Exception $exception) {
            $this->logger->error('Error al listar las tareas: ' . $exception->getMessage());
        }

        require('Views/main.php');
    }

    /**
     * Muestra una vista con un aviso indicando que la tarea con identificador $id no existe.
     * @param $id Integer con la id de la tarea
     */
    public function taskNotFound($id)
    {
        $this->logger->error('La tarea con ID ' . $id . ' no existe');

        require('Views/notFound.html');
    }
}
