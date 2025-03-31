-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-03-2025 a las 17:05:21
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dragongymactual`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accesos`
--

CREATE TABLE `accesos` (
  `ID_Acceso` int(10) NOT NULL,
  `Hora` time NOT NULL,
  `Fecha` date NOT NULL,
  `Precio` int(5) DEFAULT NULL,
  `ID_Miembro` int(5) NOT NULL,
  `Tipo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `accesos`
--

INSERT INTO `accesos` (`ID_Acceso`, `Hora`, `Fecha`, `Precio`, `ID_Miembro`, `Tipo`) VALUES
(21, '20:35:07', '2025-03-20', 0, 3, 'Miembro'),
(22, '21:10:26', '2025-03-20', 45, 2, 'Visita'),
(24, '21:12:34', '2025-03-20', 0, 4, 'Miembro'),
(26, '21:48:14', '2025-03-20', 0, 6, 'Miembro'),
(27, '08:36:32', '2025-03-21', 45, 2, 'Visita'),
(28, '08:36:47', '2025-03-21', 0, 6, 'Miembro'),
(29, '08:49:12', '2025-03-21', 34, 3, 'Visita'),
(30, '22:40:13', '2025-03-21', 0, 3, 'Miembro'),
(31, '15:39:19', '2025-03-22', 45, 45, 'Visita'),
(33, '21:43:26', '2025-03-22', 0, 3, 'Miembro'),
(34, '23:23:51', '2025-03-22', 0, 3, 'Miembro'),
(35, '07:38:05', '2025-03-24', 0, 3, 'Miembro'),
(38, '14:24:50', '2025-03-25', 0, 3, 'Miembro'),
(40, '21:47:42', '2025-03-26', 45, 3, 'Visita'),
(41, '21:47:52', '2025-03-26', 0, 6, 'Miembro'),
(42, '20:16:09', '2025-03-27', 0, 7, 'Miembro'),
(43, '22:19:27', '2025-03-30', 45, 4, 'Visita');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `ID_DetalleVenta` int(10) NOT NULL,
  `ID_Venta` int(10) NOT NULL,
  `ID_Producto` int(5) NOT NULL,
  `Cantidad` int(6) NOT NULL,
  `Subtotal` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gastos`
--

CREATE TABLE `gastos` (
  `ID_Gasto` int(5) NOT NULL,
  `Descripcion` varchar(200) NOT NULL,
  `Precio` int(6) NOT NULL,
  `Fecha` date NOT NULL,
  `ID_Usuario` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `gastos`
--

INSERT INTO `gastos` (`ID_Gasto`, `Descripcion`, `Precio`, `Fecha`, `ID_Usuario`) VALUES
(5, 'Compra de maquina Smith', 32, '2025-03-02', 27),
(7, 'Compra de Preentreno', 2333, '2024-06-28', 27),
(16, 'Compra para surtir refrigerador', 2333, '2025-03-03', 27),
(18, 'Compra de mancuernillas 5 kg', 2333, '2024-06-10', 27),
(19, 'Gatorade', 2333, '2025-03-17', 27),
(20, 'Maquinaria util', 2333, '2025-03-16', 27),
(21, 'Maquinaria pesada', 2333, '2025-03-03', 27),
(26, 'Computadora', 2333, '2025-03-10', 27),
(27, 'Gasto en poleas', 2333, '2025-03-17', 27),
(29, 'Si', 2333, '2025-03-02', 27),
(32, 'Mancuernas', 123, '2025-04-05', 27),
(34, 'Maquina press', 34, '2025-03-17', 27);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingresos`
--

CREATE TABLE `ingresos` (
  `ID_Ingreso` int(6) NOT NULL,
  `ID_Producto` int(5) NOT NULL,
  `Cantidad` int(6) NOT NULL,
  `Fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `membresias`
--

CREATE TABLE `membresias` (
  `ID_Membresia` int(5) NOT NULL,
  `Tipo` varchar(30) NOT NULL,
  `Descripcion` varchar(100) NOT NULL,
  `Costo` int(5) NOT NULL,
  `Duracion` enum('semana','mes') DEFAULT NULL,
  `Estatus` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `membresias`
--

INSERT INTO `membresias` (`ID_Membresia`, `Tipo`, `Descripcion`, `Costo`, `Duracion`, `Estatus`) VALUES
(1, 'Semana', 'Vigencia 7 dias el gimnasio', 150, 'semana', 0),
(4, 'Estudiante', 'Mes a precio de descuento', 380, 'mes', 1),
(7, 'Mes', 'Un mes de duracion', 420, 'mes', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `miembros`
--

CREATE TABLE `miembros` (
  `ID_Miembro` int(5) NOT NULL,
  `Nombre` varchar(30) NOT NULL,
  `ApellidoP` varchar(30) NOT NULL,
  `ApellidoM` varchar(30) NOT NULL,
  `Sexo` char(1) NOT NULL,
  `Telefono` varchar(10) NOT NULL,
  `Estatus` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `miembros`
--

INSERT INTO `miembros` (`ID_Miembro`, `Nombre`, `ApellidoP`, `ApellidoM`, `Sexo`, `Telefono`, `Estatus`) VALUES
(1, 'Juan', 'Gómez', 'López', 'M', '5551234567', 1),
(2, 'María', 'Martínez', 'González', 'F', '5559876543', 1),
(3, 'Carlos', 'Hernández', 'Díaz', 'M', '5552345678', 1),
(4, 'Ana', 'Pérez', 'Ramírez', 'F', '5558765432', 1),
(6, 'Laura', 'Ramírez', 'Vargas', 'F', '5557654321', 1),
(7, 'Miguel', 'Díaz', 'Ortega', 'M', '5554567890', 1),
(8, 'Andrea', 'Torres', 'Mendoza', 'F', '5556543210', 1),
(9, 'Fernando', 'López', 'Castro', 'M', '5555678901', 0),
(10, 'Sofía', 'Vargas', 'Morales', 'F', '5554321098', 1),
(11, 'Ricardo', 'Ortega', 'Núñez', 'M', '5556789012', 1),
(12, 'Valeria', 'Mendoza', 'Reyes', 'F', '5553210987', 1),
(13, 'Diego', 'Castro', 'Flores', 'M', '5557890123', 1),
(14, 'Gabriela', 'Morales', 'Herrera', 'F', '5552109876', 1),
(15, 'Jorge', 'Núñez', 'Gutiérrez', 'M', '5558901234', 1),
(16, 'Patricia', 'Reyes', 'Jiménez', 'F', '5551098765', 1),
(17, 'Roberto', 'Flores', 'Rojas', 'M', '5559012345', 1),
(18, 'Isabel', 'Herrera', 'Cabrera', 'F', '5550987654', 1),
(19, 'Héctor', 'Gutiérrez', 'Delgado', 'M', '5550123456', 1),
(20, 'Claudia', 'Jiménez', 'Acosta', 'F', '5558765430', 1),
(21, 'Alejandro', 'Rojas', 'Campos', 'M', '5551345678', 1),
(22, 'Daniela', 'Cabrera', 'Paredes', 'F', '5557654309', 1),
(23, 'Emilio', 'Delgado', 'Peña', 'M', '5551472583', 1),
(24, 'Lucía', 'Acosta', 'Navarro', 'F', '5553698520', 1),
(25, 'Manuel', 'Campos', 'Silva', 'M', '5552583697', 1),
(26, 'Renata', 'Paredes', 'Ibarra', 'F', '5558527410', 1),
(27, 'Felipe', 'Peña', 'Luna', 'M', '5559638527', 1),
(28, 'Camila', 'Navarro', 'Escobar', 'F', '5557412589', 1),
(29, 'Oscar', 'Silva', 'Maldonado', 'M', '5557896541', 1),
(30, 'Adriana', 'Ibarra', 'Solís', 'F', '5553216549', 1),
(31, 'Pablo', 'Luna', 'Guzmán', 'M', '5556549871', 1),
(32, 'Elena', 'Escobar', 'León', 'F', '5551597538', 1),
(33, 'Guillermo', 'Maldonado', 'Estrada', 'M', '5557531594', 1),
(34, 'Verónica', 'Solís', 'Meza', 'F', '5558529631', 1),
(35, 'Sebastián', 'Guzmán', 'Cortés', 'M', '5554561239', 1),
(36, 'Natalia', 'León', 'Aguilar', 'F', '5559631472', 1),
(37, 'Mario', 'Estrada', 'Beltrán', 'M', '5553571596', 1),
(38, 'Paula', 'Meza', 'Esquivel', 'F', '5559513574', 1),
(39, 'Esteban', 'Cortés', 'Méndez', 'M', '5557538529', 1),
(40, 'Carla', 'Aguilar', 'Castañeda', 'F', '5552587413', 1),
(41, 'Rodrigo', 'Beltrán', 'Ramos', 'M', '5558521479', 1),
(42, 'Beatriz', 'Esquivel', 'Salazar', 'F', '5556542581', 1),
(43, 'Hugo', 'Méndez', 'Cordero', 'M', '5553697412', 1),
(44, 'Florencia', 'Castañeda', 'Vega', 'F', '5557413698', 1),
(45, 'Germán', 'Ramos', 'Valencia', 'M', '5558529637', 1),
(46, 'Lorena', 'Salazar', 'Carranza', 'F', '5559637418', 1),
(47, 'Ángel', 'Cordero', 'Bautista', 'M', '5557418523', 1),
(48, 'Mónica', 'Vega', 'Cervantes', 'F', '5558521476', 1),
(49, 'Rafael', 'Valencia', 'Rosales', 'M', '5559632587', 1),
(50, 'Jessica', 'Carranza', 'Bravo', 'F', '5553698524', 1),
(51, 'Francisco', 'Bautista', 'Escalante', 'M', '5551478529', 1),
(52, 'Daniela', 'Cervantes', 'Tapia', 'F', '5559632581', 1),
(53, 'Sergio', 'Rosales', 'Chávez', 'M', '5557534562', 1),
(54, 'Cecilia', 'Bravo', 'Del Valle', 'F', '5558527531', 1),
(55, 'Armando', 'Escalante', 'Arellano', 'M', '5554569517', 1),
(56, 'Fabiola', 'Tapia', 'Medina', 'F', '5557413695', 1),
(57, 'Julio', 'Chávez', 'Estrada', 'M', '5559517536', 0),
(61, 'Miguel', 'Menza', 'Mendez', 'M', '2481822198', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `miembro_membresia`
--

CREATE TABLE `miembro_membresia` (
  `ID_MiemMiembro` int(5) NOT NULL,
  `FechaInicio` date NOT NULL,
  `FechaFin` date NOT NULL,
  `Costo` double NOT NULL,
  `Cantidad` int(5) NOT NULL,
  `FechaPago` date NOT NULL,
  `ID_Miembro` int(5) NOT NULL,
  `ID_Membresia` int(5) NOT NULL,
  `ID_Usuario` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `miembro_membresia`
--

INSERT INTO `miembro_membresia` (`ID_MiemMiembro`, `FechaInicio`, `FechaFin`, `Costo`, `Cantidad`, `FechaPago`, `ID_Miembro`, `ID_Membresia`, `ID_Usuario`) VALUES
(7, '2025-03-18', '2025-03-25', 150, 1, '2025-03-16', 3, 1, 27),
(17, '2025-03-22', '2025-03-29', 150, 1, '2025-03-22', 9, 1, 27);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `ID_Producto` int(5) NOT NULL,
  `img` varchar(200) NOT NULL,
  `Descripcion` varchar(200) NOT NULL,
  `Precio` int(6) NOT NULL,
  `Disponible` decimal(10,0) NOT NULL,
  `ID_TipoProducto` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`ID_Producto`, `img`, `Descripcion`, `Precio`, `Disponible`, `ID_TipoProducto`) VALUES
(1, 'inventarioImg/clorets.png', 'clorets', 2, -1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoi`
--

CREATE TABLE `tipoi` (
  `ID_TipoProducto` int(5) NOT NULL,
  `Descripcion` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipoi`
--

INSERT INTO `tipoi` (`ID_TipoProducto`, `Descripcion`) VALUES
(1, 'Bebidas'),
(2, 'Suplemento');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `ID_Usuario` int(5) NOT NULL,
  `Nombre` varchar(30) NOT NULL,
  `ApellidoP` varchar(30) NOT NULL,
  `ApellidoM` varchar(30) NOT NULL,
  `CorreoUsu` varchar(70) NOT NULL,
  `NombreUsu` varchar(50) NOT NULL,
  `Contra` varchar(200) NOT NULL,
  `Salario` int(6) NOT NULL,
  `Foto` varchar(50) NOT NULL,
  `usutip` enum('admin','coach','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID_Usuario`, `Nombre`, `ApellidoP`, `ApellidoM`, `CorreoUsu`, `NombreUsu`, `Contra`, `Salario`, `Foto`, `usutip`) VALUES
(27, 'Arath', 'Saavedra', 'Cabrera', 'saavedraarath@gmail.com', 'Admin', '$2y$10$RHyWQh2iY0tuz9kR7/xCl.vpnz5IDN393DMmnxWYgKflas6S2pBvK', 1500, '', 'admin'),
(60, 'Kevin', 'Rolcer', 'Salazar', 'arathsaavedracabrera96@gmail.com', 'Kevin', '$2y$10$A9Db4GulkWi.2YtkvMAaaujaMYwR5VbhPEQO6Jcu5pxnMIBaS3uKS', 2, '', 'coach');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `ID_Venta` int(6) NOT NULL,
  `Fecha` date NOT NULL,
  `Total` float NOT NULL,
  `ID_Usuario` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`ID_Venta`, `Fecha`, `Total`, `ID_Usuario`) VALUES
(1, '2025-03-22', 156, 27),
(2, '2025-03-22', 248, 27);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_accesos_hoy`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_accesos_hoy` (
`ID_Acceso` int(10)
,`Hora` time
,`Fecha` date
,`Precio` int(5)
,`ID_Miembro` int(5)
,`Tipo` varchar(20)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_corte`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_corte` (
`Tipo` varchar(13)
,`Total_Visitas` decimal(42,0)
,`Total_Visitas_Monto` decimal(54,0)
,`Total_Ventas` decimal(42,0)
,`Total_Ventas_Monto` double
,`Total_Membresias` decimal(54,0)
,`Total_Membresias_Monto` double
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_membresias_vigentes`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_membresias_vigentes` (
`ID_MiemMiembro` int(5)
,`FechaInicio` date
,`FechaFin` date
,`Costo` double
,`Cantidad` int(5)
,`FechaPago` date
,`ID_Miembro` int(5)
,`ID_Membresia` int(5)
,`ID_Usuario` int(5)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_accesos_hoy`
--
DROP TABLE IF EXISTS `vista_accesos_hoy`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_accesos_hoy`  AS SELECT `accesos`.`ID_Acceso` AS `ID_Acceso`, `accesos`.`Hora` AS `Hora`, `accesos`.`Fecha` AS `Fecha`, `accesos`.`Precio` AS `Precio`, `accesos`.`ID_Miembro` AS `ID_Miembro`, `accesos`.`Tipo` AS `Tipo` FROM `accesos` WHERE `accesos`.`Fecha` = curdate() ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_corte`
--
DROP TABLE IF EXISTS `vista_corte`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_corte`  AS SELECT 'Visita' AS `Tipo`, coalesce(count(`accesos`.`ID_Acceso`),0) AS `Total_Visitas`, coalesce(sum(`accesos`.`Precio`),0) AS `Total_Visitas_Monto`, 0 AS `Total_Ventas`, 0 AS `Total_Ventas_Monto`, 0 AS `Total_Membresias`, 0 AS `Total_Membresias_Monto` FROM `accesos` WHERE cast(`accesos`.`Fecha` as date) = curdate() AND `accesos`.`Tipo` = 'Visita'union all select 'Venta' AS `Tipo`,0 AS `Total_Visitas`,0 AS `Total_Visitas_Monto`,coalesce(count(`ventas`.`ID_Venta`),0) AS `Total_Ventas`,coalesce(sum(`ventas`.`Total`),0) AS `Total_Ventas_Monto`,0 AS `Total_Membresias`,0 AS `Total_Membresias_Monto` from `ventas` where cast(`ventas`.`Fecha` as date) = curdate() union all select 'Membresia' AS `Tipo`,0 AS `Total_Visitas`,0 AS `Total_Visitas_Monto`,0 AS `Total_Ventas`,0 AS `Total_Ventas_Monto`,coalesce(sum(`miembro_membresia`.`Cantidad`),0) AS `Total_Membresias`,coalesce(sum(`miembro_membresia`.`Cantidad` * `miembro_membresia`.`Costo`),0) AS `Total_Membresias_Monto` from `miembro_membresia` where cast(`miembro_membresia`.`FechaPago` as date) = curdate() union all select 'Total General' AS `Tipo`,coalesce(sum(case when `resumen`.`Tipo` = 'Visita' then `resumen`.`Total_Visitas` else 0 end),0) AS `Total_Visitas`,coalesce(sum(case when `resumen`.`Tipo` = 'Visita' then `resumen`.`Total_Visitas_Monto` else 0 end),0) AS `Total_Visitas_Monto`,coalesce(sum(case when `resumen`.`Tipo` = 'Venta' then `resumen`.`Total_Ventas` else 0 end),0) AS `Total_Ventas`,coalesce(sum(case when `resumen`.`Tipo` = 'Venta' then `resumen`.`Total_Ventas_Monto` else 0 end),0) AS `Total_Ventas_Monto`,coalesce(sum(case when `resumen`.`Tipo` = 'Membresia' then `resumen`.`Total_Membresias` else 0 end),0) AS `Total_Membresias`,coalesce(sum(case when `resumen`.`Tipo` = 'Membresia' then `resumen`.`Total_Membresias_Monto` else 0 end),0) AS `Total_Membresias_Monto` from (select 'Visita' AS `Tipo`,count(`accesos`.`ID_Acceso`) AS `Total_Visitas`,sum(`accesos`.`Precio`) AS `Total_Visitas_Monto`,0 AS `Total_Ventas`,0 AS `Total_Ventas_Monto`,0 AS `Total_Membresias`,0 AS `Total_Membresias_Monto` from `accesos` where cast(`accesos`.`Fecha` as date) = curdate() and `accesos`.`Tipo` = 'Visita' union all select 'Venta' AS `Tipo`,0 AS `Total_Visitas`,0 AS `Total_Visitas_Monto`,count(`ventas`.`ID_Venta`) AS `Total_Ventas`,sum(`ventas`.`Total`) AS `Total_Ventas_Monto`,0 AS `Total_Membresias`,0 AS `Total_Membresias_Monto` from `ventas` where cast(`ventas`.`Fecha` as date) = curdate() union all select 'Membresia' AS `Tipo`,0 AS `Total_Visitas`,0 AS `Total_Visitas_Monto`,0 AS `Total_Ventas`,0 AS `Total_Ventas_Monto`,sum(`miembro_membresia`.`Cantidad`) AS `Total_Membresias`,sum(`miembro_membresia`.`Cantidad` * `miembro_membresia`.`Costo`) AS `Total_Membresias_Monto` from `miembro_membresia` where cast(`miembro_membresia`.`FechaPago` as date) = curdate()) `resumen`  ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_membresias_vigentes`
--
DROP TABLE IF EXISTS `vista_membresias_vigentes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_membresias_vigentes`  AS SELECT `miembro_membresia`.`ID_MiemMiembro` AS `ID_MiemMiembro`, `miembro_membresia`.`FechaInicio` AS `FechaInicio`, `miembro_membresia`.`FechaFin` AS `FechaFin`, `miembro_membresia`.`Costo` AS `Costo`, `miembro_membresia`.`Cantidad` AS `Cantidad`, `miembro_membresia`.`FechaPago` AS `FechaPago`, `miembro_membresia`.`ID_Miembro` AS `ID_Miembro`, `miembro_membresia`.`ID_Membresia` AS `ID_Membresia`, `miembro_membresia`.`ID_Usuario` AS `ID_Usuario` FROM `miembro_membresia` WHERE `miembro_membresia`.`FechaFin` >= curdate() ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accesos`
--
ALTER TABLE `accesos`
  ADD PRIMARY KEY (`ID_Acceso`),
  ADD KEY `ID_Miembro` (`ID_Miembro`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`ID_DetalleVenta`),
  ADD KEY `ID_Producto` (`ID_Producto`),
  ADD KEY `ID_Venta` (`ID_Venta`);

--
-- Indices de la tabla `gastos`
--
ALTER TABLE `gastos`
  ADD PRIMARY KEY (`ID_Gasto`),
  ADD KEY `ID_Usuario` (`ID_Usuario`);

--
-- Indices de la tabla `ingresos`
--
ALTER TABLE `ingresos`
  ADD PRIMARY KEY (`ID_Ingreso`),
  ADD KEY `ID_Producto` (`ID_Producto`);

--
-- Indices de la tabla `membresias`
--
ALTER TABLE `membresias`
  ADD PRIMARY KEY (`ID_Membresia`);

--
-- Indices de la tabla `miembros`
--
ALTER TABLE `miembros`
  ADD PRIMARY KEY (`ID_Miembro`);

--
-- Indices de la tabla `miembro_membresia`
--
ALTER TABLE `miembro_membresia`
  ADD PRIMARY KEY (`ID_MiemMiembro`),
  ADD KEY `ID_Miembro` (`ID_Miembro`),
  ADD KEY `ID_Membresia` (`ID_Membresia`),
  ADD KEY `ID_Usuario` (`ID_Usuario`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`ID_Producto`),
  ADD KEY `ID_TipoProducto` (`ID_TipoProducto`);

--
-- Indices de la tabla `tipoi`
--
ALTER TABLE `tipoi`
  ADD PRIMARY KEY (`ID_TipoProducto`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID_Usuario`),
  ADD UNIQUE KEY `unique_nombreUsu` (`NombreUsu`),
  ADD UNIQUE KEY `unique_correoUsu` (`CorreoUsu`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`ID_Venta`),
  ADD KEY `ID_Usuario` (`ID_Usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `accesos`
--
ALTER TABLE `accesos`
  MODIFY `ID_Acceso` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `ID_DetalleVenta` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `gastos`
--
ALTER TABLE `gastos`
  MODIFY `ID_Gasto` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `ingresos`
--
ALTER TABLE `ingresos`
  MODIFY `ID_Ingreso` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `membresias`
--
ALTER TABLE `membresias`
  MODIFY `ID_Membresia` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `miembros`
--
ALTER TABLE `miembros`
  MODIFY `ID_Miembro` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT de la tabla `miembro_membresia`
--
ALTER TABLE `miembro_membresia`
  MODIFY `ID_MiemMiembro` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `ID_Producto` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tipoi`
--
ALTER TABLE `tipoi`
  MODIFY `ID_TipoProducto` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID_Usuario` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `ID_Venta` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `accesos`
--
ALTER TABLE `accesos`
  ADD CONSTRAINT `accesos_ibfk_1` FOREIGN KEY (`ID_Miembro`) REFERENCES `miembros` (`ID_Miembro`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `detalle_venta_ibfk_1` FOREIGN KEY (`ID_Producto`) REFERENCES `productos` (`ID_Producto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_venta_ibfk_2` FOREIGN KEY (`ID_Venta`) REFERENCES `ventas` (`ID_Venta`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `gastos`
--
ALTER TABLE `gastos`
  ADD CONSTRAINT `gastos_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuarios` (`ID_Usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ingresos`
--
ALTER TABLE `ingresos`
  ADD CONSTRAINT `ingresos_ibfk_1` FOREIGN KEY (`ID_Producto`) REFERENCES `productos` (`ID_Producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `miembro_membresia`
--
ALTER TABLE `miembro_membresia`
  ADD CONSTRAINT `miembro_membresia_ibfk_1` FOREIGN KEY (`ID_Miembro`) REFERENCES `miembros` (`ID_Miembro`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `miembro_membresia_ibfk_2` FOREIGN KEY (`ID_Membresia`) REFERENCES `membresias` (`ID_Membresia`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `miembro_membresia_ibfk_3` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuarios` (`ID_Usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`ID_TipoProducto`) REFERENCES `tipoi` (`ID_TipoProducto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuarios` (`ID_Usuario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
