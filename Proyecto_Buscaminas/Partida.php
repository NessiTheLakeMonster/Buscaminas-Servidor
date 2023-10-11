<?php

class Partida
{
    public $tableroOculto;
    public $tableroJugador;
    public $finalizado;

    public function __construct($tabO, $tabJ, $fin)
    {
        $this->tableroOculto = $tabO;
        $this->tableroJugador = $tabJ;
        $this->finalizado = $fin;
    }

    // Getters and Setters -------------------------------------

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
