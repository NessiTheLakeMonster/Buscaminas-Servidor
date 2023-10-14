<?php

require 'Controlador.php';
require 'Persona.php';
require 'Partida.php';

class Controlador
{

    // -------------------- FUNCIONES DE LA PARTIDA ----------------------------

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

    static function partidaByID($idPart)
    {
        $partida = Conexion::seleccionarPartida($idPart);
        $cod = 201;
        $mes = "TODO OK";
        header(Constantes::$headerMssg . $cod . ' ' . $mes);
        $respuesta = [
            'Cod:' => $cod,
            'Mensaje:' => $mes,
            'Partida' => $partida
        ];
        echo json_encode($respuesta);
    }

    // -------------------- FUNCIONES DE LA PERSONA ----------------------------
    static function crearUsuario($persJSON)
    {
        $pers = json_decode($persJSON, true);

        if (Conexion::insertarPersona($pers)) {
            $insercion = true;
            $cod = 201;
            $mes = "TODO OK";
        } else {
            $insercion = false;
            $cod = 400;
            $mes = "ERROR";
        }

        // Send the response
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
        $arrayPersonas = Conexion::seleccionarTodasPersonas();
        $cod = 201;
        $mes = "TODO OK";
        header(Constantes::$headerMssg . $cod . ' ' . $mes);
        $respuesta = [
            'Cod:' => $cod,
            'Mensaje:' => $mes,
            'Personas' => $arrayPersonas
        ];
        echo json_encode($respuesta);
    }

    static function usuarioByID($idUsu)
    {
        $persona = Conexion::seleccionarPersona($idUsu);
        $cod = 201;
        $mes = "TODO OK";
        header(Constantes::$headerMssg . $cod . ' ' . $mes);
        $respuesta = [
            'Cod:' => $cod,
            'Mensaje:' => $mes,
            'Persona' => $persona
        ];
        echo json_encode($respuesta);
    }
}
