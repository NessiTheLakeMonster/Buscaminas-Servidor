<?php

class Constantes
{
    /**
     * Constantes usadas durante la conexión a la Base de Datos
     */
    static $headerMssg = "HTTP/1.1 ";
    static $host = '127.0.0.1';
    static $user = 'root';
    static $psswd = '';
    static $bdName = 'buscaminas';

    /**
     * Sentencias SQL usadas durante la conexión a la Base de Datos
     */
    static $insertPartida = "INSERT INTO partida VALUES(?,?,?,?,?)";
    static $selecPartidaByID = "SELECT * FROM partida WHERE idPartida = ?";
    static $selecPartida = "SELECT * FROM partida";
    static $deletePartidaByID = "DELETE * FROM partida WHERE idPartida = ?";

    static $selectPersona = "SELECT * FROM persona";
    static $selectPersonaByID = "SELECT * FROM persona WHERE idUsuario = ?";
}
