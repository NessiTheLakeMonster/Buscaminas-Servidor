<?php

require __DIR__ . 'Partida.php';

class Conexion
{

    static $conexion;

    private static function conectar()
    {
        try {
            $conexion = new mysqli(
                Constantes::$host,
                Constantes::$user,
                Constantes::$psswd,
                Constantes::$bdName
            );
        } catch (Exception $e) {
            echo "Fallo al conectar a MySQL: (" . $e->getMessage() . ")";
            die();
        }

        echo $conexion->host_info . "<br>";

        return $conexion;
    }

    private static function desconectar()
    {
        self::$conexion->close();
    }

    public static function insertarPartida($partida)
    {
        self::$conexion->conectar();
        $correcto = false;

        if (!self::$conexion) {
            die();
        } else {
            $query = "INSERT INTO partida VALUES(?,?,?,?,?)";
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

    public static function seleccionarPartida($id)
    {
        self::$conexion->conectar();

        if (!self::$conexion) {
            die();
        } else {
            $query = "SELECT * FROM partida WHERE idPartida = ?";
            $stmt = self::$conexion->prepare($query);
            //$id =
        }
    }

    public static function seleccionarTodasPartidas()
    {
        self::$conexion->conectar();

        if (!self::$conexion) {
            die();
        } else {
            $query = "SELECT * FROM partida";
            $stmt = self::$conexion->prepare($query);

            $stmt->execute();
            $correcto = [];
            $correcto_query = mysqli_stmt_get_result($stmt);

            while ($fila = mysqli_fetch_array($correcto_query)) {
            }
        }
    }

    public static function seleccionarPersona($mail, $passwd)
    {
    }
}
