<?php

require_once __DIR__ . '\..\Databases\Conexion.php';
require_once __DIR__ . '\..\Model\Persona.php';
require_once __DIR__ . '\..\Model\Partida.php';
require_once __DIR__ . '\..\Model\Tablero.php';

class Controlador
{

    static function crearPartida($p)
    {
        if (Conexion::insertarPartida($p)) {
            $insercion = true;
            $cod = 201;
            $msg = 'TODO OK';
        } else {
            $insercion = false;
            $cod = 400;
            $msg = 'No se pudo crear la partida';
        }

        header(Constantes::$headerMssg . $cod . ' ' . $msg);
        $respuesta = [
            'Cod: ' => $cod,
            'Mensaje: ' => $msg,
            'Insercion: ' =>  $insercion
        ];
        echo json_encode($respuesta);
    } 

    static function allPartidas()
    {
        if ($arrayPartidas = Conexion::seleccionarTodasPartidas()) {
            $cod = 201;
            $mes = "TODO OK";
        } else {
            $cod = 400;
            $mes = "ERROR";
        }

        header(Constantes::$headerMssg . $cod . ' ' . $mes);
        $respuesta = [
            'Cod:' => $cod,
            'Mensaje:' => $mes,
            'Personas' => $arrayPartidas
        ];

        echo json_encode($respuesta);
    }

    static function partidaByIdUsuario($id)
    {
    }

    // ----------------------- FUNCION DE TABLERO ------------------------

    /* static function crearTablero($tab)
    {
        $casillas = $tab -> getCasillas();
        $minas = $tab -> getMinas();

        if ($casillas == null || $minas == null) {
            $t = Factoria::crearTablero(
                Constantes::$defaultCasillas,
                Constantes::$defaultMinas
            );
        } else {
            $t = Factoria::crearTablero(
                $casillas,
                $minas
            );
        }

        return $t;
    } */

    // ----------------------- FUNCION DE LOGIN --------------------------

    static function login($email, $passw)
    {
        $persona = Conexion::seleccionarPersonaLogin($email, $passw);

        if ($persona != null) {
            $login = true;
            $cod = 201;
            $mes = "TODO OK";

            header(Constantes::$headerMssg . $cod . ' ' . $mes);
            $respuesta = [
                'Cod:' => $cod,
                'Mensaje:' => $mes,
                'Login:' => $login
            ];

            return $persona;
        } else {
            $login = false;
            $cod = 400;
            $mes = "ERROR";

            header(Constantes::$headerMssg . $cod . ' ' . $mes);
            $respuesta = [
                'Cod:' => $cod,
                'Mensaje:' => $mes,
                'Login:' => $login
            ];

            echo json_encode($respuesta);
            return null;
        }
    }

    /**
     * Función que comprueba si el usuario pasado es admin o no
     * 
     * Si un usuario es admin su campo valdrá 0
     * Si un usuario no es admin su campo valdrá 1
     * 
     * @param Persona $persona
     * @return boolean
     */
    static function checkAdmin($persona)
    {
        $admin = false;

        if ($persona->getAdmin() == 0) {
            $admin = true;
        } else {
            $admin = false;
        }

        return $admin;
    }

    /**
     * Función que comprueba si la partida pasada esta acabada o no
     * 
     * Si el usuario no tiene partida abierta valdrá 0
     * Si el usuario tiene partida abierta valdrá 1
     * 
     * @param Partida $partida
     * @return boolean
     */
    static function checkFinalizado($partida)
    {
        $fin = false;

        if ($partida->getFinalizado() == 0) {
            $fin = true;
        } else {
            $fin = false;
        }

        return $fin;
    }
}
