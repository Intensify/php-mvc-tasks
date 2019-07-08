<?php
session_start();

require_once(__DIR__ . '/vendor/autoload.php');

require_once(__DIR__ . '/Models/Database.php');
require_once(__DIR__ . '/Models/Task.php');
require_once(__DIR__ . '/Controllers/TaskController.php');
require_once(__DIR__ . '/Controllers/IndexController.php');

// Crea nuevo objeto del Controlador principal e inicializa la aplicación
$controller = new IndexController();
$controller->start();
