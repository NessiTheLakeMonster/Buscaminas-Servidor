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

}
