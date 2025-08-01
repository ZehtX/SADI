-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-08-2025 a las 09:35:47
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
-- Base de datos: `SADI`
--
CREATE DATABASE `SADI`;
-- --------------------------------------------------------
USE `SADI`;
--
-- Estructura de tabla para la tabla `categoria_materia_prima`
--

CREATE TABLE `categoria_materia_prima` (
  `PK_ID` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_producto`
--

CREATE TABLE `categoria_producto` (
  `PK_ID` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `PK_ID` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Direccion_Fiscal` varchar(255) DEFAULT NULL,
  `Rif_Cedula` varchar(20) DEFAULT NULL,
  `Telefono` varchar(20) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Tipo_Cliente` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle`
--

CREATE TABLE `detalle` (
  `PK_ID` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `Precio_Unitario` decimal(10,2) NOT NULL,
  `Subtotal` decimal(10,2) NOT NULL,
  `FK_ID_Factura` int(11) NOT NULL,
  `FK_ID_Producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--

CREATE TABLE `detalle_compra` (
  `PK_ID` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `Precio_Compra` decimal(10,2) DEFAULT NULL,
  `FK_ID_Orden_Compra` int(11) NOT NULL,
  `FK_ID_Materia_Prima` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `PK_ID` int(11) NOT NULL,
  `Numero_Factura` varchar(50) NOT NULL,
  `Fecha` date NOT NULL,
  `Total` decimal(10,2) NOT NULL,
  `Status` varchar(50) NOT NULL,
  `FK_ID_Cliente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forma_pago`
--

CREATE TABLE `forma_pago` (
  `PK_ID` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materia_prima`
--

CREATE TABLE `materia_prima` (
  `PK_ID` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Stock` int(11) NOT NULL,
  `Stock_Minimo` int(11) DEFAULT NULL,
  `Precio_Costo` decimal(10,2) DEFAULT NULL,
  `Unidad_Medida` varchar(50) DEFAULT NULL,
  `FK_ID_Categoria_Mat_Prima` int(11) NOT NULL,
  `FK_ID_Proveedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimiento_inventario`
--

CREATE TABLE `movimiento_inventario` (
  `PK_ID` int(11) NOT NULL,
  `Tipo` varchar(50) NOT NULL,
  `Fecha` date NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `FK_ID_Materia_Prima` int(11) NOT NULL,
  `FK_ID_Usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nota_credito`
--

CREATE TABLE `nota_credito` (
  `PK_ID` int(11) NOT NULL,
  `Numero_Nota` varchar(50) NOT NULL,
  `Fecha` date NOT NULL,
  `Monto_Total` decimal(10,2) NOT NULL,
  `FK_ID_Factura` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nota_entrega`
--

CREATE TABLE `nota_entrega` (
  `PK_ID` int(11) NOT NULL,
  `Numero_Nota` varchar(50) NOT NULL,
  `Fecha_Emision` date NOT NULL,
  `Direccion_Despacho` varchar(255) DEFAULT NULL,
  `FK_ID_Cliente` int(11) NOT NULL,
  `FK_ID_Factura` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_compra`
--

CREATE TABLE `orden_compra` (
  `PK_ID` int(11) NOT NULL,
  `Fecha_Emision` date NOT NULL,
  `Fecha_Entrega_Est` datetime DEFAULT NULL,
  `Monto_Total` decimal(10,2) DEFAULT NULL,
  `FK_ID_Proveedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago_factura`
--

CREATE TABLE `pago_factura` (
  `PK_ID` int(11) NOT NULL,
  `Monto` decimal(10,2) NOT NULL,
  `Fecha_Pago` date NOT NULL,
  `FK_ID_Factura` int(11) NOT NULL,
  `FK_ID_Forma_Pago` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presupuesto`
--

CREATE TABLE `presupuesto` (
  `PK_ID` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Direccion` varchar(255) DEFAULT NULL,
  `Telefono` varchar(20) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Fecha_Llegada` date DEFAULT NULL,
  `Fecha_Salida` date DEFAULT NULL,
  `FK_ID_Factura` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `PK_ID` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Stock` int(11) NOT NULL,
  `Stock_Minimo` int(11) DEFAULT NULL,
  `Precio_Costo` decimal(10,2) DEFAULT NULL,
  `Precio_Venta` decimal(10,2) DEFAULT NULL,
  `FK_ID_Categoria_Prod` int(11) NOT NULL,
  `FK_ID_Proveedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `PK_ID` int(11) NOT NULL,
  `Nombre_Comercial` varchar(100) NOT NULL,
  `Nombre_Fiscal` varchar(100) DEFAULT NULL,
  `Rif` varchar(20) DEFAULT NULL,
  `Telefono` varchar(20) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Direccion_Fiscal` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `PK_ID` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `PK_ID` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `FK_ID_Rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria_materia_prima`
--
ALTER TABLE `categoria_materia_prima`
  ADD PRIMARY KEY (`PK_ID`);

--
-- Indices de la tabla `categoria_producto`
--
ALTER TABLE `categoria_producto`
  ADD PRIMARY KEY (`PK_ID`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`PK_ID`),
  ADD UNIQUE KEY `Rif_Cedula` (`Rif_Cedula`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indices de la tabla `detalle`
--
ALTER TABLE `detalle`
  ADD PRIMARY KEY (`PK_ID`),
  ADD KEY `FK_ID_Factura` (`FK_ID_Factura`),
  ADD KEY `FK_ID_Producto` (`FK_ID_Producto`);

--
-- Indices de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD PRIMARY KEY (`PK_ID`),
  ADD KEY `FK_ID_Orden_Compra` (`FK_ID_Orden_Compra`),
  ADD KEY `FK_ID_Materia_Prima` (`FK_ID_Materia_Prima`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`PK_ID`),
  ADD UNIQUE KEY `Numero_Factura` (`Numero_Factura`),
  ADD KEY `FK_ID_Cliente` (`FK_ID_Cliente`);

--
-- Indices de la tabla `forma_pago`
--
ALTER TABLE `forma_pago`
  ADD PRIMARY KEY (`PK_ID`);

--
-- Indices de la tabla `materia_prima`
--
ALTER TABLE `materia_prima`
  ADD PRIMARY KEY (`PK_ID`),
  ADD KEY `FK_ID_Categoria_Mat_Prima` (`FK_ID_Categoria_Mat_Prima`),
  ADD KEY `FK_ID_Proveedor` (`FK_ID_Proveedor`);

--
-- Indices de la tabla `movimiento_inventario`
--
ALTER TABLE `movimiento_inventario`
  ADD PRIMARY KEY (`PK_ID`),
  ADD KEY `FK_ID_Materia_Prima` (`FK_ID_Materia_Prima`),
  ADD KEY `FK_ID_Usuario` (`FK_ID_Usuario`);

--
-- Indices de la tabla `nota_credito`
--
ALTER TABLE `nota_credito`
  ADD PRIMARY KEY (`PK_ID`),
  ADD UNIQUE KEY `Numero_Nota` (`Numero_Nota`),
  ADD KEY `FK_ID_Factura` (`FK_ID_Factura`);

--
-- Indices de la tabla `nota_entrega`
--
ALTER TABLE `nota_entrega`
  ADD PRIMARY KEY (`PK_ID`),
  ADD UNIQUE KEY `Numero_Nota` (`Numero_Nota`),
  ADD KEY `FK_ID_Cliente` (`FK_ID_Cliente`),
  ADD KEY `FK_ID_Factura` (`FK_ID_Factura`);

--
-- Indices de la tabla `orden_compra`
--
ALTER TABLE `orden_compra`
  ADD PRIMARY KEY (`PK_ID`),
  ADD KEY `FK_ID_Proveedor` (`FK_ID_Proveedor`);

--
-- Indices de la tabla `pago_factura`
--
ALTER TABLE `pago_factura`
  ADD PRIMARY KEY (`PK_ID`),
  ADD KEY `FK_ID_Factura` (`FK_ID_Factura`),
  ADD KEY `FK_ID_Forma_Pago` (`FK_ID_Forma_Pago`);

--
-- Indices de la tabla `presupuesto`
--
ALTER TABLE `presupuesto`
  ADD PRIMARY KEY (`PK_ID`),
  ADD KEY `FK_ID_Factura` (`FK_ID_Factura`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`PK_ID`),
  ADD KEY `FK_ID_Categoria_Prod` (`FK_ID_Categoria_Prod`),
  ADD KEY `FK_ID_Proveedor` (`FK_ID_Proveedor`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`PK_ID`),
  ADD UNIQUE KEY `Rif` (`Rif`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`PK_ID`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`PK_ID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `FK_ID_Rol` (`FK_ID_Rol`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle`
--
ALTER TABLE `detalle`
  ADD CONSTRAINT `detalle_ibfk_1` FOREIGN KEY (`FK_ID_Factura`) REFERENCES `factura` (`PK_ID`),
  ADD CONSTRAINT `detalle_ibfk_2` FOREIGN KEY (`FK_ID_Producto`) REFERENCES `producto` (`PK_ID`);

--
-- Filtros para la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD CONSTRAINT `detalle_compra_ibfk_1` FOREIGN KEY (`FK_ID_Orden_Compra`) REFERENCES `orden_compra` (`PK_ID`),
  ADD CONSTRAINT `detalle_compra_ibfk_2` FOREIGN KEY (`FK_ID_Materia_Prima`) REFERENCES `materia_prima` (`PK_ID`);

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`FK_ID_Cliente`) REFERENCES `cliente` (`PK_ID`);

--
-- Filtros para la tabla `materia_prima`
--
ALTER TABLE `materia_prima`
  ADD CONSTRAINT `materia_prima_ibfk_1` FOREIGN KEY (`FK_ID_Categoria_Mat_Prima`) REFERENCES `categoria_materia_prima` (`PK_ID`),
  ADD CONSTRAINT `materia_prima_ibfk_2` FOREIGN KEY (`FK_ID_Proveedor`) REFERENCES `proveedor` (`PK_ID`);

--
-- Filtros para la tabla `movimiento_inventario`
--
ALTER TABLE `movimiento_inventario`
  ADD CONSTRAINT `movimiento_inventario_ibfk_1` FOREIGN KEY (`FK_ID_Materia_Prima`) REFERENCES `materia_prima` (`PK_ID`),
  ADD CONSTRAINT `movimiento_inventario_ibfk_2` FOREIGN KEY (`FK_ID_Usuario`) REFERENCES `usuario` (`PK_ID`);

--
-- Filtros para la tabla `nota_credito`
--
ALTER TABLE `nota_credito`
  ADD CONSTRAINT `nota_credito_ibfk_1` FOREIGN KEY (`FK_ID_Factura`) REFERENCES `factura` (`PK_ID`);

--
-- Filtros para la tabla `nota_entrega`
--
ALTER TABLE `nota_entrega`
  ADD CONSTRAINT `nota_entrega_ibfk_1` FOREIGN KEY (`FK_ID_Cliente`) REFERENCES `cliente` (`PK_ID`),
  ADD CONSTRAINT `nota_entrega_ibfk_2` FOREIGN KEY (`FK_ID_Factura`) REFERENCES `factura` (`PK_ID`);

--
-- Filtros para la tabla `orden_compra`
--
ALTER TABLE `orden_compra`
  ADD CONSTRAINT `orden_compra_ibfk_1` FOREIGN KEY (`FK_ID_Proveedor`) REFERENCES `proveedor` (`PK_ID`);

--
-- Filtros para la tabla `pago_factura`
--
ALTER TABLE `pago_factura`
  ADD CONSTRAINT `pago_factura_ibfk_1` FOREIGN KEY (`FK_ID_Factura`) REFERENCES `factura` (`PK_ID`),
  ADD CONSTRAINT `pago_factura_ibfk_2` FOREIGN KEY (`FK_ID_Forma_Pago`) REFERENCES `forma_pago` (`PK_ID`);

--
-- Filtros para la tabla `presupuesto`
--
ALTER TABLE `presupuesto`
  ADD CONSTRAINT `presupuesto_ibfk_1` FOREIGN KEY (`FK_ID_Factura`) REFERENCES `factura` (`PK_ID`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`FK_ID_Categoria_Prod`) REFERENCES `categoria_producto` (`PK_ID`),
  ADD CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`FK_ID_Proveedor`) REFERENCES `proveedor` (`PK_ID`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`FK_ID_Rol`) REFERENCES `rol` (`PK_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
