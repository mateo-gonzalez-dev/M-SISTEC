-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-12-2025 a las 00:29:10
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

CREATE DATABASE IF NOT EXISTS mg_suministros;
USE mg_suministros;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mg_suministros`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `abono`
--

CREATE TABLE `abono` (
  `id_abono` int(11) NOT NULL,
  `id_deuda` int(11) NOT NULL,
  `fecha_abono` date NOT NULL,
  `valor_abono` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL,
  `tipo_categoria` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `tipo_categoria`) VALUES
(1, 'Teclado'),
(2, 'Mouse'),
(3, 'Audifono'),
(4, 'Diadema'),
(5, 'Cargador'),
(6, 'Webcam'),
(7, 'Parlante'),
(8, 'Micrófono'),
(9, 'Adaptador'),
(10, 'Base Refrigeradora');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudad`
--

CREATE TABLE `ciudad` (
  `id_ciudad` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `id_departamento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `ciudad`
--

INSERT INTO `ciudad` (`id_ciudad`, `nombre`, `id_departamento`) VALUES
(1, 'Bogotá', 2),
(2, 'Ciudad de México', 2),
(3, 'La Plata', 3),
(4, 'Madrid', 4),
(5, 'Santiago', 5),
(6, 'Lima', 6),
(7, 'São Paulo', 7),
(8, 'Toronto', 8),
(9, 'Múnich', 9),
(10, 'Tokio', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `id_compra` int(11) NOT NULL,
  `fecha_compra` date NOT NULL,
  `valor_total` decimal(12,0) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `id_estado_factura` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`id_compra`, `fecha_compra`, `valor_total`, `id_vendedor`, `id_cliente`, `id_empresa`, `id_estado_factura`) VALUES
(1, '2024-07-20', 850000, 2, 6, 1, 1),
(2, '2024-07-21', 120000, 2, 7, 2, 1),
(3, '2024-07-22', 4500000, 2, 8, 3, 1),
(4, '2024-07-23', 95000, 2, 9, 1, 1),
(5, '2024-07-24', 2100000, 2, 6, 2, 1),
(6, '2024-07-25', 180000, 2, 7, 3, 1),
(7, '2024-07-26', 720000, 2, 8, 1, 1),
(8, '2024-07-27', 1500000, 2, 9, 2, 1),
(9, '2024-07-28', 500000, 2, 6, 3, 1),
(10, '2024-07-29', 290000, 2, 7, 1, 1),
(16, '2025-11-28', 1850000, 1, 6, 1, 1),
(17, '2025-11-28', 452000, 1, 8, 1, 1),
(18, '2025-11-28', 200000, 1, 6, 1, 1),
(19, '2025-11-28', 320000, 1, 6, 1, 1),
(20, '2025-11-28', 400000, 1, 6, 1, 1),
(21, '2025-11-29', 6600000, 1, 7, 1, 1),
(22, '2025-11-29', 1160000, 1, 8, 1, 2),
(23, '2025-11-30', 700000, 1, 7, 1, 2),
(24, '2025-12-02', 6600000, 1, 6, 1, 2),
(25, '2025-12-02', 1100000, 1, 6, 1, 1),
(26, '2025-12-02', 400000, 1, 7, 1, 2),
(27, '2025-12-03', 200000, 1, 6, 1, 1),
(28, '2025-12-04', 6600000, 1, 7, 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra_producto`
--

CREATE TABLE `compra_producto` (
  `id_compra_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(12,0) NOT NULL,
  `id_compra` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `compra_producto`
--

INSERT INTO `compra_producto` (`id_compra_producto`, `cantidad`, `precio_unitario`, `id_compra`, `id_producto`) VALUES
(1, 2, 425000, 1, 1),
(2, 3, 40000, 2, 2),
(3, 1, 4500000, 3, 3),
(4, 5, 19000, 4, 4),
(5, 2, 1050000, 5, 5),
(6, 4, 45000, 6, 6),
(7, 12, 60000, 7, 7),
(8, 1, 1500000, 8, 8),
(9, 10, 50000, 9, 9),
(10, 1, 290000, 10, 10),
(11, 3, 550000, 16, 1),
(12, 4, 50000, 16, 2),
(13, 2, 190000, 17, 3),
(14, 1, 72000, 17, 15),
(15, 1, 200000, 18, 20),
(16, 2, 160000, 19, 8),
(17, 2, 200000, 20, 20),
(18, 12, 550000, 21, 1),
(19, 1, 60000, 22, 9),
(20, 2, 550000, 22, 1),
(21, 2, 350000, 23, 10),
(22, 12, 550000, 24, 1),
(23, 2, 550000, 25, 1),
(24, 2, 200000, 26, 20),
(25, 1, 200000, 27, 20),
(26, 12, 550000, 28, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cronograma`
--

CREATE TABLE `cronograma` (
  `id_cronograma` int(11) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `descripcion_crono` varchar(100) DEFAULT NULL,
  `fecha_crono` date NOT NULL,
  `id_empresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `cronograma`
--

INSERT INTO `cronograma` (`id_cronograma`, `nombre`, `descripcion_crono`, `fecha_crono`, `id_empresa`) VALUES
(1, 'Pago Nómina', 'Pago de sueldos y salarios a todos los empleados', '2024-08-25', 1),
(2, 'Revisión de Inventario', 'Conteo físico y revisión del stock de productos', '2024-09-05', 2),
(3, 'Impuestos Trimestrales', 'Presentación y pago de impuestos correspondientes al trimestre', '2024-09-15', 1),
(4, 'Auditoría Interna', 'Revisión de procesos financieros y operativos', '2024-10-01', 2),
(5, 'Pago a Proveedores', NULL, '2024-10-10', 1),
(6, 'Mantenimiento de Servidores', 'Mantenimiento y actualización de los sistemas informáticos', '2024-10-20', 2),
(7, 'Cierre Contable Anual', NULL, '2024-12-31', 1),
(8, 'Reunión de Estrategia', 'Análisis de resultados y planificación del próximo año', '2024-11-01', 2),
(9, 'Capacitación del Personal', NULL, '2024-11-15', 1),
(10, 'Renovación de Licencias de Software', 'Renovación de licencias de programas clave de la empresa', '2024-12-05', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `id_departamento` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `id_pais` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`id_departamento`, `nombre`, `id_pais`) VALUES
(1, 'Cundinamarca', 9),
(2, 'Ciudad de México', 2),
(3, 'Provincia de Buenos Aires', 3),
(4, 'Comunidad de Madrid', 4),
(5, 'Región Metropolitana de Santia', 5),
(6, 'Lima', 6),
(7, 'São Paulo', 7),
(8, 'Ontario', 8),
(9, 'Baviera', 9),
(10, 'Tokio', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `deuda`
--

CREATE TABLE `deuda` (
  `id_deuda` int(11) NOT NULL,
  `fecha_compra` date NOT NULL,
  `valor_deuda` decimal(12,0) NOT NULL,
  `saldo_pendiente` decimal(12,0) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_compra` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `deuda`
--

INSERT INTO `deuda` (`id_deuda`, `fecha_compra`, `valor_deuda`, `saldo_pendiente`, `id_cliente`, `id_compra`) VALUES
(1, '2024-07-20', 850000, 700000, 2, 1),
(2, '2024-07-21', 120000, 50000, 3, 2),
(3, '2024-07-22', 4500000, 4200000, 5, 3),
(4, '2024-07-23', 95000, 45000, 7, 4),
(5, '2024-07-24', 2100000, 1850000, 9, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direccion`
--

CREATE TABLE `direccion` (
  `id_direccion` int(11) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `id_ciudad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `direccion`
--

INSERT INTO `direccion` (`id_direccion`, `direccion`, `id_ciudad`) VALUES
(1, 'Carrera 7 # 26 - 54, Centro, Bogotá', 1),
(2, 'Avenida Insurgentes Sur 2375, Roma Norte, Ciudad de México', 2),
(3, 'Calle 51 # 740, La Loma, La Plata', 3),
(4, 'Paseo del Prado 2, Centro, Madrid', 4),
(5, 'Avenida Libertador Bernardo O\'Higgins 1146, Santiago Centro, Santiago', 5),
(6, 'Avenida Larco 789, Miraflores, Lima', 6),
(7, 'Avenida Paulista 157, Bela Vista, São Paulo', 7),
(8, 'Yonge Street 220, Downtown, Toronto', 8),
(9, 'Marienplatz 1, Altstadt, Múnich', 9),
(10, 'Shibuya Crossing 1-1, Shibuya, Tokio', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `id_empresa` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `id_tipo_identidad` int(11) NOT NULL,
  `id_tipo_documento` int(11) DEFAULT NULL,
  `numero_identificacion` varchar(30) NOT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `id_ciudad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`id_empresa`, `nombre`, `id_tipo_identidad`, `id_tipo_documento`, `numero_identificacion`, `direccion`, `id_ciudad`) VALUES
(1, 'MG Suministros', 1, 3, '800123456', '0', 1),
(2, 'Mexicana de Electrónicos S.A. de C.V.', 1, 3, 'MEC001', '0', 2),
(3, 'Productos Informáticos del Sur', 1, 3, '2045678912', '0', 3),
(5, 'Importadora Chilena Ltda.', 1, 3, '76543210-9', '0', 5),
(6, 'Andean Computing', 1, 3, '987654321', '0', 6),
(7, 'BrasilTec Sistemas', 1, 3, '01234567890123', '0', 7),
(8, 'North America PC Solutions', 1, 3, 'NA789', '0', 8),
(9, 'Deutsche Elektronik GmbH', 1, 3, 'DE987654', '0', 9),
(10, 'Asia Pacific Tech', 1, 3, 'JP101112', '0', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_factura`
--

CREATE TABLE `estado_factura` (
  `id_estado` int(11) NOT NULL,
  `nombre_estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `estado_factura`
--

INSERT INTO `estado_factura` (`id_estado`, `nombre_estado`) VALUES
(1, 'Vigente'),
(2, 'Anulada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

CREATE TABLE `marca` (
  `id_marca` int(11) NOT NULL,
  `nombre_marca` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `marca`
--

INSERT INTO `marca` (`id_marca`, `nombre_marca`) VALUES
(1, 'Logitech'),
(2, 'VirtualTronic'),
(3, 'Genius'),
(4, 'GX Gaming'),
(5, 'Lenovo'),
(6, 'HP'),
(7, 'Dell'),
(8, 'Acer'),
(9, 'Razer'),
(10, 'Samsung');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pais`
--

CREATE TABLE `pais` (
  `id_pais` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `pais`
--

INSERT INTO `pais` (`id_pais`, `nombre`) VALUES
(1, 'Colombia'),
(2, 'México'),
(3, 'Argentina'),
(4, 'España'),
(5, 'Chile'),
(6, 'Perú'),
(7, 'Brasil'),
(8, 'Canadá'),
(9, 'Alemania'),
(10, 'Japón');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `id_persona` int(11) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `id_tipo_identidad` int(11) DEFAULT NULL,
  `id_tipo_documento` int(11) NOT NULL,
  `numero_documento` varchar(40) DEFAULT NULL,
  `correo_electronico` varchar(50) DEFAULT NULL,
  `contrasena` varchar(40) DEFAULT NULL,
  `id_rol` int(11) DEFAULT NULL,
  `direccion` varchar(40) DEFAULT NULL,
  `ciudad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`id_persona`, `nombre`, `id_tipo_identidad`, `id_tipo_documento`, `numero_documento`, `correo_electronico`, `contrasena`, `id_rol`, `direccion`, `ciudad`) VALUES
(1, 'Mateo Gonzalez', 1, 1, '1010123456', 'mateog@gmail.com', '123456', 1, 'Calle 10 #12-34', 1),
(2, 'Maria Rodríguez', 1, 2, '900555888-1', 'maria.rodriguez@empresa.com', 'maria20', 2, 'Carrera 5 #20-15', 2),
(3, 'Chizpazo', 2, 3, 'A12345678', 'chizpazotunja08@gmail.com', 'chipza01', 3, 'Avenida 30 #45-21', 3),
(4, 'Laura Gómez', 1, 2, '1123456789', 'laura.gomez@email.com', 'laura89', 3, 'Calle 8 #14-10', 4),
(5, 'Ricardo Soto', 1, 5, '1012345678', 'ricardo.soto@email.com', 'rsoto55', 3, 'Diagonal 22 #18-09', 5),
(6, 'Paula Montoya', 1, 1, '900111222-3', 'paula.montoya@email.com', 'pmontoya7', 4, 'Transversal 9 #33-01', 6),
(7, 'Roberto Hernández', 1, 1, '123456', 'roberto.h@email.com', 'roberto1', 4, 'Carrera 12 #7-40', 7),
(8, 'Sofía Vargas', 1, 2, '1017890123', 'sofia.vargas@email.com', 'sofia22', 4, 'Calle 25 #16-02', 8),
(9, 'Javier Torres', 1, 4, 'B98765432', 'javier.torres@email.com', 'jtorres9', 4, 'Avenida Central #50-12', 9),
(10, 'Ana Castillo', 1, 1, '900333444-5', 'ana.castillo@empresa.com', 'ana2023', 3, 'Calle 3 #9-77', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_marca` int(11) NOT NULL,
  `referencia` varchar(50) NOT NULL,
  `stock` int(11) NOT NULL,
  `precio_compra` decimal(10,2) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL,
  `id_proveedor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `id_categoria`, `id_marca`, `referencia`, `stock`, `precio_compra`, `precio_venta`, `id_proveedor`) VALUES
(1, 1, 1, 'KB-LOG-001', 107, 400000.00, 550000.00, 5),
(2, 2, 9, 'M-RAZ-003', 76, 35000.00, 50000.00, 3),
(3, 3, 3, 'AUD-GEN-003', 198, 150000.00, 190000.00, 5),
(4, 4, 4, 'DIA-GXG-004', 120, 18000.00, 30000.00, 10),
(5, 5, 10, 'CAR-SAM-005', 300, 80000.00, 110000.00, 5),
(6, 6, 6, 'WBC-HP-006', 90, 100000.00, 140000.00, 10),
(7, 7, 8, 'PAR-ACE-007', 110, 45000.00, 65000.00, 5),
(8, 8, 1, 'MIC-LOG-008', 73, 120000.00, 160000.00, 10),
(9, 9, 5, 'ADAP-LEN-009', 249, 40000.00, 60000.00, 5),
(10, 10, 7, 'BASE-DEL-010', 58, 250000.00, 350000.00, 10),
(11, 1, 1, 'KB-LOG-001', 150, 140000.00, 200000.00, 5),
(12, 2, 9, 'M-RAZ-002', 80, 240000.00, 380000.00, 10),
(13, 3, 3, 'AUD-GEN-003', 200, 60000.00, 100000.00, 5),
(14, 4, 4, 'DIA-GXG-004', 120, 100000.00, 180000.00, 10),
(15, 5, 10, 'CAR-SAM-005', 299, 40000.00, 72000.00, 5),
(16, 6, 6, 'WBC-HP-006', 90, 180000.00, 280000.00, 10),
(17, 7, 8, 'PAR-ACE-007', 110, 80000.00, 140000.00, 5),
(18, 8, 1, 'MIC-LOG-008', 75, 112000.00, 160000.00, 10),
(20, 10, 7, 'BASE-DEL-010', 54, 120000.00, 200000.00, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL,
  `nombre_rol` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `nombre_rol`) VALUES
(1, 'Administrador'),
(2, 'Vendedor'),
(3, 'Proveedor'),
(4, 'Cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento`
--

CREATE TABLE `tipo_documento` (
  `id_tipo_documento` int(11) NOT NULL,
  `tipo_documento` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `tipo_documento`
--

INSERT INTO `tipo_documento` (`id_tipo_documento`, `tipo_documento`) VALUES
(1, 'Cédula de Ciudadanía'),
(2, 'Cédula de Extranjería'),
(3, 'NIT'),
(4, 'Pasaporte'),
(5, 'Tarjeta de Identidad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_identidad`
--

CREATE TABLE `tipo_identidad` (
  `id_tipo_identidad` int(11) NOT NULL,
  `tipo_identidad` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `tipo_identidad`
--

INSERT INTO `tipo_identidad` (`id_tipo_identidad`, `tipo_identidad`) VALUES
(1, 'Natural'),
(2, 'Juridico');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `abono`
--
ALTER TABLE `abono`
  ADD PRIMARY KEY (`id_abono`),
  ADD KEY `idx_abono_deuda` (`id_deuda`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  ADD PRIMARY KEY (`id_ciudad`),
  ADD KEY `idx_ciudad_departamento` (`id_departamento`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id_compra`),
  ADD KEY `idx_compra_vendedor` (`id_vendedor`),
  ADD KEY `idx_compra_cliente` (`id_cliente`),
  ADD KEY `idx_compra_empresa` (`id_empresa`),
  ADD KEY `fk_estado_factura` (`id_estado_factura`);

--
-- Indices de la tabla `compra_producto`
--
ALTER TABLE `compra_producto`
  ADD PRIMARY KEY (`id_compra_producto`),
  ADD KEY `idx_cp_compra` (`id_compra`),
  ADD KEY `idx_cp_producto` (`id_producto`);

--
-- Indices de la tabla `cronograma`
--
ALTER TABLE `cronograma`
  ADD PRIMARY KEY (`id_cronograma`),
  ADD KEY `idx_cronograma_empresa` (`id_empresa`);

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`id_departamento`),
  ADD KEY `idx_departamento_pais` (`id_pais`);

--
-- Indices de la tabla `deuda`
--
ALTER TABLE `deuda`
  ADD PRIMARY KEY (`id_deuda`),
  ADD KEY `idx_deuda_cliente` (`id_cliente`),
  ADD KEY `idx_deuda_compra` (`id_compra`);

--
-- Indices de la tabla `direccion`
--
ALTER TABLE `direccion`
  ADD PRIMARY KEY (`id_direccion`),
  ADD KEY `idx_direccion_ciudad` (`id_ciudad`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id_empresa`),
  ADD KEY `idx_empresa_tipo_identidad` (`id_tipo_identidad`),
  ADD KEY `idx_empresa_direccion` (`direccion`),
  ADD KEY `fk_empresa_tipo_documento` (`id_tipo_documento`),
  ADD KEY `fk_empresa_ciudad` (`id_ciudad`);

--
-- Indices de la tabla `estado_factura`
--
ALTER TABLE `estado_factura`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`id_marca`);

--
-- Indices de la tabla `pais`
--
ALTER TABLE `pais`
  ADD PRIMARY KEY (`id_pais`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id_persona`),
  ADD KEY `idx_persona_tipo_documento` (`id_tipo_documento`),
  ADD KEY `idx_persona_tipo_identidad` (`id_tipo_identidad`),
  ADD KEY `idx_persona_direccion` (`direccion`),
  ADD KEY `fk_persona_rol` (`id_rol`),
  ADD KEY `fk_persona_ciudad` (`ciudad`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `idx_producto_categoria` (`id_categoria`),
  ADD KEY `idx_producto_marca` (`id_marca`),
  ADD KEY `idx_producto_proveedor` (`id_proveedor`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  ADD PRIMARY KEY (`id_tipo_documento`);

--
-- Indices de la tabla `tipo_identidad`
--
ALTER TABLE `tipo_identidad`
  ADD PRIMARY KEY (`id_tipo_identidad`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `abono`
--
ALTER TABLE `abono`
  MODIFY `id_abono` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  MODIFY `id_ciudad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `compra_producto`
--
ALTER TABLE `compra_producto`
  MODIFY `id_compra_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `cronograma`
--
ALTER TABLE `cronograma`
  MODIFY `id_cronograma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `id_departamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `deuda`
--
ALTER TABLE `deuda`
  MODIFY `id_deuda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `direccion`
--
ALTER TABLE `direccion`
  MODIFY `id_direccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id_empresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `estado_factura`
--
ALTER TABLE `estado_factura`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `marca`
--
ALTER TABLE `marca`
  MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `pais`
--
ALTER TABLE `pais`
  MODIFY `id_pais` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id_persona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  MODIFY `id_tipo_documento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipo_identidad`
--
ALTER TABLE `tipo_identidad`
  MODIFY `id_tipo_identidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `abono`
--
ALTER TABLE `abono`
  ADD CONSTRAINT `fk_abono_deuda` FOREIGN KEY (`id_deuda`) REFERENCES `deuda` (`id_deuda`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `ciudad`
--
ALTER TABLE `ciudad`
  ADD CONSTRAINT `fk_ciudad_departamento` FOREIGN KEY (`id_departamento`) REFERENCES `departamento` (`id_departamento`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `fk_compra_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `persona` (`id_persona`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_compra_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_compra_vendedor` FOREIGN KEY (`id_vendedor`) REFERENCES `persona` (`id_persona`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_estado_factura` FOREIGN KEY (`id_estado_factura`) REFERENCES `estado_factura` (`id_estado`);

--
-- Filtros para la tabla `compra_producto`
--
ALTER TABLE `compra_producto`
  ADD CONSTRAINT `fk_compra_producto_compra` FOREIGN KEY (`id_compra`) REFERENCES `compra` (`id_compra`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_compra_producto_producto` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `cronograma`
--
ALTER TABLE `cronograma`
  ADD CONSTRAINT `fk_cronograma_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD CONSTRAINT `fk_departamento_pais` FOREIGN KEY (`id_pais`) REFERENCES `pais` (`id_pais`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `deuda`
--
ALTER TABLE `deuda`
  ADD CONSTRAINT `fk_deuda_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `persona` (`id_persona`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_deuda_compra` FOREIGN KEY (`id_compra`) REFERENCES `compra` (`id_compra`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `direccion`
--
ALTER TABLE `direccion`
  ADD CONSTRAINT `fk_direccion_ciudad` FOREIGN KEY (`id_ciudad`) REFERENCES `ciudad` (`id_ciudad`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD CONSTRAINT `fk_empresa_ciudad` FOREIGN KEY (`id_ciudad`) REFERENCES `ciudad` (`id_ciudad`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_empresa_tipo_documento` FOREIGN KEY (`id_tipo_documento`) REFERENCES `tipo_documento` (`id_tipo_documento`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_empresa_tipo_identidad` FOREIGN KEY (`id_tipo_identidad`) REFERENCES `tipo_identidad` (`id_tipo_identidad`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `persona`
--
ALTER TABLE `persona`
  ADD CONSTRAINT `fk_persona_ciudad` FOREIGN KEY (`ciudad`) REFERENCES `ciudad` (`id_ciudad`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_persona_rol` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`),
  ADD CONSTRAINT `fk_persona_tipo_documento` FOREIGN KEY (`id_tipo_documento`) REFERENCES `tipo_documento` (`id_tipo_documento`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_persona_tipo_identidad` FOREIGN KEY (`id_tipo_identidad`) REFERENCES `tipo_identidad` (`id_tipo_identidad`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_producto_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_producto_marca` FOREIGN KEY (`id_marca`) REFERENCES `marca` (`id_marca`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_producto_proveedor` FOREIGN KEY (`id_proveedor`) REFERENCES `persona` (`id_persona`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
