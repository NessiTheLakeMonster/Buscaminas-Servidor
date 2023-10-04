<?php

require_once __DIR__.'Conexion.php';
require_once __DIR__.'Partida.php';
require_once __DIR__.'Controlador.php';

header("Content-Type:application/json");
$requestMethod = $_SERVER["REQUEST_METHOD"];
$paths =  $_SERVER['REQUEST_URI'];
$datosRecibidos = file_get_contents("php://input");

$argus = explode('/', $paths);
unset($argus[0]);

if ($requestMethod == 'GET') {
    if ($argus[1] == '') {
        Controlador::allPartidas();


    }

} else if ($requestMethod == 'POST') {

}