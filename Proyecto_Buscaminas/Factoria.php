<?php

require 'Persona.php';
require 'Partida.php';

class Factoria {

    static function crearPersona($idUsu, $pass, $nom, $em, $partJ, $partG, $adm) {
        $pers = new Persona($idUsu, $pass, $nom, $em, $partJ, $partG, $adm);
        return $pers;
    }

    static function crearPartida($idPart, $idUsu, $tabO, $tabJ, $fin) {
        $part = new Partida($idPart, $idUsu, $tabO, $tabJ, $fin);
        return $part;
    }
}