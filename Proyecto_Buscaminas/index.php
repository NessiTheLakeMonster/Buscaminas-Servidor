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

// Métodos con el verbo GET
if ($requestMethod == 'GET') {
    // Función GET para los administradores
    if ($argus[1] == 'admin') {
        $data = json_decode($datosRecibidos, true);

        $data[0] = Controlador::login(
            $data['email'],
            $data['password']
        );

        // Listar los usuarios en modo administrador
        if (Controlador::checkAdmin($data[0]) == true && $data[0] !== null) {
            if ($argus[2] == null) {
                $data[1] = Controlador_Usuario::allUsuarios();
            } else {
                $data[1] = Controlador_Usuario::usuarioByID($argus[2]);
            }
        } else {
            $msgError = [
                'Cod:' => 200,
                'Mensaje:' => "Usuario no es administrador"
            ];

            echo json_encode($msgError);
        }

        // Función GET para los jugadores
    } else {
        // codigo para el jugador
    }
}

// Métodos con el verbo POST
if ($requestMethod == 'POST') {
    // Función POST para los administradores
    if ($argus[1] == 'admin') {
        $data = json_decode($datosRecibidos, true);

        $data[0] = Controlador::login(
            $data['email'],
            $data['password']
        );

        print_r($data[0]);
        print_r(Controlador::checkAdmin($data[0]));

        if (Controlador::checkAdmin($data[0]) == true && $data[0] !== null) {
            $data[1] = Controlador_Usuario::crearUsuario(
                Factoria::crearPersona (
                    $data['idUsuario'],
                    $data['password'],
                    $data['nombre'],
                    $data['email'],
                    $data['partidasJugadas'],
                    $data['partidasGanadas'],
                    $data['admin']
                )
            );

            print_r($data);
        } else {
            $msgError = [
                'Cod:' => 200,
                'Mensaje:' => "Usuario no es administrador"
            ];

            echo json_encode($msgError);
        }
    }
}

if ($requestMethod == 'DELETE') {

    if ($argus[1] == 'admin') {
        $data = json_decode($datosRecibidos, true);

        $data[0] = Controlador::login(
            $data['email'],
            $data['password']
        );

        if (Controlador::checkAdmin($data[0]) == true && $data[0] !== null) {
            if ($argus[2] == null) {
                $msgError = [
                    'Cod:' => 200,
                    'Mensaje:' => "No has metido que usuario quieres borrar"
                ];

                echo json_encode($msgError);
            } else {
                $data[1] = Controlador_Usuario::borrarUsuario($argus[2]);
            }
        } else {
            $msgError = [
                'Cod:' => 200,
                'Mensaje:' => "Usuario no es administrador"
            ];

            echo json_encode($msgError);
        }
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