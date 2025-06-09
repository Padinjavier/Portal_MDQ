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
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- La exportación de datos fue deseleccionada.

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

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla helpdesk.modulos
CREATE TABLE IF NOT EXISTS `modulos` (
  `IdModulo` int NOT NULL AUTO_INCREMENT COMMENT 'Identificador único del módulo',
  `NombreModulo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Nombre del módulo',
  `DescripcionModulo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Descripción del módulo',
  `DatecreateModulo` datetime DEFAULT (now()),
  `StatusModulo` int DEFAULT '1' COMMENT 'Estado del módulo: 0 = Inactivo, 1 = Activo',
  PRIMARY KEY (`IdModulo`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- La exportación de datos fue deseleccionada.

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- La exportación de datos fue deseleccionada.

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
) ENGINE=InnoDB AUTO_INCREMENT=142 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla helpdesk.problemas
CREATE TABLE IF NOT EXISTS `problemas` (
  `IdProblema` int NOT NULL AUTO_INCREMENT,
  `NombreProblema` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `DataCreateProblema` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `StatusProblema` int DEFAULT '1',
  PRIMARY KEY (`IdProblema`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla helpdesk.rol
CREATE TABLE IF NOT EXISTS `rol` (
  `IdRol` int NOT NULL AUTO_INCREMENT COMMENT 'Identificador único del rol',
  `NombreRol` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Nombre del rol',
  `DescripcionRol` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Descripción del rol',
  `DatecreateRol` datetime DEFAULT (now()),
  `StatusRol` int DEFAULT '1' COMMENT 'Estado del rol: 0 = Eliminado, 1 = Habilitado',
  PRIMARY KEY (`IdRol`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- La exportación de datos fue deseleccionada.

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

-- La exportación de datos fue deseleccionada.

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
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- La exportación de datos fue deseleccionada.

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

-- La exportación de datos fue deseleccionada.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
