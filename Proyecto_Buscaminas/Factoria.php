<?php

require __DIR__.'\Model\Persona.php';
require __DIR__.'\Model\Partida.php';
require __DIR__.'\Model\Tablero.php';

class Factoria {

    static function crearPersona($idUsu, $pass, $nom, $em, $partJ, $partG, $adm) {
        $pers = new Persona($idUsu, $pass, $nom, $em, $partJ, $partG, $adm);
        return $pers;
    }

    static function crearPartida($idPart, $idUsu, $tabO, $tabJ, $fin) {
        $part = new Partida($idPart, $idUsu, $tabO, $tabJ, $fin);
        return $part;
    }

    static function crearTablero($cas, $min) {
        $tab = new Tablero($cas, $min);
        return $tab;
    }
}