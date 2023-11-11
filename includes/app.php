<?php
require __DIR__ . '/../vendor/autoload.php';

use Model\ActiveRecord;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

require 'funciones.php';
require 'database.php';


// Conectarnos a la base de datos
ActiveRecord::setDB($db);
?>