<?php

require_once __DIR__ . '\..\Databases\Conexion.php';

class Controlador
{

    static function crearPartida($p)
    {
        if (Conexion::insertarPartida($p)) {
            $insercion = true;

            $cod = 201;
            $msg = 'TODO OK';

            header(Constantes::$headerMssg . $cod . ' ' . $msg);
            $respuesta = [
                'Cod: ' => $cod,
                'Mensaje: ' => $msg,
                'Inserccion: ' =>  $insercion
            ];
            echo json_encode($respuesta);
        } else {
            $insercion = false;

            $cod = 201;
            $msg = 'NO SE PUDO CREAR LA PARTIDA';

            header(Constantes::$headerMssg . $cod . ' ' . $msg);
            $respuesta = [
                'Cod: ' => $cod,
                'Mensaje: ' => $msg,
                'Inserccion: ' =>  $insercion
            ];
            echo json_encode($respuesta);
        }
    }

    static function allPartidas()
    {
        $arrayPartidas = Conexion::seleccionarTodasPartidas();
        $cod = 201;
        $mes = "TODO OK";
        header(Constantes::$headerMssg . $cod . ' ' . $mes);
        $respuesta = [
            'Cod:' => $cod,
            'Mensaje:' => $mes,
            'Personas' => $arrayPartidas
        ];
        echo json_encode($respuesta);
    }

    // ----------------------- FUNCION DE LOGIN --------------------------

    static function login($email, $passw)
    {
        if (Conexion::seleccionarPersona($email, $passw)) {
            $login = true;
            $cod = 201;
            $mes = "TODO OK";
        } else {
            $login = false;
            $cod = 400;
            $mes = "ERROR";
        }

        header(Constantes::$headerMssg . $cod . ' ' . $mes);
        $respuesta = [
            'Cod:' => $cod,
            'Mensaje:' => $mes,
            'Login:' => $login
        ];

        echo json_encode($respuesta);
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
