<?php

/*
 * Comprueba que el acceso a este script sea a través de algún método o clase con permiso de acceso
 */
if(!defined('AllowAccessToConfigFile')) {
    die('No se permite acceder a este archivo directamente.');
} else {
    /*
     * Devuelve una array con los datos de configuración de la base de datos
     */
    return array(
        'dbhost' => 'EDITA_ESTE_VALOR',
        'dbuser' => 'EDITA_ESTE_VALOR',
        'dbpass' => 'EDITA_ESTE_VALOR',
        'dbname' => 'EDITA_ESTE_VALOR'
    );
}
