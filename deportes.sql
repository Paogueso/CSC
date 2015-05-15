-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 15-05-2015 a las 05:32:02
-- Versión del servidor: 5.6.12-log
-- Versión de PHP: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `deportes`
--
CREATE DATABASE IF NOT EXISTS `deportes` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `deportes`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo`
--

CREATE TABLE IF NOT EXISTS `equipo` (
  `idEquipo` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(25) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`idEquipo`),
  UNIQUE KEY `Nombre` (`Nombre`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Volcado de datos para la tabla `equipo`
--

INSERT INTO `equipo` (`idEquipo`, `Nombre`, `activo`) VALUES
(1, 'fgdxgd', 1),
(2, 'asdee', 1),
(3, 'zdf', 1),
(4, 'sdfsadf', 1),
(6, 'asd', 0),
(7, 'dff', 1),
(8, 'd', 0),
(9, 'as', 1),
(12, 'f', 0),
(13, 'fg', 0),
(14, 'Maikitos', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscrito`
--

CREATE TABLE IF NOT EXISTS `inscrito` (
  `idInscrito` int(11) NOT NULL AUTO_INCREMENT,
  `Posicion` varchar(4) DEFAULT NULL,
  `Equipo_idEquipo` int(11) NOT NULL,
  `persona_idPersona` int(11) NOT NULL,
  `titular` tinyint(1) NOT NULL,
  PRIMARY KEY (`idInscrito`),
  UNIQUE KEY `persona_idPersona` (`persona_idPersona`),
  KEY `fk_Inscrito_Equipo1_idx` (`Equipo_idEquipo`),
  KEY `fk_inscrito_persona1_idx` (`persona_idPersona`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ins_torneo`
--

CREATE TABLE IF NOT EXISTS `ins_torneo` (
  `idIT` int(11) NOT NULL AUTO_INCREMENT,
  `Equipo_idEquipo` int(11) NOT NULL,
  `Torneo_idTorneo` int(11) NOT NULL,
  PRIMARY KEY (`idIT`),
  KEY `fk_Ins_Torneo_Equipo1_idx` (`Equipo_idEquipo`),
  KEY `fk_Ins_Torneo_Torneo1_idx` (`Torneo_idTorneo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Volcado de datos para la tabla `ins_torneo`
--

INSERT INTO `ins_torneo` (`idIT`, `Equipo_idEquipo`, `Torneo_idTorneo`) VALUES
(1, 6, 1),
(2, 7, 1),
(3, 8, 2),
(4, 9, 1),
(6, 12, 1),
(7, 13, 4),
(8, 14, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partido`
--

CREATE TABLE IF NOT EXISTS `partido` (
  `idPartido` int(11) NOT NULL AUTO_INCREMENT,
  `Puntos_Equipo1` int(11) DEFAULT NULL,
  `Puntos_Equipo2` int(11) DEFAULT NULL,
  `torneo_idTorneo` int(11) NOT NULL,
  `equipo_idEquipo1` int(11) NOT NULL,
  `equipo_idEquipo2` int(11) NOT NULL,
  PRIMARY KEY (`idPartido`,`torneo_idTorneo`,`equipo_idEquipo1`,`equipo_idEquipo2`),
  KEY `fk_partido_torneo1_idx` (`torneo_idTorneo`),
  KEY `fk_partido_equipo1_idx` (`equipo_idEquipo1`),
  KEY `fk_partido_equipo2_idx` (`equipo_idEquipo2`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `partido`
--

INSERT INTO `partido` (`idPartido`, `Puntos_Equipo1`, `Puntos_Equipo2`, `torneo_idTorneo`, `equipo_idEquipo1`, `equipo_idEquipo2`) VALUES
(1, NULL, NULL, 1, 1, 2),
(2, NULL, NULL, 5, 1, 3),
(3, NULL, NULL, 5, 2, 1),
(4, NULL, NULL, 6, 3, 14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE IF NOT EXISTS `persona` (
  `idPersona` int(11) NOT NULL AUTO_INCREMENT,
  `Nombres` varchar(50) DEFAULT NULL,
  `Apellidos` varchar(50) DEFAULT NULL,
  `Fecha_Nac` date DEFAULT NULL,
  `Deporte` varchar(25) DEFAULT NULL,
  `Categoria` varchar(10) DEFAULT NULL,
  `DUI` varchar(10) DEFAULT NULL,
  `Telefono` varchar(9) DEFAULT NULL,
  `usuario_idusuario` int(11) NOT NULL,
  PRIMARY KEY (`idPersona`),
  KEY `fk_persona_usuario1_idx` (`usuario_idusuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`idPersona`, `Nombres`, `Apellidos`, `Fecha_Nac`, `Deporte`, `Categoria`, `DUI`, `Telefono`, `usuario_idusuario`) VALUES
(7, 'Rodrigo', 'Mixco', '1996-12-31', 'Baloncesto', 'U-17', 'N/D', '2132-1321', 38);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stat_bkb`
--

CREATE TABLE IF NOT EXISTS `stat_bkb` (
  `idStat_bkb` int(11) NOT NULL AUTO_INCREMENT,
  `Tipo` char(1) DEFAULT NULL,
  `tiempo_juego` varchar(50) DEFAULT NULL,
  `tiros_1` int(11) DEFAULT NULL,
  `tiros_fallados_1` int(11) DEFAULT NULL,
  `tiros_por_1` int(11) DEFAULT NULL,
  `tiros_2` int(11) DEFAULT NULL,
  `tiros_fallados_2` int(11) DEFAULT NULL,
  `tiros_por_2` int(11) DEFAULT NULL,
  `tiros_3` int(11) DEFAULT NULL,
  `tiros_fallados_3` int(11) DEFAULT NULL,
  `tiros_por_3` int(11) DEFAULT NULL,
  `asistencias` int(11) DEFAULT NULL,
  `faltas` int(11) DEFAULT NULL,
  `perdidas` int(11) DEFAULT NULL,
  `rebotes_def` int(11) DEFAULT NULL,
  `rebotes_of` int(11) DEFAULT NULL,
  `Faltas_of` int(11) DEFAULT NULL,
  `Faltas_def` int(11) DEFAULT NULL,
  `Jugador_idJugador` int(11) NOT NULL,
  `Partido_idPartido` int(11) NOT NULL,
  PRIMARY KEY (`idStat_bkb`),
  KEY `fk_Stat_bkb_Jugador1_idx` (`Jugador_idJugador`),
  KEY `fk_Stat_bkb_Partido1_idx` (`Partido_idPartido`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `stat_bkb`
--

INSERT INTO `stat_bkb` (`idStat_bkb`, `Tipo`, `tiempo_juego`, `tiros_1`, `tiros_fallados_1`, `tiros_por_1`, `tiros_2`, `tiros_fallados_2`, `tiros_por_2`, `tiros_3`, `tiros_fallados_3`, `tiros_por_3`, `asistencias`, `faltas`, `perdidas`, `rebotes_def`, `rebotes_of`, `Faltas_of`, `Faltas_def`, `Jugador_idJugador`, `Partido_idPartido`) VALUES
(1, NULL, '0', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 7, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stat_fut`
--

CREATE TABLE IF NOT EXISTS `stat_fut` (
  `idStat_Fut` int(11) NOT NULL AUTO_INCREMENT,
  `Tipo` char(1) DEFAULT NULL,
  `Porcentaje_Tiro` float DEFAULT NULL,
  `Tiro_Gol` int(11) DEFAULT NULL,
  `Tiro_Desv` int(11) DEFAULT NULL,
  `Faltas` int(11) DEFAULT NULL,
  `Tarjeta_A` int(11) DEFAULT NULL,
  `Tarjeta_R` int(11) DEFAULT NULL,
  `Pases` float DEFAULT NULL,
  `Tiros_Esquina` int(11) DEFAULT NULL,
  `Fuera_Lugar` int(11) DEFAULT NULL,
  `Asistencias` float DEFAULT NULL,
  `Lesion` int(11) DEFAULT NULL,
  `Barridas` int(11) DEFAULT NULL,
  `Tiempo_Juego` time DEFAULT NULL,
  `Goles` float DEFAULT NULL,
  `Jugador_idJugador` int(11) NOT NULL,
  `Partido_idPartido` int(11) NOT NULL,
  PRIMARY KEY (`idStat_Fut`),
  KEY `fk_Stat_Fut_Jugador1_idx` (`Jugador_idJugador`),
  KEY `fk_Stat_Fut_Partido1_idx` (`Partido_idPartido`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stat_vb`
--

CREATE TABLE IF NOT EXISTS `stat_vb` (
  `idStat_vb` int(11) NOT NULL AUTO_INCREMENT,
  `Tipo` char(1) DEFAULT NULL,
  `Efect_Saque` float DEFAULT NULL,
  `Bloqueo` int(11) DEFAULT NULL,
  `Recepciones` int(11) DEFAULT NULL,
  `Puntos` int(11) DEFAULT NULL,
  `Jugador_idJugador` int(11) NOT NULL,
  `Partido_idPartido` int(11) NOT NULL,
  PRIMARY KEY (`idStat_vb`),
  KEY `fk_Stat_vb_Jugador1_idx` (`Jugador_idJugador`),
  KEY `fk_Stat_vb_Partido1_idx` (`Partido_idPartido`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `torneo`
--

CREATE TABLE IF NOT EXISTS `torneo` (
  `idTorneo` int(11) NOT NULL AUTO_INCREMENT,
  `Categoria` varchar(10) DEFAULT NULL,
  `Deporte` varchar(15) DEFAULT NULL,
  `Nombre` varchar(25) DEFAULT NULL,
  `Activo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idTorneo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `torneo`
--

INSERT INTO `torneo` (`idTorneo`, `Categoria`, `Deporte`, `Nombre`, `Activo`) VALUES
(1, 'U-17', 'Baloncesto', 'Copa Acti Malta', 0),
(2, 'U-12', 'Futbol', 'd', 0),
(3, 'U-12', 'Futbol', 'asd', 0),
(4, 'U-12', 'Futbol', 'a', 0),
(5, 'U-12', 'Futbol', 'Beach', 1),
(6, 'U-17', 'Baloncesto', 'MAIKI', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `idusuario` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(45) NOT NULL,
  `contrasena` varchar(102) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `tipo` int(11) NOT NULL,
  `imagen` varchar(50) NOT NULL,
  PRIMARY KEY (`idusuario`),
  UNIQUE KEY `usuario_UNIQUE` (`usuario`),
  UNIQUE KEY `correo_UNIQUE` (`correo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `usuario`, `contrasena`, `correo`, `tipo`, `imagen`) VALUES
(1, 'asd', 'asd', 'asd', 1, 'asd'),
(3, 'a', 'sha256:1000:Ad2MpXsFxda1DbwmfTY2iYDlZd3q9/F/:PGuFGBm56lsxZcKFsvC3EQhHm7KPn5LM', 'a@a', 1, 'a'),
(4, 'admin', 'sha256:1000:iPkPeJWYpHfl3jRCTmzRMK9KX73csdtP:iN9Vremqd2Ht+WmWbID++SW4ZM0ZQy1q', 'asdm@fd.com', 1, 'admin'),
(9, 'admin4', 'sha256:1000:D0CU1X5sMGBlbPNrmOvK0L6XSGq7Ii91:Qgo4Y7YrNc/eI5i7TnTssmzrzmc7D9Qr', 'admin4@gmail.com', 2, 'admin4'),
(16, 'jkhd7ryru', 'sha256:1000:x4fJrNvjKZ8HA2T6lfezf7z7tonyub0g:F5pSZ4LU0JR9Ydxd9YmxsFm59PXevMfb', 'dfsdf@hyy', 4, 'jkhd7ryru'),
(23, 'admin2', 'sha256:1000:Z7dxuQWo3zUwlMuv4Zj8j9cQBjYYOCJ7:wVdKqDyTjbV21WJ2iQaV3Jx8c7OmFDPv', 'gf@r', 1, 'admin2'),
(29, 'hola7', 'sha256:1000:NSA8dKzRudb1AdrJd5G/3sLR4vradFMi:h5dsPYbT06EHDaqhuFFwYAuqYezQ4NBC', 'paogueso@hotmail.com', 2, 'hola7'),
(30, 'ab', 'sha256:1000:6Xn4/JdtjBBwqJJwfmxMZjz23N9KtCe6:YRwb2MN03nw4cdsL5xN2cm9wEZSFH4/2', 'hh@ggg', 1, 'ab'),
(31, 'as', 'sha256:1000:XGDSA1cg6K9js2uzVH4/SWM1stG42w3D:X1lpsjUsEaj/H/lARSknP4ZhvdQcqJOa', 'as@hot', 2, 'as'),
(32, 'abc', 'sha256:1000:t0utWfLcTo3CtA2aN+7D1ezHg+NKLwFx:qiC9XbDXS18xnqnLbYweOoBxkyXQWyjs', 'asas@gdsf', 1, 'abc'),
(33, 'asdf', 'sha256:1000:eOqQ2YIU2MKoxlkbfP1OqTxsyeNlWM8g:5cWiaJ3hUYHUwrlrUfbjzQS4Bzgu+0y9', 'asdf@ge', 2, 'asdf'),
(34, 'stat', 'sha256:1000:8FTnisR0lUnT4hlUV74NJ1q1HkeZJ0Ka:t6Z+ZXijPy6QbFXRMRd4llga6mlkLQtZ', 'stat@hotmail.com', 2, 'stat'),
(35, 'sas', 'sha256:1000:yXEKbGPTAQ2fugZwPMyrk7dwvmSfqIIf:tvauxL9MRqh94/q69EV2OI1x829jqbzR', 'dasd@fssdf', 1, 'sas'),
(37, '123456', 'sha256:1000:WldaI0DnmkVqfMRBHKFqQluskQBTJK52:/W+7kYXMya2Oyxk5uEqClixAnKWC6E7u', '123456@hotmail.com', 1, '123456'),
(38, 'rmixco', 'sha256:1000:ATz4e6d3VvarWfhAK4bKmnRIQGjFp65C:3IAPlwcBkfh8aoP645JSnLdt/jSVsp9h', 'mixco@gmail.com', 4, 'rmixco');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `inscrito`
--
ALTER TABLE `inscrito`
  ADD CONSTRAINT `fk_Inscrito_Equipo1` FOREIGN KEY (`Equipo_idEquipo`) REFERENCES `equipo` (`idEquipo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inscrito_persona1` FOREIGN KEY (`persona_idPersona`) REFERENCES `persona` (`idPersona`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ins_torneo`
--
ALTER TABLE `ins_torneo`
  ADD CONSTRAINT `fk_Ins_Torneo_Equipo1` FOREIGN KEY (`Equipo_idEquipo`) REFERENCES `equipo` (`idEquipo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Ins_Torneo_Torneo1` FOREIGN KEY (`Torneo_idTorneo`) REFERENCES `torneo` (`idTorneo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `partido`
--
ALTER TABLE `partido`
  ADD CONSTRAINT `fk_partido_equipo1` FOREIGN KEY (`equipo_idEquipo1`) REFERENCES `equipo` (`idEquipo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_partido_equipo2` FOREIGN KEY (`equipo_idEquipo2`) REFERENCES `equipo` (`idEquipo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_partido_torneo1` FOREIGN KEY (`torneo_idTorneo`) REFERENCES `torneo` (`idTorneo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `persona`
--
ALTER TABLE `persona`
  ADD CONSTRAINT `fk_persona_usuario1` FOREIGN KEY (`usuario_idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `stat_bkb`
--
ALTER TABLE `stat_bkb`
  ADD CONSTRAINT `fk_Stat_bkb_Jugador1` FOREIGN KEY (`Jugador_idJugador`) REFERENCES `persona` (`idPersona`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Stat_bkb_Partido1` FOREIGN KEY (`Partido_idPartido`) REFERENCES `partido` (`idPartido`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `stat_fut`
--
ALTER TABLE `stat_fut`
  ADD CONSTRAINT `fk_Stat_Fut_Jugador1` FOREIGN KEY (`Jugador_idJugador`) REFERENCES `persona` (`idPersona`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Stat_Fut_Partido1` FOREIGN KEY (`Partido_idPartido`) REFERENCES `partido` (`idPartido`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `stat_vb`
--
ALTER TABLE `stat_vb`
  ADD CONSTRAINT `fk_Stat_vb_Jugador1` FOREIGN KEY (`Jugador_idJugador`) REFERENCES `persona` (`idPersona`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Stat_vb_Partido1` FOREIGN KEY (`Partido_idPartido`) REFERENCES `partido` (`idPartido`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
