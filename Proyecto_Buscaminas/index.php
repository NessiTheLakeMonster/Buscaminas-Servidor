<?php

require_once __DIR__ . '/Controllers/Controlador.php';
require_once __DIR__ . '/Databases/Conexion.php';

header("Content-Type:application/json");
$requestMethod = $_SERVER["REQUEST_METHOD"];
$paths = $_SERVER['REQUEST_URI'];
$datosRecibidos = file_get_contents("php://input");

$argus = explode('/', $paths);
unset($argus[0]);

// Metodos manejados unicamente por el administrador
if ($argus[1] == 'admin') {
    if ($requestMethod == 'POST') { // Creación de usuarios con POST
        $data = json_decode($datosRecibidos, true);

        Controlador::crearUsuario(new Persona(
            $data['idUsuario'],
            $data['password'],
            $data['nombre'],
            $data['email'],
            $data['partidasJugadas'],
            $data['partidasGanadas'],
            $data['admin']
        ));
    } else if ($requestMethod == 'GET') { // Listar usuarios con GET
        if ($argus[2] == '') {
            Controlador::allUsuarios();
        } else {
            Controlador::usuarioByID($argus[2]);
        }
    }

    // Metodos para poder jugar
} else if ($argus[1] == 'jugador') {
}
