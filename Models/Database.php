<?php

use Monolog\Logger;
/*
 * Por tal de hacer esta aplicación portable, uso una alternativa a las configuraciones de nginx o Apache
 * para restringir el acceso público al archivo config/database.php
 */
define('AllowAccessToConfigFile', TRUE);
class Database
{
    private $database = null;
    private $logger;
    private $dbconfig;

    /**
     * Database constructor. Inicializa la configuración de la base de datos y crea una conexión
     * @param Logger $logger
     */
    public function __construct(Logger $logger)
    {
        $this->dbconfig = require('config/database.php');

        $this->logger = $logger;

        try {
            $this->database = new PDO(
                'mysql:host=' . $this->dbconfig['dbhost'] . ';dbname=' . $this->dbconfig['dbname'] . ';charset=utf8',
                $this->dbconfig['dbuser'],
                $this->dbconfig['dbpass'],
                array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
                )
            );

            $this->checkTableExists();
        } catch (Exception $exception) {
            $this->logger->error($exception->getMessage());
            die('<div class="alert alert-danger" role="alert">Error al conectar a la base de datos:<br><strong>'
                . $exception->getMessage() . '</strong></div>');
        }
    }

    public function getDatabase()
    {
        return $this->database;
    }

    /**
     * Método para comprobar si la tabla `tasks` existe en la base de datos
     */
    public function checkTableExists()
    {
        $this->database->query("SELECT 1 FROM tasks LIMIT 1");
    }
}
