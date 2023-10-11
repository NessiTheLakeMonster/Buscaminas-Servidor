<?php

require 'Persona.php';
require 'Partida.php';
require 'Constantes.php';

class Conexion
{

    /* ---------------------- FUNCIONES DE CONEXION ------------------------------------ */

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

    public static function seleccionarPartida($idPart)
    {
        self::conectar();

        if (!self::$conexion) {
            die();
        } else {
            $query = Constantes::$selecPartidaByID;
            $stmt = self::$conexion->prepare($query);
            $stmt->bind_param("i", $idPart);

            try {
                $stmt->execute();
                $result = $stmt->get_result();

                $correcto = [];
                while ($fila = $result->fetch_array()) {
                    $part = new Partida(
                        $fila["idPartida"],
                        $fila["idUsuario"],
                        $fila["tableroOculto"],
                        $fila["tableroJugador"],
                        $fila["finalizado"]
                    );

                    $correcto = $part;
                }
            } catch (Exception $e) {
                echo 'No se pudo selecionar' . $e->getMessage();
                $correcto = false;
            }
        }

        self::desconectar();
        return $correcto;
    }

    public static function seleccionarTodasPartidas()
    {
        self::conectar();

        if (!self::$conexion) {
            die();
        } else {
            $query = Constantes::$selecPartida;
            $stmt = self::$conexion->prepare($query);

            try {
                $stmt->execute();
                $result = $stmt->get_result();

                $correcto = [];
                while ($fila = $result->fetch_array()) {
                    $partida = new Partida(
                        $fila['idPartida'],
                        $fila['idUsuario'],
                        $fila['tableroOculto'],
                        $fila['tableroJugador'],
                        $fila['finalizado']
                    );

                    array_push($correcto, $partida);
                }
            } catch (Exception $e) {
                echo 'No se pudo selecionar' . $e->getMessage();
                $correcto = false;
            }
        }

        self::desconectar();
        return $correcto;
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
        }

        self::desconectar();
        return $correcto;
    }

    public static function eliminarPartida($idPart)
    {
        self::conectar();
        $correcto = false;

        if (!self::$conexion) {
            die();
        } else {
            $query = Constantes::$deletePartidaByID;
            $stmt = self::$conexion->prepare($query);

            $stmt->bind_param("i", $idPart);

            try {
                if ($stmt->execute()) {
                    $correcto = true;
                }
            } catch (Exception $e) {
                $correcto = false;
            }
        }
        self::desconectar();
        return $correcto;
    }

    /* ---------------------- CRUD TABLA PERSONA ------------------------------------ */

    public static function seleccionarPersona($idPers)
    {
        self::conectar();

        if (!self::$conexion) {
            die();
        } else {
            $query = Constantes::$selectPersonaByID;
            $stmt = self::$conexion->prepare($query);
            $stmt->bind_param("i", $idPers);

            try {
                $stmt->execute();
                $result = $stmt->get_result();

                $correcto = [];

                while ($fila = $result->fetch_array()) {
                    // Crear el objeto persona
                }
            } catch (Exception $e) {
                echo 'No se pudo selecionar' . $e->getMessage();
                $correcto = false;
            }
        }

        self::desconectar();
        return $correcto;
    }

    public static function seleccionarTodasPersonas()
    {
        self::conectar();

        if (!self::$conexion) {
            die();
        } else {
            $query = Constantes::$selectPersona;
            $stmt = self::$conexion;

            try {
                $stmt->execute();
                $result = $stmt->get_result();

                $correcto = [];

                while ($fila = $result->fetch_array()) {
                    // Crear el objeto persona
                }
            } catch (Exception $e) {
                echo 'No se pudo selecionar' . $e->getMessage();
                $correcto = false;
            }
        }

        self::desconectar();
        return $correcto;
    }

    public static function insertarPersona($persona)
    {
        self::conectar();
        $correcto = false;

        if (!self::$conexion) {
            die();
        } else {
            $query = Constantes::$insertPersona;
            $stmt = self::$conexion->prepare($query);

            // Propiedades persona

            $stmt->bind_param(
                // añade atributos
            );

            try {
                if ($stmt->execute()) {
                    $correcto = true;
                }
            } catch (Exception $e) {
                $correcto = false;
            }
        }
        self::desconectar();
        return $correcto;
    }

    public static function deletePersona($idPers)
    {
        self::conectar();
        $correcto = false;

        if (!self::$conexion) {
            die();
        } else {
            $query = Constantes::$deletePersonaByID;
            $stmt = self::$conexion->prepare($query);

            $stmt->bind_param(
                "i",
                $idPers
            );

            try {
                if ($stmt->execute()) {
                    $correcto = true;
                }
            } catch (Exception $e) {
                $correcto = false;
            }
        }
        self::desconectar();
        return $correcto;
    }
}
