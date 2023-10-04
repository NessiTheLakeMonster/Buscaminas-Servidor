CREATE TABLE `buscaminas`.`partida` (
    `idPartida` INT(3) NOT NULL,
    `idUsuario` INT(3) NOT NULL,
    `tableroOculto` VARCHAR(50) NOT NULL,
    `tableroJugador` VARCHAR(50) NOT NULL,
    `finalizado` BOOLEAN NOT NULL,
    PRIMARY KEY (`idPartida`)
) ENGINE = InnoDB;

CREATE TABLE `buscaminas`.`persona` (
    `idUsuario` INT(3) NOT NULL,
    `password` VARCHAR(30) NOT NULL,
    `nombre` VARCHAR(50) NOT NULL,
    `email` VARCHAR(50) NOT NULL,
    `partidasJugadas` INT(3) NOT NULL,
    `partidasGanadas` INT(3) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;