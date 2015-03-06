-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 06-03-2015 a las 08:02:04
-- Versión del servidor: 5.6.12-log
-- Versión de PHP: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `billetes`
--
CREATE DATABASE IF NOT EXISTS `billetes` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish2_ci;
USE `billetes`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudades`
--

CREATE TABLE IF NOT EXISTS `ciudades` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) COLLATE utf8_spanish2_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `ciudades`
--

INSERT INTO `ciudades` (`id`, `nombre`) VALUES
(1, 'Madrid'),
(2, 'Barcelona'),
(3, 'Valencia'),
(4, 'Sevilla');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE IF NOT EXISTS `personas` (
  `dni` varchar(9) COLLATE utf8_spanish2_ci NOT NULL,
  `nombre` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `ap1` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `ap2` varchar(30) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `telf` int(9) NOT NULL,
  PRIMARY KEY (`dni`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `personas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `referencias`
--

CREATE TABLE IF NOT EXISTS `referencias` (
  `referencia` varchar(20) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `dni` varchar(9) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `origen` int(5) NOT NULL,
  `destino` int(5) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`referencia`),
  KEY `fk_persona_referencias` (`dni`),
  KEY `fk_origen_referencias` (`origen`),
  KEY `fk_destino_referencias` (`destino`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `referencias`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `viajes`
--

CREATE TABLE IF NOT EXISTS `viajes` (
  `origen` int(5) NOT NULL DEFAULT '0',
  `destino` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`origen`,`destino`),
  KEY `fk_destino_ciudades` (`destino`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `viajes`
--

INSERT INTO `viajes` (`origen`, `destino`) VALUES
(2, 1),
(3, 1),
(4, 1),
(1, 2),
(4, 2),
(1, 3),
(2, 3),
(4, 3),
(1, 4),
(3, 4);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `referencias`
--
ALTER TABLE `referencias`
  ADD CONSTRAINT `fk_destino_referencias` FOREIGN KEY (`destino`) REFERENCES `ciudades` (`id`),
  ADD CONSTRAINT `fk_origen_referencias` FOREIGN KEY (`origen`) REFERENCES `ciudades` (`id`),
  ADD CONSTRAINT `fk_persona_referencias` FOREIGN KEY (`dni`) REFERENCES `personas` (`dni`) ON DELETE CASCADE;

--
-- Filtros para la tabla `viajes`
--
ALTER TABLE `viajes`
  ADD CONSTRAINT `fk_destino_ciudades` FOREIGN KEY (`destino`) REFERENCES `ciudades` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_origen_ciudades` FOREIGN KEY (`origen`) REFERENCES `ciudades` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
