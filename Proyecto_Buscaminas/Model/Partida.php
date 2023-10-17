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

    public function inicializarTableroOculto($longitud, $minas)
    {
        $t = $this->tableroOculto;
        $t = array_fill(0, $longitud - 1, 0);

        for ($i = 0; $i < $minas; $i++) {
            $index = rand(0, $longitud - 1);

            while ($t[$index] === 1) {
                $index = rand(0, $longitud - 1);
            }
            
            $t[$index] = 1;
        }

        return $t;
    }

    public function inicializarTableroJugador($longitud)
    {
        $t = $this->tableroJugador;
        $t = array_fill(0, $longitud - 1, '0');
        return $t;
    }

    public function destaparPista() {

    }
}
