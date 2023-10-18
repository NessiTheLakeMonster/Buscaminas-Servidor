<?php

require_once __DIR__ . '/Controllers/Controlador.php';
require_once __DIR__ . '/Controllers/Controlador_Usuario.php';
require_once __DIR__ . '/Databases/Conexion.php';
require_once __DIR__ . '/Model/Persona.php';
require_once __DIR__ . '/Model/Partida.php';
require_once __DIR__ . '/Factoria.php';
require_once __DIR__ . '/Constantes.php';

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
                'Cod:' => 401,
                'Mensaje:' => "Usuario no es administrador"
            ];

            header(Constantes::$headerMssg . $msgError['Cod:'] . ' ' . $msgError['Mensaje:']);
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

        $p = new Partida(1, 1, 1, 1, 1);
        $data[2] = $p;

        if ($data[0] !== null) {
            // Usuario elige el tamaño y las minas de su tablero
            if (is_numeric($argus[2]) && is_numeric($argus[3])) {
                if ($argus[3] > $argus[2]) {
                    $tabO = $p->inicializarTableroOculto($argus[2], $argus[3]);
                    $tabO_str = Controlador::arrayToStr($tabO);
                    $tabJ = $p->inicializarTableroJugador($argus[2]);
                    $tabJ_str = Controlador::arrayToStr($tabJ);

                    $p = Controlador::crearPartida(
                        Factoria::crearPartida(
                            ['idPartida'],
                            $data[0]->getIdUsuario(),
                            $tabO_str,
                            $tabJ_str,
                            false
                        )
                    );
                } else {
                    $msgError = [
                        'Cod:' => 406,
                        'Mensaje:' => "El número de minas no puede ser mayor que el número de casillas"
                    ];

                    header(Constantes::$headerMssg . $msgError['Cod:'] . ' ' . $msgError['Mensaje:']);
                    echo json_encode($msgError);
                }

                // El tablero se crea por defecto con 10 casillas y 2 minas (por defecto)
            } else if ($argus[2] == null && $argus[3] == null) {
                $tabO = $p->inicializarTableroOculto(Constantes::$defaultCasillas, Constantes::$defaultMinas);
                $tabO_str = Controlador::arrayToStr($tabO);
                $tabJ = $p->inicializarTableroJugador(Constantes::$defaultCasillas);
                $tabJ_str = Controlador::arrayToStr($tabJ);

                $p = Controlador::crearPartida(
                    Factoria::crearPartida(
                        ['idPartida'],
                        $data[0]->getIdUsuario(),
                        $tabO_str,
                        $tabJ_str,
                        false
                    )
                );
            }
        } else {
            $msgError = [
                'Cod:' => 406,
                'Mensaje:' => "Usuario no existe"
            ];

            header(Constantes::$headerMssg . $msgError['Cod:'] . ' ' . $msgError['Mensaje:']);
            echo json_encode($msgError);
        }

        // Listar el ranking de los jugadores
    } else if ($argus[1] == 'ranking') {
        Controlador_Usuario::ranking();
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
                'Cod:' => 401,
                'Mensaje:' => "Usuario no es administrador"
            ];

            header(Constantes::$headerMssg . $msgError['Cod:'] . ' ' . $msgError['Mensaje:']);
            echo json_encode($msgError);
        }

        // Función POST para los jugadores
    } else if ($argus[1] == 'jugar') {
        $data = json_decode($datosRecibidos, true);

        $data[0] = Controlador::login(
            $data['email'],
            $data['password']
        );

        if ($data[0] !== null) {
            if ($argus[1] !== null) {

                $partida = Controlador::partidaById($argus[2]);

                $partida = Factoria::crearPartida(
                    $partida->getIdPartida(),
                    $partida->getIdUsuario(),
                    $partida->getTableroOculto(),
                    $partida->getTableroJugador(),
                    $partida->getFinalizado()
                );

                // Compruebo que la partida que va a jugar el usuario es suya
                if ($partida->getIdUsuario() == $data[0]->getIdUsuario() || $partida !== null) {

                    // Compruebo que la partida no ha finalizado
                    if ($partida->getFinalizado() == true) {
                        $msgError = [
                            'Cod:' => 401,
                            'Mensaje:' => "La partida ya ha finalizado"
                        ];

                        header(Constantes::$headerMssg . $msgError['Cod:'] . ' ' . $msgError['Mensaje:']);
                        echo json_encode($msgError);
                    } else {

                        if ($argus[3] == 'rendirse') {
                            // Cambia el estado de finalizado a la partida
                            Controlador::updateFin(1, $partida->getIdPartida());
                            // Le suma 1 a las partidas jugadas por el usuario 
                            Controlador_Usuario::incrementarPartJugadas($data[0]->getPartidasJugadas() + 1, $partida->getIdUsuario());

                            $msgError = [
                                'Cod:' => 401,
                                'Mensaje:' => "Te has rendido"
                            ];

                            header(Constantes::$headerMssg . $msgError['Cod:'] . ' ' . $msgError['Mensaje:']);
                            echo json_encode($msgError);
                        }

                        // Convierto los tableros de string a array
                        $newTableroOculto = $partida->getTableroOculto();
                        $newTableroOcultoArr = Controlador::strToArray($newTableroOculto);
                        $partida->setTableroOculto($newTableroOcultoArr);

                        $newTableroJugador = $partida->getTableroJugador();
                        $newTableroJugadorArr = Controlador::strToArray($newTableroJugador);
                        $partida->setTableroJugador($newTableroJugadorArr);

                        if (!is_numeric($data['Casilla'])) {
                            $msgError = [
                                'Cod:' => 406,
                                'Mensaje:' => "No has especificado la casilla que quieres destapar"
                            ];

                            header(Constantes::$headerMssg . $msgError['Cod:'] . ' ' . $msgError['Mensaje:']);
                            echo json_encode($msgError);
                        } else {

                            // Destapo la casilla que ha elegido el usuario
                            $newTableroJugadorArr = $partida->destaparPista($data['Casilla']);

                            // Convierto los tableros de array a string
                            $newTableroJugadorStr = Controlador::arrayToStr($newTableroJugadorArr);

                            if (Controlador::checkFinalizado($partida) == true) {
                                // Cambia el estado de finalizado a la partida
                                Controlador::updateFin(1, $partida->getIdPartida());
                                // Le suma 1 a las partidas jugadas por el usuario 
                                Controlador_Usuario::incrementarPartJugadas($data[0]->getPartidasJugadas() + 1, $partida->getIdUsuario());
                                Controlador::updateTablero($newTableroJugadorStr, $partida->getIdPartida());
                            } else {
                                // Simplemente actualiza el tablero del jugador
                                Controlador::updateTablero($newTableroJugadorStr, $partida->getIdPartida());
                            }

                            if ($partida->comprobarVictoria($newTableroOcultoArr, $newTableroJugadorArr) == true) {
                                // Cambia el estado de finalizado a la partida
                                Controlador::updateFin(1, $partida->getIdPartida());
                                // Le suma 1 a las partidas ganadas por el usuario 
                                Controlador_Usuario::incrementarPartGanadas($data[0]->getPartidasGanadas() + 1, $partida->getIdUsuario());
                            }
                        }
                    }
                } else {
                    $msgError = [
                        'Cod:' => 401,
                        'Mensaje:' => "No puedes acceder a esta partida"
                    ];

                    header(Constantes::$headerMssg . $msgError['Cod:'] . ' ' . $msgError['Mensaje:']);
                    echo json_encode($msgError);
                }
            }
        } else {
            $msgError = [
                'Cod:' => 406,
                'Mensaje:' => "Usuario no existe"
            ];

            header(Constantes::$headerMssg . $msgError['Cod:'] . ' ' . $msgError['Mensaje:']);
            echo json_encode($msgError);
        }
    }
}


// Métodos con el verbo DELETE
if ($requestMethod == 'DELETE') {
    
    if ($argus[1] == 'admin') {
        $data = json_decode($datosRecibidos, true);

        $data[0] = Controlador::login(
            $data['email'],
            $data['password']
        );

        if (Controlador::checkAdmin($data[0]) == true && $data[0] !== null) {
            if ($argus[2] == null || !is_numeric($argus[2])) {
                $msgError = [
                    'Cod:' => 406,
                    'Mensaje:' => "No has especificado que usuario quieres borrar"
                ];

                header(Constantes::$headerMssg . $msgError['Cod:'] . ' ' . $msgError['Mensaje:']);
                echo json_encode($msgError);
            } else {
                $data[1] = Controlador_Usuario::borrarUsuario($argus[2]);
            }
        } else {
            $msgError = [
                'Cod:' => 401,
                'Mensaje:' => "Usuario no es administrador"
            ];

            header(Constantes::$headerMssg . $msgError['Cod:'] . ' ' . $msgError['Mensaje:']);
            echo json_encode($msgError);
        }
    }
}

// Métodos con el verbo PUT
if ($requestMethod == 'PUT') {
    // Función PUT para los administradores
    if ($argus[1] == 'admin') {
        $data = json_decode($datosRecibidos, true);

        $data[0] = Controlador::login(
            $data['email'],
            $data['password']
        );

        // Modificar la contraseña de un usuario
        if (Controlador::checkAdmin($data[0]) == true && $data[0] !== null) {
            if ($argus[2] == null || !is_numeric($argus[2])) {
                $msgError = [
                    'Cod:' => 406,
                    'Mensaje:' => "No has especificado que usuario quieres modificar"
                ];

                header(Constantes::$headerMssg . $msgError['Cod:'] . ' ' . $msgError['Mensaje:']);
                echo json_encode($msgError);
            } else {
                $data[1] = Controlador_Usuario::cambioPersona(
                    $argus[2],
                    $data['New password'],
                    $data['New nombre'],
                    $data['New email'],
                    $data['New admin']
                );
            }
        } else {
            $msgError = [
                'Cod:' => 401,
                'Mensaje:' => "Usuario no es administrador"
            ];

            header(Constantes::$headerMssg . $msgError['Cod:'] . ' ' . $msgError['Mensaje:']);
            echo json_encode($msgError);
        }
    }
}
