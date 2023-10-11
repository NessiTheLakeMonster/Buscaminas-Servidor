<?php

require 'Persona.php';
require 'Partida.php';

class Factoria {

    static function crearPersona($pass, $nom, $em, $partJ, $partG, $adm) {
        $pers = new Persona($pass, $nom, $em, $partJ, $partG, $adm);
        return $pers;
    }

    static function crearPartida($tabO, $tabJ, $fin) {
        $part = new Partida($tabO, $tabJ, $fin);
        return $part;
    }
}