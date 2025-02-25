-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 25-02-2025 a las 08:46:59
-- Versión del servidor: 8.0.17
-- Versión de PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `concesionario`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alquileres`
--

CREATE TABLE `alquileres` (
  `id_alquiler` int(10) UNSIGNED NOT NULL,
  `id_usuario` int(10) UNSIGNED NOT NULL,
  `id_coche` int(10) UNSIGNED NOT NULL,
  `prestado` datetime NOT NULL,
  `devuelto` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `alquileres`
--

INSERT INTO `alquileres` (`id_alquiler`, `id_usuario`, `id_coche`, `prestado`, `devuelto`) VALUES
(1, 13, 29, '2025-02-25 08:23:57', '2025-02-25 09:24:06'),
(2, 13, 29, '2025-02-25 08:25:21', '2025-02-25 09:26:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coches`
--

CREATE TABLE `coches` (
  `id_coche` int(10) UNSIGNED NOT NULL,
  `modelo` varchar(50) NOT NULL,
  `marca` varchar(50) NOT NULL,
  `color` varchar(50) DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `alquilado` tinyint(1) NOT NULL DEFAULT '0',
  `foto` varchar(300) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_vendedor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `coches`
--

INSERT INTO `coches` (`id_coche`, `modelo`, `marca`, `color`, `precio`, `alquilado`, `foto`, `id_usuario`, `id_vendedor`) VALUES
(28, 'CyberTruck', 'Tesla', 'Gris', '40000.00', 0, 'OIF.jpg', 12, 12),
(29, 'Serie 4', 'BMW', 'Azul', '1000.00', 0, 'bmw.jpg', 14, 14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(10) UNSIGNED NOT NULL,
  `password` varchar(100) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `dni` varchar(9) NOT NULL,
  `saldo` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tipo_usuario` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `password`, `nombre`, `apellidos`, `dni`, `saldo`, `tipo_usuario`) VALUES
(12, '$2y$10$Q3FrQP80xoere4FPnlGg.uk/gk6u688p2l4.ZeATCnIsSzWurZyLm', 'daniel', 'h', 'a', '100000.00', 'vendedor'),
(13, '$2y$10$XPHcLOge7cfJCYSOYIMuHu8aUhl1OFrf50PY1yIz/mHoxn6Z5HVX6', 'marcos', 'g', 's', '3000.00', 'comprador'),
(14, '$2y$10$LOt9f9MIR4tWepEoNIpo3uW6K4KA8xU.HQmRc1xTJC0QlsIJqPWZm', 'jose', 'm', 'd', '2000.00', 'vendedor'),
(15, '$2y$10$wl0bbLi8Pl/d2xF7BgqSoOX/ifBL1r7ID9qIZOm8lLj23fef2IY.K', 'Admin', 'Principal', 'f', '0.00', 'admin');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alquileres`
--
ALTER TABLE `alquileres`
  ADD PRIMARY KEY (`id_alquiler`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_coche` (`id_coche`);

--
-- Indices de la tabla `coches`
--
ALTER TABLE `coches`
  ADD PRIMARY KEY (`id_coche`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `dni` (`dni`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alquileres`
--
ALTER TABLE `alquileres`
  MODIFY `id_alquiler` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `coches`
--
ALTER TABLE `coches`
  MODIFY `id_coche` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alquileres`
--
ALTER TABLE `alquileres`
  ADD CONSTRAINT `alquileres_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alquileres_ibfk_2` FOREIGN KEY (`id_coche`) REFERENCES `coches` (`id_coche`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
