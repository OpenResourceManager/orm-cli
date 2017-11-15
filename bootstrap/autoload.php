<?php

if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}

if (!defined('VALID_CODES')) {
    define('VALID_CODES', [200, 201, 202, 204]);
}

// Defines the ORM home based on OS
if (DIRECTORY_SEPARATOR == '/') {
    $home = $_SERVER['HOME'];
    if (!defined('ORM_HOME')) {
        // Define ORM Home for *nix
        define('ORM_HOME', implode('/', [$home, '.config', 'orm']));
    }
    if (!defined('ORM_DB_PATH')) {
        // Define ORM DB Path for *nix
        define('ORM_DB_PATH', implode('/', [ORM_HOME, 'orm.sqlite']));
    }
} else if (DIRECTORY_SEPARATOR == '\\') {
    $home = $_SERVER['USERPROFILE'];
    if (!defined('ORM_HOME')) {
        // Define ORM Home for win
        define('ORM_HOME', implode('\\', [$home, 'AppData', 'Roaming', 'orm']));
    }
    if (!defined('ORM_DB_PATH')) {
        // Define ORM Home for win
        define('ORM_DB_PATH', implode('\\', [ORM_HOME, 'orm.sqlite']));
    }
}

/*
|--------------------------------------------------------------------------
| Register The Composer Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader
| for our application. We just need to utilize it! We'll require it
| into the script here so we do not have to manually load any of
| our application's PHP classes. It just feels great to relax.
|
*/

if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require __DIR__ . '/../vendor/autoload.php';
} else {
    require __DIR__ . '/../../../autoload.php';
}
