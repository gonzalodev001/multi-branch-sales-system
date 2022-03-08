-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-12-2019 a las 17:33:03
-- Versión del servidor: 10.4.8-MariaDB
-- Versión de PHP: 7.2.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbemec`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

CREATE TABLE `articulos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idcategoria` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marca` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_serie` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modelo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio_venta` decimal(11,2) NOT NULL,
  `descripcion` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `articulos`
--

INSERT INTO `articulos` (`id`, `idcategoria`, `nombre`, `marca`, `numero_serie`, `modelo`, `precio_venta`, `descripcion`, `condicion`, `created_at`, `updated_at`) VALUES
(1, 1, 'Core i5 2500k', 'intel', 'gf3234ggh43', 'intel', '650.00', 'procesador', 1, NULL, '2019-10-17 23:16:07'),
(2, 1, 'Ryzen 3 2200G', 'AMD', 'sdasrgh5', 'AMD', '150.00', 'SDS', 1, '2019-10-17 23:12:48', '2019-10-17 23:51:23'),
(3, 2, 'msi', 'msi', 'sdsads', 'ads', '150.00', 'sads', 1, '2019-10-26 16:29:59', '2019-10-26 16:29:59'),
(5, 2, 'H310M', 'ASROCK', 'GJHD4211342', 'H32', '345.00', 'ALGO de tarjetas', 1, '2019-10-26 18:39:18', '2019-11-20 02:33:18'),
(6, 3, 'Video GT210', 'MSI', 'TRSWQ3254JG5', 'GT210', '300.00', 'TARJETA DE VIDEO MSI', 1, '2019-11-19 23:29:49', '2019-11-20 02:15:46'),
(7, 2, 'asus h342', 'asus', 'gfdgsdfsd436', 'gf34', '550.00', 'des', 1, '2019-11-20 02:35:09', '2019-11-20 02:36:25'),
(8, 4, 'Kingston ValueRam', 'Kingston', 'ARBD32346G', 'Kingston ValueRam M3E', '220.00', 'memoria ram', 1, '2019-12-12 19:52:10', '2019-12-12 19:55:06'),
(9, 5, 'Disco duro Hdd', 'toshiba', 'D5GHDSDS4', 'Barracuda', '250.00', 'fg', 1, '2019-12-13 00:22:13', '2019-12-13 00:25:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `descripcion`, `condicion`, `created_at`, `updated_at`) VALUES
(1, 'Procesadores', 'Todo tipo de procesadores de computadoras', 1, '2019-10-16 06:51:49', '2019-10-16 06:51:49'),
(2, 'tarjetas madres', 'tarjetas madre', 1, '2019-10-26 16:29:04', '2019-11-18 18:56:26'),
(3, 'Tarjetas de Video', 'tajetas de video', 1, '2019-11-19 23:27:55', '2019-11-19 23:28:04'),
(4, 'Memoria Ram', NULL, 0, '2019-12-12 19:49:05', '2019-12-13 00:19:48'),
(5, 'Disco duro', 'disco', 1, '2019-12-13 00:21:26', '2019-12-13 00:21:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idpersona` bigint(20) UNSIGNED NOT NULL,
  `nota_corta` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `idpersona`, `nota_corta`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, NULL),
(2, 2, NULL, '2019-10-18 00:02:28', '2019-10-21 18:15:25'),
(3, 14, 'asdas', '2019-10-26 16:33:49', '2019-10-26 16:33:49'),
(4, 16, NULL, '2019-11-19 18:57:22', '2019-11-19 18:57:22'),
(5, 17, NULL, '2019-11-19 19:03:13', '2019-11-19 19:03:13'),
(6, 18, NULL, '2019-11-19 19:21:55', '2019-11-19 19:21:55'),
(7, 19, NULL, '2019-11-19 19:25:38', '2019-11-19 19:25:38'),
(8, 20, NULL, '2019-11-19 19:28:29', '2019-11-19 19:28:29'),
(9, 21, NULL, '2019-11-19 19:28:37', '2019-11-19 19:28:37'),
(10, 22, NULL, '2019-11-19 19:29:21', '2019-11-19 19:29:21'),
(11, 23, NULL, '2019-11-19 19:49:55', '2019-11-19 19:49:55'),
(12, 24, NULL, '2019-11-19 19:50:28', '2019-11-19 19:50:28'),
(13, 25, NULL, '2019-11-19 20:01:34', '2019-11-19 20:01:34'),
(14, 26, NULL, '2019-11-19 20:03:33', '2019-11-19 20:03:33'),
(15, 27, NULL, '2019-11-20 00:17:42', '2019-11-20 00:17:42'),
(16, 28, NULL, '2019-12-13 00:25:48', '2019-12-13 00:25:48'),
(17, 29, NULL, '2019-12-13 18:12:51', '2019-12-13 18:12:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ingresos`
--

CREATE TABLE `detalle_ingresos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idingreso` bigint(20) UNSIGNED NOT NULL,
  `idarticulo` bigint(20) UNSIGNED NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_compra` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalle_ingresos`
--

INSERT INTO `detalle_ingresos` (`id`, `idingreso`, `idarticulo`, `cantidad`, `precio_compra`) VALUES
(3, 3, 2, 1, '55.00'),
(4, 3, 1, 1, '55.00'),
(5, 4, 1, 3, '70.00'),
(6, 5, 1, 2, '60.00'),
(7, 6, 2, 2, '150.00'),
(8, 6, 1, 2, '160.00'),
(9, 7, 2, 1, '150.00'),
(10, 7, 1, 1, '160.00'),
(11, 8, 5, 5, '480.00'),
(12, 9, 5, 10, '150.00'),
(13, 9, 1, 8, '170.00'),
(14, 10, 5, 10, '365.00'),
(15, 11, 5, 1, '370.00'),
(16, 12, 6, 1, '256.00'),
(17, 12, 5, 1, '234.00'),
(18, 13, 6, 10, '300.00'),
(19, 14, 7, 10, '456.00'),
(20, 15, 8, 4, '180.00'),
(21, 16, 8, 10, '180.00'),
(22, 17, 7, 5, '250.00'),
(23, 18, 9, 5, '200.00'),
(24, 19, 9, 2, '200.00'),
(25, 20, 1, 2, '800.00');

--
-- Disparadores `detalle_ingresos`
--
DELIMITER $$
CREATE TRIGGER `tr_updStockIngreso` AFTER INSERT ON `detalle_ingresos` FOR EACH ROW BEGIN
UPDATE existencia_sucursales 
INNER JOIN ingresos ON ingresos.id = NEW.idingreso 
INNER JOIN sucursales ON ingresos.idsucursal = sucursales.id
INNER JOIN existencia_sucursales AS ex ON sucursales.id = existencia_sucursales.idsucursal
SET existencia_sucursales.stock = existencia_sucursales.stock + NEW.cantidad
WHERE existencia_sucursales.idarticulo = NEW.idarticulo AND existencia_sucursales.idsucursal = ingresos.idsucursal;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ventas`
--

CREATE TABLE `detalle_ventas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idventa` bigint(20) UNSIGNED NOT NULL,
  `idarticulo` bigint(20) UNSIGNED NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(11,2) NOT NULL,
  `descuento` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalle_ventas`
--

INSERT INTO `detalle_ventas` (`id`, `idventa`, `idarticulo`, `cantidad`, `precio`, `descuento`) VALUES
(1, 1, 2, 1, '150.00', '0.00'),
(2, 1, 1, 1, '650.00', '0.00'),
(3, 2, 2, 1, '150.00', '0.00'),
(4, 3, 2, 2, '150.00', '0.00'),
(5, 3, 1, 2, '650.00', '0.00'),
(6, 4, 2, 1, '150.00', '15.00'),
(7, 4, 1, 1, '650.00', '10.00'),
(8, 5, 2, 1, '150.00', '10.00'),
(9, 5, 1, 1, '650.00', '15.00'),
(10, 6, 2, 1, '150.00', '10.00'),
(11, 6, 1, 1, '650.00', '0.00'),
(12, 7, 5, 1, '70.00', '0.00'),
(13, 7, 2, 1, '150.00', '0.00'),
(14, 8, 1, 1, '650.00', '0.00'),
(15, 9, 2, 1, '150.00', '0.00'),
(16, 10, 2, 1, '150.00', '0.00'),
(17, 11, 1, 1, '650.00', '0.00'),
(18, 11, 2, 1, '150.00', '0.00'),
(19, 12, 2, 1, '150.00', '0.00'),
(20, 12, 5, 1, '0.00', '0.00'),
(21, 13, 5, 1, '0.00', '0.00'),
(22, 13, 1, 1, '650.00', '0.00'),
(23, 14, 9, 1, '250.00', '0.00'),
(24, 15, 6, 1, '300.00', '0.00'),
(25, 15, 5, 1, '345.00', '0.00'),
(26, 15, 8, 2, '220.00', '0.00'),
(27, 15, 7, 1, '550.00', '0.00');

--
-- Disparadores `detalle_ventas`
--
DELIMITER $$
CREATE TRIGGER `tr_updStockVenta` AFTER INSERT ON `detalle_ventas` FOR EACH ROW BEGIN
	UPDATE existencia_sucursales ex
		INNER JOIN ventas ON ventas.id = NEW.idventa 
		INNER JOIN sucursales ON ventas.idsucursal = sucursales.id
		AND ex.idsucursal = sucursales.id 
		SET ex.stock = ex.stock - NEW.cantidad
		WHERE ex.idarticulo = NEW.idarticulo AND ex.idsucursal = ventas.idsucursal;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `existencia_sucursales`
--

CREATE TABLE `existencia_sucursales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idsucursal` bigint(20) UNSIGNED NOT NULL,
  `idarticulo` bigint(20) UNSIGNED NOT NULL,
  `stock` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `existencia_sucursales`
--

INSERT INTO `existencia_sucursales` (`id`, `idsucursal`, `idarticulo`, `stock`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 17, NULL, NULL),
(2, 2, 1, 8, NULL, NULL),
(3, 1, 2, 1, NULL, NULL),
(4, 2, 2, 14, NULL, NULL),
(5, 1, 5, 23, '2019-10-26 18:39:18', '2019-10-26 18:39:18'),
(6, 2, 5, 0, '2019-10-26 18:39:18', '2019-10-26 18:39:18'),
(7, 1, 6, 10, '2019-11-19 23:29:49', '2019-11-19 23:29:49'),
(8, 2, 6, 0, '2019-11-19 23:29:49', '2019-11-19 23:29:49'),
(9, 1, 7, 9, '2019-11-20 02:35:09', '2019-11-20 02:35:09'),
(10, 2, 7, 5, '2019-11-20 02:35:09', '2019-11-20 02:35:09'),
(11, 1, 8, 2, '2019-12-12 19:52:10', '2019-12-12 19:52:10'),
(12, 2, 8, 11, '2019-12-12 19:52:10', '2019-12-12 19:52:10'),
(13, 1, 9, 6, '2019-12-13 00:22:13', '2019-12-13 00:22:13'),
(14, 2, 9, 0, '2019-12-13 00:22:13', '2019-12-13 00:22:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingresos`
--

CREATE TABLE `ingresos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idproveedor` bigint(20) UNSIGNED NOT NULL,
  `idusuario` bigint(20) UNSIGNED NOT NULL,
  `idsucursal` bigint(20) UNSIGNED NOT NULL,
  `tipo_comprobante` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_comprobante` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `impuesto` decimal(4,2) NOT NULL,
  `total_compra` decimal(11,2) NOT NULL,
  `estado` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ingresos`
--

INSERT INTO `ingresos` (`id`, `idproveedor`, `idusuario`, `idsucursal`, `tipo_comprobante`, `numero_comprobante`, `fecha_hora`, `impuesto`, `total_compra`, `estado`, `created_at`, `updated_at`) VALUES
(3, 8, 9, 2, 'Factura', '0001', '2019-10-22 01:20:36', '0.13', '110.00', 'Anulado', '2019-10-22 09:20:36', '2019-10-23 01:37:18'),
(4, 8, 9, 2, 'Factura', '0002', '2019-10-22 01:23:10', '0.13', '210.00', 'Registrado', '2019-10-22 09:23:10', '2019-10-22 09:23:10'),
(5, 8, 10, 1, 'Factura', '0003', '2019-10-22 01:34:55', '0.13', '120.00', 'Registrado', '2019-10-22 09:34:55', '2019-10-22 09:34:55'),
(6, 13, 7, 1, 'Recibo', '0004', '2019-10-26 08:33:06', '0.13', '620.00', 'Registrado', '2019-10-26 16:33:06', '2019-10-26 16:33:06'),
(7, 13, 9, 2, 'Recibo', '0003', '2019-10-26 08:37:54', '0.13', '310.00', 'Registrado', '2019-10-26 16:37:54', '2019-10-26 16:37:54'),
(8, 8, 10, 1, 'Factura', '0008', '2019-10-26 10:40:32', '0.13', '2400.00', 'Registrado', '2019-10-26 18:40:32', '2019-10-26 18:40:32'),
(9, 8, 10, 1, 'Factura', '00045', '2019-11-06 19:12:12', '0.13', '2860.00', 'Registrado', '2019-11-07 03:12:12', '2019-11-07 03:12:12'),
(10, 13, 10, 1, 'Factura', '00067', '2019-11-19 17:56:39', '0.13', '3650.00', 'Registrado', '2019-11-20 01:56:39', '2019-11-20 01:56:39'),
(11, 15, 10, 1, 'Factura', '00034', '2019-11-19 17:59:31', '0.13', '370.00', 'Registrado', '2019-11-20 01:59:31', '2019-11-20 01:59:31'),
(12, 15, 10, 1, 'Factura', '000076', '2019-11-19 18:04:57', '0.13', '490.00', 'Registrado', '2019-11-20 02:04:57', '2019-11-20 02:04:57'),
(13, 13, 7, 1, 'Recibo', '000435', '2019-11-19 18:34:07', '0.13', '3000.00', 'Registrado', '2019-11-20 02:34:07', '2019-11-20 02:34:07'),
(14, 15, 7, 1, 'Factura', '0000543', '2019-11-19 18:35:47', '0.13', '4560.00', 'Registrado', '2019-11-20 02:35:47', '2019-11-20 02:35:47'),
(15, 15, 10, 1, 'Factura', '006554', '2019-12-12 11:54:26', '0.13', '720.00', 'Registrado', '2019-12-12 19:54:26', '2019-12-12 19:54:26'),
(16, 13, 9, 2, 'Factura', '0630', '2019-12-12 11:59:50', '0.13', '1800.00', 'Registrado', '2019-12-12 19:59:50', '2019-12-12 19:59:50'),
(17, 8, 9, 2, 'Factura', '09865', '2019-12-12 12:04:47', '0.13', '1250.00', 'Registrado', '2019-12-12 20:04:47', '2019-12-12 20:04:47'),
(18, 8, 7, 1, 'Recibo', '0657563', '2019-12-12 16:23:27', '0.13', '1000.00', 'Registrado', '2019-12-13 00:23:27', '2019-12-13 00:23:27'),
(19, 8, 7, 1, 'Factura', '06575637', '2019-12-12 16:24:52', '0.13', '400.00', 'Registrado', '2019-12-13 00:24:52', '2019-12-13 00:24:52'),
(20, 8, 7, 1, 'Factura', '00532', '2019-12-12 16:43:29', '0.13', '1600.00', 'Registrado', '2019-12-13 00:43:29', '2019-12-13 00:43:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(8, '2014_10_12_100000_create_password_resets_table', 1),
(9, '2019_10_15_152843_create_categorias_table', 1),
(10, '2019_10_16_013427_create_articulos_table', 1),
(11, '2019_10_16_204826_create_personas_table', 2),
(12, '2019_10_16_210313_create_clientes_table', 3),
(13, '2019_10_17_155801_create_sucursales_table', 4),
(15, '2019_10_17_160601_create_existencia_sucursales_table', 5),
(17, '2019_10_19_040651_create_roles_table', 7),
(19, '2019_10_21_000000_create_users_table', 8),
(20, '2019_10_19_024110_create_proveedores_table', 9),
(21, '2019_10_21_224545_create_ingresos_table', 9),
(22, '2019_10_21_224627_create_detalle_ingresos_table', 10),
(23, '2019_10_23_031449_create_ventas_table', 11),
(24, '2019_10_23_031517_create_detalle_ventas_table', 11),
(25, '2019_12_13_073540_create_servicio_tecnicos_table', 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_documento` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id`, `nombre`, `numero_documento`, `direccion`, `telefono`, `email`, `created_at`, `updated_at`) VALUES
(1, 'Ruben Taborga', '7234566', 'Tomas frias 34', '64-31123', NULL, NULL, '2019-10-21 18:15:49'),
(2, 'Lorena Gutierrez', '3121762', 'dsa', '123', 'gu@gu.com', '2019-10-18 00:02:28', '2019-10-21 18:15:25'),
(5, 'Global-PC', '45455421', 'Uyustus', '64-34311', 'global@global.com', '2019-10-19 07:13:46', '2019-10-19 07:13:46'),
(6, 'Alex villalobos', '653212', 'canelas 34', '73425367', 'alex@alex.com', '2019-10-21 20:08:05', '2019-10-21 20:08:05'),
(7, 'beto', '12321', 'loa 34', '6412333', 'beto@beto.com', '2019-10-21 23:36:33', '2019-10-21 23:36:33'),
(8, 'Global PC', '65232412', 'Nataniel aguirre 34', '72845612', 'global@global.com', '2019-10-22 06:20:18', '2019-10-22 06:20:18'),
(9, 'carlos tapia', '4545445', 'bolivar 32', '43332432', 'carlos@carlos.com', '2019-10-22 06:31:16', '2019-10-22 06:31:16'),
(10, 'pepe sanchez', '4565688', 'calvo 98', '6453444', 'pepe@pepe.com', '2019-10-22 06:35:08', '2019-10-22 06:35:08'),
(11, 'juan carlos torres', '3423432', 'comarapa 34', '73450765', 'jcarlos@jcarlos.com', '2019-10-23 08:01:43', '2019-10-23 08:01:43'),
(12, 'monica vildozo', '524111323', 'jj perez 928', '72882345', 'moni@moni.com', '2019-10-23 08:03:49', '2019-10-23 08:03:49'),
(13, 'importadora', '432423432', 'algo 45', '54324324', 'imp@impo.com', '2019-10-26 16:31:54', '2019-10-26 16:31:54'),
(14, 'manuel', '234324324', 'adfs', '5645454', 'mamu@manu.com', '2019-10-26 16:33:49', '2019-10-26 16:33:49'),
(15, 'Info Computers', '45234532', 'pastor sainz', '32432432', 'info@info.com', '2019-11-18 19:01:33', '2019-11-18 19:01:33'),
(16, 'Pamela Castro', '12345678', NULL, NULL, NULL, '2019-11-19 18:57:22', '2019-11-19 18:57:22'),
(17, 'Brenda jimenexz', '342423', NULL, NULL, NULL, '2019-11-19 19:03:13', '2019-11-19 19:03:13'),
(18, 'luca pers', '312321', NULL, NULL, NULL, '2019-11-19 19:21:55', '2019-11-19 19:21:55'),
(19, 'luca pers', '312321', NULL, NULL, NULL, '2019-11-19 19:25:38', '2019-11-19 19:25:38'),
(20, 'Norma tellez', '3423432', NULL, NULL, NULL, '2019-11-19 19:28:29', '2019-11-19 19:28:29'),
(21, 'Norma tellez', '3423432', NULL, NULL, NULL, '2019-11-19 19:28:37', '2019-11-19 19:28:37'),
(22, 'Norma tellez', '3423432', NULL, NULL, NULL, '2019-11-19 19:29:21', '2019-11-19 19:29:21'),
(23, 'Esther', '123123', NULL, NULL, NULL, '2019-11-19 19:49:55', '2019-11-19 19:49:55'),
(24, 'Juan Cardona', '2312321', NULL, NULL, NULL, '2019-11-19 19:50:28', '2019-11-19 19:50:28'),
(25, 'Roxana Poppe', '32432', NULL, NULL, NULL, '2019-11-19 20:01:34', '2019-11-19 20:01:34'),
(26, 'Pablo Flores', '654654332', NULL, NULL, NULL, '2019-11-19 20:03:32', '2019-11-19 20:03:32'),
(27, 'jose taborga', '343242342', NULL, NULL, NULL, '2019-11-20 00:17:42', '2019-11-20 00:17:42'),
(28, 'humberto medrano', '76345676', NULL, NULL, NULL, '2019-12-13 00:25:48', '2019-12-13 00:25:48'),
(29, 'Sacarias Tellez', '6532323', NULL, NULL, NULL, '2019-12-13 18:12:50', '2019-12-13 18:12:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `idp` bigint(20) UNSIGNED NOT NULL,
  `contacto` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono_contacto` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`idp`, `contacto`, `telefono_contacto`) VALUES
(8, 'Eduardo', '73452076'),
(13, 'juan', '74532211'),
(15, 'humberto rojas', '23423432');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`, `descripcion`, `condicion`) VALUES
(1, 'Administrador', 'Administradores de área', 1),
(2, 'Vendedor', 'Vendedor área de ventas', 1),
(3, 'Almacenero', 'Almacenero área de compras', 1),
(4, 'Recepcionista', 'Recepcionista área de reparación', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio_tecnicos`
--

CREATE TABLE `servicio_tecnicos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idcliente` bigint(20) UNSIGNED NOT NULL,
  `idusuario` bigint(20) UNSIGNED NOT NULL,
  `idsucursal` bigint(20) UNSIGNED NOT NULL,
  `descipcion_equipo` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `defectos_entrada` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `defectos_salida` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_hora` datetime NOT NULL,
  `fecha_hora_salida` datetime DEFAULT NULL,
  `estado` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `servicio_tecnicos`
--

INSERT INTO `servicio_tecnicos` (`id`, `idcliente`, `idusuario`, `idsucursal`, `descipcion_equipo`, `defectos_entrada`, `defectos_salida`, `fecha_hora`, `fecha_hora_salida`, `estado`, `created_at`, `updated_at`) VALUES
(1, 14, 7, 1, 'Laptop hp pavillon', 'reparacion virus', 'Limpieza de virus', '2019-12-13 10:41:14', '2019-12-13 12:07:54', 'Repadaro', '2019-12-13 18:41:14', '2019-12-13 20:07:54'),
(2, 15, 7, 1, 'Impresora cannon', 'Cargar tinta', 'se reparo el cargador de tintass', '2019-12-13 12:21:32', '2019-12-13 12:26:25', 'Repadaro', '2019-12-13 20:21:32', '2019-12-13 20:26:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursales`
--

CREATE TABLE `sucursales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `direccion` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sucursales`
--

INSERT INTO `sucursales` (`id`, `direccion`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'Nataniel Aguirre 53', 'Sucursal A', NULL, NULL),
(2, 'Junin 1345', 'Sucursal B', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `usuario` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1,
  `idrol` bigint(20) UNSIGNED NOT NULL,
  `idsucursal` bigint(20) UNSIGNED NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `usuario`, `password`, `condicion`, `idrol`, `idsucursal`, `remember_token`) VALUES
(7, 'admin', '$2y$10$9rYQq2FKM/yD.ByldeYGLuRHlNCXoAXPFv1cjtDf8T8Rl1abaSjse', 1, 1, 1, NULL),
(6, 'alexv', '123456', 1, 1, 1, NULL),
(9, 'carlos', '$2y$10$nwrPx54xm1DsKhBWzeqJqeCxiqG2NXUJ74dnGio0avWQfifFNAuoO', 1, 3, 2, NULL),
(11, 'juanc', '$2y$10$g8wibAuxGz0PP5VmAlojX.PGJYIX3YJAXeU6DDKqXHMp5WXZFqpHG', 1, 2, 1, NULL),
(12, 'monicav', '$2y$10$jPbrntWtCoptnLTwyz7Tw.uC2SGmSfUfE/ty1g6BHKSE9LpYSSwUy', 1, 2, 2, NULL),
(10, 'pepe', '$2y$10$YvvvmiMoZvSWIzPlPxHRduEM2nKy/uMFod5nGOyAt5a2IgHSD5NI.', 1, 3, 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idcliente` bigint(20) UNSIGNED NOT NULL,
  `idusuario` bigint(20) UNSIGNED NOT NULL,
  `idsucursal` bigint(20) UNSIGNED NOT NULL,
  `num_comprobante` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo_control` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `impuesto` decimal(4,2) NOT NULL,
  `total` decimal(11,2) NOT NULL,
  `estado` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `idcliente`, `idusuario`, `idsucursal`, `num_comprobante`, `codigo_control`, `fecha_hora`, `impuesto`, `total`, `estado`, `created_at`, `updated_at`) VALUES
(1, 2, 11, 1, '000001', 'AAA', '2019-10-23 00:42:42', '0.13', '800.00', 'Registrado', '2019-10-23 08:42:42', '2019-10-23 08:42:42'),
(2, 1, 11, 1, '000002', 'AAA', '2019-10-23 00:43:35', '0.13', '150.00', 'Registrado', '2019-10-23 08:43:35', '2019-10-23 08:43:35'),
(3, 2, 12, 2, '000003', 'AAA', '2019-10-23 00:45:01', '0.13', '1600.00', 'Registrado', '2019-10-23 08:45:01', '2019-10-23 08:45:01'),
(4, 1, 11, 1, '000004', 'AAA', '2019-10-24 23:49:25', '0.13', '775.00', 'Registrado', '2019-10-25 07:49:25', '2019-10-25 07:49:25'),
(5, 3, 7, 1, '000005', 'AAA', '2019-10-26 08:35:00', '0.13', '775.00', 'Registrado', '2019-10-26 16:35:00', '2019-10-26 16:35:00'),
(6, 3, 11, 1, '000006', 'AAA', '2019-10-26 08:40:04', '0.13', '790.00', 'Registrado', '2019-10-26 16:40:04', '2019-10-26 16:40:04'),
(7, 2, 7, 1, '000007', 'AAA', '2019-11-18 18:38:17', '0.13', '220.00', 'Registrado', '2019-11-19 02:38:17', '2019-11-19 02:38:17'),
(8, 3, 7, 1, '000008', 'AAA', '2019-11-18 18:39:58', '0.13', '650.00', 'Registrado', '2019-11-19 02:39:58', '2019-11-19 02:39:58'),
(9, 1, 7, 1, '000009', 'AAA', '2019-11-18 18:40:17', '0.13', '150.00', 'Registrado', '2019-11-19 02:40:17', '2019-11-19 02:40:17'),
(10, 1, 7, 1, '000010', 'AAA', '2019-11-18 18:40:36', '0.13', '150.00', 'Registrado', '2019-11-19 02:40:36', '2019-11-19 02:40:36'),
(11, 13, 7, 1, '000011', 'AAA', '2019-11-19 12:02:33', '0.13', '800.00', 'Registrado', '2019-11-19 20:02:33', '2019-11-19 20:02:33'),
(12, 14, 7, 1, '000012', 'AAA', '2019-11-19 12:03:46', '0.13', '150.00', 'Registrado', '2019-11-19 20:03:46', '2019-11-19 20:03:46'),
(13, 15, 7, 1, '000013', 'AAA', '2019-11-19 16:17:50', '0.13', '650.00', 'Registrado', '2019-11-20 00:17:50', '2019-11-20 00:17:50'),
(14, 16, 7, 1, '000014', 'AAA', '2019-12-12 16:26:11', '0.13', '250.00', 'Registrado', '2019-12-13 00:26:11', '2019-12-13 00:26:11'),
(15, 14, 7, 1, '000015', 'AAA', '2019-12-12 16:39:05', '0.13', '1635.00', 'Registrado', '2019-12-13 00:39:05', '2019-12-13 00:39:05');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `articulos_numero_serie_unique` (`numero_serie`),
  ADD KEY `articulos_idcategoria_foreign` (`idcategoria`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clientes_idpersona_foreign` (`idpersona`);

--
-- Indices de la tabla `detalle_ingresos`
--
ALTER TABLE `detalle_ingresos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalle_ingresos_idingreso_foreign` (`idingreso`),
  ADD KEY `detalle_ingresos_idarticulo_foreign` (`idarticulo`);

--
-- Indices de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalle_ventas_idventa_foreign` (`idventa`),
  ADD KEY `detalle_ventas_idarticulo_foreign` (`idarticulo`);

--
-- Indices de la tabla `existencia_sucursales`
--
ALTER TABLE `existencia_sucursales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `existencia_sucursales_idsucursal_foreign` (`idsucursal`),
  ADD KEY `existencia_sucursales_idarticulo_foreign` (`idarticulo`);

--
-- Indices de la tabla `ingresos`
--
ALTER TABLE `ingresos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ingresos_idproveedor_foreign` (`idproveedor`),
  ADD KEY `ingresos_idusuario_foreign` (`idusuario`),
  ADD KEY `ingresos_idsucursal_foreign` (`idsucursal`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD KEY `proveedores_idp_foreign` (`idp`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_nombre_unique` (`nombre`);

--
-- Indices de la tabla `servicio_tecnicos`
--
ALTER TABLE `servicio_tecnicos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `servicio_tecnicos_idcliente_foreign` (`idcliente`),
  ADD KEY `servicio_tecnicos_idusuario_foreign` (`idusuario`),
  ADD KEY `servicio_tecnicos_idsucursal_foreign` (`idsucursal`);

--
-- Indices de la tabla `sucursales`
--
ALTER TABLE `sucursales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `users_usuario_unique` (`usuario`),
  ADD KEY `users_id_foreign` (`id`),
  ADD KEY `users_idrol_foreign` (`idrol`),
  ADD KEY `users_idsucursal_foreign` (`idsucursal`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ventas_idcliente_foreign` (`idcliente`),
  ADD KEY `ventas_idusuario_foreign` (`idusuario`),
  ADD KEY `ventas_idsucursal_foreign` (`idsucursal`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulos`
--
ALTER TABLE `articulos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `detalle_ingresos`
--
ALTER TABLE `detalle_ingresos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `existencia_sucursales`
--
ALTER TABLE `existencia_sucursales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `ingresos`
--
ALTER TABLE `ingresos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `servicio_tecnicos`
--
ALTER TABLE `servicio_tecnicos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `sucursales`
--
ALTER TABLE `sucursales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD CONSTRAINT `articulos_idcategoria_foreign` FOREIGN KEY (`idcategoria`) REFERENCES `categorias` (`id`);

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `clientes_idpersona_foreign` FOREIGN KEY (`idpersona`) REFERENCES `personas` (`id`);

--
-- Filtros para la tabla `detalle_ingresos`
--
ALTER TABLE `detalle_ingresos`
  ADD CONSTRAINT `detalle_ingresos_idarticulo_foreign` FOREIGN KEY (`idarticulo`) REFERENCES `articulos` (`id`),
  ADD CONSTRAINT `detalle_ingresos_idingreso_foreign` FOREIGN KEY (`idingreso`) REFERENCES `ingresos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD CONSTRAINT `detalle_ventas_idarticulo_foreign` FOREIGN KEY (`idarticulo`) REFERENCES `articulos` (`id`),
  ADD CONSTRAINT `detalle_ventas_idventa_foreign` FOREIGN KEY (`idventa`) REFERENCES `ventas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `existencia_sucursales`
--
ALTER TABLE `existencia_sucursales`
  ADD CONSTRAINT `existencia_sucursales_idarticulo_foreign` FOREIGN KEY (`idarticulo`) REFERENCES `articulos` (`id`),
  ADD CONSTRAINT `existencia_sucursales_idsucursal_foreign` FOREIGN KEY (`idsucursal`) REFERENCES `sucursales` (`id`);

--
-- Filtros para la tabla `ingresos`
--
ALTER TABLE `ingresos`
  ADD CONSTRAINT `ingresos_idproveedor_foreign` FOREIGN KEY (`idproveedor`) REFERENCES `proveedores` (`idp`),
  ADD CONSTRAINT `ingresos_idsucursal_foreign` FOREIGN KEY (`idsucursal`) REFERENCES `sucursales` (`id`),
  ADD CONSTRAINT `ingresos_idusuario_foreign` FOREIGN KEY (`idusuario`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD CONSTRAINT `proveedores_idp_foreign` FOREIGN KEY (`idp`) REFERENCES `personas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `servicio_tecnicos`
--
ALTER TABLE `servicio_tecnicos`
  ADD CONSTRAINT `servicio_tecnicos_idcliente_foreign` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `servicio_tecnicos_idsucursal_foreign` FOREIGN KEY (`idsucursal`) REFERENCES `sucursales` (`id`),
  ADD CONSTRAINT `servicio_tecnicos_idusuario_foreign` FOREIGN KEY (`idusuario`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_id_foreign` FOREIGN KEY (`id`) REFERENCES `personas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_idrol_foreign` FOREIGN KEY (`idrol`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `users_idsucursal_foreign` FOREIGN KEY (`idsucursal`) REFERENCES `sucursales` (`id`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_idcliente_foreign` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `ventas_idsucursal_foreign` FOREIGN KEY (`idsucursal`) REFERENCES `sucursales` (`id`),
  ADD CONSTRAINT `ventas_idusuario_foreign` FOREIGN KEY (`idusuario`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
