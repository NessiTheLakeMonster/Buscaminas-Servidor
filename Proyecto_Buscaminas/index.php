<?php

require_once __DIR__ . '/Controllers/Controlador.php';
require_once __DIR__ . '/Controllers/Controlador_Usuario.php';
require_once __DIR__ . '/Databases/Conexion.php';
require_once __DIR__ . '/Model/Persona.php';
require_once __DIR__ . '/Model/Partida.php';
require_once __DIR__ . '/Model/Tablero.php';

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
    } else if ($argus[1] == 'jugar') {
        // Creación de una nueva partida de un usuario
        $data = json_decode($datosRecibidos, true);

        $data[0] = Controlador::login(
            $data['email'],
            $data['password']
        );

        if ($data[0] !== null) {
            // Usuario elige el tamaño y las minas de su tablero
            if (is_numeric($argus[2]) && is_numeric($argus[3])) {
                $data[1] = Controlador::crearPartida(
                    Factoria::crearPartida(
                        " ",
                        $data[0] -> getIdUsuario(),
                        "[]",
                        "[]",
                        1
                    )
                );
                
                // El tablero se crea por defecto con 10 casillas y 2 minas
            } else if ($argus[2] == null && $argus[3] == null) {

            }

        } else {
            $msgError = [
                'Cod:' => 200,
                'Mensaje:' => "Usuario no existe"
            ];

            echo json_encode($msgError);
        }
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

        if (Controlador::checkAdmin($data[0]) == true && $data[0] !== null) {
            $data[1] = Controlador_Usuario::crearUsuario(
                Factoria::crearPersona(
                    $data['Personas']['idUsuario'],
                    $data['Personas']['password'],
                    $data['Personas']['nombre'],
                    $data['Personas']['email'],
                    $data['Personas']['partidasJugadas'],
                    $data['Personas']['partidasGanadas'],
                    $data['Personas']['admin']
                )
            );
        } else {
            $msgError = [
                'Cod:' => 200,
                'Mensaje:' => "Usuario no es administrador"
            ];

            echo json_encode($msgError);
        }
    } else if ($argus[1] == 'jugar') {
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
                    'Mensaje:' => "No has especificado que usuario quieres borrar"
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

if ($requestMethod == 'PUT') {
}
