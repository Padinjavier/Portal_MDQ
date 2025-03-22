-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.3.0 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.10.0.7000
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Volcando estructura para tabla helpdesk.comments
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `user_type` tinyint(1) NOT NULL COMMENT '1= admin, 2= staff,3= customer',
  `ticket_id` int NOT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla helpdesk.comments: ~4 rows (aproximadamente)
DELETE FROM `comments`;
INSERT INTO `comments` (`id`, `user_id`, `user_type`, `ticket_id`, `comment`, `date_created`) VALUES
	(9, 1, 1, 0, '&lt;p&gt;bb&lt;/p&gt;', '2024-11-20 21:59:19'),
	(16, 1, 1, 50, '&lt;p&gt;luego de una revisión se&amp;nbsp; identificó que es daño de placa&amp;nbsp;&lt;/p&gt;', '2024-11-21 02:37:42'),
	(20, 1, 1, 50, '&lt;p&gt;&lt;img src=&quot;assets/evidencia/1732175107_WIN_20241010_11_12_37_Pro.jpg&quot; style=&quot;width: 50%;&quot;&gt;&lt;/p&gt;&lt;p&gt;el practicante se durmió y no reparo la maquina&lt;/p&gt;', '2024-11-21 02:45:35'),
	(21, 1, 1, 54, '&lt;p&gt;&lt;img src=&quot;assets/evidencia/1735154956_software_59_Padin Flores[R][R]_001.png&quot; style=&quot;width: 25%;&quot;&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;assets/evidencia/1735154979_images.jpeg&quot; style=&quot;width: 201px;&quot;&gt;&lt;br&gt;&lt;/p&gt;', '2024-12-25 14:30:05');

-- Volcando estructura para tabla helpdesk.computadoras
CREATE TABLE IF NOT EXISTS `computadoras` (
  `id` int NOT NULL AUTO_INCREMENT,
  `marca` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `modelo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `codigo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ram` int NOT NULL,
  `disco` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `procesador` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tarjeta_grafica` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sistema_operativo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla helpdesk.computadoras: ~1 rows (aproximadamente)
DELETE FROM `computadoras`;
INSERT INTO `computadoras` (`id`, `marca`, `modelo`, `codigo`, `ram`, `disco`, `procesador`, `tarjeta_grafica`, `sistema_operativo`, `fecha_registro`) VALUES
	(1, 'LENOVO', 'TICKPAD ', 'L5DRST', 20, 'MVNE 250GB', 'INTEL COREi 5 10G', 'INTEGRADA IRIS', 'WINDOWS 10', '2024-12-11 16:05:29');

-- Volcando estructura para tabla helpdesk.problema
CREATE TABLE IF NOT EXISTS `problema` (
  `problema_id` int NOT NULL AUTO_INCREMENT,
  `nombre_prob` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`problema_id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla helpdesk.problema: ~49 rows (aproximadamente)
DELETE FROM `problema`;
INSERT INTO `problema` (`problema_id`, `nombre_prob`) VALUES
	(1, 'Computadora / Laptop'),
	(2, 'Monitor'),
	(3, 'Teclado / Mouse / Parlantes'),
	(4, 'Impresora / Plotter / Escáner'),
	(5, 'Disco Duro / Memoria USB / CD'),
	(6, 'Teléfono / Anexo'),
	(7, 'Proyector Multimedia'),
	(8, 'Reloj Biométrico'),
	(9, 'Windows / Office / Autocad'),
	(10, 'Problemas con programas o sistemas de la oficina'),
	(11, 'No puedo acceder a carpetas o archivos compartidos'),
	(12, 'Correo Electrónico Institucional'),
	(13, 'No puedo entrar a la página web de la institución'),
	(14, 'Problemas con el Internet'),
	(15, 'Reuniones virtuales (Zoom, Teams, Meet)'),
	(16, 'Compra o evaluación de computadora o periférico'),
	(17, 'Problemas con firma digital'),
	(18, 'Computadora lenta'),
	(19, 'Pantalla azul en la computadora'),
	(20, 'No se puede abrir un archivo'),
	(21, 'No funciona el correo electrónico'),
	(22, 'Internet se desconecta seguido'),
	(23, 'Impresora no imprime'),
	(24, 'La computadora no enciende'),
	(25, 'Problemas para entrar a una reunión virtual'),
	(26, 'Error al abrir un programa'),
	(27, 'No funciona la cámara en la videollamada'),
	(28, 'Teclado o mouse no responde'),
	(29, 'No puedo acceder a una página web'),
	(30, 'Olvidé mi contraseña de correo'),
	(31, 'Faltan archivos en mi computadora'),
	(32, 'Recibo muchos correos de spam'),
	(33, 'Problema al conectar memoria USB'),
	(34, 'No puedo imprimir a doble cara'),
	(35, 'Error al enviar archivos grandes por correo'),
	(36, 'Problema para entrar a un sistema con mi usuario'),
	(37, 'No me llega la notificación de un trámite'),
	(38, 'Impresora imprime a rayas'),
	(39, 'Impresora imprime en otros colores'),
	(40, 'Impresora no imprime en negro'),
	(41, 'Impresora no enciende'),
	(42, 'Impresora sin tinta o tóner'),
	(43, 'No puedo escribir en Word o Excel'),
	(44, 'Aparece mensaje de licencia desactivada en Office'),
	(45, 'Office pide activar la licencia de nuevo'),
	(46, 'Error al abrir un archivo de Word o Excel'),
	(47, 'No puedo guardar mi archivo en Office'),
	(48, 'Office está en modo de solo lectura'),
	(49, 'OTROS');

-- Volcando estructura para tabla helpdesk.rol
CREATE TABLE IF NOT EXISTS `rol` (
  `idrol` int NOT NULL AUTO_INCREMENT,
  `nombre_rol` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `descripcion_rol` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` int DEFAULT '1',
  PRIMARY KEY (`idrol`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla helpdesk.rol: ~3 rows (aproximadamente)
DELETE FROM `rol`;
INSERT INTO `rol` (`idrol`, `nombre_rol`, `descripcion_rol`, `status`) VALUES
	(1, 'admin', 'admin', 1),
	(2, 'soporte', 'encargados de dar soporte a los trabajadores de la', 1),
	(3, 'trabajadores', 'encargados de cumplir sus funciones en las diferen', 1);

-- Volcando estructura para tabla helpdesk.tickets
CREATE TABLE IF NOT EXISTS `tickets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cod_ticket` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `department` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `usertraba_id` int NOT NULL,
  `userinfor_id` int DEFAULT '0',
  `problema_id` int NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=Eliminado\r\n1=Abierto, \r\n2=En Atencion, \r\n3=Resuelto, \r\n4=Reabierto, \r\n5=Cerrado, ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla helpdesk.tickets: ~5 rows (aproximadamente)
DELETE FROM `tickets`;
INSERT INTO `tickets` (`id`, `cod_ticket`, `department`, `usertraba_id`, `userinfor_id`, `problema_id`, `description`, `date_created`, `status`) VALUES
	(50, 'T_1', 'subgerencia_de_registro_civil', 10, 1, 23, 'Aparece error en la pantalla limpiar de almohadillas', '2024-11-19 10:31:51', 1),
	(51, 'T_2', 'subgerencia_de_recursos_humanos', 10, 0, 5, '&lt;p&gt;EL DISCO SUENA&amp;nbsp;&lt;/p&gt;', '2024-11-24 11:56:14', 1),
	(52, 'T_3', 'gerencia_de_administración_y_finanzas', 13, 13, 12, '&lt;p&gt;HHHH&lt;/p&gt;', '2024-11-24 12:01:29', 1),
	(53, 'T_4', 'subgerencia_de_contabilidad', 1, 1, 22, '&lt;p&gt;aaaaa&lt;/p&gt;', '2024-11-25 11:04:00', 4),
	(54, 'T_5', 'subgerencia_de_tesorería', 1, 14, 4, '&lt;p&gt;XXXXX&lt;/p&gt;', '2024-11-25 11:08:13', 2);

-- Volcando estructura para tabla helpdesk.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombres` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `apellidos` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `telefono` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dni` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `correo` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rol` int NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla helpdesk.usuarios: ~7 rows (aproximadamente)
DELETE FROM `usuarios`;
INSERT INTO `usuarios` (`id`, `nombres`, `apellidos`, `telefono`, `dni`, `correo`, `username`, `password`, `date_created`, `rol`, `status`) VALUES
	(1, 'Javier Antonio ', 'Padin Flores ', '917189300', '74199531', 'javierpadin661@gmail.com', 'javier20', 'afad7b36d11a0e2c7b30ec3a16c9077d8e2c4117f282f257790bd9f70641d840', '2025-03-21 23:54:52', 1, 1),
	(4, 'Mathias Gabriel', 'Padin Flores ', '924804802', '74199532', 'javierpadin662@gmail.com', 'mathias20', 'fc2e2294cd25e4383ac6995ffabe05cbf5ef46763f94aad805d069c17db9a28a', '2025-03-22 01:58:25', 2, 1),
	(5, 'Juan', 'Pérez López', '987654321', '12345678', 'juan.perez@email.com', 'juanperez', '630e8b9d4b526f224f721c299f586309b6da475a4c536fa66a48d8d0b2db7ff4', '2025-03-22 01:59:49', 2, 1),
	(6, 'María', 'González Torres', '912345678', '87654321', 'maria.gonzalez@email.com', 'mariagonzalez', '41262418c85bff0e53567a387f7a7a8cc62fcd17a3d0c8d341d069edbd8fdab2', '2025-03-22 01:59:49', 2, 1),
	(7, 'Carlos', 'Ramírez Soto', '956789123', '56781234', 'carlos.ramirez@email.com', 'carlosramirez', '5eb9252dbe42943e955e8bcea05943cec5a71297c6ac55669185db29bd9f94f7', '2025-03-22 01:59:49', 3, 1),
	(8, 'Ana', 'Fernández Díaz', '934567890', '34567890', 'ana.fernandez@email.com', 'anafernandez', '4b2b75f4cafde054cdabcdd3065b995f0379a39fa03da5853e5457c4fe091653', '2025-03-22 01:59:49', 3, 1),
	(9, 'Luis', 'Martínez Rojas', '976543210', '23456789', 'luis.martinez@email.com', 'luismartinez', 'c94a21dc9372bbc8d0172deb5ad400826995af10f965fdc8f59d1353d6194e11', '2025-03-22 01:59:49', 3, 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
