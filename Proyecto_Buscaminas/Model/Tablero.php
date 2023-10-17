<?php

class Tablero {
    public $casillas;
    public $minas;

    public function __construct($cas, $min)
    {
        $this->casillas = $cas;
        $this->minas = $min;
    }
    
    // Getters y Setters
    public function getCasillas()
    {
        return $this->casillas;
    }

    public function setCasillas($cas)
    {
        $this->casillas = $cas;
    }

    public function getMinas()
    {
        return $this->minas;
    }

    public function setMinas($min)
    {
        $this->minas = $min;
    }
}