<?php

require_once __DIR__ . '\..\Databases\Conexion.php';
require_once __DIR__ . '\..\Model\Persona.php';
require_once __DIR__ . '\..\Model\Partida.php';

class Controlador
{

    static function crearPartida($p)
    {
        if ($partida = Conexion::insertarPartida($p)) {
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
            'Insercion: ' =>  $insercion,
            'Partida' => $partida
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

    static function partidaById($id)
    {
        if ($partida = Conexion::seleccionarPartida($id)) {
            $cod = 201;
            $mes = "TODO OK";

            return $partida;
        } else {
            $cod = 400;
            $mes = "ERROR";
        }

        header(Constantes::$headerMssg . $cod . ' ' . $mes);
        $respuesta = [
            'Cod:' => $cod,
            'Mensaje:' => $mes,
            'Partida' => $partida
        ];

        echo json_encode($respuesta);
    }

    static function updateTablero($tabStr, $id)
    {
        if ($partida = Conexion::updateTableroJugador($tabStr, $id)) {
            $cod = 201;
            $mes = "TODO OK";
        } else {
            $cod = 400;
            $mes = "ERROR";
        }

        header(Constantes::$headerMssg . $cod . ' ' . $mes);
        $respuesta = [
            'Cod: ' => $cod,
            'Mensaje: ' => $mes,
            'Partida' => $partida
        ];
        echo json_encode($respuesta);
    }

    static function updateFin($fin, $id)
    {
        if ($partida = Conexion::updateFinalizado($fin, $id)) {
            $cod = 201;
            $mes = "TODO OK";
        } else {
            $cod = 400;
            $mes = "ERROR";
        }

        header(Constantes::$headerMssg . $cod . ' ' . $mes);
        $respuesta = [
            'Cod: ' => $cod,
            'Mensaje: ' => $mes,
            'Partida' => $partida
        ];
        echo json_encode($respuesta);
    }

    static function strToArray($str)
    {
        $array = explode(',', $str);

        return $array;
    }

    static function arrayToStr($array)
    {
        $str = implode(',', $array);

        return $str;
    }

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

        if ($partida->getFinalizado() == 1) {
            $fin = true;
        } else {
            $fin = false;
        }

        return $fin;
    }
}
