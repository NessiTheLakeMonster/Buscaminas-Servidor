<?php

class Persona
{
    public $password;
    public $nombre;
    public $email;
    public $partidasJugadas;
    public $partidasGanadas;
    public $admin;

    public function __construct($pass, $nom, $em, $partJ, $partG, $adm)
    {
        $this->password = $pass;
        $this->nombre = $nom;
        $this->email = $em;
        $this->partidasJugadas = $partJ;
        $this->partidasGanadas = $partG;
        $this->admin = $adm;
    }

    // Getters and Setters -------------------------------------

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($pass)
    {
        $this->password = $pass;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nom)
    {
        $this->nombre = $nom;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($em)
    {
        $this->email = $em;
    }

    public function getPartidasJugadas()
    {
        return $this->partidasJugadas;
    }

    public function setPartidasJugadas($partJ)
    {
        $this->partidasJugadas = $partJ;
    }

    public function getPartidasGanadas()
    {
        return $this->partidasGanadas;
    }

    public function setPartidasGanadas($partG)
    {
        $this->partidasGanadas = $partG;
    }

    public function getAdmin()
    {
        return $this->admin;
    }

    public function setAdmin($adm)
    {
        $this->admin = $adm;
    }
}
