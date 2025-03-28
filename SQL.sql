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
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `marca` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `modelo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `codigo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `ram` int NOT NULL,
  `disco` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `procesador` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tarjeta_grafica` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `sistema_operativo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla helpdesk.computadoras: ~0 rows (aproximadamente)
DELETE FROM `computadoras`;
INSERT INTO `computadoras` (`id`, `marca`, `modelo`, `codigo`, `ram`, `disco`, `procesador`, `tarjeta_grafica`, `sistema_operativo`, `fecha_registro`) VALUES
	(1, 'LENOVO', 'TICKPAD ', 'L5DRST', 20, 'MVNE 250GB', 'INTEL COREi 5 10G', 'INTEGRADA IRIS', 'WINDOWS 10', '2024-12-11 16:05:29');

-- Volcando estructura para tabla helpdesk.modulos
CREATE TABLE IF NOT EXISTS `modulos` (
  `IdModulo` int NOT NULL AUTO_INCREMENT COMMENT 'Identificador único del módulo',
  `NombreModulo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Nombre del módulo',
  `DescripcionModulo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Descripción del módulo',
  `DatecreateModulo` datetime DEFAULT (now()),
  `StatusModulo` int DEFAULT '1' COMMENT 'Estado del módulo: 0 = Inactivo, 1 = Activo',
  PRIMARY KEY (`IdModulo`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla helpdesk.modulos: ~13 rows (aproximadamente)
DELETE FROM `modulos`;
INSERT INTO `modulos` (`IdModulo`, `NombreModulo`, `DescripcionModulo`, `DatecreateModulo`, `StatusModulo`) VALUES
	(1, 'Dashboard', 'Panel principal con métricas y accesos rápidos', '2025-03-22 12:06:20', 1),
	(2, 'Trabajadores', 'Gestión de trabajadores', '2025-03-22 12:06:20', 1),
	(3, 'Técnicos', 'Gestión de técnicos', '2025-03-22 12:06:20', 1),
	(4, 'Roles', 'Administración de roles y permisos', '2025-03-22 12:06:20', 1),
	(5, 'Permisos', 'Administración de permisos', '2025-03-22 12:06:20', 1),
	(6, 'Gestión de Inventario', 'Manejo de productos y stock', '2025-03-22 12:06:20', 1),
	(7, 'Reportes de Inventario', 'Generación de reportes del inventario', '2025-03-22 12:06:20', 1),
	(8, 'Gestión de Tickets', 'Administración de tickets', '2025-03-22 12:06:20', 1),
	(9, 'Reportes de Tickets', 'Generación de reportes de tickets', '2025-03-22 12:06:20', 1),
	(10, 'Problemas', 'Clasificación y control de problemas reportados', '2025-03-22 12:06:20', 1),
	(11, 'Tips', 'Consejos y recomendaciones', '2025-03-22 12:06:20', 1),
	(12, 'Preguntas Frecuentes', 'Sección de preguntas frecuentes', '2025-03-22 12:06:20', 1),
	(13, 'Manuales', 'Documentación y guías de uso', '2025-03-22 12:06:20', 1),
	(14, 'Papelera', 'Módulo de elementos eliminados', '2025-03-22 12:06:20', 1),
	(17, 'Configuracion', 'Configuracion de la tabla trabajadores y tecnicos', '2025-03-26 07:42:03', 1);

-- Volcando estructura para tabla helpdesk.modulo_roles
CREATE TABLE IF NOT EXISTS `modulo_roles` (
  `IdModuloRol` int NOT NULL AUTO_INCREMENT COMMENT 'Identificador único de la relación módulo-rol',
  `IdModulo` int NOT NULL COMMENT 'ID del módulo (trabajadores o técnicos), relacionado con la tabla modulos',
  `IdRol` int NOT NULL COMMENT 'ID del rol asignado al módulo, relacionado con la tabla rol',
  `DatecreateModuloRol` datetime DEFAULT (now()) COMMENT 'Fecha y hora de creación de la relación',
  `StatusModuloRol` int DEFAULT '1' COMMENT 'Estado de la relación: 0 = Inactivo, 1 = Activo',
  PRIMARY KEY (`IdModuloRol`) USING BTREE,
  UNIQUE KEY `IdModuloIdRol` (`IdModulo`,`IdRol`) USING BTREE,
  KEY `FK_modulo_roles_rol` (`IdRol`),
  CONSTRAINT `FK_modulo_roles_modulos` FOREIGN KEY (`IdModulo`) REFERENCES `modulos` (`IdModulo`),
  CONSTRAINT `FK_modulo_roles_rol` FOREIGN KEY (`IdRol`) REFERENCES `rol` (`IdRol`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla helpdesk.modulo_roles: ~4 rows (aproximadamente)
DELETE FROM `modulo_roles`;
INSERT INTO `modulo_roles` (`IdModuloRol`, `IdModulo`, `IdRol`, `DatecreateModuloRol`, `StatusModuloRol`) VALUES
	(4, 3, 2, '2025-03-23 19:39:47', 1),
	(72, 2, 4, '2025-03-27 14:12:17', 1),
	(73, 2, 5, '2025-03-27 14:12:17', 1),
	(74, 2, 6, '2025-03-27 14:12:17', 1),
	(75, 2, 7, '2025-03-27 14:12:17', 1),
	(76, 2, 8, '2025-03-27 14:12:17', 1),
	(77, 2, 1, '2025-03-27 20:00:56', 1);

-- Volcando estructura para tabla helpdesk.permisos
CREATE TABLE IF NOT EXISTS `permisos` (
  `IdPermiso` int NOT NULL AUTO_INCREMENT,
  `IdRol` int NOT NULL,
  `IdModulo` int NOT NULL,
  `R` int DEFAULT '0',
  `W` int NOT NULL DEFAULT '0',
  `U` int DEFAULT '0',
  `D` int DEFAULT '0',
  `DatecreatePermiso` datetime DEFAULT (now()),
  PRIMARY KEY (`IdPermiso`),
  KEY `IdRol` (`IdRol`),
  KEY `IdModulo` (`IdModulo`),
  CONSTRAINT `FK_permisos_modulos` FOREIGN KEY (`IdModulo`) REFERENCES `modulos` (`IdModulo`),
  CONSTRAINT `FK_permisos_rol` FOREIGN KEY (`IdRol`) REFERENCES `rol` (`IdRol`)
) ENGINE=InnoDB AUTO_INCREMENT=315 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla helpdesk.permisos: ~135 rows (aproximadamente)
DELETE FROM `permisos`;
INSERT INTO `permisos` (`IdPermiso`, `IdRol`, `IdModulo`, `R`, `W`, `U`, `D`, `DatecreatePermiso`) VALUES
	(1, 1, 1, 1, 1, 1, 1, '2025-03-22 15:36:56'),
	(2, 1, 2, 1, 1, 1, 1, '2025-03-22 15:36:56'),
	(3, 1, 3, 1, 1, 1, 1, '2025-03-22 15:36:56'),
	(4, 1, 4, 1, 1, 1, 1, '2025-03-22 15:36:56'),
	(5, 1, 5, 1, 1, 1, 1, '2025-03-22 15:36:56'),
	(6, 1, 6, 1, 1, 1, 1, '2025-03-22 15:36:56'),
	(7, 1, 7, 1, 1, 1, 1, '2025-03-22 15:36:56'),
	(8, 1, 8, 1, 1, 1, 1, '2025-03-22 15:36:56'),
	(9, 1, 9, 1, 1, 1, 1, '2025-03-22 15:36:56'),
	(10, 1, 10, 1, 1, 1, 1, '2025-03-22 15:36:56'),
	(11, 1, 11, 1, 1, 1, 1, '2025-03-22 15:36:56'),
	(12, 1, 12, 1, 1, 1, 1, '2025-03-22 15:36:56'),
	(13, 1, 13, 1, 1, 1, 1, '2025-03-22 15:36:56'),
	(14, 1, 14, 1, 1, 1, 1, '2025-03-22 15:36:56'),
	(15, 2, 1, 0, 0, 0, 0, '2025-03-25 15:13:46'),
	(16, 2, 2, 0, 0, 0, 0, '2025-03-25 15:13:46'),
	(17, 2, 3, 0, 0, 0, 0, '2025-03-25 15:13:46'),
	(18, 2, 4, 0, 0, 0, 0, '2025-03-25 15:13:46'),
	(19, 2, 5, 0, 0, 0, 0, '2025-03-25 15:13:46'),
	(20, 2, 6, 0, 0, 0, 0, '2025-03-25 15:13:46'),
	(21, 2, 7, 0, 0, 0, 0, '2025-03-25 15:13:46'),
	(22, 2, 8, 0, 0, 0, 0, '2025-03-25 15:13:46'),
	(23, 2, 9, 0, 0, 0, 0, '2025-03-25 15:13:46'),
	(24, 2, 10, 0, 0, 0, 0, '2025-03-25 15:13:46'),
	(25, 2, 11, 0, 0, 0, 0, '2025-03-25 15:13:46'),
	(26, 2, 12, 0, 0, 0, 0, '2025-03-25 15:13:46'),
	(27, 2, 13, 0, 0, 0, 0, '2025-03-25 15:13:46'),
	(28, 2, 14, 0, 0, 0, 0, '2025-03-25 15:13:46'),
	(29, 3, 1, 0, 0, 0, 0, '2025-03-25 15:13:48'),
	(30, 3, 2, 0, 0, 0, 0, '2025-03-25 15:13:48'),
	(31, 3, 3, 0, 0, 0, 0, '2025-03-25 15:13:48'),
	(32, 3, 4, 0, 0, 0, 0, '2025-03-25 15:13:48'),
	(33, 3, 5, 0, 0, 0, 0, '2025-03-25 15:13:48'),
	(34, 3, 6, 0, 0, 0, 0, '2025-03-25 15:13:48'),
	(35, 3, 7, 0, 0, 0, 0, '2025-03-25 15:13:48'),
	(36, 3, 8, 0, 0, 0, 0, '2025-03-25 15:13:48'),
	(37, 3, 9, 0, 0, 0, 0, '2025-03-25 15:13:48'),
	(38, 3, 10, 0, 0, 0, 0, '2025-03-25 15:13:48'),
	(39, 3, 11, 0, 0, 0, 0, '2025-03-25 15:13:48'),
	(40, 3, 12, 0, 0, 0, 0, '2025-03-25 15:13:48'),
	(41, 3, 13, 0, 0, 0, 0, '2025-03-25 15:13:48'),
	(42, 3, 14, 0, 0, 0, 0, '2025-03-25 15:13:48'),
	(43, 4, 1, 0, 0, 0, 0, '2025-03-25 15:13:49'),
	(44, 4, 2, 0, 0, 0, 0, '2025-03-25 15:13:49'),
	(45, 4, 3, 0, 0, 0, 0, '2025-03-25 15:13:49'),
	(46, 4, 4, 0, 0, 0, 0, '2025-03-25 15:13:49'),
	(47, 4, 5, 0, 0, 0, 0, '2025-03-25 15:13:49'),
	(48, 4, 6, 0, 0, 0, 0, '2025-03-25 15:13:49'),
	(49, 4, 7, 0, 0, 0, 0, '2025-03-25 15:13:49'),
	(50, 4, 8, 0, 0, 0, 0, '2025-03-25 15:13:49'),
	(51, 4, 9, 0, 0, 0, 0, '2025-03-25 15:13:49'),
	(52, 4, 10, 0, 0, 0, 0, '2025-03-25 15:13:49'),
	(53, 4, 11, 0, 0, 0, 0, '2025-03-25 15:13:49'),
	(54, 4, 12, 0, 0, 0, 0, '2025-03-25 15:13:49'),
	(55, 4, 13, 0, 0, 0, 0, '2025-03-25 15:13:49'),
	(56, 4, 14, 0, 0, 0, 0, '2025-03-25 15:13:49'),
	(57, 5, 1, 0, 0, 0, 0, '2025-03-25 15:13:51'),
	(58, 5, 2, 0, 0, 0, 0, '2025-03-25 15:13:51'),
	(59, 5, 3, 0, 0, 0, 0, '2025-03-25 15:13:51'),
	(60, 5, 4, 0, 0, 0, 0, '2025-03-25 15:13:51'),
	(61, 5, 5, 0, 0, 0, 0, '2025-03-25 15:13:51'),
	(62, 5, 6, 0, 0, 0, 0, '2025-03-25 15:13:51'),
	(63, 5, 7, 0, 0, 0, 0, '2025-03-25 15:13:51'),
	(64, 5, 8, 0, 0, 0, 0, '2025-03-25 15:13:51'),
	(65, 5, 9, 0, 0, 0, 0, '2025-03-25 15:13:51'),
	(66, 5, 10, 0, 0, 0, 0, '2025-03-25 15:13:51'),
	(67, 5, 11, 0, 0, 0, 0, '2025-03-25 15:13:51'),
	(68, 5, 12, 0, 0, 0, 0, '2025-03-25 15:13:51'),
	(69, 5, 13, 0, 0, 0, 0, '2025-03-25 15:13:51'),
	(70, 5, 14, 0, 0, 0, 0, '2025-03-25 15:13:51'),
	(71, 6, 1, 0, 0, 0, 0, '2025-03-25 15:13:53'),
	(72, 6, 2, 0, 0, 0, 0, '2025-03-25 15:13:53'),
	(73, 6, 3, 0, 0, 0, 0, '2025-03-25 15:13:53'),
	(74, 6, 4, 0, 0, 0, 0, '2025-03-25 15:13:53'),
	(75, 6, 5, 0, 0, 0, 0, '2025-03-25 15:13:53'),
	(76, 6, 6, 0, 0, 0, 0, '2025-03-25 15:13:53'),
	(77, 6, 7, 0, 0, 0, 0, '2025-03-25 15:13:53'),
	(78, 6, 8, 0, 0, 0, 0, '2025-03-25 15:13:53'),
	(79, 6, 9, 0, 0, 0, 0, '2025-03-25 15:13:53'),
	(80, 6, 10, 0, 0, 0, 0, '2025-03-25 15:13:53'),
	(81, 6, 11, 0, 0, 0, 0, '2025-03-25 15:13:53'),
	(82, 6, 12, 0, 0, 0, 0, '2025-03-25 15:13:53'),
	(83, 6, 13, 0, 0, 0, 0, '2025-03-25 15:13:53'),
	(84, 6, 14, 0, 0, 0, 0, '2025-03-25 15:13:53'),
	(85, 7, 1, 0, 0, 0, 0, '2025-03-25 15:13:55'),
	(86, 7, 2, 0, 0, 0, 0, '2025-03-25 15:13:55'),
	(87, 7, 3, 0, 0, 0, 0, '2025-03-25 15:13:55'),
	(88, 7, 4, 0, 0, 0, 0, '2025-03-25 15:13:55'),
	(89, 7, 5, 0, 0, 0, 0, '2025-03-25 15:13:55'),
	(90, 7, 6, 0, 0, 0, 0, '2025-03-25 15:13:55'),
	(91, 7, 7, 0, 0, 0, 0, '2025-03-25 15:13:55'),
	(92, 7, 8, 0, 0, 0, 0, '2025-03-25 15:13:55'),
	(93, 7, 9, 0, 0, 0, 0, '2025-03-25 15:13:55'),
	(94, 7, 10, 0, 0, 0, 0, '2025-03-25 15:13:55'),
	(95, 7, 11, 0, 0, 0, 0, '2025-03-25 15:13:55'),
	(96, 7, 12, 0, 0, 0, 0, '2025-03-25 15:13:55'),
	(97, 7, 13, 0, 0, 0, 0, '2025-03-25 15:13:55'),
	(98, 7, 14, 0, 0, 0, 0, '2025-03-25 15:13:55'),
	(99, 8, 1, 0, 0, 0, 0, '2025-03-25 15:13:56'),
	(100, 8, 2, 0, 0, 0, 0, '2025-03-25 15:13:56'),
	(101, 8, 3, 0, 0, 0, 0, '2025-03-25 15:13:56'),
	(102, 8, 4, 0, 0, 0, 0, '2025-03-25 15:13:56'),
	(103, 8, 5, 0, 0, 0, 0, '2025-03-25 15:13:56'),
	(104, 8, 6, 0, 0, 0, 0, '2025-03-25 15:13:56'),
	(105, 8, 7, 0, 0, 0, 0, '2025-03-25 15:13:56'),
	(106, 8, 8, 0, 0, 0, 0, '2025-03-25 15:13:56'),
	(107, 8, 9, 0, 0, 0, 0, '2025-03-25 15:13:56'),
	(108, 8, 10, 0, 0, 0, 0, '2025-03-25 15:13:56'),
	(109, 8, 11, 0, 0, 0, 0, '2025-03-25 15:13:56'),
	(110, 8, 12, 0, 0, 0, 0, '2025-03-25 15:13:56'),
	(111, 8, 13, 0, 0, 0, 0, '2025-03-25 15:13:56'),
	(112, 8, 14, 0, 0, 0, 0, '2025-03-25 15:13:56'),
	(113, 10, 1, 0, 0, 0, 0, '2025-03-25 15:23:05'),
	(114, 10, 2, 0, 0, 0, 0, '2025-03-25 15:23:05'),
	(115, 10, 3, 0, 0, 0, 0, '2025-03-25 15:23:05'),
	(116, 10, 4, 0, 0, 0, 0, '2025-03-25 15:23:05'),
	(117, 10, 5, 0, 0, 0, 0, '2025-03-25 15:23:05'),
	(118, 10, 6, 0, 0, 0, 0, '2025-03-25 15:23:05'),
	(119, 10, 7, 0, 0, 0, 0, '2025-03-25 15:23:05'),
	(120, 10, 8, 0, 0, 0, 0, '2025-03-25 15:23:05'),
	(121, 10, 9, 0, 0, 0, 0, '2025-03-25 15:23:05'),
	(122, 10, 10, 0, 0, 0, 0, '2025-03-25 15:23:05'),
	(123, 10, 11, 0, 0, 0, 0, '2025-03-25 15:23:05'),
	(124, 10, 12, 0, 0, 0, 0, '2025-03-25 15:23:05'),
	(125, 10, 13, 0, 0, 0, 0, '2025-03-25 15:23:05'),
	(126, 10, 14, 0, 0, 0, 0, '2025-03-25 15:23:05'),
	(306, 1, 17, 0, 0, 0, 0, '2025-03-26 07:42:03'),
	(307, 2, 17, 0, 0, 0, 0, '2025-03-26 07:42:03'),
	(308, 3, 17, 0, 0, 0, 0, '2025-03-26 07:42:03'),
	(309, 4, 17, 0, 0, 0, 0, '2025-03-26 07:42:03'),
	(310, 5, 17, 0, 0, 0, 0, '2025-03-26 07:42:03'),
	(311, 6, 17, 0, 0, 0, 0, '2025-03-26 07:42:03'),
	(312, 7, 17, 0, 0, 0, 0, '2025-03-26 07:42:03'),
	(313, 8, 17, 0, 0, 0, 0, '2025-03-26 07:42:03'),
	(314, 10, 17, 0, 0, 0, 0, '2025-03-26 07:42:03');

-- Volcando estructura para tabla helpdesk.problema
CREATE TABLE IF NOT EXISTS `problema` (
  `problema_id` int NOT NULL AUTO_INCREMENT,
  `nombre_prob` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`problema_id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `IdRol` int NOT NULL AUTO_INCREMENT COMMENT 'Identificador único del rol',
  `NombreRol` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Nombre del rol',
  `DescripcionRol` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Descripción del rol',
  `DatecreateRol` datetime DEFAULT (now()),
  `StatusRol` int DEFAULT '1' COMMENT 'Estado del rol: 0 = Eliminado, 1 = Habilitado',
  PRIMARY KEY (`IdRol`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla helpdesk.rol: ~9 rows (aproximadamente)
DELETE FROM `rol`;
INSERT INTO `rol` (`IdRol`, `NombreRol`, `DescripcionRol`, `DatecreateRol`, `StatusRol`) VALUES
	(1, 'Administrador', 'Gestiona el sistema, configura permisos y administ', '2025-03-22 11:51:38', 1),
	(2, 'Soporte', 'Atiende incidencias, gestiona tickets y brinda asi', '2025-03-22 11:51:38', 1),
	(3, 'Trabajador', 'Accede a módulos operativos según sus permisos', '2025-03-22 11:51:38', 1),
	(4, 'SuperAdmin', 'Acceso total al sistema, incluso sobre administrad', '2025-03-22 12:08:39', 1),
	(5, 'Alcalde', 'Autoridad principal con acceso a reportes y audito', '2025-03-22 12:08:39', 1),
	(6, 'Gerente', 'Gestión de áreas específicas con permisos administ', '2025-03-22 12:08:39', 1),
	(7, 'Supervisor', 'Encargado de la supervisión de trabajadores y técn', '2025-03-22 12:08:39', 1),
	(8, 'UsuarioRegistrado', 'Rol con acceso básico al sistema', '2025-03-22 12:08:39', 1),
	(10, 'tercero', 'trabajadores contratados como terceros ', '2025-03-25 15:23:05', 1);

-- Volcando estructura para tabla helpdesk.tickets
CREATE TABLE IF NOT EXISTS `tickets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cod_ticket` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `department` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `usertraba_id` int NOT NULL,
  `userinfor_id` int DEFAULT '0',
  `problema_id` int NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=Eliminado\r\n1=Abierto, \r\n2=En Atencion, \r\n3=Resuelto, \r\n4=Reabierto, \r\n5=Cerrado, ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `IdUsuario` int NOT NULL AUTO_INCREMENT COMMENT 'Identificador único del usuario',
  `NombresUsuario` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Nombres del usuario',
  `ApellidosUsuario` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Apellidos del usuario',
  `TelefonoUsuario` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Número de teléfono del usuario',
  `DNIUsuario` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Documento Nacional de Identidad del usuario',
  `CorreoUsuario` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Correo electrónico del usuario',
  `UsernameUsuario` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Nombre de usuario para autenticación',
  `PasswordUsuario` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Contraseña del usuario, almacenada en formato seguro',
  `DatecreateUsuario` datetime NOT NULL DEFAULT (now()) COMMENT 'Fecha y hora de creación del usuario',
  `RolUsuario` int NOT NULL COMMENT 'ID del rol asignado al usuario, relacionado con la tabla rol',
  `StatusUsuario` int NOT NULL DEFAULT '1' COMMENT 'Estado del usuario: 0 = Inactivo, 1 = Activo',
  PRIMARY KEY (`IdUsuario`) USING BTREE,
  UNIQUE KEY `DNIUsuario` (`DNIUsuario`),
  KEY `RolUsuario` (`RolUsuario`),
  CONSTRAINT `FK_usuarios_rol` FOREIGN KEY (`RolUsuario`) REFERENCES `rol` (`IdRol`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla helpdesk.usuarios: ~3 rows (aproximadamente)
DELETE FROM `usuarios`;
INSERT INTO `usuarios` (`IdUsuario`, `NombresUsuario`, `ApellidosUsuario`, `TelefonoUsuario`, `DNIUsuario`, `CorreoUsuario`, `UsernameUsuario`, `PasswordUsuario`, `DatecreateUsuario`, `RolUsuario`, `StatusUsuario`) VALUES
	(1, 'Javier Antonio ', 'Padin Flores ', '917189300', '74199531', 'javierpadin661@gmail.com', 'javier20', 'afad7b36d11a0e2c7b30ec3a16c9077d8e2c4117f282f257790bd9f70641d840', '2025-03-21 23:54:52', 1, 1),
	(20, 'Jeanettis Marielee', 'Luyo Correaee', '999876545', '76543215', 'jeanettis@gmail.come', 'jeanettis20', '4be4143698061e956ac2742f354bcbd21e1e6ea33a583d28d07b12972decbdb9', '2025-03-24 01:08:51', 3, 1),
	(21, 'Jose Angel', 'Huaman Samudio', '987654321', '76543213', 'josehuaman@gmail.com', 'jose20', '92e7dd7306dbdd412c8d6b626b7c808f0c3fc692c9297aedf047ae918b11be58', '2025-03-24 19:28:52', 5, 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
