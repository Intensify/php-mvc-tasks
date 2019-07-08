# PHP MVC Tasks
 Simple gestor de tareas escrito en PHP con estructura MVC
 
### Prerrequisitos
 Para la instalación y ejecución de esta aplicación se requiere:
  * PHP 5.6 o superior
  * MySQL 5.x o superior
  * [Composer](https://getcomposer.org/download/)
  
Si se está usando la distribución Ubuntu se puede adquirir Composer más comodamente usando el siguiente comando:
```
sudo apt-get install composer
```
  
### Instalación
Para la instalación solo se requiere clonar este repositorio en el directorio deseado: 
```
git clone git@github.com:Intensify/php-mvc-tasks.git
```

Entrar al nuevo directorio creado e instalar las dependencias con composer:
```
cd php-mvc-tasks
composer install
```

En el caso de instalar composer sin un gestor de paquetes, se puede usar el siguiente comando para la instalación de dependencias:
```
php composer.phar install
```

### Configuración
Para poder usar la aplicación es necesario configurar los datos de conexión a la base de datos.

Para ello debemos editar el archivo `config/database.php` y reemplazar los valores etiquetados como `EDITA_ESTE_VALOR` 
por los datos de conexión a la base de datos MySQL.

Paralelamente en MySQL debemos crear la tabla `tasks` en el schema que se desee. Para ello se puede usar la sentencia SQL que se halla en el archivo `resources/tasks.sql`, que es la siguiente:

```
CREATE TABLE `tasks` (
                       `id` int(11) NOT NULL AUTO_INCREMENT,
                       `task` varchar(300) NOT NULL,
                       `createdAt` int(10) NOT NULL,
                       `isCompleted` tinyint(4) NOT NULL,
                       PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

```

Por último, hay que comprobar que el interprete de PHP tenga permisos de escritura al directorio `storage` y más concretamente a `storage/logs/tasks.log`.