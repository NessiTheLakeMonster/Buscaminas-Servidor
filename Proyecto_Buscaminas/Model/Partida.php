<?php

class Partida
{
    public $idPartida;
    public $idUsuario;
    public $tableroOculto;
    public $tableroJugador;
    public $finalizado;

    public function __construct($idPart, $idUsu, $tabO, $tabJ, $fin)
    {
        $this->idPartida = $idPart;
        $this->idUsuario = $idUsu;
        $this->tableroOculto = $tabO;
        $this->tableroJugador = $tabJ;
        $this->finalizado = $fin;
    }

    // Getters and Setters -------------------------------------

    public function getIdPartida()
    {
        return $this->idPartida;
    }

    public function setIdPartida($idPart)
    {
        $this->idPartida = $idPart;
    }

    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    public function setIdUsuario($idUsu)
    {
        $this->idUsuario = $idUsu;
    }

    public function getTableroOculto()
    {
        return $this->tableroOculto;
    }

    public function setTableroOculto($tabO)
    {
        $this->tableroOculto = $tabO;
    }

    public function getTableroJugador()
    {
        return $this->tableroJugador;
    }

    public function setTableroJugador($tabJ)
    {
        $this->tableroJugador = $tabJ;
    }

    public function getFinalizado()
    {
        return $this->finalizado;
    }

    public function setFinalizado($fin)
    {
        $this->finalizado = $fin;
    }

    // -----------------------------------------------------------

    /**
     * Función que inicializa el tablero oculto con las minas
     * 
     * 0 -> No hay mina
     * 1 -> Hay mina
     * 
     * @param $longitud
     * @param $minas
     * @return array
     */
    public function inicializarTableroOculto($longitud, $minas)
    {
        $t = $this->tableroOculto;
        $t = array_fill(0, $longitud - 1, 0);

        for ($i = 0; $i < $minas; $i++) {
            $index = rand(0, $longitud - 1);

            while ($t[$index] === '*') {
                $index = rand(0, $longitud - 1);
            }

            $t[$index] = '*';
        }

        return $t;
    }

    /**
     * Función que inicializa el tablero del jugador
     * 
     * - -> Casilla no destapada
     * 
     * @param $longitud
     * @return array
     */
    public function inicializarTableroJugador($longitud)
    {
        $t = $this->tableroJugador;
        $t = array_fill(0, $longitud - 1, '-');
        return $t;
    }

    /**
     * Función que destapa una casilla del tablero del jugador
     * y la comprara con el tablero oculto
     * 
     * @param $posicion
     * @return array
     */
    public function destaparPista($posicion)
    {
        $tabJ = $this->tableroJugador;
        $tabO = $this->tableroOculto;

        if ($tabO[$posicion] == '*') {
            $tabJ[$posicion] = '*';
            $this->finalizado = true;
        } else if ($tabO[$posicion] == 0) {
            if (($posicion > 0 && $tabO[$posicion - 1] == '*')
                || ($posicion < count($tabO) - 1 && $tabO[$posicion + 1] == '*')
            ) {
                $tabJ[$posicion] = 1;
            } else {
                $tabJ[$posicion] = 0;
            }
        } else {
            $tabJ[$posicion] = $tabO[$posicion];
        }

        return $tabJ;
    }

    public function comprobarVictoria($tabO, $tabJ)
    {
        $ganar = false;

        // Cuenta las casillas destapadas
        $casillaDestapada = 0;
        for ($i = 0; $i < count($tabJ); $i++) {
            if ($tabJ[$i] !== null && $tabJ[$i] !== '-') {
                $casillaDestapada++;
            }
        }

        // Cuenta las casillas sin mina
        $casillasSinMina = 0;
        for ($i = 0; $i < count($tabO); $i++) {
            if ($tabO[$i] !== '*') {
                $casillasSinMina++;
            }
        }

        if ($casillaDestapada == $casillasSinMina) {
            $ganar = true;
        }

        return $ganar;
    }
}
