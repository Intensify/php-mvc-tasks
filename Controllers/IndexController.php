<?php

use Monolog\Logger;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
class IndexController
{
    private $logger;
    private $taskController;

    /**
     * IndexController constructor.
     * @throws Exception
     */
    public function __construct()
    {
        // Crea un nuevo objeto Logger para el registro de eventos, usado para control y depuración
        $logger = new Logger('tasks_logger');
        $debugHandler = new StreamHandler('storage/logs/tasks.log', Logger::DEBUG);
        $debugHandler->setFormatter(new LineFormatter(null, null, false, true));
        $logger->pushHandler($debugHandler);
        $this->logger = $logger;
    }

    public function getLogger()
    {
        return $this->logger;
    }

    public function setLogger($logger)
    {
        $this->logger = $logger;
    }

    public function getTaskController()
    {
        return $this->taskController;
    }

    public function setTaskController($taskController)
    {
        $this->taskController = $taskController;
    }

    public function start()
    {
        // Incluye cabecera HTML con metadatos, estilos y scripts necesarios para el layout
        include_once('Views/header.html');

        // Muestra una alerta si el cliente de php no tiene permisos de escritura en el archivo de registro de eventos
        if(!is_writeable('storage/logs/tasks.log')) {
            $this->logger->error('PHP no tiene permisos para editar el archivo: storage/logs/tasks.log');

            echo '<div class="alert alert-danger" role="alert">Por favor, da permisos de escritura al archivo: <strong>'
                . 'storage/logs/tasks.log</strong></div>';
        }

        /*
         * Antes de ejecutar la aplicación, se comprueba si se ha editado el archivo config/database.php
         * De no ser así, termina la aplicación con un mensaje de alerta.
         */
        if(file_exists('config/database.php')) {
            $dbConfig = require_once('config/database.php');

            if(in_array('EDITA_ESTE_VALOR', $dbConfig)) {
                $this->logger->error('Falta editar la configuración del archivo: config/database.php');

                die('<div class="alert alert-danger" role="alert">Por favor, antes de usar la aplicación edita el archivo de configuración: <strong>'
                    . 'config/database.php</strong></div>');
            }
        } else {
            $this->logger->error('No existe archivo de configuración: config/database.php');

            die('<div class="alert alert-danger" role="alert">No existe el archivo de configuración: <strong>'
                . 'config/database.php</strong></div>');
        }

        // Procesa la petición HTTP que recibe el Index
        $this->processRequest();

        // Incluye pie de página HTML con el resto de scripts necesarios para el layout
        include_once('Views/footer.html');
    }

    public function processRequest()
    {
        // Crea un nuevo Controlador de Tareas
        $this->taskController = new TaskController($this->logger);

        $this->logger->info('Request ' . $_SERVER['REQUEST_METHOD'] . ': ' . $_SERVER['REQUEST_URI']);

        // Si el Request GET contiene la variable `view`, retorna la vista individual de la tarea. De lo contrario lista todas las tareas
        if($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Crea un token en la sesión para proteger de CSRF
            $_SESSION['csrftoken'] = md5(uniqid(mt_rand(), true));

            $requestedView = filter_input(INPUT_GET, 'view', FILTER_SANITIZE_SPECIAL_CHARS);
            is_null($requestedView) ? $this->taskController->listTasks() : $this->taskController->view($requestedView);
        }

        // Si es un Request POST, lee el tipo de acción necesario y llama al método correspondiente en el TaskController
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $requestBody = array();
            foreach($_POST as $key => $value)
            {
                $requestBody[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                $this->logger->info('Post Data: ' . $key . ' => ' . $requestBody[$key]);
            }

            // Si el valor de CSRF en la sesión coincide con el del POST procesamos el formulario
            if(!isset($requestBody['csrf']) || $requestBody['csrf'] !== $_SESSION['csrftoken']) {
                $this->logger->error('Token CSRF distinto al de la sesión. SESSION:' . $_SESSION['csrftoken'] . ' POST: ' . $requestBody['csrf']);

                die('<div class="alert alert-danger" role="alert">Protección anti CSRF</div>');
            } else {
                switch ($requestBody['action']) {
                    case 'create':
                        $this->taskController->create(array(
                            'task' => $requestBody['task'],
                            'createdAt' => time(),
                            'isCompleted' => 0
                        ));
                        $this->taskController->listTasks();
                        break;
                    case 'update':
                        $this->taskController->update(array(
                            'id' => $requestBody['id'],
                            'task' => $requestBody['task'],
                            'createdAt' => $requestBody['createdAt'],
                            'isCompleted' => $requestBody['isCompleted']
                        ));

                        if (isset($requestBody['view'])) {
                            $this->taskController->view($requestBody['view']);
                        }
                        break;
                    case 'delete':
                        $this->taskController->delete($requestBody['id']);
                        break;
                    default:
                        header('Location: index.php');
                        break;
                }
            }
        }
    }
}