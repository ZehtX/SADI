-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 24-05-2024 a las 04:25:54
-- Versión del servidor: 10.5.20-MariaDB
-- Versión de PHP: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `id22050405_facturacion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cabecera`
--

CREATE TABLE `cabecera` (
  `Nombre_Empresa` varchar(255) DEFAULT NULL,
  `RIF_Empresa` varchar(32) DEFAULT NULL,
  `IVA` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `ID` int(11) NOT NULL,
  `Nombre` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`ID`, `Nombre`) VALUES
(1, 'Camisas'),
(2, 'Pantalon'),
(3, 'Sueter'),
(4, 'Franela');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `CI` varchar(8) NOT NULL,
  `Nombre_Apellido` varchar(64) NOT NULL,
  `Telefono` varchar(12) NOT NULL,
  `Direccion` varchar(128) NOT NULL,
  `is_delete` varchar(23) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`CI`, `Nombre_Apellido`, `Telefono`, `Direccion`, `is_delete`) VALUES
('10159798', 'Ram', '0412-9999999', 'Desconocida', '1'),
('11234578', '1', '0412-0450084', 'Desconocida', '1'),
('1334415', 'KEvin', '0412-0450084', 'ecqcqeceq', '1'),
('1334514', 'admin', '0412-3234562', 'Carretera Vieja Tocuyito Urb. Alexis Cravo Calle Negro Primero Casa 121', '1'),
('20258777', 'Diego lopez', '0412-4556789', 'Desconocida', '0'),
('30678646', 'Gabriel lampe', '0412-2345678', 'Guacara', '0'),
('30758321', 'Ramses Oviol', '0412-1234567', 'Tacarigua', '0'),
('30758328', 'admin', '0412-3234562', 'Desconocida', '0'),
('30758333', 'Alexander Lopez', '0412-7894561', 'Boqueron', '0'),
('31325322', 'Zeht', '0412-4643265', 'Desconocida', '0'),
('31325329', 'admin', '0412-0450084', 'Desconocida', '1'),
('8361383', 'Zeht', '0412-9382813', 'Desconocida', '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle`
--

CREATE TABLE `detalle` (
  `ID` int(11) NOT NULL,
  `Codigo_Factura` int(4) UNSIGNED ZEROFILL DEFAULT NULL,
  `Codigo_Producto` varchar(8) DEFAULT NULL,
  `Cantidad` int(11) NOT NULL,
  `Subtotal` float(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle`
--

INSERT INTO `detalle` (`ID`, `Codigo_Factura`, `Codigo_Producto`, `Cantidad`, `Subtotal`) VALUES
(29, 0001, 'CN001', 1, 5.00),
(30, 0002, 'FB001', 1, 5.00),
(31, 0002, 'FB001', 1, 5.00),
(32, 0003, 'CN001', 1, 5.00),
(33, 0003, 'SA002', 2, 21.00),
(34, 0004, '0005', 2, 24.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `Codigo_Factura` int(4) UNSIGNED ZEROFILL NOT NULL,
  `CI_Cliente` varchar(8) DEFAULT NULL,
  `Fecha` date DEFAULT current_timestamp(),
  `Total` float(10,2) DEFAULT NULL,
  `is_delete` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`Codigo_Factura`, `CI_Cliente`, `Fecha`, `Total`, `is_delete`) VALUES
(0001, '1334415', '2024-05-22', 5.80, 1),
(0002, '1334415', '2024-05-22', 11.60, 0),
(0003, '30758321', '2024-05-23', 30.16, 0),
(0004, '30758321', '2024-05-24', 27.84, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `Codigo` varchar(8) NOT NULL,
  `Descripcion` varchar(64) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `Precio` float(10,2) NOT NULL,
  `ID_Categoria` int(11) DEFAULT NULL,
  `is_delete` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`Codigo`, `Descripcion`, `Cantidad`, `Precio`, `ID_Categoria`, `is_delete`) VALUES
('0005', 'Verde', 3, 12.00, 3, 0),
('006', 'Verde', 5, 12.50, 1, 1),
('44443', 'Franela', 10, 5.00, 4, 1),
('CB002', 'Camisa Blanca M2', 5, 6.00, 1, 1),
('CB003', 'Camisa Negra', 5, 10.00, 1, 1),
('CB006', 'Camisa Negra', 4, 10.50, 1, 1),
('CN001', 'Camisa Blanca M', 1, 5.00, 1, 0),
('FA02', 'Franela Amarilla', 20, 5.00, 4, 0),
('FB001', 'Franelilla Blanca Ovejita L', 18, 5.00, 4, 0),
('PN001', 'Pantalon Jean Negro M', 20, 15.00, 2, 1),
('SA001', 'Camisa Blanca M2', 5, 6.00, 1, 1),
('SA002', 'Sueter Azul M', 4, 10.50, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ultima_operacion`
--

CREATE TABLE `ultima_operacion` (
  `Numero` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ultima_operacion`
--

INSERT INTO `ultima_operacion` (`Numero`) VALUES
(4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `Correo` varchar(128) NOT NULL,
  `Clave` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`Correo`, `Clave`) VALUES
('a@a.com', '$2y$10$coFbVWEf8rbmEz.8dWmWE.nBctS9NlqSFGOKlMRQis9lyz9ttMEvW'),
('a@a2.com', '$2y$10$Nq1nHFCzsCI9suJmaWE0L.i6BkWxKoy6Q2ynJubaVPEi2/0c32qJW'),
('b@b.com', '$2y$10$tirAv.JyzJGQE9nR0BvnBOzEI4qofxlduUfxwvVwrrpx08QIDyRfq'),
('b@b.comb', '$2y$10$UHfG9mUKAQXR8DeBCpoRIOvGRAsJ0t1MquHGF47CJhP78ZE36fjV6'),
('c@a.com', '$2y$10$oIwkPcW5cMJUELEmrHaLY.Aw26ShbuXpv5Yoyvvl2gmyzeFXM.49W'),
('c@a.coms', '$2y$10$Xb/IrIotedTW./pvqNAIru4pKR8SlygQiGj/skiGtzrSH7biVG13W'),
('c@c.com', '$2y$10$3gLu25fR8d6jHVy/ZQMlWug/zvXnFJtGftItiT91mw1kuYcLhPtBm'),
('g@gmail.com', '$2y$10$wkQkri3VAdOl1Z0CKw9PkODXxm/tKeNEXplGWl2R58R6mgTMGC2.S'),
('ram@g.com', '$2y$10$0O5BfTnFNoqvmDUN5gRy4OZzLZj51HyI3rqMU6tatm/egK86X7i4e');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cabecera`
--
ALTER TABLE `cabecera`
  ADD KEY `idx_RIF_Empresa` (`RIF_Empresa`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`CI`);

--
-- Indices de la tabla `detalle`
--
ALTER TABLE `detalle`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Codigo_Factura` (`Codigo_Factura`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`Codigo_Factura`),
  ADD KEY `CI_Cliente` (`CI_Cliente`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`Codigo`),
  ADD KEY `ID_Categoria` (`ID_Categoria`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`Correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `detalle`
--
ALTER TABLE `detalle`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle`
--
ALTER TABLE `detalle`
  ADD CONSTRAINT `detalle_ibfk_1` FOREIGN KEY (`Codigo_Factura`) REFERENCES `factura` (`Codigo_Factura`);

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`CI_Cliente`) REFERENCES `cliente` (`CI`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`ID_Categoria`) REFERENCES `categoria` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
