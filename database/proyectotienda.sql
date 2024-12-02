-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:8889
-- Tiempo de generación: 02-12-2024 a las 04:53:29
-- Versión del servidor: 5.7.24
-- Versión de PHP: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyectotienda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `car_fk_producto` int(11) NOT NULL,
  `car_fk_usuario` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`car_fk_producto`, `car_fk_usuario`, `cantidad`) VALUES
(25, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `cat_id` int(11) NOT NULL,
  `cat_nombre` varchar(50) DEFAULT NULL,
  `cat_descripcion` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`cat_id`, `cat_nombre`, `cat_descripcion`) VALUES
(1, 'Ropa de Mujer', 'Categoría de ropa para mujeres, incluyendo prendas de vestir, accesorios, etc.'),
(2, 'Electrónicos', 'Categoría que incluye productos electrónicos como computadoras, teléfonos, etc.'),
(3, 'Videojuegos', 'Categoría de videojuegos para diversas plataformas de entretenimiento.'),
(4, 'Libros', 'Categoría que incluye libros de todos los géneros y para todas las edades.'),
(5, 'Hogar y Cocina', 'Categoría para productos del hogar, electrodomésticos, utensilios de cocina, etc.'),
(6, 'Mascotas', 'Categoría que incluye productos para el cuidado y bienestar de las mascotas.'),
(7, 'Juguetes', 'Categoría de juguetes para niños de diferentes edades.'),
(8, 'Bebidas', 'Categoría que incluye una variedad de bebidas, desde refrescos hasta bebidas alcohólicas.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `inv_id_producto` int(11) NOT NULL,
  `inv_stock` int(11) DEFAULT NULL,
  `inv_NombreAlmacen` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes`
--

CREATE TABLE `ordenes` (
  `ord_id` int(11) NOT NULL,
  `ord_vendedor` int(11) DEFAULT NULL,
  `ord_cliente` int(11) DEFAULT NULL,
  `ord_fecha_pedido` date DEFAULT NULL,
  `ord_fecha_entrega` date DEFAULT NULL,
  `ord_fk_ordenproducto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_productos`
--

CREATE TABLE `orden_productos` (
  `orpd_id` int(11) NOT NULL,
  `orpd_idorden` int(11) DEFAULT NULL,
  `orpd_idproducto` int(11) NOT NULL,
  `orpd_cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idproducto` int(11) NOT NULL,
  `prd_nombre` varchar(100) DEFAULT NULL,
  `prd_descrip` text,
  `prd_precio` float DEFAULT NULL,
  `prd_marca` varchar(50) DEFAULT NULL,
  `prd_imagen` text,
  `prd_estado` varchar(50) DEFAULT NULL,
  `prd_categoria` int(50) DEFAULT NULL,
  `prd_id_publicacion` int(11) DEFAULT NULL,
  `prd_id_vendedor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idproducto`, `prd_nombre`, `prd_descrip`, `prd_precio`, `prd_marca`, `prd_imagen`, `prd_estado`, `prd_categoria`, `prd_id_publicacion`, `prd_id_vendedor`) VALUES
(25, 'Libreta', 'Azul', 25.23, 'Scribe', 'https://papeleriadelahorro.mx/cdn/shop/products/75613027.jpg?v=1631197983', 'Disponible', 4, NULL, NULL),
(43, 'Jeans ajustados', 'Jeans de talle alto y corte ajustado', 49.99, 'Levi\'s', 'imagen3.jpg', 'Nuevo', 1, NULL, NULL),
(44, 'Chaqueta de cuero', 'Chaqueta de cuero de diseño elegante', 99.99, 'H&M', 'imagen4.jpg', 'Nuevo', 1, NULL, NULL),
(45, 'Falda plisada', 'Falda larga de estilo bohemio', 59.99, 'Bershka', 'imagen5.jpg', 'Nuevo', 1, NULL, NULL),
(46, 'Smartphone Samsung Galaxy', 'Smartphone con pantalla AMOLED y 128GB de almacenamiento', 799.99, 'Samsung', 'smartphone.jpg', 'Nuevo', 2, NULL, NULL),
(47, 'Laptop HP Spectre', 'Laptop ultradelgada con procesador Intel i7', 1299.99, 'HP', 'laptop.jpg', 'Nuevo', 2, NULL, NULL),
(48, 'Auriculares Bose', 'Auriculares inalámbricos con cancelación de ruido', 299.99, 'Bose', 'auriculares.jpg', 'Nuevo', 2, NULL, NULL),
(49, 'Smartwatch Apple', 'Reloj inteligente con monitoreo de salud', 399.99, 'Apple', 'smartwatch.jpg', 'Nuevo', 2, NULL, NULL),
(50, 'Cámara DSLR Canon', 'Cámara profesional con lente de 18-55mm', 899.99, 'Canon', 'camara.jpg', 'Nuevo', 2, NULL, NULL),
(51, 'The Last of Us 2', 'Videojuego de acción y aventura, exclusivo para PS4', 59.99, 'Naughty Dog', 'tloz2.jpg', 'Nuevo', 3, NULL, NULL),
(52, 'Cyberpunk 2077', 'Juego de rol y acción en un mundo futurista', 49.99, 'CD Projekt', 'cyberpunk.jpg', 'Nuevo', 3, NULL, NULL),
(53, 'FIFA 24', 'Simulador de fútbol con modos en línea y campaña', 59.99, 'EA Sports', 'fifa24.jpg', 'Nuevo', 3, NULL, NULL),
(54, 'Minecraft', 'Juego de construcción y aventuras en un mundo abierto', 19.99, 'Mojang', 'minecraft.jpg', 'Nuevo', 3, NULL, NULL),
(55, 'Call of Duty: Modern Warfare', 'Juego de disparos en primera persona, con modo multijugador', 59.99, 'Activision', 'codmw.jpg', 'Nuevo', 3, NULL, NULL),
(56, 'Cien Años de Soledad', 'Obra maestra de Gabriel García Márquez', 15.99, 'Editorial Sudamericana', 'cienanos.jpg', 'Nuevo', 4, NULL, NULL),
(57, '1984', 'Novela distópica de George Orwell', 12.99, 'Harvill Secker', '1984.jpg', 'Nuevo', 4, NULL, NULL),
(58, 'El Hobbit', 'Fantasía épica escrita por J.R.R. Tolkien', 14.99, 'HarperCollins', 'hobbit.jpg', 'Nuevo', 4, NULL, NULL),
(59, 'Orgullo y Prejuicio', 'Clásico de Jane Austen', 9.99, 'Penguin Books', 'orgullo.jpg', 'Nuevo', 4, NULL, NULL),
(60, 'El Alquimista', 'Fábula de Paulo Coelho sobre el destino y la realización personal', 10.99, 'Planeta', 'alquimista.jpg', 'Nuevo', 4, NULL, NULL),
(61, 'Cafetera Nespresso', 'Cafetera de cápsulas con tecnología de café expreso', 149.99, 'Nespresso', 'cafetera.jpg', 'Nuevo', 5, NULL, NULL),
(62, 'Batidora KitchenAid', 'Batidora de pie con varios accesorios', 349.99, 'KitchenAid', 'batidora.jpg', 'Nuevo', 5, NULL, NULL),
(63, 'Olla a presión', 'Olla de acero inoxidable, ideal para cocinar rápido', 79.99, 'Tefal', 'olla.jpg', 'Nuevo', 5, NULL, NULL),
(64, 'Sartén antiadherente', 'Sartén de 30 cm con recubrimiento antiadherente', 39.99, 'Tefal', 'sarten.jpg', 'Nuevo', 5, NULL, NULL),
(65, 'Cuchillos de cocina', 'Set de cuchillos de alta calidad para todo tipo de alimentos', 99.99, 'Cuisinart', 'cuchillos.jpg', 'Nuevo', 5, NULL, NULL),
(66, 'Comida para perros', 'Alimento balanceado para perros de todas las edades', 24.99, 'Pedigree', 'comida_perro.jpg', 'Nuevo', 6, NULL, NULL),
(67, 'Arenero para gatos', 'Arenero de plástico con tapa para gatos', 19.99, 'Petmate', 'arenero.jpg', 'Nuevo', 6, NULL, NULL),
(68, 'Cama para perros', 'Cama suave y cómoda para perros pequeños', 49.99, 'K&H', 'cama_perro.jpg', 'Nuevo', 6, NULL, NULL),
(69, 'Juguete para gatos', 'Pelota interactiva para mantener a los gatos entretenidos', 9.99, 'Petstages', 'juguete_gato.jpg', 'Nuevo', 6, NULL, NULL),
(70, 'Correa para perros', 'Correa extensible para paseos seguros', 14.99, 'Flexi', 'correa.jpg', 'Nuevo', 6, NULL, NULL),
(71, 'Muñeca Barbie', 'Muñeca clásica de Barbie con diferentes accesorios', 19.99, 'Mattel', 'barbie.jpg', 'Nuevo', 7, NULL, NULL),
(72, 'LEGO City', 'Set de construcción LEGO para crear una ciudad', 49.99, 'LEGO', 'lego_city.jpg', 'Nuevo', 7, NULL, NULL),
(73, 'Peluche de oso', 'Peluche suave de oso para niños', 14.99, 'Build-A-Bear', 'peluche.jpg', 'Nuevo', 7, NULL, NULL),
(74, 'Juego de mesa Monopoly', 'Versión clásica de Monopoly, juego de mesa', 29.99, 'Hasbro', 'monopoly.jpg', 'Nuevo', 7, NULL, NULL),
(75, 'Carro de control remoto', 'Carro a control remoto con velocidad ajustable', 39.99, 'Fisher-Price', 'carro_rc.jpg', 'Nuevo', 7, NULL, NULL),
(76, 'Cerveza Corona', 'Cerveza mexicana tipo lager', 1.99, 'Corona', 'cerveza.jpg', 'Nuevo', 8, NULL, NULL),
(77, 'Vino Tinto', 'Vino tinto seco de la región de Napa', 12.99, 'Napa Valley', 'vino.jpg', 'Nuevo', 8, NULL, NULL),
(78, 'Jugo de Naranja', 'Jugo natural 100% de naranja', 3.99, 'Minute Maid', 'jugo.jpg', 'Nuevo', 8, NULL, NULL),
(79, 'Agua Mineral', 'Agua mineral con gas', 1.29, 'San Pellegrino', 'agua.jpg', 'Nuevo', 8, NULL, NULL),
(80, 'Café Starbucks', 'Café tostado en grano para preparar en casa', 7.99, 'Starbucks', 'cafe.jpg', 'Nuevo', 8, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usr_id` int(11) NOT NULL,
  `usr_nombre` varchar(50) DEFAULT NULL,
  `usr_apaterno` varchar(50) DEFAULT NULL,
  `usr_amaterno` varchar(50) DEFAULT NULL,
  `usr_usuario` varchar(50) DEFAULT NULL,
  `usr_psword` varchar(255) DEFAULT NULL,
  `usr_correo` varchar(100) DEFAULT NULL,
  `usr_telefono` varchar(20) DEFAULT NULL,
  `usr_direccion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usr_id`, `usr_nombre`, `usr_apaterno`, `usr_amaterno`, `usr_usuario`, `usr_psword`, `usr_correo`, `usr_telefono`, `usr_direccion`) VALUES
(1, 'Karim', 'Rivera', 'Calderon', 'karim', '$2y$10$S6ikwxUTHXwFVfLx6Tcugeo/DaEddzedn8lArAknRZZhMN8Sv6xmK', 'karimkyurem@gmail.com', '123445', 'direccionfalsa'),
(2, 'Karim', 'r', 'c', 'correo@mail.com', '$2y$10$jJE3rbidH728NA0GId4i4O1nMyvjfDlETOIsNb1NykFXR9n15Qz/a', 'mail@mail.com', '123', '123');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vendedor`
--

CREATE TABLE `vendedor` (
  `usr_fk_usuario` int(11) NOT NULL,
  `usr_ranking` int(11) DEFAULT NULL,
  `usr_NumVentas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `vendedor`
--

INSERT INTO `vendedor` (`usr_fk_usuario`, `usr_ranking`, `usr_NumVentas`) VALUES
(1, 0, 0),
(2, 0, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`car_fk_producto`,`car_fk_usuario`),
  ADD KEY `car_fk_usuario` (`car_fk_usuario`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`inv_id_producto`);

--
-- Indices de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  ADD PRIMARY KEY (`ord_id`),
  ADD KEY `ord_vendedor` (`ord_vendedor`),
  ADD KEY `ord_cliente` (`ord_cliente`);

--
-- Indices de la tabla `orden_productos`
--
ALTER TABLE `orden_productos`
  ADD PRIMARY KEY (`orpd_id`),
  ADD KEY `orpd_idproducto` (`orpd_idproducto`),
  ADD KEY `orden_productos_ibfk_2` (`orpd_idorden`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idproducto`),
  ADD KEY `prd_categoria` (`prd_categoria`),
  ADD KEY `prd_id_vendedor` (`prd_id_vendedor`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usr_id`),
  ADD UNIQUE KEY `usr_usuario` (`usr_usuario`);

--
-- Indices de la tabla `vendedor`
--
ALTER TABLE `vendedor`
  ADD PRIMARY KEY (`usr_fk_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  MODIFY `ord_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `orden_productos`
--
ALTER TABLE `orden_productos`
  MODIFY `orpd_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idproducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
