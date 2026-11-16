-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-11-2026 a las 19:32:49
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tecnohogar2_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id_compra` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_compra` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_recepcion` datetime DEFAULT NULL,
  `total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `estado` enum('Pendiente','Recibida','Cancelada') NOT NULL DEFAULT 'Pendiente',
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra_detalles`
--

CREATE TABLE `compra_detalles` (
  `id_detalle_compra` int(11) NOT NULL,
  `id_compra` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `costo_unitario` decimal(12,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `creditos`
--

CREATE TABLE `creditos` (
  `id_credito` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `monto_total` decimal(12,2) NOT NULL,
  `numero_cuotas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `creditos`
--

INSERT INTO `creditos` (`id_credito`, `id_pedido`, `monto_total`, `numero_cuotas`) VALUES
(1, 5, '1500000.00', 6),
(2, 12, '123123.00', 3),
(3, 14, '1000000.00', 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuotas_credito`
--

CREATE TABLE `cuotas_credito` (
  `id_cuota` int(11) NOT NULL,
  `id_credito` int(11) NOT NULL,
  `numero_cuota` int(11) NOT NULL,
  `monto_cuota` decimal(12,2) NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cuotas_credito`
--

INSERT INTO `cuotas_credito` (`id_cuota`, `id_credito`, `numero_cuota`, `monto_cuota`, `fecha_vencimiento`, `estado`) VALUES
(1, 1, 1, '250000.00', '2026-12-13', 2),
(2, 1, 2, '250000.00', '2027-01-13', 2),
(3, 1, 3, '250000.00', '2027-02-13', 2),
(4, 1, 4, '250000.00', '2027-03-13', 2),
(5, 1, 5, '250000.00', '2027-04-13', 2),
(6, 1, 6, '250000.00', '2027-05-13', 1),
(7, 2, 1, '41041.00', '2026-12-14', 1),
(8, 2, 2, '41041.00', '2027-01-14', 1),
(9, 2, 3, '41041.00', '2027-02-14', 1),
(10, 3, 1, '111111.11', '2026-12-14', 1),
(11, 3, 2, '111111.11', '2027-01-14', 1),
(12, 3, 3, '111111.11', '2027-02-14', 1),
(13, 3, 4, '111111.11', '2027-03-14', 1),
(14, 3, 5, '111111.11', '2027-04-14', 1),
(15, 3, 6, '111111.11', '2027-05-14', 1),
(16, 3, 7, '111111.11', '2027-06-14', 1),
(17, 3, 8, '111111.11', '2027-07-14', 1),
(18, 3, 9, '111111.12', '2027-08-14', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descuentos`
--

CREATE TABLE `descuentos` (
  `id_descuento` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `cupon` decimal(12,2) NOT NULL,
  `rango` decimal(12,2) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `descuentos`
--

INSERT INTO `descuentos` (`id_descuento`, `id_usuario`, `cupon`, `rango`, `estado`) VALUES
(1, 2, '200000.00', '2000000.00', 0),
(2, 2, '10000.00', '100000.00', 0),
(3, 3, '20000.00', '200000.00', 0),
(4, 3, '10000.00', '100000.00', 0),
(5, 3, '10000.00', '100000.00', 0),
(6, 3, '30000.00', '300000.00', 2),
(7, 3, '50000.00', '500000.00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `egresos`
--

CREATE TABLE `egresos` (
  `id_egreso` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `concepto` varchar(150) NOT NULL,
  `categoria` varchar(80) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `valor` decimal(12,2) NOT NULL,
  `fecha_egreso` date NOT NULL,
  `metodo_pago` varchar(50) NOT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `garantias`
--

CREATE TABLE `garantias` (
  `id_garantia` int(11) NOT NULL,
  `tipo` int(11) NOT NULL DEFAULT 1,
  `id_detalle` int(11) NOT NULL,
  `fecha_compra` date NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `estado_garantia` enum('Vigente','Vencida','En revision','Anulada') NOT NULL DEFAULT 'Vigente',
  `condiciones` text DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `garantias`
--

INSERT INTO `garantias` (`id_garantia`, `tipo`, `id_detalle`, `fecha_compra`, `fecha_inicio`, `fecha_vencimiento`, `estado_garantia`, `condiciones`, `observaciones`, `fecha_registro`) VALUES
(2, 1, 4, '2026-11-13', '2026-11-13', '2027-11-13', 'Vigente', NULL, NULL, '2026-11-13 21:44:47'),
(3, 1, 5, '2026-11-13', '2026-11-13', '2027-11-13', 'Vigente', NULL, NULL, '2026-11-13 21:57:44'),
(4, 1, 6, '2026-11-13', '2026-11-13', '2027-11-13', 'Vigente', NULL, NULL, '2026-11-13 23:28:26'),
(5, 1, 7, '2026-11-13', '2026-11-13', '2027-01-13', 'Vigente', NULL, NULL, '2026-11-13 23:37:56'),
(6, 1, 8, '2026-11-14', '2026-11-14', '2027-11-14', 'Vigente', NULL, NULL, '2026-11-14 00:39:17'),
(7, 1, 12, '2026-11-14', '2026-11-14', '2027-04-14', 'Vigente', NULL, NULL, '2026-11-14 09:39:33'),
(8, 1, 13, '2026-11-14', '2026-11-14', '2027-01-14', 'Vigente', NULL, NULL, '2026-11-14 10:00:33'),
(9, 1, 11, '2026-11-14', '2026-11-14', '2027-04-14', 'Vigente', NULL, NULL, '2026-11-14 10:11:42'),
(10, 1, 14, '2026-11-14', '2026-11-14', '2027-11-14', 'Vigente', NULL, NULL, '2026-11-14 10:11:43'),
(11, 1, 15, '2026-11-14', '2026-11-14', '2027-11-14', 'Vigente', NULL, NULL, '2026-11-14 10:12:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mantenimiento`
--

CREATE TABLE `mantenimiento` (
  `id_mantenimiento` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_tecnico` int(11) DEFAULT NULL,
  `tipo_servicio` tinyint(4) NOT NULL DEFAULT 2,
  `nombre_equipo` varchar(100) NOT NULL,
  `descripcion_problema` text NOT NULL,
  `diagnostico` text DEFAULT NULL,
  `mano_obra` decimal(12,2) NOT NULL DEFAULT 0.00,
  `costo_repuestos` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `fecha_ingreso` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_entrega` datetime DEFAULT NULL,
  `garantia` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mantenimiento`
--

INSERT INTO `mantenimiento` (`id_mantenimiento`, `id_usuario`, `id_tecnico`, `tipo_servicio`, `nombre_equipo`, `descripcion_problema`, `diagnostico`, `mano_obra`, `costo_repuestos`, `total`, `fecha_ingreso`, `fecha_entrega`, `garantia`) VALUES
(2, 5, NULL, 1, 'Vidrio Templado de prueba', 'Solicitud integral de servicio tecnico Codex', NULL, '0.00', '0.00', '0.00', '2026-11-14 09:42:38', NULL, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodo_pago`
--

CREATE TABLE `metodo_pago` (
  `id_metodo` int(11) NOT NULL,
  `nombre_metodo` varchar(60) NOT NULL,
  `estado` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `metodo_pago`
--

INSERT INTO `metodo_pago` (`id_metodo`, `nombre_metodo`, `estado`) VALUES
(1, 'Efectivo', 1),
(2, 'Transferencia / Consignación', 1),
(3, 'Débito', 1),
(4, 'Crédito', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id_pago` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_cuota` int(11) DEFAULT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `monto` decimal(12,2) NOT NULL,
  `estado` varchar(30) NOT NULL,
  `comprobante` varchar(255) DEFAULT NULL,
  `id_metodo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id_pago`, `id_pedido`, `id_cuota`, `fecha`, `monto`, `estado`, `comprobante`, `id_metodo`) VALUES
(1, 5, NULL, '2026-11-13 21:57:44', '500000.00', 'Aprobado', NULL, 1),
(2, 5, 1, '2026-11-13 22:23:10', '250000.00', 'Aprobado', '123213123123', 1),
(3, 5, 2, '2026-11-13 22:23:29', '250000.00', 'Aprobado', '12312312412412', 2),
(4, 5, 3, '2026-11-13 22:24:06', '250000.00', 'Aprobado', '', 1),
(5, 5, 4, '2026-11-13 22:24:44', '250000.00', 'Aprobado', '', 1),
(6, 5, 5, '2026-11-13 22:28:35', '250000.00', 'Aprobado', '', 1),
(7, 6, NULL, '2026-11-13 23:28:26', '2000000.00', 'Aprobado', NULL, 1),
(8, 7, NULL, '2026-11-13 23:37:56', '210000.00', 'Aprobado', NULL, 1),
(9, 8, NULL, '2026-11-14 00:39:17', '980000.00', 'Aprobado', NULL, 1),
(10, 13, NULL, '2026-11-14 10:00:33', '270000.00', 'Aprobado', NULL, 1),
(11, 11, NULL, '2026-11-14 10:11:43', '2369369.00', 'Pendiente', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `id_usuario` int(11) NOT NULL,
  `id_descuento` int(11) DEFAULT NULL,
  `descuento_aplicado` decimal(12,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id_pedido`, `estado`, `fecha`, `total`, `id_usuario`, `id_descuento`, `descuento_aplicado`) VALUES
(2, 0, '2026-11-13 18:58:52', '60000.00', 2, NULL, '0.00'),
(3, 0, '2026-11-13 21:13:22', '2000000.00', 2, NULL, '0.00'),
(4, 0, '2026-11-13 21:44:47', '1000000.00', 2, NULL, '0.00'),
(5, 0, '2026-11-13 21:57:44', '2000000.00', 2, NULL, '0.00'),
(6, 0, '2026-11-13 23:28:26', '2000000.00', 3, NULL, '0.00'),
(7, 0, '2026-11-13 23:37:56', '210000.00', 3, NULL, '0.00'),
(8, 0, '2026-11-14 00:39:17', '980000.00', 3, 3, '20000.00'),
(9, 2, '2026-11-14 07:54:05', '2000000.00', 4, NULL, '0.00'),
(10, 2, '2026-11-14 08:25:39', '492492.00', 4, NULL, '0.00'),
(11, 2, '2026-11-14 10:11:42', '2369369.00', 4, NULL, '0.00'),
(12, 4, '2026-11-14 09:39:33', '123123.00', 5, NULL, '0.00'),
(13, 4, '2026-11-14 10:00:33', '270000.00', 3, 6, '30000.00'),
(14, 4, '2026-11-14 10:12:19', '1000000.00', 4, NULL, '0.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_detalles`
--

CREATE TABLE `pedido_detalles` (
  `id_detalle` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(12,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `garantia` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido_detalles`
--

INSERT INTO `pedido_detalles` (`id_detalle`, `id_pedido`, `id_producto`, `cantidad`, `precio_unitario`, `subtotal`, `garantia`) VALUES
(2, 2, 2, 2, '30000.00', '60000.00', 0),
(3, 3, 3, 2, '1000000.00', '2000000.00', 0),
(4, 4, 3, 1, '1000000.00', '1000000.00', 12),
(5, 5, 3, 2, '1000000.00', '2000000.00', 12),
(6, 6, 3, 2, '1000000.00', '2000000.00', 12),
(7, 7, 2, 7, '30000.00', '210000.00', 2),
(8, 8, 3, 1, '1000000.00', '1000000.00', 12),
(9, 9, 3, 2, '1000000.00', '2000000.00', 12),
(10, 10, 4, 4, '123123.00', '492492.00', 5),
(11, 11, 4, 3, '123123.00', '369369.00', 5),
(12, 12, 4, 1, '123123.00', '123123.00', 5),
(13, 13, 2, 10, '30000.00', '300000.00', 2),
(14, 11, 3, 2, '1000000.00', '2000000.00', 12),
(15, 14, 3, 1, '1000000.00', '1000000.00', 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `nombre_producto` varchar(100) NOT NULL,
  `categoria` varchar(60) NOT NULL,
  `precio` decimal(12,2) NOT NULL,
  `modelo_detalle` text DEFAULT NULL,
  `garantia` int(11) NOT NULL DEFAULT 0,
  `cantidad` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre_producto`, `categoria`, `precio`, `modelo_detalle`, `garantia`, `cantidad`) VALUES
(2, 'Vidrio kiriku', 'Accesorio', '30000.00', 'Compatible con Samsung desde el A10 al A55', 2, 0),
(3, 'Samgsung A36', 'Celular', '1000000.00', 'Samgsung Galaxy A36 Modelo 2027', 12, 6),
(4, 'Vidrio Templado', 'Celular', '123123.00', 'asdasdasd', 5, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id_proveedor` int(11) NOT NULL,
  `nombre_proveedor` varchar(120) NOT NULL,
  `nit` varchar(30) DEFAULT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `departamento` varchar(100) DEFAULT NULL,
  `ciudad` varchar(100) DEFAULT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id_proveedor`, `nombre_proveedor`, `nit`, `celular`, `correo`, `departamento`, `ciudad`, `direccion`, `estado`, `fecha_registro`) VALUES
(1, 'mottttta', '1918271727', '3054579176', 'mariomottabetancurt@gmail.com', 'Antioquia', 'apartado', 'KR 81 97 A 12/16, CASA , 057841', 0, '2026-11-13 15:48:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `nombre_rol` varchar(50) NOT NULL,
  `descripcion` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `nombre_rol`, `descripcion`) VALUES
(1, 'Administrador', 'Gestiona y administra el sistema'),
(2, 'Vendedor', 'Registra ventas y atiende clientes'),
(3, 'Tecnico', 'Gestiona ordenes de servicio y reparaciones'),
(4, 'Cliente', 'Realiza compras y consulta sus servicios');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguimiento_mantenimiento`
--

CREATE TABLE `seguimiento_mantenimiento` (
  `id_seguimiento` int(11) NOT NULL,
  `id_mantenimiento` int(11) NOT NULL,
  `estado` varchar(40) NOT NULL,
  `detalle` text DEFAULT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `seguimiento_mantenimiento`
--

INSERT INTO `seguimiento_mantenimiento` (`id_seguimiento`, `id_mantenimiento`, `estado`, `detalle`, `fecha_registro`) VALUES
(1, 2, 'Recibido', 'Solicitud creada por el cliente.', '2026-11-14 09:42:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `id_rol` int(11) DEFAULT NULL,
  `nombre1` varchar(50) NOT NULL,
  `nombre2` varchar(50) DEFAULT NULL,
  `apellido1` varchar(50) NOT NULL,
  `apellido2` varchar(50) DEFAULT NULL,
  `celular` varchar(20) NOT NULL,
  `cedula` varchar(20) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `departamento` varchar(100) DEFAULT NULL,
  `ciudad` varchar(100) DEFAULT NULL,
  `barrio` varchar(100) DEFAULT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  `referencia` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `id_rol`, `nombre1`, `nombre2`, `apellido1`, `apellido2`, `celular`, `cedula`, `correo`, `contrasena`, `departamento`, `ciudad`, `barrio`, `direccion`, `referencia`) VALUES
(1, 1, 'Mario', 'Mario Andres', 'Motta', 'Betancurt', '3054579175', '1234567890', 'mario@gmail.com', '$2y$10$sLrxdM2j40REq2qQSOmXu.LjY.JuUEhkMKkNKddHFKi2uZR3diBdm', 'Antioquia', 'No', 'lopez', 'KR 81 97 A 12/16, CASA , 057841', 'holaa'),
(2, 3, 'Toji', 'totototo', 'asdasd', 'Betancurt', '124124124', '12312312', 'motta222@gmail.com', '$2y$10$m0Ygg3cVU95oaY1bKuEHV.5JnVzF8ZuXG7p2cUhC4yESVWsOCd6X6', 'Antioquia', 'apartado', 'lopez', 'KR 81 97 A 12/16, CASA , 057841', 'holaa'),
(3, 4, 'daasdas', 'dasdasdasd', 'asdasdasd1', 'asdasdasd', '12312312312', '3123123122', 'adasd@gmail.com', '$2y$10$cKrGZPdRjSUyrxorjk.NoeoF6E8112LPVYT7BYyDtTcXl7M610rrW', 'asdasda', 'sadasdasd', 'asdasdasd', 'dasdasdasd', 'asdasda'),
(4, 4, '23123123', '12312312', '3123123', '12312312', '3123123123', '312312312312', 'motta123@gmaill.com', '$2y$10$yQr13KCzRSXDiJRj9xJOke6.rfzxdAzcEJWYhUPz/z2qnFeTqm1dm', '312312312sa', 'dasdasdasd', 'asdasdas', 'dasdasd', 'asdasdasda'),
(5, 4, 'Cliente', 'Prueba', 'Codex', 'QA', '3000000001', '900000001', 'cliente.prueba.codex@tecnohogar.local', '$2y$10$7ShnjiUT1IZrB2btNoHog.qwFwT7.Dyu3ykRAlFwty.TmM4.dmhru', 'Antioquia', 'Medellin', 'Centro', 'Calle Prueba 124', 'Perfil actualizado en prueba');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id_compra`),
  ADD KEY `idx_compras_proveedor` (`id_proveedor`),
  ADD KEY `idx_compras_usuario` (`id_usuario`);

--
-- Indices de la tabla `compra_detalles`
--
ALTER TABLE `compra_detalles`
  ADD PRIMARY KEY (`id_detalle_compra`),
  ADD KEY `idx_detalles_compra` (`id_compra`),
  ADD KEY `idx_detalles_producto` (`id_producto`);

--
-- Indices de la tabla `creditos`
--
ALTER TABLE `creditos`
  ADD PRIMARY KEY (`id_credito`),
  ADD KEY `id_pedido` (`id_pedido`);

--
-- Indices de la tabla `cuotas_credito`
--
ALTER TABLE `cuotas_credito`
  ADD PRIMARY KEY (`id_cuota`),
  ADD UNIQUE KEY `uq_credito_numero_cuota` (`id_credito`,`numero_cuota`);

--
-- Indices de la tabla `descuentos`
--
ALTER TABLE `descuentos`
  ADD PRIMARY KEY (`id_descuento`);

--
-- Indices de la tabla `egresos`
--
ALTER TABLE `egresos`
  ADD PRIMARY KEY (`id_egreso`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `garantias`
--
ALTER TABLE `garantias`
  ADD PRIMARY KEY (`id_garantia`),
  ADD KEY `idx_garantias_detalle` (`id_detalle`);

--
-- Indices de la tabla `mantenimiento`
--
ALTER TABLE `mantenimiento`
  ADD PRIMARY KEY (`id_mantenimiento`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `garantia` (`garantia`);

--
-- Indices de la tabla `metodo_pago`
--
ALTER TABLE `metodo_pago`
  ADD PRIMARY KEY (`id_metodo`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id_pago`),
  ADD KEY `id_pedido` (`id_pedido`),
  ADD KEY `id_cuota` (`id_cuota`),
  ADD KEY `fk_pagos_metodo` (`id_metodo`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_descuento` (`id_descuento`);

--
-- Indices de la tabla `pedido_detalles`
--
ALTER TABLE `pedido_detalles`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_pedido` (`id_pedido`),
  ADD KEY `garantia` (`garantia`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id_proveedor`),
  ADD UNIQUE KEY `uk_proveedores_nit` (`nit`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `seguimiento_mantenimiento`
--
ALTER TABLE `seguimiento_mantenimiento`
  ADD PRIMARY KEY (`id_seguimiento`),
  ADD KEY `id_mantenimiento` (`id_mantenimiento`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `cedula` (`cedula`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `id_rol` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `compra_detalles`
--
ALTER TABLE `compra_detalles`
  MODIFY `id_detalle_compra` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `creditos`
--
ALTER TABLE `creditos`
  MODIFY `id_credito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cuotas_credito`
--
ALTER TABLE `cuotas_credito`
  MODIFY `id_cuota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `descuentos`
--
ALTER TABLE `descuentos`
  MODIFY `id_descuento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `egresos`
--
ALTER TABLE `egresos`
  MODIFY `id_egreso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `garantias`
--
ALTER TABLE `garantias`
  MODIFY `id_garantia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `mantenimiento`
--
ALTER TABLE `mantenimiento`
  MODIFY `id_mantenimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `metodo_pago`
--
ALTER TABLE `metodo_pago`
  MODIFY `id_metodo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `pedido_detalles`
--
ALTER TABLE `pedido_detalles`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `seguimiento_mantenimiento`
--
ALTER TABLE `seguimiento_mantenimiento`
  MODIFY `id_seguimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `fk_compras_proveedores` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_compras_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `compra_detalles`
--
ALTER TABLE `compra_detalles`
  ADD CONSTRAINT `fk_detalles_compras` FOREIGN KEY (`id_compra`) REFERENCES `compras` (`id_compra`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detalles_productos` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `creditos`
--
ALTER TABLE `creditos`
  ADD CONSTRAINT `creditos_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`);

--
-- Filtros para la tabla `cuotas_credito`
--
ALTER TABLE `cuotas_credito`
  ADD CONSTRAINT `cuotas_credito_ibfk_1` FOREIGN KEY (`id_credito`) REFERENCES `creditos` (`id_credito`);

--
-- Filtros para la tabla `egresos`
--
ALTER TABLE `egresos`
  ADD CONSTRAINT `egresos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `garantias`
--
ALTER TABLE `garantias`
  ADD CONSTRAINT `fk_garantias_detalle` FOREIGN KEY (`id_detalle`) REFERENCES `pedido_detalles` (`id_detalle`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `mantenimiento`
--
ALTER TABLE `mantenimiento`
  ADD CONSTRAINT `mantenimiento_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `mantenimiento_ibfk_2` FOREIGN KEY (`garantia`) REFERENCES `garantias` (`id_garantia`);

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `fk_pagos_metodo` FOREIGN KEY (`id_metodo`) REFERENCES `metodo_pago` (`id_metodo`),
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`),
  ADD CONSTRAINT `pagos_ibfk_2` FOREIGN KEY (`id_cuota`) REFERENCES `cuotas_credito` (`id_cuota`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`id_descuento`) REFERENCES `descuentos` (`id_descuento`);

--
-- Filtros para la tabla `pedido_detalles`
--
ALTER TABLE `pedido_detalles`
  ADD CONSTRAINT `pedido_detalles_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`),
  ADD CONSTRAINT `pedido_detalles_ibfk_2` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`);

--
-- Filtros para la tabla `seguimiento_mantenimiento`
--
ALTER TABLE `seguimiento_mantenimiento`
  ADD CONSTRAINT `seguimiento_mantenimiento_ibfk_1` FOREIGN KEY (`id_mantenimiento`) REFERENCES `mantenimiento` (`id_mantenimiento`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
