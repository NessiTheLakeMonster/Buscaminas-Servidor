<?php

require 'Constantes.php';
require 'Factoria.php';

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
        }

        /* echo self::$conexion->host_info . "<br>"; */

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
            echo "Error al conectar a MySQL";
        } else {
            $query = Constantes::$selecPartidaByID;
            $stmt = self::$conexion->prepare($query);

            $stmt->bind_param(
                "i",
                $idPart
            );

            try {
                $stmt->execute();
                $result = $stmt->get_result();

                $partida = [];

                while ($fila = $result->fetch_array()) {
                    $part = Factoria::crearPartida(
                        $fila["idPartida"],
                        $fila["idUsuario"],
                        $fila["tableroOculto"],
                        $fila["tableroJugador"],
                        $fila["finalizado"]
                    );

                    $partida = $part;
                }

                $result->free_result();
                return $partida;
            } catch (Exception $e) {
                echo 'No se pudo selecionar' . $e->getMessage();
            }
        }
        self::desconectar();
    }

    public static function seleccionarTodasPartidas()
    {
        self::conectar();

        if (!self::$conexion) {
            echo 'Error al conectar a MySQL';
        } else {
            $query = Constantes::$selecPartida;
            $stmt = self::$conexion->prepare($query);

            try {
                $stmt->execute();
                $result = $stmt->get_result();

                $partidas = [];
                while ($fila = $result->fetch_array()) {
                    $p = Factoria::crearPartida(
                        $fila['idPartida'],
                        $fila['idUsuario'],
                        $fila['tableroOculto'],
                        $fila['tableroJugador'],
                        $fila['finalizado']
                    );
                    $partidas[] = $p;
                }

                $result->free_result();
                return $partidas;
            } catch (Exception $e) {
                echo 'No se pudo seleccionar' . $e->getMessage();
            }
        }

        self::desconectar();
    }

    public static function insertarPartida($partida)
    {
        self::conectar();
        $correcto = false;

        if (!self::$conexion) {
            echo 'Error al conectar a MySQL';
        } else {
            $query = Constantes::$insertPartida;
            $stmt = self::$conexion->prepare($query);

            $idUsuario = $partida->getIdUsuario();
            $tableroOculto = $partida->getTableroOculto();
            $tableroJugador = $partida->getTableroJugador();
            $finalizado = $partida->getFinalizado();

            $stmt->bind_param(
                "issi",
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
            echo 'Error al conectar a MySQL';
        } else {
            $query = Constantes::$deletePartidaByID;
            $stmt = self::$conexion->prepare($query);

            $stmt->bind_param(
                "i",
                $idPart
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

    public static function updateTableroJugador($tableroJugador, $idPart)
    {
        self::conectar();
        $correcto = false;

        if (!self::$conexion) {
            echo 'Error al conectar a MySQL';
        } else {
            $query = Constantes::$updateTableroJugador;
            $stmt = self::$conexion->prepare($query);

            $stmt->bind_param(
                "si",
                $tableroJugador,
                $idPart
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

    public static function updatePartidasJugadas($partJ, $idUsu)
    {
        self::conectar();
        $correcto = false;

        if (!self::$conexion) {
            echo 'Error al conectar a MySQL';
        } else {
            $query = Constantes::$updatePartidasJugadas;
            $stmt = self::$conexion->prepare($query);

            $stmt->bind_param(
                "ii",
                $partJ,
                $idUsu
            );

            try {
                if ($stmt->execute()) {
                    $correcto = true;
                }
            } catch (Exception $e) {
                echo 'No se pudo actualizar' . $e->getMessage();
                $correcto = false;
            }
        }
        self::desconectar();
        return $correcto;
    }

    public static function updatePartidasGanadas($partG, $idUsu)
    {
        self::conectar();
        $correcto = false;

        if (!self::$conexion) {
            echo 'Error al conectar a MySQL';
        } else {
            $query = Constantes::$updatePartidasJGanadas;
            $stmt = self::$conexion->prepare($query);

            $stmt->bind_param(
                "ii",
                $partG,
                $idUsu
            );

            try {
                if ($stmt->execute()) {
                    $correcto = true;
                }
            } catch (Exception $e) {
                echo 'No se pudo actualizar' . $e->getMessage();
                $correcto = false;
            }
        }
        self::desconectar();
        return $correcto;
    }

    public static function updateFinalizado($fin, $idPart)
    {
        self::conectar();
        $correcto = false;

        if (!self::$conexion) {
            echo 'Error al conectar a MySQL';
        } else {
            $query = Constantes::$updateFinalizado;
            $stmt = self::$conexion->prepare($query);

            $stmt->bind_param(
                "ii",
                $fin,
                $idPart
            );

            try {
                if ($stmt->execute()) {
                    $correcto = true;
                }
            } catch (Exception $e) {
                echo 'No se pudo actualizar' . $e->getMessage();
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
            echo 'Error al conectar a MySQL';
        } else {
            $query = Constantes::$selectPersonaByID;
            $stmt = self::$conexion->prepare($query);

            $stmt->bind_param(
                "i",
                $idPers
            );

            try {
                $stmt->execute();
                $result = $stmt->get_result();

                $usuarios = [];

                while ($fila = $result->fetch_array()) {
                    $p = Factoria::crearPersona(
                        $fila['idUsuario'],
                        $fila['password'],
                        $fila['nombre'],
                        $fila['email'],
                        $fila['partidasJugadas'],
                        $fila['partidasGanadas'],
                        $fila['admin']
                    );
                    $usuarios[] = $p;
                }

                $result->free_result();
                return $usuarios;
            } catch (Exception $e) {
                echo 'No se pudo selecionar' . $e->getMessage();
            }
        }
        self::desconectar();
    }

    public static function seleccionarPersonaLogin($mail, $pass)
    {
        self::conectar();

        if (!self::$conexion) {
            echo 'Error al conectar a MySQL';
        } else {
            $query = Constantes::$selectPersonaByEmailPass;
            $stmt = self::$conexion->prepare($query);

            $stmt->bind_param(
                "ss",
                $pass,
                $mail
            );

            try {
                $stmt->execute();
                $result = $stmt->get_result();

                $usuarios = [];

                while ($fila = $result->fetch_array()) {
                    $p = Factoria::crearPersona(
                        $fila['idUsuario'],
                        $fila['password'],
                        $fila['nombre'],
                        $fila['email'],
                        $fila['partidasJugadas'],
                        $fila['partidasGanadas'],
                        $fila['admin']
                    );
                    $usuarios = $p;
                }

                $result->free_result();
                return $usuarios;
            } catch (Exception $e) {
                echo 'No se pudo selecionar' . $e->getMessage();
            }
        }
        self::desconectar();
    }

    public static function seleccionarTodasPersonas()
    {
        self::conectar();

        if (!self::$conexion) {
            echo 'Error al conectar a MySQL';
        } else {
            $query = Constantes::$selectPersona;
            $stmt = self::$conexion->prepare($query);

            try {
                $stmt->execute();
                $result = $stmt->get_result();

                $usuarios = [];

                while ($fila = $result->fetch_array()) {
                    $p = Factoria::crearPersona(
                        $fila['idUsuario'],
                        $fila['password'],
                        $fila['nombre'],
                        $fila['email'],
                        $fila['partidasJugadas'],
                        $fila['partidasGanadas'],
                        $fila['admin']
                    );
                    $usuarios[] = $p;
                }

                $result->free_result();
                return $usuarios;
            } catch (Exception $e) {
                echo 'No se pudo selecionar' . $e->getMessage();
            }
        }

        self::desconectar();
    }

    public static function insertarPersona($persona)
    {
        self::conectar();
        $correcto = false;

        if (!self::$conexion) {
            echo 'Error al conectar a MySQL';
        } else {
            $query = Constantes::$insertPersona;
            $stmt = self::$conexion->prepare($query);

            $pass = $persona->getPassword();
            $nom = $persona->getNombre();
            $em = $persona->getEmail();
            $partJ = $persona->getPartidasJugadas();
            $partG = $persona->getPartidasGanadas();
            $adm = $persona->getAdmin();

            $stmt->bind_param(
                "sssiii",
                $pass,
                $nom,
                $em,
                $partJ,
                $partG,
                $adm
            );

            try {
                if ($stmt->execute()) {
                    $correcto = true;
                }
            } catch (Exception $e) {
                echo 'No se pudo insertar' . $e->getMessage();
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
            echo 'Error al conectar a MySQL';
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
                echo 'No se pudo eliminar' . $e->getMessage();
                $correcto = false;
            }
        }
        self::desconectar();
        return $correcto;
    }

    public static function updatePersona($idUsu, $pass, $nom, $email, $admin)
    {
        self::conectar();
        $correcto = false;

        if (self::$conexion) {
            $query = Constantes::$updatePassw;
            $stmt = self::$conexion->prepare($query);

            $stmt->bind_param(
                "sssii",
                $pass,
                $nom,
                $email,
                $admin,
                $idUsu
            );

            try {
                if ($stmt->execute()) {
                    $correcto = true;
                }
            } catch (Exception $e) {
                echo 'No se pudo actualizar' . $e->getMessage();
                $correcto = false;
            }
        }
        self::desconectar();
        return $correcto;
    }

    /* ---------------------- FUNCIONES DE RANKING ------------------------------------ */

    public static function selectPersonasRanking()
    {
        self::conectar();

        if (!self::$conexion) {
            echo 'Error al conectar a MySQL';
        } else {
            $query = Constantes::$ranking;
            $stmt = self::$conexion->prepare($query);

            try {
                $stmt->execute();
                $result = $stmt->get_result();

                $usuarios = [];

                while ($fila = $result->fetch_array()) {
                    $p = Factoria::crearPersona(
                        $fila['idUsuario'],
                        $fila['password'],
                        $fila['nombre'],
                        $fila['email'],
                        $fila['partidasJugadas'],
                        $fila['partidasGanadas'],
                        $fila['admin']
                    );
                    $usuarios[] = $p;
                }

                $result->free_result();
                return $usuarios;
            } catch (Exception $e) {
                echo 'No se pudo selecionar' . $e->getMessage();
            }
        }

        self::desconectar();
    }
}
