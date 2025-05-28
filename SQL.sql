-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         9.1.0 - MySQL Community Server - GPL
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


-- Volcando estructura de base de datos para helpdesk
CREATE DATABASE IF NOT EXISTS `helpdesk` /*!40100 DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `helpdesk`;

-- Volcando estructura para tabla helpdesk.comentarios_tickets
CREATE TABLE IF NOT EXISTS `comentarios_tickets` (
  `IdComentario` int NOT NULL AUTO_INCREMENT,
  `IdTicket` int NOT NULL,
  `Comentario` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `FechaComentario` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `IdUsuarioComentario` int NOT NULL,
  PRIMARY KEY (`IdComentario`),
  KEY `IdTicket` (`IdTicket`),
  KEY `FK_comentarios_tickets_usuarios` (`IdUsuarioComentario`),
  CONSTRAINT `FK_comentarios_tickets_tickets` FOREIGN KEY (`IdTicket`) REFERENCES `tickets` (`IdTicket`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_comentarios_tickets_usuarios` FOREIGN KEY (`IdUsuarioComentario`) REFERENCES `usuarios` (`IdUsuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla helpdesk.comentarios_tickets: ~10 rows (aproximadamente)
INSERT INTO `comentarios_tickets` (`IdComentario`, `IdTicket`, `Comentario`, `FechaComentario`, `IdUsuarioComentario`) VALUES
	(1, 69, 'iiyiiyiy', '2025-05-02 22:30:33', 1),
	(2, 69, 'yyyyyyyy', '2025-05-02 23:40:27', 3),
	(4, 76, '<p>ghghghhg</p>', '2025-05-03 23:48:26', 1),
	(22, 76, '<p></p><p>arreglado</p>', '2025-05-12 09:25:45', 1),
	(23, 76, '<p></p><p><br></p><p><br></p><p>arreglado</p>', '2025-05-12 09:26:39', 1),
	(24, 76, '<p></p><p><br></p><p><br></p><p>arreglado</p>', '2025-05-12 09:26:57', 1),
	(25, 76, '<p></p><p><br></p><p><br></p><p>arreglado</p>', '2025-05-12 09:26:58', 1),
	(26, 76, 'fff', '2025-05-12 09:27:06', 1),
	(27, 76, '<p>ddssdsd</p>', '2025-05-12 09:29:14', 1),
	(28, 76, '<div>Swal.fire({</div><div>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; title: "Error",</div><div>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; html: typeof error === \'string\' ? error : "Error desconocido",&nbsp; &nbsp; &nbsp; &nbsp; // Si no es JSON válido, mostrar el error crudo (HTML)</div><div>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; icon: "error",</div><div>&nbsp; &nbsp; &nbsp; &nbsp; })</div>', '2025-05-12 09:31:04', 1);

-- Volcando estructura para tabla helpdesk.inventarios
CREATE TABLE IF NOT EXISTS `inventarios` (
  `IdInventario` int NOT NULL AUTO_INCREMENT,
  `NombreInventario` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `CodigoInventario` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `DescripcionInventario` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `DatecreateInventario` datetime NOT NULL DEFAULT (now()),
  `DateupdateInventario` datetime DEFAULT (now()),
  `StatusInventario` int DEFAULT '1',
  PRIMARY KEY (`IdInventario`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla helpdesk.inventarios: ~1 rows (aproximadamente)
INSERT INTO `inventarios` (`IdInventario`, `NombreInventario`, `CodigoInventario`, `DescripcionInventario`, `DatecreateInventario`, `DateupdateInventario`, `StatusInventario`) VALUES
	(1, 'yyy', 'yyu', 'iiii', '2025-04-19 23:00:41', '2025-04-19 23:00:41', 1);

-- Volcando estructura para tabla helpdesk.modulos
CREATE TABLE IF NOT EXISTS `modulos` (
  `IdModulo` int NOT NULL AUTO_INCREMENT COMMENT 'Identificador único del módulo',
  `NombreModulo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Nombre del módulo',
  `DescripcionModulo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Descripción del módulo',
  `DatecreateModulo` datetime DEFAULT (now()),
  `StatusModulo` int DEFAULT '1' COMMENT 'Estado del módulo: 0 = Inactivo, 1 = Activo',
  PRIMARY KEY (`IdModulo`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla helpdesk.modulos: ~16 rows (aproximadamente)
INSERT INTO `modulos` (`IdModulo`, `NombreModulo`, `DescripcionModulo`, `DatecreateModulo`, `StatusModulo`) VALUES
	(1, 'Dashboard', 'Panel principal con métricas y accesos rápidos', '2025-03-22 12:06:20', 1),
	(2, 'Trabajadores', 'Gestión de trabajadores', '2025-03-22 12:06:20', 1),
	(3, 'Soportes', 'Gestión de soportes (staff)', '2025-03-22 12:06:20', 1),
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
	(15, 'Configuracion', 'Configuracion de la tabla trabajadores y tecnicos', '2025-03-26 07:42:03', 1),
	(16, 'Subproblemas', 'Subproblemas', '2025-04-01 06:54:32', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla helpdesk.modulo_roles: ~3 rows (aproximadamente)
INSERT INTO `modulo_roles` (`IdModuloRol`, `IdModulo`, `IdRol`, `DatecreateModuloRol`, `StatusModuloRol`) VALUES
	(1, 2, 2, '2025-03-29 17:59:44', 1),
	(2, 2, 5, '2025-03-29 17:59:44', 1),
	(5, 2, 1, '2025-04-06 10:53:51', 1);

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
  PRIMARY KEY (`IdPermiso`) USING BTREE,
  KEY `IdRol` (`IdRol`) USING BTREE,
  KEY `IdModulo` (`IdModulo`) USING BTREE,
  CONSTRAINT `FK_permisos_modulos` FOREIGN KEY (`IdModulo`) REFERENCES `modulos` (`IdModulo`),
  CONSTRAINT `FK_permisos_rol` FOREIGN KEY (`IdRol`) REFERENCES `rol` (`IdRol`)
) ENGINE=InnoDB AUTO_INCREMENT=256 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla helpdesk.permisos: ~141 rows (aproximadamente)
INSERT INTO `permisos` (`IdPermiso`, `IdRol`, `IdModulo`, `R`, `W`, `U`, `D`, `DatecreatePermiso`) VALUES
	(1, 1, 1, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(2, 1, 2, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(3, 1, 3, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(4, 1, 4, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(5, 1, 5, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(6, 1, 6, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(7, 1, 7, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(8, 1, 8, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(9, 1, 9, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(10, 1, 10, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(11, 1, 11, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(12, 1, 12, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(13, 1, 13, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(14, 1, 14, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(15, 1, 15, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(16, 1, 16, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(17, 2, 1, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(18, 2, 2, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(19, 2, 3, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(20, 2, 4, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(21, 2, 5, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(22, 2, 6, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(23, 2, 7, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(24, 2, 8, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(25, 2, 9, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(26, 2, 10, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(27, 2, 11, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(28, 2, 12, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(29, 2, 13, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(30, 2, 14, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(31, 2, 15, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(32, 2, 16, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(33, 3, 1, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(34, 3, 2, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(35, 3, 3, 0, 1, 1, 0, '2025-05-28 09:41:33'),
	(36, 3, 4, 0, 0, 1, 0, '2025-05-28 09:41:33'),
	(37, 3, 5, 0, 0, 1, 0, '2025-05-28 09:41:33'),
	(38, 3, 6, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(39, 3, 7, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(40, 3, 8, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(41, 3, 9, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(42, 3, 10, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(43, 3, 11, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(44, 3, 12, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(45, 3, 13, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(46, 3, 14, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(47, 3, 15, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(48, 3, 16, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(49, 4, 1, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(50, 4, 2, 0, 0, 1, 0, '2025-05-28 09:41:33'),
	(51, 4, 3, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(52, 4, 4, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(53, 4, 5, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(54, 4, 6, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(55, 4, 7, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(56, 4, 8, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(57, 4, 9, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(58, 4, 10, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(59, 4, 11, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(60, 4, 12, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(61, 4, 13, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(62, 4, 14, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(63, 4, 15, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(64, 4, 16, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(65, 5, 1, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(66, 5, 2, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(67, 5, 3, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(68, 5, 4, 1, 0, 1, 1, '2025-05-28 09:41:33'),
	(69, 5, 5, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(70, 5, 6, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(71, 5, 7, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(72, 5, 8, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(73, 5, 9, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(74, 5, 10, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(75, 5, 11, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(76, 5, 12, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(77, 5, 13, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(78, 5, 14, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(79, 5, 15, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(80, 5, 16, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(81, 6, 1, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(82, 6, 2, 0, 1, 0, 0, '2025-05-28 09:41:33'),
	(83, 6, 3, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(84, 6, 4, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(85, 6, 5, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(86, 6, 6, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(87, 6, 7, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(88, 6, 8, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(89, 6, 9, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(90, 6, 10, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(91, 6, 11, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(92, 6, 12, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(93, 6, 13, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(94, 6, 14, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(95, 6, 15, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(96, 6, 16, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(97, 7, 1, 1, 1, 1, 0, '2025-05-28 09:41:33'),
	(98, 7, 2, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(99, 7, 3, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(100, 7, 4, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(101, 7, 5, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(102, 7, 6, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(103, 7, 7, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(104, 7, 8, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(105, 7, 9, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(106, 7, 10, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(107, 7, 11, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(108, 7, 12, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(109, 7, 13, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(110, 7, 14, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(111, 7, 15, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(112, 8, 1, 1, 0, 1, 1, '2025-05-28 09:41:33'),
	(113, 8, 2, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(114, 8, 3, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(115, 8, 4, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(116, 8, 5, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(117, 8, 6, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(118, 8, 7, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(119, 8, 8, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(120, 8, 9, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(121, 8, 10, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(122, 8, 11, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(123, 8, 12, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(124, 8, 13, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(125, 8, 14, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(126, 8, 15, 0, 0, 0, 0, '2025-05-28 09:41:33'),
	(127, 9, 1, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(128, 9, 2, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(129, 9, 3, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(130, 9, 4, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(131, 9, 5, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(132, 9, 6, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(133, 9, 7, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(134, 9, 8, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(135, 9, 9, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(136, 9, 10, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(137, 9, 11, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(138, 9, 12, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(139, 9, 13, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(140, 9, 14, 1, 1, 1, 1, '2025-05-28 09:41:33'),
	(141, 9, 15, 1, 1, 1, 1, '2025-05-28 09:41:33');

-- Volcando estructura para tabla helpdesk.problemas
CREATE TABLE IF NOT EXISTS `problemas` (
  `IdProblema` int NOT NULL AUTO_INCREMENT,
  `NombreProblema` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `DataCreateProblema` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `StatusProblema` int DEFAULT '1',
  PRIMARY KEY (`IdProblema`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla helpdesk.problemas: ~10 rows (aproximadamente)
INSERT INTO `problemas` (`IdProblema`, `NombreProblema`, `DataCreateProblema`, `StatusProblema`) VALUES
	(1, 'Computadoras', '2025-04-01 04:52:05', 1),
	(2, 'Internet', '2025-04-01 04:52:05', 1),
	(3, 'Microsoft Word', '2025-04-01 04:52:05', 1),
	(4, 'Microsoft Excel', '2025-04-01 04:52:05', 1),
	(5, 'Microsoft PowerPoint', '2025-04-01 04:52:05', 1),
	(6, 'Nitro PDF', '2025-04-01 04:52:05', 1),
	(7, 'SIAF', '2025-04-01 04:52:05', 1),
	(8, 'Impresoras', '2025-04-01 04:52:05', 1),
	(9, 'Energía Eléctrica', '2025-04-01 04:52:05', 1),
	(10, 'Teléfono IP', '2025-04-01 04:52:05', 1);

-- Volcando estructura para tabla helpdesk.rol
CREATE TABLE IF NOT EXISTS `rol` (
  `IdRol` int NOT NULL AUTO_INCREMENT COMMENT 'Identificador único del rol',
  `NombreRol` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Nombre del rol',
  `DescripcionRol` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Descripción del rol',
  `DatecreateRol` datetime DEFAULT (now()),
  `StatusRol` int DEFAULT '1' COMMENT 'Estado del rol: 0 = Eliminado, 1 = Habilitado',
  PRIMARY KEY (`IdRol`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla helpdesk.rol: ~9 rows (aproximadamente)
INSERT INTO `rol` (`IdRol`, `NombreRol`, `DescripcionRol`, `DatecreateRol`, `StatusRol`) VALUES
	(1, 'Administrador', 'Gestiona el sistema, configura permisos y administra usuarios.', '2025-03-22 11:51:38', 1),
	(2, 'Trabajador', 'Accede a módulos específicos para realizar tareas asignadas.', '2025-03-22 11:51:38', 1),
	(3, 'Soporte', 'Gestiona incidencias, atiende tickets y brinda asistencia técnica.', '2025-03-22 11:51:38', 1),
	(4, 'Super Admin', 'Acceso total al sistema, incluyendo la gestión de administradores.', '2025-03-22 12:08:39', 1),
	(5, 'Alcalde', 'Máxima autoridad con acceso a reportes, auditorías y gestión general.', '2025-03-22 12:08:39', 1),
	(6, 'Gerente', 'Supervisa áreas específicas y toma decisiones administrativas.', '2025-03-22 12:08:39', 1),
	(7, 'Supervisor', 'Supervisa personal y operaciones asegurando cumplimiento de tareas.', '2025-03-22 12:08:39', 1),
	(8, 'Usuario Registrado', 'Accede a funciones básicas del sistema con permisos limitados.', '2025-03-22 12:08:39', 1),
	(9, 'Tercero', 'Personal contratado externamente con acceso restringido.', '2025-03-25 15:23:05', 1);

-- Volcando estructura para tabla helpdesk.subproblemas
CREATE TABLE IF NOT EXISTS `subproblemas` (
  `IdSubproblema` int NOT NULL AUTO_INCREMENT,
  `IdProblema` int NOT NULL,
  `NombreSubproblema` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `DescripcionSubproblema` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `DataCreateSubproblema` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `StatusSubproblema` int DEFAULT '1',
  PRIMARY KEY (`IdSubproblema`),
  KEY `IdProblema` (`IdProblema`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla helpdesk.subproblemas: ~40 rows (aproximadamente)
INSERT INTO `subproblemas` (`IdSubproblema`, `IdProblema`, `NombreSubproblema`, `DescripcionSubproblema`, `DataCreateSubproblema`, `StatusSubproblema`) VALUES
	(1, 1, 'Se apaga sola', '', '2025-04-01 04:52:20', 1),
	(2, 1, 'Pantalla azul al iniciar', '', '2025-04-01 04:52:20', 1),
	(3, 1, 'No enciende', '', '2025-04-01 04:52:20', 1),
	(4, 1, 'Se congela constantemente', '', '2025-04-01 04:52:20', 1),
	(5, 2, 'Internet muy lento', '', '2025-04-01 04:52:20', 1),
	(6, 2, 'Sin conexión', '', '2025-04-01 04:52:20', 1),
	(7, 2, 'WiFi se desconecta', '', '2025-04-01 04:52:20', 1),
	(8, 2, 'VPN no funciona', '', '2025-04-01 04:52:20', 1),
	(9, 3, 'No abre el programa', '', '2025-04-01 04:52:20', 1),
	(10, 3, 'Error al guardar documentos', '', '2025-04-01 04:52:20', 1),
	(11, 3, 'No reconoce formato de archivo', '', '2025-04-01 04:52:20', 1),
	(12, 3, 'Problemas con la licencia', '', '2025-04-01 04:52:20', 1),
	(13, 4, 'Celdas no calculan bien', '', '2025-04-01 04:52:20', 1),
	(14, 4, 'Error al abrir archivos', '', '2025-04-01 04:52:20', 1),
	(15, 4, 'Problemas con macros', '', '2025-04-01 04:52:20', 1),
	(16, 4, 'Se cierra inesperadamente', '', '2025-04-01 04:52:20', 1),
	(17, 5, 'No carga presentaciones', '', '2025-04-01 04:52:20', 1),
	(18, 5, 'Problemas con transiciones', '', '2025-04-01 04:52:20', 1),
	(19, 5, 'Error al exportar PDF', '', '2025-04-01 04:52:20', 1),
	(20, 5, 'No permite insertar videos', '', '2025-04-01 04:52:20', 1),
	(21, 6, 'No abre archivos PDF', '', '2025-04-01 04:52:20', 1),
	(22, 6, 'Error al firmar documentos', '', '2025-04-01 04:52:20', 1),
	(23, 6, 'Problemas al convertir PDF a Word', '', '2025-04-01 04:52:20', 1),
	(24, 6, 'No reconoce impresora virtual', '', '2025-04-01 04:52:20', 1),
	(25, 7, 'No conecta con el servidor', '', '2025-04-01 04:52:20', 1),
	(26, 7, 'Error en módulos de ejecución', '', '2025-04-01 04:52:20', 1),
	(27, 7, 'Problema con actualización', '', '2025-04-01 04:52:20', 1),
	(28, 7, 'Usuarios sin acceso', '', '2025-04-01 04:52:20', 1),
	(29, 8, 'No imprime', '', '2025-04-01 04:52:20', 1),
	(30, 8, 'Impresión en blanco', '', '2025-04-01 04:52:20', 1),
	(31, 8, 'Atasco de papel', '', '2025-04-01 04:52:20', 1),
	(32, 8, 'Error de conexión', '', '2025-04-01 04:52:20', 1),
	(33, 9, 'Apagón repentino', '', '2025-04-01 04:52:20', 1),
	(34, 9, 'Variaciones de voltaje (sube y baja repentinamente)', '', '2025-04-01 04:52:20', 1),
	(35, 9, 'UPS no responde', '', '2025-04-01 04:52:20', 1),
	(36, 9, 'Corte de energía en la oficina', '', '2025-04-01 04:52:20', 1),
	(37, 10, 'No tiene tono', '', '2025-04-01 04:52:20', 1),
	(38, 10, 'Se corta la llamada', '', '2025-04-01 04:52:20', 1),
	(39, 10, 'No registra en el sistema', '', '2025-04-01 04:52:20', 1),
	(40, 10, 'Eco o ruido en la llamada', '', '2025-04-01 04:52:20', 1);

-- Volcando estructura para tabla helpdesk.tickets
CREATE TABLE IF NOT EXISTS `tickets` (
  `IdTicket` int NOT NULL AUTO_INCREMENT,
  `CodTicket` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `IdUsuarioCreadorTicket` int NOT NULL,
  `DepartamentoTicket` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `IdProblemaTicket` int NOT NULL,
  `IdSubproblemaTicket` int DEFAULT NULL,
  `IdUsuarioSoporteTicket` int DEFAULT NULL,
  `DataCreateTicket` datetime NOT NULL DEFAULT (now()),
  `DataUpdateTicket` datetime DEFAULT (now()),
  `StatusTicket` int NOT NULL DEFAULT (1) COMMENT '0=Eliminado, 1=Abierto, 2=En Atención, 3=Resuelto, 4=Reabierto, 5=Cerrado',
  PRIMARY KEY (`IdTicket`) USING BTREE,
  KEY `FK_tickets_usuarios` (`IdUsuarioCreadorTicket`),
  KEY `FK_tickets_usuarios_2` (`IdUsuarioSoporteTicket`),
  KEY `FK_tickets_problemas` (`IdProblemaTicket`),
  KEY `FK_tickets_subproblemas` (`IdSubproblemaTicket`),
  CONSTRAINT `FK_tickets_problemas` FOREIGN KEY (`IdProblemaTicket`) REFERENCES `problemas` (`IdProblema`),
  CONSTRAINT `FK_tickets_subproblemas` FOREIGN KEY (`IdSubproblemaTicket`) REFERENCES `subproblemas` (`IdSubproblema`),
  CONSTRAINT `FK_tickets_usuarios` FOREIGN KEY (`IdUsuarioCreadorTicket`) REFERENCES `usuarios` (`IdUsuario`),
  CONSTRAINT `FK_tickets_usuarios_2` FOREIGN KEY (`IdUsuarioSoporteTicket`) REFERENCES `usuarios` (`IdUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla helpdesk.tickets: ~11 rows (aproximadamente)
INSERT INTO `tickets` (`IdTicket`, `CodTicket`, `IdUsuarioCreadorTicket`, `DepartamentoTicket`, `IdProblemaTicket`, `IdSubproblemaTicket`, `IdUsuarioSoporteTicket`, `DataCreateTicket`, `DataUpdateTicket`, `StatusTicket`) VALUES
	(61, 'TK_1', 1, 'Gerencia de Administración y Finanzas', 2, 6, 2, '2025-04-19 10:42:13', '2025-04-19 10:42:13', 1),
	(62, 'C_62', 1, 'Gerencia de Administración y Finanzas', 1, 2, NULL, '2025-04-19 12:49:12', '2025-04-19 13:54:16', 1),
	(68, 'C_8', 1, 'Gerencia de Administración y Finanzas', 2, 6, 3, '2025-04-19 10:42:13', '2025-04-19 10:42:13', 1),
	(69, 'TK_69', 2, 'Subgerencia de Recursos Humanos', 2, 6, 3, '2025-04-26 20:05:37', '2025-04-26 20:05:37', 1),
	(70, 'TK_70', 2, 'Subgerencia de Tesorería', 2, 7, NULL, '2025-04-28 00:04:23', '2025-04-28 00:04:23', 1),
	(71, 'TK_71', 2, 'Subgerencia de Contabilidad', 8, 31, NULL, '2025-04-29 22:28:36', '2025-04-29 22:28:36', 1),
	(72, 'TK_72', 2, 'Subgerencia de Contabilidad', 8, 31, NULL, '2025-04-29 22:29:03', '2025-04-30 12:32:57', 1),
	(73, 'TK_73', 2, 'Unidad Informática', 3, 11, NULL, '2025-04-30 10:35:38', '2025-05-02 18:52:29', 1),
	(74, 'TK_74', 1, 'Subgerencia de Logística, Abastecimiento y Control Patrimonial', 2, 6, NULL, '2025-04-30 19:19:55', '2025-05-02 18:48:47', 1),
	(75, 'TK_75', 1, 'Subgerencia de Recursos Humanos', 2, 6, 1, '2025-05-02 08:37:14', '2025-05-02 18:51:51', 0),
	(76, 'TK_76', 2, 'Subgerencia de Tesorería', 3, 11, 3, '2025-05-02 19:59:54', '2025-05-13 11:20:06', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla helpdesk.usuarios: ~3 rows (aproximadamente)
INSERT INTO `usuarios` (`IdUsuario`, `NombresUsuario`, `ApellidosUsuario`, `TelefonoUsuario`, `DNIUsuario`, `CorreoUsuario`, `UsernameUsuario`, `PasswordUsuario`, `DatecreateUsuario`, `RolUsuario`, `StatusUsuario`) VALUES
	(1, 'Javier Antonio ', 'Padin Flores ', '917189300', '74199531', 'javierpadin661@gmail.com', 'javier20', '1e5e7811deb7437161d451d9359803020c5f2e563f10985d53e8a4521bf90083', '2025-03-21 23:54:52', 1, 1),
	(2, 'Jose Angel', 'Huaman Samudio', '987654321', '76543213', 'josehuaman@gmail.com', 'jose20', 'afad7b36d11a0e2c7b30ec3a16c9077d8e2c4117f282f257790bd9f70641d840', '2025-03-24 19:28:52', 3, 1),
	(3, 'Jeanettis Mariel', 'Luyo Correa', '998765432', '75432145', 'Luyoc27@gmail.com', 'Mariel20uuu', '00640dc640eb11d3d036b88eb7ab388e38044d498afe77efc0188285b96742d4', '2025-04-06 19:50:42', 3, 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
