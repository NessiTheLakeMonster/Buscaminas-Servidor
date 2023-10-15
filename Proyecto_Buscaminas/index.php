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
    // Metodo login aqui
    if ($requestMethod == 'POST') {

        $data = json_decode($datosRecibidos, true);

        $persona = Controlador::login(
            $data['email'],
            $data['password']
        );

        if (Controlador::checkAdmin($persona) == false) {
            echo 'No eres admin';
        } else {
            echo 'Eres admin';
            if ($requestMethod == 'POST') { // Creación de usuarios con POST
                $data = json_decode($datosRecibidos, true);

                Controlador::crearUsuario(Factoria::crearPersona(
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
            } else if ($requestMethod == 'DELETE') { // Borrar usuarios con DELETE
                Controlador::borrarUsuario($argus[2]);
            }
        }
    }
    // Metodos para poder jugar
} else if ($argus[1] == 'jugador') {
}
