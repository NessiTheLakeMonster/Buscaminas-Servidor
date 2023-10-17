<?php

require_once __DIR__ . '\..\Databases\Conexion.php';
require_once __DIR__ . '\..\Model\Persona.php';

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

    // ----------------------- FUNCION DE TABLERO ------------------------

    /* static function crearTablero($tab)
    {
        if ($tab['casillas'] == null || $tab['minas'] == null) {
            $t = Factoria::crearTablero(
                Constantes::$defaultCasillas,
                Constantes::$defaultMinas
            );
        } else {
            $t = Factoria::crearTablero(
                $tab['casillas'],
                $tab['minas']
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
}
