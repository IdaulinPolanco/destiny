-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-01-2025 a las 02:10:27
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `destiny`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lugares`
--

CREATE TABLE `lugares` (
  `id_lugar` int(11) NOT NULL,
  `Nombre` varchar(80) NOT NULL,
  `Imagen` varchar(255) NOT NULL,
  `Descripcion` varchar(700) NOT NULL,
  `Capacidad_Maxima` int(11) NOT NULL,
  `Horario_Apertura` time NOT NULL,
  `Horario_Cierre` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lugares`
--

INSERT INTO `lugares` (`id_lugar`, `Nombre`, `Imagen`, `Descripcion`, `Capacidad_Maxima`, `Horario_Apertura`, `Horario_Cierre`) VALUES
(2, 'Restaurante Absolutto', '/imagen_del_proyecto_final/rest/abso.jpg', 'Aqui podras encontrar todo tipo de bebidas y comidas principalmente francesa', 10, '07:30:00', '22:00:00'),
(3, 'Restaurante D´Capriccio', '/imagen_del_proyecto_final/rest/capr.jpg', 'Aqui prodras encontrar vinos de la mas alta calidad y pasta en todas sus presentaciones ', 8, '09:00:00', '20:30:00'),
(4, 'Restaurante Vesu', '/imagen_del_proyecto_final/rest/vesu.jpg', 'Aquí encontraras todo tipo de comida mediterránea y postres exquisitos', 8, '07:30:00', '22:00:00'),
(5, 'Restaurante Yoi', '/imagen_del_proyecto_final/rest/yoi.jpg', 'Aquí encontraras todo tipo de comida tradicional asiática', 10, '09:00:00', '20:30:00'),
(6, 'Museo La Plata', '/imagen_del_proyecto_final/mus/La_Plata.jpg', 'Ven y admira el cambio y evolucion de las monedas a lo largo de su historia', 20, '07:30:00', '22:00:00'),
(7, 'Museo Ambar', '/imagen_del_proyecto_final/mus/ambar.jpg', 'Ven y observa como el ámbar puede conservar el pasado para el futuro', 15, '07:00:00', '20:30:00'),
(8, 'Museo Bellapart', '/imagen_del_proyecto_final/mus/bellapart.jpg', 'Ven y observa el arte, desde el mas antiguo hasta el mas reciente', 22, '07:30:00', '23:00:00'),
(9, 'Audubon Zoo', '/imagen_del_proyecto_final/zoo/Audubon-Zoo.jpg', 'Ven y descubre las especies de la naturaleza de tu pais', 20, '07:30:00', '22:00:00'),
(10, 'Bronx Zoo', '/imagen_del_proyecto_final/zoo/Bronx-Zoo.jpg', 'Ven y vive una experiencia de lo salvaje', 30, '07:00:00', '20:30:00'),
(11, 'Zooleón', '/imagen_del_proyecto_final/zoo/zooleon.jpg', 'Ven y conoce sobre los increibles animales que componen nuestra gran fauna', 22, '07:30:00', '23:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opiniones`
--

CREATE TABLE `opiniones` (
  `id_opinion` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_lugar` int(11) NOT NULL,
  `comentario` varchar(400) DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `opiniones`
--

INSERT INTO `opiniones` (`id_opinion`, `id_usuario`, `id_lugar`, `comentario`, `fecha`) VALUES
(1, 4, 11, 'Me gusto mucho mi estancia en este zoologico, el personal fue muy amable, sin dudas volveré.', '2024-11-27 12:14:52'),
(2, 4, 2, 'll', '2024-11-27 12:17:20'),
(3, 6, 7, 'La mejor pagina', '2024-11-29 11:02:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva`
--

CREATE TABLE `reserva` (
  `id_reserva` bigint(20) UNSIGNED NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_lugar` int(11) NOT NULL,
  `fecha_reserva` date NOT NULL,
  `hora_reserva` time NOT NULL,
  `cantidad_personas` int(11) NOT NULL,
  `creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reserva`
--

INSERT INTO `reserva` (`id_reserva`, `id_usuario`, `id_lugar`, `fecha_reserva`, `hora_reserva`, `cantidad_personas`, `creacion`) VALUES
(5, 4, 3, '2024-11-28', '22:45:00', 6, '2024-11-28 13:45:20'),
(6, 6, 7, '2024-11-30', '13:00:00', 12, '2024-11-29 16:01:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `Correo` varchar(255) NOT NULL,
  `Contraseña` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `Nombre`, `Correo`, `Contraseña`) VALUES
(4, 'Ydaulin Polanco lopez', 'pitaya7274@gmail.com', '$2y$10$9jIk6t0cmupfIVugzdGq0eSEoL4P3/hpP1Jt87ElFW1QaWTbz/knC'),
(5, 'abrahili', 'hola@gmail.com', '$2y$10$eDJtzdr7jEiITtgbJG3TM.G/z65BdTyeIlem3sPy5Gj4z8FKWvJci'),
(6, 'Charlini', 'charlini@gmail.com', '$2y$10$ZJ1isjEbLkmF1/Gmpi7x5eiIlfnT6rKzikdP9tE5Kxv1Qc62JMH2W');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `lugares`
--
ALTER TABLE `lugares`
  ADD PRIMARY KEY (`id_lugar`);

--
-- Indices de la tabla `opiniones`
--
ALTER TABLE `opiniones`
  ADD PRIMARY KEY (`id_opinion`),
  ADD KEY `FK_Opiniones_Usuarios` (`id_usuario`),
  ADD KEY `FK_Opiniones_Lugares` (`id_lugar`);

--
-- Indices de la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `fk_usuario` (`id_usuario`),
  ADD KEY `fk_lugar` (`id_lugar`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `Correo` (`Correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `lugares`
--
ALTER TABLE `lugares`
  MODIFY `id_lugar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `opiniones`
--
ALTER TABLE `opiniones`
  MODIFY `id_opinion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `reserva`
--
ALTER TABLE `reserva`
  MODIFY `id_reserva` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `opiniones`
--
ALTER TABLE `opiniones`
  ADD CONSTRAINT `FK_Opiniones_Lugares` FOREIGN KEY (`id_lugar`) REFERENCES `lugares` (`id_lugar`),
  ADD CONSTRAINT `FK_Opiniones_Usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `fk_lugar` FOREIGN KEY (`id_lugar`) REFERENCES `lugares` (`id_lugar`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
