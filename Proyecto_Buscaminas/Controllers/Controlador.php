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

    // ------------------------------ FUNCIONES USUARIO ------------------------------

    static function crearUsuario($pers)
    {
        if (Conexion::insertarPersona($pers)) {
            $insercion = true;
            $cod = 201;
            $mes = "TODO OK";
        } else {
            $insercion = false;
            $cod = 400;
            $mes = "ERROR";
        }

        header(Constantes::$headerMssg . $cod . ' ' . $mes);
        $respuesta = [
            'Cod:' => $cod,
            'Mensaje:' => $mes,
            'Insercion:' => $insercion
        ];

        echo json_encode($respuesta);
    }

    static function allUsuarios()
    {
        if ($arrayPersonas = Conexion::seleccionarTodasPersonas()) {
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
            'Personas' => $arrayPersonas
        ];

        echo json_encode($respuesta);
    }

    static function usuarioByID($id)
    {
        if ($persona = Conexion::seleccionarPersona($id)) {
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
            'Persona' => $persona
        ];
        echo json_encode($respuesta);
    }

    static function borrarUsuario($id)
    {
        if (Conexion::deletePersona($id)) {
            $borrado = true;
            $cod = 201;
            $mes = "TODO OK";
        } else {
            $borrado = false;
            $cod = 400;
            $mes = "ERROR";
        }

        header(Constantes::$headerMssg . $cod . ' ' . $mes);
        $respuesta = [
            'Cod:' => $cod,
            'Mensaje:' => $mes,
            'Borrado:' => $borrado
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

    static function checkAdmin($persona)
    {
        $admin = false;

        if ($persona->getAdmin() == 0) { // Si es 0, es admin
            $admin = true;
        } else { // Si es 1, no es admin
            $admin = false;
        }

        return $admin;
    }
}
