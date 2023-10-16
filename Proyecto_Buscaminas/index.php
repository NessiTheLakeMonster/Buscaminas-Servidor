<?php

require_once __DIR__ . '/Controllers/Controlador.php';
require_once __DIR__ . '/Controllers/Controlador_Usuario.php';
require_once __DIR__ . '/Databases/Conexion.php';
require_once __DIR__ . '/Model/Persona.php';

header("Content-Type:application/json");
$requestMethod = $_SERVER["REQUEST_METHOD"];
$paths = $_SERVER['REQUEST_URI'];
$datosRecibidos = file_get_contents("php://input");

$argus = explode('/', $paths);
unset($argus[0]);


if ($requestMethod == 'GET') {
    if ($argus[1] == 'admin') {
        $data = json_decode($datosRecibidos, true);

        $data[0] = Controlador::login(
            $data['email'],
            $data['password']
        );
        
        if (Controlador::checkAdmin($data[0]) == true && $data[0] !== null) {
            $data[1] = Controlador_Usuario::allUsuarios();
        } else {
            $msgError = [
                'Cod:' => 200,
                'Mensaje:' => "Usuario no es administrador"
            ];

            echo json_encode($msgError);
        }
    } else {
        // codigo para el jugador
    }
}



// Metodos manejados unicamente por el administrador
/* if ($argus[1] == 'admin') {

    if ($requestMethod == 'POST') { // Creación de usuarios con POST
        $data = json_decode($datosRecibidos, true);

        $persona = Controlador::login(
            $data['email'],
            $data['password']
        );

        if (Controlador::checkAdmin($persona) == true) {

            Controlador_Usuario::crearUsuario(Factoria::crearPersona(
                $data['idUsuario'],
                $data['password'],
                $data['nombre'],
                $data['email'],
                $data['partidasJugadas'],
                $data['partidasGanadas'],
                $data['admin']
            ));
        }
    } else if ($requestMethod == 'GET' && $argus[1] == 'admin') { // Listar usuarios con GET
        $data = json_decode($datosRecibidos, true);

        $data[0] = Controlador::login(
            ['email'],
            ['password']
        );

        print_r($data);

        if (Controlador::checkAdmin($data[0]) == true) {
            if ($argus[2] == '') {
                $data[1] = Controlador_Usuario::allUsuarios();
            } else {
                Controlador_Usuario::usuarioByID($argus[2]);
            }
        }
    } else if ($requestMethod == 'DELETE') { // Borrar usuarios con DELETE
        Controlador_Usuario::borrarUsuario($argus[2]);
    }

    // Metodos para poder jugar
} else if ($argus[1] == 'jugador') {
} */