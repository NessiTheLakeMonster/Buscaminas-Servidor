<?php

require_once __DIR__ . '\..\Databases\Conexion.php';

class Controlador_Usuario
{

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
}
