-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 02-05-2025 a las 20:47:17
-- Versión del servidor: 10.6.16-MariaDB-cll-lve
-- Versión de PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `lqxgdozk_deportazo`
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
  `fase` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `enfrentamientos2`
--

INSERT INTO `enfrentamientos2` (`id`, `id_torneo`, `id_equipo_local`, `id_equipo_visitante`, `marcador_local`, `marcador_visitante`, `ganador`, `perdedor`, `fase`) VALUES
(1, 1, 1, 2, 19, 20, 2, 1, 0),
(2, 1, 1, 3, 20, 17, 1, 3, 0),
(3, 1, 1, 4, 17, 20, 4, 1, 0),
(4, 1, 2, 3, 20, 15, 2, 3, 0),
(5, 1, 2, 4, 20, 16, 2, 4, 0),
(6, 1, 3, 4, 20, 16, 3, 4, 0),
(11, 1, 3, 4, 1, 0, 3, 4, 1),
(12, 1, 1, 3, 1, 0, 1, 3, 2),
(13, 1, 2, 1, 1, 0, 2, 1, 3);

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
(4, 'EQUIPO 4', 1, 1, 1, '#B7C8DB');

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
(1, 4, 1, 1, 1, 1, 1),
(2, 5, 1, 2, 2, 1, 1),
(3, 6, 1, 3, 3, 1, 1),
(4, 7, 1, 5, 4, 1, 1),
(5, 8, 1, 6, 5, 1, 1),
(6, 9, 2, 1, 1, 1, 1),
(7, 10, 2, 2, 2, 1, 1),
(8, 11, 2, 3, 3, 1, 1),
(9, 12, 2, 4, 4, 1, 1),
(10, 13, 2, 6, 5, 1, 1),
(11, 16, 3, 1, 1, 1, 1),
(12, 14, 3, 2, 2, 1, 1),
(13, 17, 3, 3, 3, 1, 1),
(14, 15, 3, 4, 4, 1, 1),
(15, 18, 3, 6, 5, 1, 1),
(16, 23, 4, 1, 1, 1, 1),
(17, 19, 4, 2, 2, 1, 1),
(18, 20, 4, 3, 3, 1, 1),
(19, 21, 4, 4, 4, 1, 1),
(20, 22, 4, 6, 5, 1, 1);

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
(5, 'Imagen de WhatsApp 2025-04-20 a las 21.01.02_f33a6fc3.jpg', 1, 0);

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
(1, 'TORNEO AMISTADES X VOLEY', '1', 1, 4, 'TORNEO PARA RECOLECCION PARA COMPRAR UN BALON', '2025-04-20 15:00:00', 'PAN BENDITO', 1, '2025-04-19', NULL);

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
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `correo`, `avatar`, `correo_verificado`, `user`, `password`, `id_rol`, `created_at`, `updated_at`) VALUES
(1, 'SuperAdministrador', 'superadmin', 'default.png', 'superadmin', 'superadmin', 'superadmin', 1, '2024-12-14', NULL),
(2, 'Administrador', 'admin', 'default.png', 'admin', 'admin', 'admin', 2, '2024-12-14', NULL),
(3, 'jugador', 'jugador', 'default.png', 'jugador', 'jugador', 'jugador', 3, '2024-12-14', NULL),
(4, 'EMILIO', '123456789', 'avatar_default.png', NULL, 'EMILIO', 'emilio', 3, '2025-04-19', '2025-05-01'),
(5, 'MILENA', '123456789', 'avatar_default.png', NULL, 'MILENA', 'MILENA', 3, '2025-04-19', NULL),
(6, 'JOSUE S', '1234566', 'avatar_default.png', NULL, 'JOSUE', 'JOSUE', 3, '2025-04-19', NULL),
(7, 'SULY', '123456', 'avatar_default.png', NULL, 'SULY', 'SULY', 3, '2025-04-19', NULL),
(8, 'JUAN', '123456', 'avatar_default.png', NULL, 'JUAN', 'JUAN', 3, '2025-04-19', NULL),
(9, 'ERIKA', '123456', 'avatar_default.png', NULL, 'ERIKA', 'ERIKA', 3, '2025-04-19', NULL),
(10, 'ABEL', '123456', 'avatar_default.png', NULL, 'ABEL', 'ABEL', 3, '2025-04-19', NULL),
(11, 'JEIK', '123456', 'avatar_default.png', NULL, 'JEIK', 'JEIK', 3, '2025-04-19', NULL),
(12, 'FELIX', '123456', 'avatar_default.png', NULL, 'FELIX', 'FELIX', 3, '2025-04-19', NULL),
(13, 'YORDI', '123456', 'avatar_default.png', NULL, 'YORDI', 'yordi', 3, '2025-04-19', '2025-04-25'),
(14, 'MAYER', '123456', 'avatar_default.png', NULL, 'MAYER', 'MAYER', 3, '2025-04-19', NULL),
(15, 'MARILUZ', '123456', 'avatar_default.png', NULL, 'MARIUZ', 'MARILUZ', 3, '2025-04-19', NULL),
(16, 'FRANCO', '123456', 'avatar_default.png', NULL, 'FRANCO', 'FRANCO', 3, '2025-04-19', NULL),
(17, 'JORGE', '123456', 'avatar_default.png', NULL, 'JORGE', 'JORGE', 3, '2025-04-19', NULL),
(18, 'CARLOS', '123456', 'avatar_default.png', NULL, 'CARLOS', 'CARLOS', 3, '2025-04-19', NULL),
(19, 'OSCAR', '123456', 'avatar_default.png', NULL, 'OSCAR', 'OSCAR', 3, '2025-04-19', NULL),
(20, 'LEO', '123456', 'avatar_default.png', NULL, 'LEO', 'LEO', 3, '2025-04-19', NULL),
(21, 'MARIA', '123456', 'avatar_default.png', NULL, 'MARIA', 'MARIA', 3, '2025-04-19', NULL),
(22, 'JOSUE M', '123456', 'avatar_default.png', NULL, 'JOSUE M', 'JOSUE MARIA', 3, '2025-04-19', NULL),
(23, 'CRISTOFER', '123456', 'avatar_default.png', NULL, 'CRISTOFER', 'CRISTOFER', 3, '2025-04-19', NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `equipo_jugador`
--
ALTER TABLE `equipo_jugador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `fotos`
--
ALTER TABLE `fotos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
