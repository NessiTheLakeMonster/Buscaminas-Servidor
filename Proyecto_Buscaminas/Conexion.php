<?php

require 'Partida.php'; 
require 'Constantes.php';

class Conexion
{

    static $conexion;

    public static function conectar()
    {
        try {
            self::$conexion = new mysqli(
                Constantes::$host,
                Constantes::$user,
                Constantes::$psswd,
                Constantes::$bdName
            );
        } catch (Exception $e) {
            echo "Fallo al conectar a MySQL: (" . $e->getMessage() . ")";
            die();
        }

        echo self::$conexion->host_info . "<br>";

        return self::$conexion;
    }

    private static function desconectar()
    {
        self::$conexion->close();
    }

    /* ---------------------- CRUD TABLA PARTIDA ------------------------------------ */

    public static function seleccionarPartida($id)
    {
        self::conectar();

        if (!self::$conexion) {
            die();
        } else {
            $query = Constantes::$selecPartidaByID;
            $stmt = self::$conexion->prepare($query);
            //$id =
        }
    }

    public static function seleccionarTodasPartidas()
    {
        self::conectar();

        if (!self::$conexion) {
            die();
        } else {
            $query = Constantes::$selecPartida;
            $stmt = self::$conexion->prepare($query);

            $stmt->execute();
            $correcto = [];
            $correcto_query = mysqli_stmt_get_result($stmt);

            while ($fila = mysqli_fetch_array($correcto_query)) {
            }
        }
    }

    public static function insertarPartida($partida)
    {
        self::conectar();
        $correcto = false;

        if (!self::$conexion) {
            die();
        } else {
            $query = Constantes::$insertPartida;
            $stmt = self::$conexion->prepare($query);

            $idPartida = $partida->getIDPartida();
            $idUsuario = $partida->getIdUsuario();
            $tableroOculto = $partida->getTableroOculto();
            $tableroJugador = $partida->getTableroJugador();
            $finalizado = $partida->getFinalizado();

            $stmt->bind_param(
                "iissb",
                $idPartida,
                $idUsuario,
                $tableroOculto,
                $tableroJugador,
                $finalizado
            );

            try {
                if ($stmt->execute()) {
                    $correcto = true;
                }
            } catch (Exception $e) {
                $correcto = false;
            }

            self::desconectar();
        }

        return $correcto;
    }

    public static function eliminarPartida($id) {

    }

    /* ---------------------- CRUD TABLA PERSONA ------------------------------------ */

    public static function seleccionarPersona($mail, $passwd)
    {
    }
}
