<?php

use Monolog\Logger;
class Task
{
    private $task;
    private $createdAt;
    private $isCompleted;
    private $logger;

    /**
     * Task constructor.
     * @param $params Array con los valores para crear la tarea
     * @param Logger $logger
     */
    public function __construct($params, Logger $logger)
    {
        $this->task = $params['task'];
        $this->createdAt = $params['createdAt'];
        $this->isCompleted = $params['isCompleted'];

        $this->logger = $logger;
        $this->logger->info('Task: ' . $this->toString());
    }

    public function getTask()
    {
        return $this->task;
    }

    public function setTask($task)
    {
        $this->task = $task;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getIsCompleted()
    {
        return $this->isCompleted;
    }

    public function setIsCompleted($isCompleted)
    {
        $this->isCompleted = $isCompleted;
    }

    public function getLogger()
    {
        return $this->logger;
    }

    public function setLogger(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Devuelve en formato de texto el contenido de las variables usables del objeto Task
     * @return string
     */
    public function toString() {
        return 'Creada en ' . date('d-m-Y H:i:s', $this->createdAt) . ' DESC: "'. $this->task . '" STATUS: ' . ($this->isCompleted ? 'Completed' : 'Pending');
    }
}