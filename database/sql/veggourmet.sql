-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-11-2025 a las 23:09:25
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
-- Base de datos: `veggourmet`
--
CREATE DATABASE IF NOT EXISTS `veggourmet` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `veggourmet`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre`, `descripcion`) VALUES
(27, 'Ensaladas', 'Verdes y de temporada'),
(28, 'Platos calientes', 'Opciones reconfortantes'),
(29, 'Bebidas', 'Jugos y smoothies'),
(30, 'Bowls', 'Combinaciones balanceadas'),
(31, 'S?ndwiches', 'Pan artesanal veg'),
(32, 'Postres', 'Dulces sin culpa'),
(33, 'Sopas', 'Cremas y caldos'),
(34, 'Tacos veg', 'Tortilla + plant-based'),
(35, 'Desayunos', 'Ma?aneros y brunch'),
(36, 'Snacks', 'Para picar'),
(37, 'Especiales', 'Chef y temporada'),
(38, 'Kids', 'Porciones peques');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `nombre` varchar(140) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nombre`, `telefono`, `email`) VALUES
(2, 'Sof?a Ram?rez', '+52-55-3912-8470', 'sofia.ramirez@gmail.com'),
(3, 'Carlos Hern?ndez', '+52-55-6241-0953', 'carlos.hernandez@outlook.com'),
(4, 'Mariana L?pez', '+52-55-7310-4682', 'mariana.lopez@gmail.com'),
(5, 'Diego Torres', '+52-55-2197-5304', 'diego.torres@yahoo.com'),
(6, 'Ana Gonz?lez', '+52-55-8734-1209', 'ana.gonzalez@gmail.com'),
(7, 'Luis Mart?nez', '+52-55-5478-3361', 'luis.martinez@outlook.com'),
(8, 'Valeria Cruz', '+52-55-9021-7745', 'valeria.cruz@gmail.com'),
(9, 'Jorge Castillo', '+52-55-4689-2103', 'jorge.castillo@hotmail.com'),
(10, 'Fernanda Ruiz', '+52-55-7850-6492', 'fernanda.ruiz@gmail.com'),
(11, 'Ricardo Vargas', '+52-55-3320-9105', 'ricardo.vargas@outlook.com'),
(12, 'Daniela Navarro', '+52-55-6402-5783', 'daniela.navarro@gmail.com'),
(13, 'Pablo Mendoza', '+52-55-2961-8430', 'pablo.mendoza@yahoo.com'),
(14, 'Camila Ortega', '+52-55-7183-2059', 'camila.ortega@gmail.com'),
(15, 'Alejandro S?nchez', '+52-55-5630-4971', 'alejandro.sanchez@outlook.com'),
(16, 'Luc?a Reyes', '+52-55-8219-3604', 'lucia.reyes@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id_compra` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `id_estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id_compra`, `id_proveedor`, `fecha`, `id_estado`) VALUES
(1, 1, '2025-10-21', 1),
(2, 2, '2025-10-10', 1),
(3, 3, '2025-10-11', 1),
(4, 4, '2025-10-12', 1),
(5, 5, '2025-10-13', 1),
(6, 7, '2025-10-15', 1),
(7, 8, '2025-10-16', 1),
(8, 9, '2025-10-17', 1),
(9, 10, '2025-10-18', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras_detalle`
--

CREATE TABLE `compras_detalle` (
  `id_compra` int(11) NOT NULL,
  `id_ingrediente` int(11) NOT NULL,
  `cantidad` decimal(10,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compras_detalle`
--

INSERT INTO `compras_detalle` (`id_compra`, `id_ingrediente`, `cantidad`) VALUES
(1, 1, 1000.000),
(2, 2, 4.500),
(2, 47, 3.200),
(3, 48, 5.000),
(3, 52, 2.800),
(4, 1, 10.000),
(4, 50, 8.000),
(5, 56, 3.500),
(5, 64, 2.000),
(6, 60, 15.000),
(7, 54, 5.000),
(7, 55, 6.000),
(8, 74, 6.000),
(8, 75, 20.000),
(9, 67, 30.000),
(9, 68, 25.000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id_empleado` int(11) NOT NULL,
  `nombre` varchar(140) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `id_puesto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id_empleado`, `nombre`, `telefono`, `email`, `id_puesto`) VALUES
(1, 'Laura P?rez', '+52-55-7000-1001', 'laura.perez@veggourmet.mx', 6),
(2, 'Miguel Torres', '+52-55-7000-1002', 'miguel.torres@veggourmet.mx', 6),
(3, 'Andrea R?os', '+52-55-7000-1003', 'andrea.rios@veggourmet.mx', 7),
(4, 'Jos? Ram?rez', '+52-55-7000-1004', 'jose.ramirez@veggourmet.mx', 8),
(5, 'Daniel G?mez', '+52-55-7000-1005', 'daniel.gomez@veggourmet.mx', 9),
(6, 'Paola Cruz', '+52-55-7000-1006', 'paola.cruz@veggourmet.mx', 4),
(7, 'Mar?a L?pez', '+52-55-7000-1007', 'maria.lopez@veggourmet.mx', 10),
(8, 'Luis Castro', '+52-55-7000-1008', 'luis.castro@veggourmet.mx', 8),
(9, 'Laura P?rez', '+52-55-7000-1001', 'laura.perez@veggourmet.mx', 6),
(10, 'Miguel Torres', '+52-55-7000-1002', 'miguel.torres@veggourmet.mx', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_compra`
--

CREATE TABLE `estados_compra` (
  `id_estado` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estados_compra`
--

INSERT INTO `estados_compra` (`id_estado`, `nombre`) VALUES
(3, 'Cancelada'),
(2, 'Parcial'),
(1, 'Recibida');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_pedido`
--

CREATE TABLE `estados_pedido` (
  `id_estado` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estados_pedido`
--

INSERT INTO `estados_pedido` (`id_estado`, `nombre`) VALUES
(4, 'Cancelado'),
(3, 'Entregado'),
(2, 'Pagado'),
(1, 'Pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingredientes`
--

CREATE TABLE `ingredientes` (
  `id_ingrediente` int(11) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `id_unidad` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ingredientes`
--

INSERT INTO `ingredientes` (`id_ingrediente`, `nombre`, `id_unidad`, `activo`) VALUES
(1, 'Quinoa', 1, 1),
(2, 'Espinaca', 1, 1),
(3, 'Aguacate', 3, 1),
(4, 'Nopal', 3, 1),
(5, 'Piña', 1, 1),
(6, 'Apio', 3, 1),
(47, 'Jitomate cherry', 3, 1),
(48, 'Pepino', 3, 1),
(49, 'Aceituna negra', 3, 1),
(50, 'Garbanzo cocido', 1, 1),
(51, 'Lechuga romana', 3, 1),
(52, 'Kale', 1, 1),
(53, 'Nuez', 1, 1),
(54, 'Betabel', 3, 1),
(55, 'Naranja', 3, 1),
(56, 'Berenjena', 3, 1),
(57, 'Calabac?n', 3, 1),
(58, 'Ricotta', 1, 1),
(59, 'Leche de coco', 2, 1),
(60, 'Tofu', 1, 1),
(61, 'Arroz integral', 1, 1),
(62, 'Fideo soba', 1, 1),
(63, 'Edamame', 1, 1),
(64, 'Portobello', 3, 1),
(65, 'Pesto', 1, 1),
(66, 'Mozzarella', 1, 1),
(67, 'Pan masa madre', 3, 1),
(68, 'Pan integral', 3, 1),
(69, 'Hummus', 1, 1),
(70, 'Tahini', 1, 1),
(71, 'Fresa', 3, 1),
(72, 'Frambuesa', 3, 1),
(73, 'Yogurt natural', 2, 1),
(74, 'Cacao 70%', 1, 1),
(75, 'Avena', 1, 1),
(76, 'Lenteja', 1, 1),
(77, 'Zanahoria', 3, 1),
(78, 'Champi??n', 3, 1),
(79, 'Miso', 1, 1),
(80, 'Alga nori', 3, 1),
(81, 'Pi?a', 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `id_producto` int(11) NOT NULL,
  `stock` decimal(10,2) NOT NULL DEFAULT 0.00,
  `stock_minimo` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`id_producto`, `stock`, `stock_minimo`) VALUES
(2, 20.00, 5.00),
(20, 20.00, 5.00),
(23, 20.00, 5.00),
(24, 20.00, 5.00),
(25, 20.00, 5.00),
(28, 20.00, 5.00),
(29, 20.00, 5.00),
(30, 20.00, 5.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `fecha` datetime NOT NULL,
  `id_estado` int(11) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `id_empleado_toma` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id_pedido`, `id_cliente`, `fecha`, `id_estado`, `tipo`, `id_empleado_toma`) VALUES
(1, NULL, '2025-10-21 06:56:51', 1, 'Local', NULL),
(2, NULL, '2025-10-21 19:44:51', 1, 'Local', NULL),
(3, 2, '2025-10-21 21:21:00', 2, 'Delivery', NULL),
(4, 3, '2025-10-22 21:21:00', 2, 'Local', NULL),
(5, 4, '2025-10-23 21:21:00', 1, 'Delivery', NULL),
(6, 5, '2025-10-24 21:21:19', 2, 'Local', NULL),
(7, 6, '2025-10-25 21:21:19', 3, 'Delivery', NULL),
(8, 7, '2025-10-20 21:21:19', 2, 'Local', NULL),
(9, 8, '2025-10-24 21:21:19', 1, 'Delivery', NULL),
(10, 9, '2025-10-25 21:21:19', 2, 'Local', NULL),
(11, 10, '2025-10-19 21:21:19', 3, 'Delivery', NULL),
(12, 11, '2025-10-17 21:21:19', 2, 'Local', NULL),
(13, 2, '2025-10-28 19:11:48', 1, 'Local', NULL),
(14, 2, '2025-10-29 03:29:01', 1, 'Local', NULL),
(15, 2, '2025-10-29 13:43:31', 1, 'Local', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos_detalle`
--

CREATE TABLE `pedidos_detalle` (
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos_detalle`
--

INSERT INTO `pedidos_detalle` (`id_pedido`, `id_producto`, `cantidad`) VALUES
(1, 1, 1.00),
(2, 1, 1.00),
(2, 2, 1.00),
(3, 2, 1.00),
(4, 23, 1.00),
(4, 30, 1.00),
(5, 9, 2.00),
(6, 22, 2.00),
(6, 44, 3.00),
(7, 12, 1.00),
(8, 30, 1.00),
(9, 20, 2.00),
(10, 22, 1.00),
(10, 29, 1.00),
(12, 2, 2.00),
(12, 32, 2.00),
(13, 29, 1.00),
(13, 50, 1.00),
(14, 29, 1.00),
(15, 50, 1.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `id_categoria`, `nombre`, `descripcion`, `activo`) VALUES
(1, 27, 'Ensalada Quinoa', 'Quinoa + espinaca + aguacate', 1),
(2, 29, 'Jugo Verde', 'sin_gluten | nopal, pi?a, apio, lim?n', 1),
(3, 27, 'Ensalada Quinoa cl?sica', 'vegetariano | quinoa, espinaca, aguacate, jitomate cherry', 1),
(4, 27, 'Ensalada Mediterr?nea', 'vegano | garbanzo, pepino, aceituna, jitomate, or?gano', 1),
(5, 27, 'Ensalada C?sar vegana', 'vegano | lechuga romana, crotones, aderezo de anacardo', 1),
(6, 27, 'Ensalada Kale & Manzana', 'vegetariano | kale, manzana, nuez, queso de cabra', 1),
(7, 27, 'Ensalada de Betabel Asado', 'vegano | betabel, naranja, pistache, vinagreta c?trica', 1),
(8, 28, 'Lasa?a de verduras', 'vegetariano | berenjena, calabac?n, queso ricotta', 1),
(9, 28, 'Curry verde thai', 'vegano | leche de coco, vegetales, arroz jazm?n', 1),
(10, 28, 'Berenjena a la parmesana', 'vegetariano | salsa de tomate, albahaca, parmesano', 1),
(11, 28, 'Tofu teriyaki con verduras', 'vegano | salteado, arroz integral', 1),
(12, 28, 'Shakshuka', 'vegetariano | huevos, jitomate, pimientos, comino', 1),
(19, 29, 'Smoothie de frutos rojos', 'vegetariano | fresa, frambuesa, yogurt', 1),
(20, 29, 'Kombucha de jengibre', 'vegano | bebida fermentada', 1),
(21, 29, 'Agua fresca pepino-lim?n', 'vegano | sin az?car a?adida', 1),
(22, 29, 'Cold brew', 'vegano | caf? de especialidad', 1),
(23, 30, 'Buddha Bowl', 'vegano | quinoa, garbanzo, hummus, verduras asadas', 1),
(24, 30, 'Mexa Bowl', 'vegetariano | arroz, frijol negro, elote, queso panela', 1),
(25, 30, 'Soba Bowl', 'vegano | fideos soba, tofu, ajonjol?, edamame', 1),
(26, 30, 'Prote?na Verde', 'vegano | arroz integral, br?coli, tofu, almendras', 1),
(27, 30, 'Mediterr?neo Bowl', 'vegetariano | couscous, aceitunas, tzatziki', 1),
(28, 31, 'Portobello a la plancha', 'vegetariano | pan masa madre, pesto, mozzarella', 1),
(29, 31, 'Banh mi vegano', 'vegano | tofu crujiente, encurtidos, cilantro', 1),
(30, 31, 'Caprese', 'vegetariano | jitomate, mozzarella, albahaca', 1),
(31, 31, 'Hummus & Veggies', 'vegano | pan integral, pepino, jitomate, ar?gula', 1),
(32, 31, 'Falafel pita', 'vegano | tahini, jitomate, lechuga', 1),
(33, 32, 'Cheesecake de frutos rojos', 'vegetariano | base de galleta integral', 1),
(34, 32, 'Brownie sin harina', 'sin_gluten | cacao 70%', 1),
(35, 32, 'Mousse de chocolate', 'vegetariano | cacao, crema', 1),
(36, 32, 'Pay de manzana integral', 'vegetariano | canela', 1),
(37, 32, 'Galletas de avena', 'vegano | chispas de cacao', 1),
(38, 33, 'Sopa de lentejas', 'vegano | con zanahoria y apio', 1),
(39, 33, 'Crema de calabaza', 'vegetariano | toque de jengibre', 1),
(40, 33, 'Minestrone', 'vegano | verduras, pasta integral', 1),
(41, 33, 'Crema de champi??n', 'vegetariano | sin_gluten (opcional)', 1),
(42, 33, 'Ramen de miso', 'vegano | tofu, alga nori', 1),
(43, 34, 'Taco de coliflor BBQ', 'vegano | tortilla ma?z', 1),
(44, 34, 'Taco de setas al pastor', 'vegano | pi?a asada, cilantro', 1),
(45, 34, 'Taco de nopales con queso', 'vegetariano | tortilla ma?z', 1),
(46, 34, 'Taco de frijol y aguacate', 'vegano | pico de gallo', 1),
(47, 34, 'Taco de tofu crujiente', 'vegano | chipotle mayo vegana', 1),
(48, 35, 'Chilaquiles verdes con tofu', 'vegano | totopos horneados', 1),
(49, 35, 'Omelette de claras y espinaca', 'vegetariano | queso panela', 1),
(50, 35, 'Avena overnight', 'vegano | ch?a, frutos rojos', 1),
(51, 35, 'Hotcakes de avena', 'vegetariano | miel de agave', 1),
(52, 35, 'Molletes integrales', 'vegetariano | frijol, queso, pico de gallo', 1),
(53, 36, 'Hummus con crudit?s', 'vegano | zanahoria, pepino, apio', 1),
(54, 36, 'Edamames al vapor', 'vegano | sal de mar', 1),
(55, 36, 'Papas gajo al horno', 'vegano | paprika ahumada', 1),
(56, 36, 'Mix de nueces', 'vegano | almendra, nuez, ar?ndano', 1),
(57, 36, 'Tostadas de aguacate', 'vegetariano | pan integral', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id_proveedor` int(11) NOT NULL,
  `nombre` varchar(140) NOT NULL,
  `rfc` varchar(20) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id_proveedor`, `nombre`, `rfc`, `telefono`, `email`) VALUES
(1, 'Proveedor Demo', 'XAXX010101000', '555-111-2222', 'proveedor@demo.com'),
(2, 'Hortalizas del Valle', 'XAXX010101001', '+52-55-5123-1001', 'contacto@hortalizasvalle.mx'),
(3, 'Verde Vivo', 'XAXX010101002', '+52-55-5123-1002', 'ventas@verdevivo.com'),
(4, 'Granos Selectos', 'XAXX010101003', '+52-55-5123-1003', 'hola@granosselectos.com'),
(5, 'La Huerta Urbana', 'XAXX010101004', '+52-55-5123-1004', 'compras@huertaurbana.mx'),
(6, 'Del Coco y M?s', 'XAXX010101005', '+52-55-5123-1005', 'facturas@delcoco.mx'),
(7, 'Tofu Artesanal', 'XAXX010101006', '+52-55-5123-1006', 'ventas@tofuartesanal.mx'),
(8, 'Cosecha Local', 'XAXX010101007', '+52-55-5123-1007', 'proveedores@cosechalocal.mx'),
(9, 'Frutos y Semillas', 'XAXX010101008', '+52-55-5123-1008', 'contacto@frutosysemillas.mx'),
(10, 'Pan Masa Madre', 'XAXX010101009', '+52-55-5123-1009', 'pan@masamadre.mx'),
(11, 'Bimbo', 'jvbdjvdbvde', '7267462820', 'bimb@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puestos`
--

CREATE TABLE `puestos` (
  `id_puesto` int(11) NOT NULL,
  `nombre` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `puestos`
--

INSERT INTO `puestos` (`id_puesto`, `nombre`) VALUES
(5, 'Administrador'),
(7, 'Cajero'),
(6, 'Cocinero'),
(4, 'Compras'),
(10, 'Gerente'),
(8, 'Mesero'),
(9, 'Repartidor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recetas`
--

CREATE TABLE `recetas` (
  `id_producto` int(11) NOT NULL,
  `id_ingrediente` int(11) NOT NULL,
  `cantidad` decimal(10,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `recetas`
--

INSERT INTO `recetas` (`id_producto`, `id_ingrediente`, `cantidad`) VALUES
(2, 4, 150.000),
(2, 6, 50.000),
(29, 48, 20.000),
(29, 60, 100.000),
(29, 68, 1.000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades_medida`
--

CREATE TABLE `unidades_medida` (
  `id_unidad` int(11) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `abreviatura` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `unidades_medida`
--

INSERT INTO `unidades_medida` (`id_unidad`, `nombre`, `abreviatura`) VALUES
(1, 'Gramos', 'g'),
(2, 'Kilogramos', 'kg'),
(3, 'Mililitros', 'ml'),
(4, 'Litros', 'L'),
(5, 'Piezas', 'pz');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_empleado` int(11) DEFAULT NULL,
  `creado_en` timestamp NULL DEFAULT current_timestamp(),
  `actualizado_en` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `uq_clientes_email` (`email`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id_compra`),
  ADD KEY `fk_comp_estado` (`id_estado`),
  ADD KEY `idx_comp_prov` (`id_proveedor`);

--
-- Indices de la tabla `compras_detalle`
--
ALTER TABLE `compras_detalle`
  ADD PRIMARY KEY (`id_compra`,`id_ingrediente`),
  ADD KEY `fk_cdet_ing` (`id_ingrediente`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_empleado`),
  ADD KEY `fk_emp_puesto` (`id_puesto`);

--
-- Indices de la tabla `estados_compra`
--
ALTER TABLE `estados_compra`
  ADD PRIMARY KEY (`id_estado`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `estados_pedido`
--
ALTER TABLE `estados_pedido`
  ADD PRIMARY KEY (`id_estado`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `ingredientes`
--
ALTER TABLE `ingredientes`
  ADD PRIMARY KEY (`id_ingrediente`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD KEY `idx_ing_um` (`id_unidad`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `idx_ped_cli` (`id_cliente`),
  ADD KEY `idx_ped_estado` (`id_estado`),
  ADD KEY `idx_ped_emp_toma` (`id_empleado_toma`),
  ADD KEY `idx_pedidos_id_cliente` (`id_cliente`),
  ADD KEY `idx_pedidos_cliente` (`id_cliente`);

--
-- Indices de la tabla `pedidos_detalle`
--
ALTER TABLE `pedidos_detalle`
  ADD PRIMARY KEY (`id_pedido`,`id_producto`),
  ADD KEY `fk_pdet_prod` (`id_producto`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD KEY `idx_prod_cat` (`id_categoria`),
  ADD KEY `idx_productos_id_categoria` (`id_categoria`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id_proveedor`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `puestos`
--
ALTER TABLE `puestos`
  ADD PRIMARY KEY (`id_puesto`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `recetas`
--
ALTER TABLE `recetas`
  ADD PRIMARY KEY (`id_producto`,`id_ingrediente`),
  ADD KEY `fk_rec_ing` (`id_ingrediente`);

--
-- Indices de la tabla `unidades_medida`
--
ALTER TABLE `unidades_medida`
  ADD PRIMARY KEY (`id_unidad`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD UNIQUE KEY `abreviatura` (`abreviatura`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `idx_usuarios_cliente` (`id_cliente`),
  ADD KEY `idx_usuarios_empleado` (`id_empleado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `estados_compra`
--
ALTER TABLE `estados_compra`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `estados_pedido`
--
ALTER TABLE `estados_pedido`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `ingredientes`
--
ALTER TABLE `ingredientes`
  MODIFY `id_ingrediente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `puestos`
--
ALTER TABLE `puestos`
  MODIFY `id_puesto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `unidades_medida`
--
ALTER TABLE `unidades_medida`
  MODIFY `id_unidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `fk_comp_estado` FOREIGN KEY (`id_estado`) REFERENCES `estados_compra` (`id_estado`),
  ADD CONSTRAINT `fk_comp_prov` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`);

--
-- Filtros para la tabla `compras_detalle`
--
ALTER TABLE `compras_detalle`
  ADD CONSTRAINT `fk_cdet_comp` FOREIGN KEY (`id_compra`) REFERENCES `compras` (`id_compra`),
  ADD CONSTRAINT `fk_cdet_ing` FOREIGN KEY (`id_ingrediente`) REFERENCES `ingredientes` (`id_ingrediente`);

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `fk_emp_puesto` FOREIGN KEY (`id_puesto`) REFERENCES `puestos` (`id_puesto`);

--
-- Filtros para la tabla `ingredientes`
--
ALTER TABLE `ingredientes`
  ADD CONSTRAINT `fk_ing_um` FOREIGN KEY (`id_unidad`) REFERENCES `unidades_medida` (`id_unidad`);

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `fk_inv_prod` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_ped_emp_toma` FOREIGN KEY (`id_empleado_toma`) REFERENCES `empleados` (`id_empleado`),
  ADD CONSTRAINT `fk_ped_estado` FOREIGN KEY (`id_estado`) REFERENCES `estados_pedido` (`id_estado`),
  ADD CONSTRAINT `fk_pedidos_clientes_setnull` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedidos_detalle`
--
ALTER TABLE `pedidos_detalle`
  ADD CONSTRAINT `fk_pdet_ped` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`),
  ADD CONSTRAINT `fk_pdet_prod` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_prod_cat` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `recetas`
--
ALTER TABLE `recetas`
  ADD CONSTRAINT `fk_rec_ing` FOREIGN KEY (`id_ingrediente`) REFERENCES `ingredientes` (`id_ingrediente`),
  ADD CONSTRAINT `fk_rec_prod` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_usuarios_empleado` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
