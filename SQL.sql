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

-- Volcando estructura para tabla helpdesk.inventarios
CREATE TABLE IF NOT EXISTS `inventarios` (
  `IdInventario` int NOT NULL AUTO_INCREMENT,
  `NombreInventario` varchar(200) DEFAULT NULL,
  `CodigoInventario` varchar(200) DEFAULT NULL,
  `DescripcionInventario` longtext,
  `DatecreateInventario` datetime NOT NULL DEFAULT (now()),
  `DateupdateInventario` datetime DEFAULT (now()),
  `StatusInventario` int DEFAULT '1',
  PRIMARY KEY (`IdInventario`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla helpdesk.inventarios: ~1 rows (aproximadamente)
DELETE FROM `inventarios`;
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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla helpdesk.modulos: ~16 rows (aproximadamente)
DELETE FROM `modulos`;
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla helpdesk.modulo_roles: ~3 rows (aproximadamente)
DELETE FROM `modulo_roles`;
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
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla helpdesk.permisos: ~77 rows (aproximadamente)
DELETE FROM `permisos`;
INSERT INTO `permisos` (`IdPermiso`, `IdRol`, `IdModulo`, `R`, `W`, `U`, `D`, `DatecreatePermiso`) VALUES
	(1, 1, 1, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(2, 1, 2, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(3, 1, 3, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(4, 1, 4, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(5, 1, 5, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(6, 1, 6, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(7, 1, 7, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(8, 1, 8, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(9, 1, 9, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(10, 1, 10, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(11, 1, 11, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(12, 1, 12, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(13, 1, 13, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(14, 1, 14, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(15, 1, 15, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(16, 1, 16, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(17, 5, 1, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(18, 5, 2, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(19, 5, 3, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(20, 5, 4, 1, 0, 1, 1, '2025-04-17 16:25:00'),
	(21, 5, 5, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(22, 5, 6, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(23, 5, 7, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(24, 5, 8, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(25, 5, 9, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(26, 5, 10, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(27, 5, 11, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(28, 5, 12, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(29, 5, 13, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(30, 5, 14, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(31, 5, 15, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(32, 5, 16, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(33, 7, 1, 1, 1, 1, 0, '2025-04-17 16:25:00'),
	(34, 7, 2, 0, 0, 0, 0, '2025-04-17 16:25:00'),
	(35, 7, 3, 0, 0, 0, 0, '2025-04-17 16:25:00'),
	(36, 7, 4, 0, 0, 0, 0, '2025-04-17 16:25:00'),
	(37, 7, 5, 0, 0, 0, 0, '2025-04-17 16:25:00'),
	(38, 7, 6, 0, 0, 0, 0, '2025-04-17 16:25:00'),
	(39, 7, 7, 0, 0, 0, 0, '2025-04-17 16:25:00'),
	(40, 7, 8, 0, 0, 0, 0, '2025-04-17 16:25:00'),
	(41, 7, 9, 0, 0, 0, 0, '2025-04-17 16:25:00'),
	(42, 7, 10, 0, 0, 0, 0, '2025-04-17 16:25:00'),
	(43, 7, 11, 0, 0, 0, 0, '2025-04-17 16:25:00'),
	(44, 7, 12, 0, 0, 0, 0, '2025-04-17 16:25:00'),
	(45, 7, 13, 0, 0, 0, 0, '2025-04-17 16:25:00'),
	(46, 7, 14, 0, 0, 0, 0, '2025-04-17 16:25:00'),
	(47, 7, 15, 0, 0, 0, 0, '2025-04-17 16:25:00'),
	(48, 8, 1, 1, 0, 1, 1, '2025-04-17 16:25:00'),
	(49, 8, 2, 0, 0, 0, 0, '2025-04-17 16:25:00'),
	(50, 8, 3, 0, 0, 0, 0, '2025-04-17 16:25:00'),
	(51, 8, 4, 0, 0, 0, 0, '2025-04-17 16:25:00'),
	(52, 8, 5, 0, 0, 0, 0, '2025-04-17 16:25:00'),
	(53, 8, 6, 0, 0, 0, 0, '2025-04-17 16:25:00'),
	(54, 8, 7, 0, 0, 0, 0, '2025-04-17 16:25:00'),
	(55, 8, 8, 0, 0, 0, 0, '2025-04-17 16:25:00'),
	(56, 8, 9, 0, 0, 0, 0, '2025-04-17 16:25:00'),
	(57, 8, 10, 0, 0, 0, 0, '2025-04-17 16:25:00'),
	(58, 8, 11, 0, 0, 0, 0, '2025-04-17 16:25:00'),
	(59, 8, 12, 0, 0, 0, 0, '2025-04-17 16:25:00'),
	(60, 8, 13, 0, 0, 0, 0, '2025-04-17 16:25:00'),
	(61, 8, 14, 0, 0, 0, 0, '2025-04-17 16:25:00'),
	(62, 8, 15, 0, 0, 0, 0, '2025-04-17 16:25:00'),
	(63, 9, 1, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(64, 9, 2, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(65, 9, 3, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(66, 9, 4, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(67, 9, 5, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(68, 9, 6, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(69, 9, 7, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(70, 9, 8, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(71, 9, 9, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(72, 9, 10, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(73, 9, 11, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(74, 9, 12, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(75, 9, 13, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(76, 9, 14, 1, 1, 1, 1, '2025-04-17 16:25:00'),
	(77, 9, 15, 1, 1, 1, 1, '2025-04-17 16:25:00');

-- Volcando estructura para tabla helpdesk.problemas
CREATE TABLE IF NOT EXISTS `problemas` (
  `IdProblema` int NOT NULL AUTO_INCREMENT,
  `NombreProblema` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `DataCreateProblema` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `StatusProblema` int DEFAULT '1',
  PRIMARY KEY (`IdProblema`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Volcando datos para la tabla helpdesk.problemas: ~10 rows (aproximadamente)
DELETE FROM `problemas`;
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla helpdesk.rol: ~9 rows (aproximadamente)
DELETE FROM `rol`;
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
  `NombreSubproblema` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `DescripcionSubproblema` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `DataCreateSubproblema` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `StatusSubproblema` int DEFAULT '1',
  PRIMARY KEY (`IdSubproblema`),
  KEY `IdProblema` (`IdProblema`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Volcando datos para la tabla helpdesk.subproblemas: ~40 rows (aproximadamente)
DELETE FROM `subproblemas`;
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
  `DescripcionTicket` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla helpdesk.tickets: ~2 rows (aproximadamente)
DELETE FROM `tickets`;
INSERT INTO `tickets` (`IdTicket`, `CodTicket`, `IdUsuarioCreadorTicket`, `DepartamentoTicket`, `IdProblemaTicket`, `IdSubproblemaTicket`, `DescripcionTicket`, `IdUsuarioSoporteTicket`, `DataCreateTicket`, `DataUpdateTicket`, `StatusTicket`) VALUES
	(61, 'C_1', 1, 'Gerencia de Administración y Finanzas', 2, 6, '<p>dd</p>', NULL, '2025-04-19 10:42:13', '2025-04-19 10:42:13', 1),
	(62, 'C_62', 1, 'Gerencia de Administración y Finanzas', 1, 2, '<p><br></p><table class="table table-bordered"><tbody><tr><td>fhhhhhhhhhhrrrrrrrrrr</td><td>f</td></tr><tr><td>f</td><td>f</td></tr></tbody></table><p>cfdfdfddf</p>', NULL, '2025-04-19 12:49:12', '2025-04-19 13:54:16', 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla helpdesk.usuarios: ~3 rows (aproximadamente)
DELETE FROM `usuarios`;
INSERT INTO `usuarios` (`IdUsuario`, `NombresUsuario`, `ApellidosUsuario`, `TelefonoUsuario`, `DNIUsuario`, `CorreoUsuario`, `UsernameUsuario`, `PasswordUsuario`, `DatecreateUsuario`, `RolUsuario`, `StatusUsuario`) VALUES
	(1, 'Javier Antonio ', 'Padin Flores ', '917189300', '74199531', 'javierpadin661@gmail.com', 'javier20', 'afad7b36d11a0e2c7b30ec3a16c9077d8e2c4117f282f257790bd9f70641d840', '2025-03-21 23:54:52', 5, 1),
	(2, 'Jose Angel', 'Huaman Samudio', '987654321', '76543213', 'josehuaman@gmail.com', 'jose20w', 'afad7b36d11a0e2c7b30ec3a16c9077d8e2c4117f282f257790bd9f70641d840', '2025-03-24 19:28:52', 5, 1),
	(3, 'Jeanettis Mariel', 'Luyo Correa', '998765432', '75432145', 'Luyoc27@gmail.com', 'Mariel20uuu', '00640dc640eb11d3d036b88eb7ab388e38044d498afe77efc0188285b96742d4', '2025-04-06 19:50:42', 1, 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
