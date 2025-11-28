-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 05-11-2025 a las 23:37:26
-- Versión del servidor: 11.8.3-MariaDB-log
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `u295124209_deportazo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colores`
--

CREATE TABLE `colores` (
  `id` int(11) NOT NULL,
  `codigo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `colores`
--

INSERT INTO `colores` (`id`, `codigo`) VALUES
(1, '#000000'),
(2, '#34535F'),
(3, '#E70202'),
(4, '#5F0127'),
(5, '#01545F'),
(6, '#7AEA09'),
(7, '#305E01'),
(8, '#845F03'),
(9, '#7F4285'),
(10, '#9954FF'),
(11, '#54FFDC'),
(12, '#FEFFFA'),
(13, '#9671AA'),
(14, '#FF548B'),
(15, '#54DAFF');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `enfrentamientos`
--

CREATE TABLE `enfrentamientos` (
  `id` int(11) NOT NULL,
  `id_torneo` int(11) NOT NULL,
  `ubicacion` varchar(100) NOT NULL,
  `id_equipo` int(11) NOT NULL,
  `marcador` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `enfrentamientos2`
--

CREATE TABLE `enfrentamientos2` (
  `id` int(11) NOT NULL,
  `id_torneo` int(11) NOT NULL,
  `id_equipo_local` int(11) NOT NULL,
  `id_equipo_visitante` int(11) NOT NULL,
  `marcador_local` int(11) NOT NULL DEFAULT 0,
  `marcador_visitante` int(11) NOT NULL DEFAULT 0,
  `ganador` int(11) NOT NULL DEFAULT 0,
  `perdedor` int(11) NOT NULL DEFAULT 0,
  `fase` int(11) NOT NULL DEFAULT 0,
  `orden` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `enfrentamientos2`
--

INSERT INTO `enfrentamientos2` (`id`, `id_torneo`, `id_equipo_local`, `id_equipo_visitante`, `marcador_local`, `marcador_visitante`, `ganador`, `perdedor`, `fase`, `orden`) VALUES
(1, 1, 1, 2, 19, 20, 2, 1, 0, 0),
(2, 1, 1, 3, 20, 17, 1, 3, 0, 0),
(3, 1, 1, 4, 17, 20, 4, 1, 0, 0),
(4, 1, 2, 3, 20, 15, 2, 3, 0, 0),
(5, 1, 2, 4, 20, 16, 2, 4, 0, 0),
(6, 1, 3, 4, 20, 16, 3, 4, 0, 0),
(11, 1, 3, 4, 1, 0, 3, 4, 1, 0),
(12, 1, 1, 3, 1, 0, 1, 3, 2, 0),
(13, 1, 2, 1, 1, 0, 2, 1, 3, 0),
(14, 2, 5, 6, 14, 20, 6, 5, 0, 0),
(15, 2, 5, 7, 9, 15, 7, 5, 0, 0),
(16, 2, 5, 8, 15, 9, 5, 8, 0, 0),
(17, 2, 5, 9, 15, 14, 5, 9, 0, 0),
(18, 2, 5, 10, 15, 14, 5, 10, 0, 0),
(19, 2, 6, 7, 15, 10, 6, 7, 0, 0),
(20, 2, 6, 8, 15, 14, 6, 8, 0, 0),
(21, 2, 6, 9, 15, 1, 6, 9, 0, 0),
(22, 2, 6, 10, 7, 15, 10, 6, 0, 0),
(23, 2, 7, 8, 15, 20, 8, 7, 0, 0),
(24, 2, 7, 9, 7, 15, 9, 7, 0, 0),
(25, 2, 7, 10, 8, 15, 10, 7, 0, 0),
(26, 2, 8, 9, 15, 13, 8, 9, 0, 0),
(27, 2, 8, 10, 12, 15, 10, 8, 0, 0),
(28, 2, 9, 10, 11, 20, 10, 9, 0, 0),
(33, 2, 10, 8, 1, 0, 10, 8, 1, 0),
(34, 2, 6, 5, 1, 0, 6, 5, 1, 0),
(35, 2, 10, 6, 1, 0, 10, 6, 2, 0),
(36, 3, 11, 12, 11, 20, 12, 11, 0, 0),
(37, 3, 11, 13, 20, 15, 11, 13, 0, 0),
(38, 3, 11, 14, 12, 20, 14, 11, 0, 0),
(39, 3, 11, 15, 14, 20, 15, 11, 0, 0),
(40, 3, 12, 13, 20, 15, 12, 13, 0, 0),
(41, 3, 12, 14, 20, 18, 12, 14, 0, 0),
(42, 3, 12, 15, 12, 20, 15, 12, 0, 0),
(43, 3, 13, 14, 13, 20, 14, 13, 0, 0),
(44, 3, 13, 15, 15, 20, 15, 13, 0, 0),
(45, 3, 14, 15, 12, 20, 15, 14, 0, 0),
(46, 3, 15, 11, 15, 8, 15, 11, 1, 0),
(47, 3, 12, 14, 15, 11, 12, 14, 1, 0),
(48, 3, 15, 12, 9, 15, 12, 15, 2, 0),
(49, 4, 16, 17, 8, 15, 17, 16, 0, 1),
(50, 4, 16, 18, 15, 12, 16, 18, 0, 9),
(51, 4, 16, 19, 15, 12, 16, 19, 0, 6),
(52, 4, 16, 20, 15, 12, 16, 20, 0, 3),
(53, 4, 17, 18, 15, 12, 17, 18, 0, 7),
(54, 4, 17, 19, 15, 14, 17, 19, 0, 4),
(55, 4, 17, 20, 11, 15, 20, 17, 0, 10),
(56, 4, 18, 19, 12, 15, 19, 18, 0, 2),
(57, 4, 18, 20, 7, 15, 20, 18, 0, 5),
(58, 4, 19, 20, 15, 14, 19, 20, 0, 8),
(59, 4, 17, 19, 1, 0, 17, 19, 1, 0),
(60, 4, 16, 20, 1, 0, 16, 20, 1, 0),
(61, 4, 17, 16, 0, 1, 16, 17, 2, 0),
(62, 5, 21, 22, 14, 20, 22, 21, 0, 1),
(63, 5, 21, 23, 15, 5, 21, 23, 0, 9),
(64, 5, 21, 24, 20, 17, 21, 24, 0, 6),
(65, 5, 21, 29, 6, 20, 29, 21, 0, 3),
(66, 5, 22, 23, 20, 18, 22, 23, 0, 7),
(67, 5, 22, 24, 15, 8, 22, 24, 0, 4),
(68, 5, 22, 29, 15, 8, 22, 29, 0, 10),
(69, 5, 23, 24, 15, 20, 24, 23, 0, 2),
(70, 5, 23, 29, 19, 20, 29, 23, 0, 5),
(71, 5, 24, 29, 19, 20, 29, 24, 0, 8),
(72, 5, 22, 24, 1, 0, 22, 24, 1, 0),
(73, 5, 29, 21, 0, 1, 21, 29, 1, 0),
(74, 5, 22, 21, 1, 0, 22, 21, 2, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `enfrentamiento_rapido`
--

CREATE TABLE `enfrentamiento_rapido` (
  `id` int(11) NOT NULL,
  `cantidad_equipos` int(11) NOT NULL,
  `estado` varchar(100) NOT NULL DEFAULT 'A',
  `equipo1` varchar(100) DEFAULT NULL,
  `equipo2` varchar(100) DEFAULT NULL,
  `equipo3` varchar(100) DEFAULT NULL,
  `equipo4` varchar(100) DEFAULT NULL,
  `equipo5` varchar(100) DEFAULT NULL,
  `equipo6` varchar(100) DEFAULT NULL,
  `fecha_reg` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `enfrentamiento_rapido`
--

INSERT INTO `enfrentamiento_rapido` (`id`, `cantidad_equipos`, `estado`, `equipo1`, `equipo2`, `equipo3`, `equipo4`, `equipo5`, `equipo6`, `fecha_reg`) VALUES
(1, 4, 'I', 'junior', 'nacional', 'america', 'cali', '', '', '2025-05-27'),
(2, 4, 'I', 'barcelona', 'real madrid ', 'atletico madrid', 'sevilla', '', '', '2025-05-27'),
(3, 5, 'I', 'junior', 'nacional', 'cali', 'medellin', 'cartagena', '', '2025-05-27'),
(4, 4, 'I', 'junior', 'medellin', 'tolima', 'cali', '', '', '2025-05-27'),
(5, 4, 'I', 'miguel', 'saray', 'jorge', 'yajaira', '', '', '2025-05-27'),
(6, 5, 'I', 'junior', 'santa fe', 'nacional', 'cali', 'envigado', '', '2025-05-27'),
(7, 6, 'I', 'junior', 'america', 'santa fe', 'nacional', 'cali', 'envigado', '2025-05-27'),
(8, 3, 'I', 'junior', 'nacional', 'envigado', '', '', '', '2025-05-27'),
(9, 5, 'I', '', '', '', '', '', '', '2025-05-27'),
(10, 4, 'I', 'colombia', 'peru', 'chile', 'argentina', '', '', '2025-05-27'),
(11, 6, 'I', 'junior', 'bucaramanga', 'santa fe ', 'huila', 'nacional', 'millonarios', '2025-05-28'),
(12, 3, 'I', 'junior', 'santa fe', 'tolima', '', '', '', '2025-05-28'),
(13, 4, 'I', 'A', 'B', 'C', 'D', '', '', '2025-05-28'),
(14, 3, 'I', 'miguel', 'saray', 'jorge', '', '', '', '2025-06-05'),
(15, 6, 'I', 'Sadith', 'Emilio', 'Cristofer ', 'Jorge', 'Erika', 'Yordi ', '2025-06-17'),
(16, 6, 'I', 'Cristofer', 'Emilio', 'Erika', 'Sadith', 'Yordi', 'Jorge', '2025-06-17'),
(17, 4, 'I', 'Oscar', 'Cristofer ', 'Emilio', 'Sadith', '', '', '2025-06-17'),
(18, 5, 'I', 'Juan', 'Dilan', 'Jorge', 'Claudio', 'Miguel', '', '2025-06-18'),
(19, 4, 'I', 'Emilio', 'Jeik', 'Mayer', 'Abel', '', '', '2025-06-22'),
(20, 4, 'I', 'emilio', 'Mayer', 'Abel', 'Jeik', '', '', '2025-06-22'),
(21, 3, 'I', 'Jeik ', 'Emilio ', 'Abel ', '', '', '', '2025-06-23'),
(22, 4, 'I', 'Daniel', 'María ', 'Juan', 'Jorge', '', '', '2025-06-25'),
(23, 6, 'I', 'Emilio', 'Jorge', 'Abel', 'Rosmery', 'Jeik', 'Yordi', '2025-06-29'),
(24, 4, 'I', 'Sadith', 'Maria', 'Suli', 'Rosmery', '', '', '2025-07-20'),
(25, 4, 'I', 'Mayer', 'Jeik', 'Emilio', 'Jorge', '', '', '2025-10-12'),
(26, 4, 'I', 'MAYER', 'EMILIO', 'JORGE', 'JEIK', '', '', '2025-10-12'),
(27, 5, 'I', 'Henry', 'Cristofer', 'Maria', 'Suly', 'Carles', '', '2025-10-19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE `equipos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `id_deporte` int(11) NOT NULL DEFAULT 1,
  `id_torneo` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `color` varchar(100) NOT NULL DEFAULT '#000000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO `equipos` (`id`, `nombre`, `id_deporte`, `id_torneo`, `status`, `color`) VALUES
(1, 'EQUIPO 1', 1, 1, 1, '#00ACDB'),
(2, 'EQUIPO 2', 1, 1, 1, '#DB1100'),
(3, 'EQUIPO 3', 1, 1, 1, '#181a1b'),
(4, 'EQUIPO 4', 1, 1, 1, '#B7C8DB'),
(5, 'EQUIPO 1', 1, 2, 1, '#000000'),
(6, 'EQUIPO 2', 1, 2, 1, '#CCCCCC'),
(7, 'EQUIPO 3', 1, 2, 1, '#E70202'),
(8, 'EQUIPO 4', 1, 2, 1, '#03a9f4'),
(9, 'EQUIPO 5', 1, 2, 1, '#2ec315'),
(10, 'EQUIPO 6', 1, 2, 1, '#ab09d1'),
(11, 'EQUIPO 3', 1, 3, 1, '#cbcbcb'),
(12, 'EQUIPO 1', 1, 3, 1, '#E70202'),
(13, 'EQUIPO 4', 1, 3, 1, '#6e757f'),
(14, 'EQUIPO 2', 1, 3, 1, '#000000'),
(15, 'EQUIPO 5', 1, 3, 1, '#0e5cbc'),
(16, 'EQUIPO 1', 1, 4, 1, '#cbcbcb'),
(17, 'EQUIPO 2', 1, 4, 1, '#0e5cbc'),
(18, 'EQUIPO 3', 1, 4, 1, '#000000'),
(19, 'EQUIPO 4', 1, 4, 1, '#E70202'),
(20, 'EQUIPO 5', 1, 4, 1, '#6e757f'),
(21, 'EQUIPO 1', 1, 5, 1, '#6e757f'),
(22, 'EQUIPO 2', 1, 5, 1, '#000000'),
(23, 'EQUIPO 3', 1, 5, 1, '#0e5cbc'),
(24, 'EQUIPO 4', 1, 5, 1, '#E70202'),
(29, 'EQUIPO 5', 1, 5, 1, '#cbc9c9');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo_jugador`
--

CREATE TABLE `equipo_jugador` (
  `id` int(11) NOT NULL,
  `id_jugador` int(11) NOT NULL,
  `id_equipo` int(11) NOT NULL,
  `posicion` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `seleccionado` int(11) DEFAULT 0,
  `id_torneo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `equipo_jugador`
--

INSERT INTO `equipo_jugador` (`id`, `id_jugador`, `id_equipo`, `posicion`, `numero`, `seleccionado`, `id_torneo`) VALUES
(1, 4, 1, 1, 64, 1, 1),
(2, 5, 1, 2, 27, 1, 1),
(3, 6, 1, 3, 81, 1, 1),
(4, 7, 1, 5, 35, 1, 1),
(5, 8, 1, 6, 92, 1, 1),
(6, 9, 2, 1, 18, 1, 1),
(7, 10, 2, 2, 50, 1, 1),
(8, 11, 2, 3, 73, 1, 1),
(9, 12, 2, 4, 41, 1, 1),
(10, 13, 2, 6, 99, 1, 1),
(11, 16, 3, 1, 22, 1, 1),
(12, 14, 3, 2, 68, 1, 1),
(13, 17, 3, 3, 11, 1, 1),
(14, 15, 3, 4, 85, 1, 1),
(15, 18, 3, 6, 30, 1, 1),
(16, 23, 4, 1, 76, 1, 1),
(17, 19, 4, 2, 53, 1, 1),
(18, 20, 4, 3, 94, 1, 1),
(19, 21, 4, 4, 20, 1, 1),
(20, 22, 4, 6, 61, 1, 1),
(22, 28, 7, 6, 89, 1, 2),
(23, 23, 7, 5, 33, 1, 2),
(24, 9, 7, 1, 70, 1, 2),
(25, 13, 7, 2, 47, 1, 2),
(26, 22, 7, 3, 96, 1, 2),
(27, 11, 8, 5, 15, 1, 2),
(28, 25, 8, 4, 58, 1, 2),
(29, 17, 8, 6, 83, 1, 2),
(30, 21, 8, 1, 29, 1, 2),
(31, 20, 8, 2, 72, 1, 2),
(32, 12, 8, 3, 44, 1, 2),
(33, 29, 9, 4, 90, 1, 2),
(34, 30, 9, 1, 13, 1, 2),
(35, 16, 9, 5, 56, 1, 2),
(36, 41, 9, 2, 79, 1, 2),
(37, 24, 9, 3, 37, 1, 2),
(38, 27, 9, 6, 95, 1, 2),
(39, 5, 6, 5, 24, 1, 2),
(40, 35, 6, 4, 66, 1, 2),
(41, 33, 6, 6, 10, 1, 2),
(42, 15, 6, 2, 80, 1, 2),
(43, 10, 6, 1, 49, 1, 2),
(44, 36, 10, 4, 91, 1, 2),
(45, 37, 10, 5, 26, 1, 2),
(46, 38, 10, 1, 75, 1, 2),
(47, 39, 10, 2, 39, 1, 2),
(48, 40, 10, 3, 87, 1, 2),
(49, 31, 10, 6, 14, 1, 2),
(50, 4, 5, 4, 52, 1, 2),
(51, 26, 5, 1, 78, 1, 2),
(52, 7, 5, 5, 31, 1, 2),
(53, 18, 5, 6, 98, 1, 2),
(54, 8, 5, 3, 25, 1, 2),
(55, 6, 5, 2, 60, 1, 2),
(56, 14, 7, 4, 17, 1, 2),
(57, 34, 6, 3, 82, 1, 2),
(58, 11, 11, 1, 1, 1, 3),
(59, 8, 11, 2, 2, 1, 3),
(60, 5, 11, 3, 3, 1, 3),
(61, 26, 11, 4, 4, 1, 3),
(62, 42, 11, 5, 5, 1, 3),
(63, 33, 11, 6, 6, 1, 3),
(64, 10, 12, 1, 1, 1, 3),
(65, 13, 12, 2, 2, 1, 3),
(66, 16, 12, 3, 3, 1, 3),
(67, 18, 12, 4, 4, 1, 3),
(68, 25, 12, 5, 5, 1, 3),
(69, 17, 12, 6, 6, 1, 3),
(70, 14, 13, 1, 1, 1, 3),
(71, 15, 13, 2, 2, 1, 3),
(72, 36, 13, 3, 3, 1, 3),
(73, 43, 13, 4, 4, 1, 3),
(74, 24, 13, 5, 5, 1, 3),
(75, 32, 14, 1, 1, 1, 3),
(76, 31, 14, 2, 2, 1, 3),
(77, 35, 14, 3, 3, 1, 3),
(78, 6, 14, 4, 4, 1, 3),
(79, 22, 14, 5, 5, 1, 3),
(80, 19, 14, 6, 6, 1, 3),
(81, 4, 15, 1, 1, 1, 3),
(82, 27, 15, 2, 2, 1, 3),
(83, 7, 15, 3, 3, 1, 3),
(84, 12, 15, 4, 4, 1, 3),
(85, 9, 15, 5, 5, 1, 3),
(86, 29, 15, 6, 6, 1, 3),
(87, 44, 13, 6, 6, 1, 3),
(88, 15, 16, 1, 1, 1, 4),
(89, 31, 16, 2, 2, 1, 4),
(90, 16, 16, 3, 3, 1, 4),
(91, 10, 16, 4, 4, 1, 4),
(92, 9, 16, 5, 5, 1, 4),
(93, 32, 16, 6, 6, 1, 4),
(94, 27, 17, 1, 1, 1, 4),
(95, 13, 17, 2, 2, 1, 4),
(96, 7, 17, 3, 3, 1, 4),
(97, 49, 17, 4, 4, 1, 4),
(98, 18, 17, 5, 5, 1, 4),
(99, 5, 17, 6, 6, 1, 4),
(100, 8, 18, 1, 1, 1, 4),
(101, 50, 18, 2, 2, 1, 4),
(102, 25, 18, 3, 3, 1, 4),
(103, 29, 18, 4, 4, 1, 4),
(104, 46, 18, 5, 5, 1, 4),
(105, 17, 18, 6, 6, 1, 4),
(106, 22, 19, 1, 1, 1, 4),
(107, 24, 19, 2, 2, 1, 4),
(108, 36, 19, 3, 3, 1, 4),
(109, 11, 19, 4, 4, 1, 4),
(110, 6, 19, 5, 5, 1, 4),
(111, 26, 19, 6, 6, 1, 4),
(112, 21, 20, 1, 1, 1, 4),
(113, 48, 20, 2, 2, 1, 4),
(114, 35, 20, 3, 3, 1, 4),
(115, 14, 20, 4, 4, 1, 4),
(116, 23, 20, 5, 5, 1, 4),
(117, 33, 20, 6, 6, 1, 4),
(118, 11, 21, 6, 1, 1, 5),
(119, 29, 21, 5, 2, 1, 5),
(120, 52, 21, 4, 3, 1, 5),
(121, 20, 21, 3, 4, 1, 5),
(122, 27, 21, 2, 5, 1, 5),
(123, 24, 21, 1, 6, 1, 5),
(124, 51, 22, 6, 1, 1, 5),
(125, 14, 22, 5, 2, 1, 5),
(126, 16, 22, 4, 3, 1, 5),
(127, 9, 22, 3, 4, 1, 5),
(128, 8, 22, 2, 5, 1, 5),
(129, 21, 22, 1, 6, 1, 5),
(130, 32, 23, 6, 1, 1, 5),
(131, 33, 23, 2, 2, 1, 5),
(132, 36, 23, 4, 3, 1, 5),
(133, 23, 23, 3, 4, 1, 5),
(134, 22, 23, 2, 5, 1, 5),
(135, 53, 23, 1, 6, 1, 5),
(136, 10, 24, 6, 1, 1, 5),
(137, 5, 24, 5, 2, 1, 5),
(138, 7, 24, 4, 3, 1, 5),
(139, 18, 24, 3, 4, 1, 5),
(140, 13, 24, 2, 5, 1, 5),
(141, 31, 24, 1, 6, 1, 5),
(142, 4, 29, 6, 1, 1, 5),
(143, 17, 29, 4, 2, 1, 5),
(144, 35, 29, 5, 3, 1, 5),
(145, 15, 29, 3, 4, 1, 5),
(146, 42, 29, 2, 5, 1, 5),
(147, 45, 29, 1, 6, 1, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotos`
--

CREATE TABLE `fotos` (
  `id` int(11) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `id_torneo` int(11) NOT NULL,
  `campeon` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `fotos`
--

INSERT INTO `fotos` (`id`, `foto`, `id_torneo`, `campeon`) VALUES
(1, 'Imagen de WhatsApp 2025-04-20 a las 21.01.00_30940cf4.jpg', 1, 0),
(2, 'Imagen de WhatsApp 2025-04-20 a las 21.01.06_494baf99.jpg', 1, 0),
(3, 'Imagen de WhatsApp 2025-04-20 a las 21.01.04_cd81920b.jpg', 1, 0),
(4, 'Imagen de WhatsApp 2025-04-20 a las 21.01.03_7b80f33f.jpg', 1, 0),
(5, 'Imagen de WhatsApp 2025-04-20 a las 21.01.02_f33a6fc3.jpg', 1, 0),
(6, '1000148049.jpg', 2, 0),
(7, 'Imagen de WhatsApp 2025-07-13 a las 17.05.19_8e6c23dd.jpg', 3, 0),
(8, 'Imagen de WhatsApp 2025-07-13 a las 17.05.21_f86c7efd.jpg', 3, 0),
(9, 'Imagen de WhatsApp 2025-07-13 a las 17.05.21_cf045686.jpg', 3, 0),
(10, 'Imagen de WhatsApp 2025-07-13 a las 21.05.58_ffe4428e.jpg', 3, 0),
(11, 'Imagen de WhatsApp 2025-07-13 a las 21.06.00_6ce8b3e2.jpg', 3, 0),
(12, 'e66609fe-fc93-4e3d-9e0f-c747d43c72f5.jpeg', 4, 0),
(13, '3cec718d-f745-461d-b5b5-879f7c036e1c.jpeg', 4, 0),
(14, '847f24d2-67aa-47fc-bb99-f13fa11193e4.jpeg', 4, 0),
(15, 'WhatsApp Image 2025-10-28 at 19.37.40.jpeg', 5, 0),
(16, '8a302ead-fc7f-439e-baf4-53e06dc9e34b.jpg', 5, 0),
(17, 'WhatsApp Image 2025-11-02 at 18.16.52.jpeg', 5, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guia_enfrentamientos`
--

CREATE TABLE `guia_enfrentamientos` (
  `local` varchar(100) NOT NULL,
  `visitante` varchar(100) NOT NULL,
  `id_tipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `guia_enfrentamientos`
--

INSERT INTO `guia_enfrentamientos` (`local`, `visitante`, `id_tipo`) VALUES
('A', 'B', 1),
('C', 'D', 1),
('E', 'F', 1),
('G', 'H', 1),
('AB', 'CD', 1),
('EF', 'GH', 1),
('ABCD', 'EFGH', 1),
('A', 'B', 2),
('A', 'C', 2),
('A', 'H', 2),
('B', 'C', 2),
('B', 'D', 2),
('B', 'H', 2),
('C', 'D', 2),
('C', 'H', 2),
('D', 'A', 2),
('D', 'H', 2),
('E', 'A', 2),
('E', 'B', 2),
('E', 'C', 2),
('E', 'D', 2),
('E', 'H', 2),
('F', 'A', 2),
('F', 'B', 2),
('F', 'C', 2),
('F', 'D', 2),
('F', 'E', 2),
('F', 'H', 2),
('G', 'A', 2),
('G', 'B', 2),
('G', 'C', 2),
('G', 'D', 2),
('G', 'E', 2),
('G', 'F', 2),
('G', 'H', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guia_enfrentamiento_rapido`
--

CREATE TABLE `guia_enfrentamiento_rapido` (
  `id` int(11) NOT NULL,
  `local` varchar(100) NOT NULL,
  `visitante` varchar(100) DEFAULT NULL,
  `cant_equipos` int(11) NOT NULL,
  `estado` varchar(100) DEFAULT 'A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `guia_enfrentamiento_rapido`
--

INSERT INTO `guia_enfrentamiento_rapido` (`id`, `local`, `visitante`, `cant_equipos`, `estado`) VALUES
(1, 'A', 'D', 4, 'A'),
(2, 'B', 'C', 4, 'A'),
(3, 'A', 'B', 4, 'A'),
(4, 'D', 'C', 4, 'A'),
(5, 'A', 'C', 4, 'A'),
(6, 'D', 'B', 4, 'A'),
(7, 'E', 'D', 5, 'A'),
(8, 'A', 'C', 5, 'A'),
(9, 'B', NULL, 5, 'A'),
(10, 'A', 'E', 5, 'A'),
(11, 'B', 'D', 5, 'A'),
(12, 'C', NULL, 5, 'A'),
(13, 'B', 'A', 5, 'A'),
(14, 'C', 'E', 5, 'A'),
(15, 'D', NULL, 5, 'A'),
(16, 'C', 'B', 5, 'A'),
(17, 'D', 'A', 5, 'A'),
(18, 'E', NULL, 5, 'A'),
(19, 'D', 'C', 5, 'A'),
(20, 'E', 'B', 5, 'A'),
(21, 'A', NULL, 5, 'A'),
(22, 'A', 'F', 6, 'A'),
(23, 'B', 'E', 6, 'A'),
(24, 'C', 'D', 6, 'A'),
(25, 'F', 'E', 6, 'A'),
(26, 'A', 'D', 6, 'A'),
(27, 'B', 'C', 6, 'A'),
(28, 'F', 'D', 6, 'A'),
(29, 'E', 'C', 6, 'A'),
(30, 'A', 'B', 6, 'A'),
(31, 'F', 'C', 6, 'A'),
(32, 'D', 'B', 6, 'A'),
(33, 'E', 'A', 6, 'A'),
(34, 'F', 'B', 6, 'A'),
(35, 'C', 'A', 6, 'A'),
(36, 'D', 'E', 6, 'A'),
(37, 'A', 'B', 3, 'A'),
(38, 'C', NULL, 3, 'A'),
(39, 'A', 'C', 3, 'A'),
(40, 'B', NULL, 3, 'A'),
(41, 'B', 'C', 3, 'A'),
(42, 'A', NULL, 3, 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posiciones_voley`
--

CREATE TABLE `posiciones_voley` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `posiciones_voley`
--

INSERT INTO `posiciones_voley` (`id`, `nombre`) VALUES
(1, 'ZAGUERO DERECHO'),
(2, 'ZAGUERO CENTRAL'),
(3, 'ZAGUERO IZQUIERDO'),
(4, 'DELANTERO DERECHO'),
(5, 'DELANTERO CENTRAL'),
(6, 'DELANTERO IZQUIERDO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` int(11) NOT NULL,
  `rol` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `rol`) VALUES
(1, 'SUPERADMIN'),
(2, 'ADMINISTRADOR'),
(3, 'JUGADOR'),
(4, 'VISITANTE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabla_posiciones`
--

CREATE TABLE `tabla_posiciones` (
  `id` int(11) NOT NULL,
  `id_equipo` int(11) NOT NULL,
  `id_torneo` int(11) NOT NULL,
  `pj` int(11) NOT NULL DEFAULT 0,
  `g` int(11) NOT NULL DEFAULT 0,
  `P` int(11) NOT NULL DEFAULT 0,
  `puntos` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `torneo`
--

CREATE TABLE `torneo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `id_deporte` varchar(100) NOT NULL,
  `tipo` int(11) NOT NULL,
  `nro_equipos` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha` datetime DEFAULT NULL,
  `direccion` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `torneo`
--

INSERT INTO `torneo` (`id`, `nombre`, `id_deporte`, `tipo`, `nro_equipos`, `descripcion`, `fecha`, `direccion`, `status`, `created_at`, `updated_at`) VALUES
(1, 'TORNEO AMISTADES X VOLEY I', '1', 1, 4, 'TORNEO PARA RECOLECCIÓN PARA COMPRAR UN BALÓN', '2025-04-20 15:00:00', 'PAN BENDITO', 0, '2025-04-19', NULL),
(2, 'TORNEO SAMY', '1', 3, 6, 'TORNEO DE RECAUDACIÓN PARA AYUDAR A NUESTRO AMIGO SAMY', '2025-06-15 15:00:00', 'PAN BENDITO', 0, '2025-06-14', NULL),
(3, 'TORNEO AMISTADES X VOLEY II', '1', 3, 4, 'TORNEO DE INTEGRACIÓN - DIVERSIÓN ENTRE AMIGOS', '2025-07-13 15:00:00', 'PAN BENDITO', 0, '2025-07-11', NULL),
(4, 'TORNEO CORAZÓN LATINO IV', '1', 4, 4, 'TORNEO AMISTOSO - BIENVENIDA  NUEVOS MIEMBROS ', '2025-09-21 16:00:00', 'PAN BENDITO', 0, '2025-09-15', NULL),
(5, 'TORNEO CORAZÓN LATINO V', '1', 4, 8, 'TORNEO DE INTEGRACIÓN', '2025-10-26 15:30:00', 'PAN BENDITO', 0, '2025-10-08', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `avatar` text DEFAULT NULL,
  `correo_verificado` varchar(100) DEFAULT NULL,
  `user` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `foto` int(11) NOT NULL DEFAULT 0,
  `convocado` int(11) NOT NULL DEFAULT 0,
  `oficial` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `correo`, `avatar`, `correo_verificado`, `user`, `password`, `id_rol`, `created_at`, `updated_at`, `foto`, `convocado`, `oficial`) VALUES
(1, 'SuperAdministrador', 'superadmin', 'default.png', 'superadmin', 'superadmin', '123456', 1, '2024-12-14', NULL, 0, 0, 1),
(2, 'Administrador', 'admin', 'default.png', 'admin', 'admin', '123456', 2, '2024-12-14', NULL, 0, 0, 1),
(3, 'jugador', 'jugador', 'default.png', 'jugador', 'jugador', '123456', 3, '2024-12-14', NULL, 0, 0, 1),
(4, 'EMILIO', '123456789', 'avatar_default.png', NULL, 'EMILIO', '123456', 3, '2025-04-19', NULL, 1, 0, 1),
(5, 'MILENA', '123456789', 'avatar_default_girl.png', NULL, 'MILENA', '123456', 3, '2025-04-19', NULL, 1, 0, 1),
(6, 'JOSUE SAMURAI', '1234566', 'avatar_default.png', NULL, 'JOSUE', '123456', 3, '2025-04-19', NULL, 0, 0, 1),
(7, 'SULY', '123456', 'avatar_default_girl.png', NULL, 'SULY', '123456', 3, '2025-04-19', NULL, 1, 0, 1),
(8, 'JUAN', '123456', 'avatar_default.png', NULL, 'JUAN', '123456', 3, '2025-04-19', NULL, 1, 0, 1),
(9, 'ERIKA', '123456', 'avatar_default_girl.png', NULL, 'ERIKA', '123456', 3, '2025-04-19', NULL, 1, 0, 1),
(10, 'ABEL', '123456', 'avatar_default.png', NULL, 'ABEL', '123456', 3, '2025-04-19', NULL, 1, 0, 1),
(11, 'JEIK', '123456', 'avatar_default.png', NULL, 'JEIK', '123456', 3, '2025-04-19', NULL, 1, 0, 1),
(12, 'FELIX', '123456', 'avatar_default.png', NULL, 'FELIX', '123456', 3, '2025-04-19', NULL, 0, 0, 0),
(13, 'JORDY', '123456', 'avatar_default.png', NULL, 'JORDY', '123456', 3, '2025-04-19', NULL, 1, 0, 1),
(14, 'MAYER', '123456', 'avatar_default.png', NULL, 'MAYER', '123456', 3, '2025-04-19', NULL, 1, 0, 1),
(15, 'MARIALUZ', '123456', 'avatar_default_girl.png', NULL, 'MARIALUZ', '123456', 3, '2025-04-19', '2025-10-25', 1, 0, 1),
(16, 'FRANCO', '123456', 'avatar_default.png', NULL, 'FRANCO', '123456', 3, '2025-04-19', NULL, 1, 0, 1),
(17, 'JORGE', '123456', 'avatar_default.png', NULL, 'JORGE', '123456', 3, '2025-04-19', NULL, 1, 0, 1),
(18, 'CARLES', '123456', 'avatar_default.png', NULL, 'CARLES', '123456', 3, '2025-04-19', '2025-07-12', 1, 0, 1),
(19, 'OSCAR', '123456', 'avatar_default.png', NULL, 'OSCAR', '123456', 3, '2025-04-19', NULL, 0, 0, 0),
(20, 'WILDER', '123456', 'avatar_default.png', NULL, 'WILDER', '123456', 3, '2025-04-19', '2025-06-14', 0, 0, 1),
(21, 'MARIA', '123456', 'avatar_default_girl.png', NULL, 'MARIA', '123456', 3, '2025-04-19', NULL, 1, 0, 1),
(22, 'JOSUE MOLE', '123456', 'avatar_default.png', NULL, 'JOSUE M', '123456', 3, '2025-04-19', '2025-10-25', 0, 0, 1),
(23, 'CRISTOFER', '123456', 'avatar_default.png', NULL, 'CRISTOFER', '123456', 3, '2025-04-19', NULL, 0, 0, 1),
(24, 'SUSAN', '123456', 'avatar_default_girl.png', NULL, 'SUSAN', '123456', 3, '2025-06-14', '2025-06-14', 0, 0, 1),
(25, 'ROSMERY', '123456', 'avatar_default.png', NULL, 'ROSMERY', '123456', 3, '2025-06-14', NULL, 1, 0, 1),
(26, 'ALEJANDRO', '123456', 'avatar_default.png', NULL, 'ALEJANDRO', '123456', 3, '2025-06-14', NULL, 0, 0, 1),
(27, 'DUDU', '123456', 'avatar_default.png', NULL, 'DUDU', '123456', 3, '2025-06-14', NULL, 1, 0, 1),
(28, 'JHONNY', '123456', 'avatar_default.png', NULL, 'JHONNY', '123456', 3, '2025-06-14', NULL, 0, 0, 1),
(29, 'ANDER', '123456', 'avatar_default.png', NULL, 'ANDER', '123456', 3, '2025-06-14', NULL, 1, 0, 1),
(30, 'KEI', '123456', 'avatar_default.png', NULL, 'KEI', '123456', 3, '2025-06-14', NULL, 0, 0, 0),
(31, 'SILVIA', '123456', 'avatar_default_girl.png', NULL, 'SILVIA', '123456', 3, '2025-06-14', NULL, 1, 0, 1),
(32, 'LEO', '123456', 'avatar_default.png', NULL, 'LEO', '123456', 3, '2025-06-14', NULL, 1, 0, 1),
(33, 'JOEL', '123456', 'avatar_default.png', NULL, 'JOEL', '123456', 3, '2025-06-14', NULL, 0, 0, 1),
(34, 'MIRY China', '123456', 'avatar_default_girl.png', NULL, 'MIRY', '123456', 3, '2025-06-14', NULL, 0, 0, 0),
(35, 'HENRY', '123456', 'avatar_default.png', NULL, 'HENRY', 'henry', 3, '2025-06-14', '2025-10-25', 0, 0, 1),
(36, 'MELINA', '123456', 'avatar_default_girl.png', NULL, 'MELINA', '123456', 3, '2025-06-14', NULL, 0, 0, 0),
(37, 'EDWARS', '123456', 'avatar_default.png', NULL, 'EDWARS', '123456', 3, '2025-06-14', NULL, 0, 0, 0),
(38, 'JUNIOR', '123456', 'avatar_default.png', NULL, 'JUNIOR', '123456', 3, '2025-06-14', NULL, 0, 0, 0),
(39, 'AXEL', '123456', 'avatar_default.png', NULL, 'AXEL', '123456', 3, '2025-06-14', NULL, 0, 0, 0),
(40, 'DENIS', '123456', 'avatar_default.png', NULL, 'DENIS', '123456', 3, '2025-06-14', NULL, 0, 0, 0),
(41, 'LILIANA China', '123456', 'avatar_default_girl.png', NULL, 'LILIANA China', '123456', 3, '2025-06-15', NULL, 0, 0, 0),
(42, 'SERGIO', '123456', 'avatar_default.png', NULL, 'SERGIO', 'SERGIO', 3, '2025-07-12', NULL, 0, 0, 1),
(43, 'GEOVANNY', '123456', 'avatar_default.png', NULL, 'GEOVANNY', 'GEOVANNY', 3, '2025-07-12', NULL, 0, 0, 0),
(44, 'DANNY', '123456', 'avatar_default.png', NULL, 'DANNY', 'danny', 3, '2025-07-13', NULL, 0, 0, 0),
(45, 'YAMILETH', '123456', 'avatar_default.png', NULL, 'YAMILETH', 'yamileth', 3, '2025-07-14', '2025-07-14', 0, 0, 1),
(46, 'IRIS', '123456', 'avatar_default.png', NULL, 'IRIS', 'IRIS', 3, '2025-09-20', NULL, 0, 0, 0),
(47, 'KATIA', '123456', 'avatar_default.png', NULL, 'KATIA', 'KATIA', 3, '2025-09-20', NULL, 0, 0, 0),
(48, 'PIERINA', '123456', 'avatar_default.png', NULL, 'PIERINA', 'PIERINA', 3, '2025-09-20', NULL, 0, 0, 0),
(49, 'JERSON', '123456', 'avatar_default.png', NULL, 'JERSON', 'JERSON', 3, '2025-09-20', NULL, 0, 0, 0),
(50, 'KEYLA', '123456', 'avatar_default.png', NULL, 'KEYLA', 'KEYLA', 3, '2025-09-20', NULL, 0, 0, 0),
(51, 'ALCIDES', '123456', 'avatar_default.png', NULL, 'ALCIDES', 'ALCIDES', 3, '2025-10-09', NULL, 1, 0, 1),
(52, 'JOOSE', '123456', 'avatar_default.png', NULL, 'JOOSE', 'JOOSE', 3, '2025-10-25', NULL, 0, 0, 1),
(53, 'MILUSKA', '123456', 'avatar_default.png', NULL, 'MILUSKA', 'MIULSKA', 3, '2025-10-25', NULL, 0, 0, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `colores`
--
ALTER TABLE `colores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `enfrentamientos`
--
ALTER TABLE `enfrentamientos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `enfrentamientos2`
--
ALTER TABLE `enfrentamientos2`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `enfrentamiento_rapido`
--
ALTER TABLE `enfrentamiento_rapido`
  ADD PRIMARY KEY (`id`,`estado`,`cantidad_equipos`,`fecha_reg`);

--
-- Indices de la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `equipo_jugador`
--
ALTER TABLE `equipo_jugador`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `fotos`
--
ALTER TABLE `fotos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `guia_enfrentamiento_rapido`
--
ALTER TABLE `guia_enfrentamiento_rapido`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `posiciones_voley`
--
ALTER TABLE `posiciones_voley`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tabla_posiciones`
--
ALTER TABLE `tabla_posiciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `torneo`
--
ALTER TABLE `torneo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `colores`
--
ALTER TABLE `colores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `enfrentamientos`
--
ALTER TABLE `enfrentamientos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `enfrentamientos2`
--
ALTER TABLE `enfrentamientos2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT de la tabla `enfrentamiento_rapido`
--
ALTER TABLE `enfrentamiento_rapido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `equipo_jugador`
--
ALTER TABLE `equipo_jugador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT de la tabla `fotos`
--
ALTER TABLE `fotos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `guia_enfrentamiento_rapido`
--
ALTER TABLE `guia_enfrentamiento_rapido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tabla_posiciones`
--
ALTER TABLE `tabla_posiciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `torneo`
--
ALTER TABLE `torneo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
