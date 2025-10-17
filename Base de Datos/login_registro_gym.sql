-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-05-2025 a las 20:26:24
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
-- Base de datos: `login_registro_gym`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eliminados`
--

CREATE TABLE `eliminados` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `rol` enum('producto','usuario') NOT NULL,
  `fecha_eliminacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `eliminados`
--

INSERT INTO `eliminados` (`id`, `nombre`, `rol`, `fecha_eliminacion`) VALUES
(1, 'Creatina Nutrex 200', 'producto', '2025-05-29 20:19:17'),
(2, 'esteban', 'usuario', '2025-05-29 20:19:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `tarjeta` varchar(20) NOT NULL,
  `cvv` varchar(4) NOT NULL,
  `fecha_expiracion` varchar(7) NOT NULL,
  `plan_comprado` varchar(50) NOT NULL,
  `fecha_pago` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planes`
--

CREATE TABLE `planes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `planes`
--

INSERT INTO `planes` (`id`, `nombre`, `descripcion`, `precio`) VALUES
(1, 'Basic', 'Acceso al gym de lunes a sabado, 5 a.m. - 10 p.m.', 80000.00),
(2, 'Energy', 'Acceso ilimitado todos los días, clases grupales, asesoría inicial', 120000.00),
(3, 'Premium', 'Acceso VIP 24/7, entrenador personal, clases, asesoría nutricional', 200000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `precio`, `tipo`, `imagen`, `stock`) VALUES
(2, 'Creatina Iron Nutrition', 120000.00, 'Creatina', '/gym/uploads/6837ea6b7faee_creatina-iron-nutrition-100-creatine-ultra-pure-1.jpg', 12),
(3, 'Creatina Platinum Muscletech', 150000.00, 'Creatina', '/gym/uploads/WhatsApp-Image-2024-08-30-at-4.38.10-PM-300x300.jpeg.jpg', 7),
(4, 'Creatina Nutrex 300', 100000.00, 'Creatina', '/gym/uploads/nutrex300.jpg', 12),
(5, 'Proteina Whey de Optimum Nutrition', 370000.00, 'Proteina', '/gym/uploads/gold-standard-5-lb-french-vanilla-800x800.jpg', 3),
(6, 'Psychotic', 160000.00, 'Preentreno', '/gym/uploads/PSYCOTHIC-HELLBOY-INSANE-LABS.jpg', 8),
(7, 'C4', 194000.00, 'Preentreno', '/gym/uploads/C4-60-Servicios.jpeg', 5),
(8, 'Scitec Nutrition', 594000.00, 'Proteina', '/gym/uploads/81cwH-uAPVL.jpg', 9),
(9, 'Creatina Nutricost', 175000.00, 'Creatina', '/gym/uploads/creatinanutricost.jpg', 10),
(10, 'PBN', 120000.00, 'Proteina', '/gym/uploads/61pm0x59MdL._AC_UL600_SR600,600_.jpg', 6),
(11, 'Creatina Monster Test', 120000.00, 'Creatina', '/gym/uploads/monstertest.jpg', 6),
(13, 'Creatina Nutrex 300', 80000.00, 'Creatina', '/gym/uploads/68390c7240442_nutrex200.jpg', 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rutinas`
--

CREATE TABLE `rutinas` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `nombre_rutina` varchar(100) NOT NULL,
  `dia_semana` enum('Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo') NOT NULL,
  `ejercicio` varchar(100) NOT NULL,
  `series` int(11) NOT NULL,
  `repeticiones` int(11) NOT NULL,
  `descanso` int(11) NOT NULL,
  `creado` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `cedula` varchar(20) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `contraseña` varbinary(255) NOT NULL,
  `rol` enum('admin','usuario') NOT NULL DEFAULT 'usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `cedula`, `telefono`, `contraseña`, `rol`) VALUES
(2, 'admin', '', '', 0x38643936396565663665636164336332396133613632393238306536383663663063336635643561383661666633636131323032306339323361646336633932, 'admin'),
(3, 'esteban', '1005184798', '3155918864', 0x30303166633733613932653066333339633062373462326238616664613163623030663464626164386366353837363962346135386666333034656539376235, 'usuario');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `eliminados`
--
ALTER TABLE `eliminados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `planes`
--
ALTER TABLE `planes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rutinas`
--
ALTER TABLE `rutinas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD UNIQUE KEY `cedula` (`cedula`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `eliminados`
--
ALTER TABLE `eliminados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `planes`
--
ALTER TABLE `planes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `rutinas`
--
ALTER TABLE `rutinas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
