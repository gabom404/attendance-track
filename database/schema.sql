-- AttendanceTrack: Smart Attendance & Shift Control
-- Database Schema DDL Definition
-- Charset: utf8mb4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `attendancetrack_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `attendancetrack_db`;

-- --------------------------------------------------------
-- Table: planilla (Master Employee Registry with weekly shift schedules)
-- --------------------------------------------------------
DROP TABLE IF EXISTS `planilla`;
CREATE TABLE `planilla` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) NOT NULL,
  `cod_empleado` varchar(250) NOT NULL,
  `lunes_entrada` time NOT NULL DEFAULT '07:00:00',
  `lunes_salida` time NOT NULL DEFAULT '17:00:00',
  `martes_entrada` time NOT NULL DEFAULT '07:00:00',
  `martes_salida` time NOT NULL DEFAULT '17:00:00',
  `miercoles_entrada` time NOT NULL DEFAULT '07:00:00',
  `miercoles_salida` time NOT NULL DEFAULT '17:00:00',
  `jueves_entrada` time NOT NULL DEFAULT '07:00:00',
  `jueves_salida` time NOT NULL DEFAULT '17:00:00',
  `viernes_entrada` time NOT NULL DEFAULT '07:00:00',
  `viernes_salida` time NOT NULL DEFAULT '16:00:00',
  `sabado_entrada` time NOT NULL DEFAULT '07:00:00',
  `sabado_salida` time NOT NULL DEFAULT '12:00:00',
  `domingo_entrada` time NOT NULL DEFAULT '00:00:00',
  `domingo_salida` time NOT NULL DEFAULT '00:00:00',
  `status` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `img_empleado` varchar(250) NOT NULL DEFAULT 'images/picture.png',
  `rol` varchar(250) NOT NULL DEFAULT 'Operario',
  `tipo` enum('Fijo','Eventual') NOT NULL DEFAULT 'Fijo',
  `tel` varchar(50) NOT NULL DEFAULT '',
  `dui` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_cod_empleado` (`cod_empleado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: proyectos (Work Sites and Project Locations)
-- --------------------------------------------------------
DROP TABLE IF EXISTS `proyectos`;
CREATE TABLE `proyectos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_proyecto` varchar(250) NOT NULL,
  `id_encargado` int(11) NOT NULL DEFAULT 0,
  `nombre_encargado` varchar(250) NOT NULL DEFAULT '',
  `id_encargado2` int(11) NOT NULL DEFAULT 0,
  `nombre_encargado2` varchar(250) NOT NULL DEFAULT '',
  `id_encargado3` int(11) NOT NULL DEFAULT 0,
  `nombre_encargado3` varchar(250) NOT NULL DEFAULT '',
  `id_encargado4` int(11) NOT NULL DEFAULT 0,
  `nombre_encargado4` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: empleados_proyectos (Assignment of Employees to Active Projects)
-- --------------------------------------------------------
DROP TABLE IF EXISTS `empleados_proyectos`;
CREATE TABLE `empleados_proyectos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_empleado` varchar(250) NOT NULL,
  `nombre_proyecto` varchar(250) NOT NULL,
  `cod_empleado` varchar(250) NOT NULL,
  `date` date DEFAULT NULL,
  `img` varchar(250) NOT NULL DEFAULT 'images/picture.png',
  PRIMARY KEY (`id`),
  KEY `idx_ep_cod_empleado` (`cod_empleado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: empleados (Daily Attendance & Shift Punch Log Records)
-- --------------------------------------------------------
DROP TABLE IF EXISTS `empleados`;
CREATE TABLE `empleados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) NOT NULL,
  `cod_empleado` varchar(250) NOT NULL,
  `day` date DEFAULT NULL,
  `proyecto` varchar(250) NOT NULL DEFAULT '',
  `entrada` time NOT NULL DEFAULT '00:00:00',
  `salida` time NOT NULL DEFAULT '00:00:00',
  `status_entrada` varchar(70) NOT NULL DEFAULT 'Presente',
  `status_salida` varchar(70) DEFAULT NULL,
  `status_horas` varchar(50) NOT NULL DEFAULT '',
  `horas_extra` float NOT NULL DEFAULT 0,
  `justificacion` varchar(250) NOT NULL DEFAULT 'SI SE PRESENTÓ',
  `justificado_por` varchar(250) NOT NULL DEFAULT 'SI SE PRESENTÓ',
  `img` varchar(250) NOT NULL DEFAULT '',
  `notas` varchar(250) NOT NULL DEFAULT 'No hay notas para mostrar',
  PRIMARY KEY (`id`),
  KEY `idx_day_cod` (`day`, `cod_empleado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: asistencias (Unified Attendance View / Table)
-- --------------------------------------------------------
DROP TABLE IF EXISTS `asistencias`;
CREATE TABLE `asistencias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) NOT NULL,
  `cod_empleado` varchar(250) NOT NULL,
  `day` date DEFAULT NULL,
  `proyecto` varchar(250) NOT NULL DEFAULT '',
  `entrada` time NOT NULL DEFAULT '00:00:00',
  `salida` time NOT NULL DEFAULT '00:00:00',
  `status_entrada` varchar(70) NOT NULL DEFAULT 'Presente',
  `status_salida` varchar(70) DEFAULT NULL,
  `status_horas` varchar(50) NOT NULL DEFAULT '',
  `horas_extra` float NOT NULL DEFAULT 0,
  `justificacion` varchar(250) NOT NULL DEFAULT 'SI SE PRESENTÓ',
  `justificado_por` varchar(250) NOT NULL DEFAULT 'SI SE PRESENTÓ',
  `img` varchar(250) NOT NULL DEFAULT '',
  `notas` varchar(250) NOT NULL DEFAULT 'No hay notas para mostrar',
  PRIMARY KEY (`id`),
  KEY `idx_asistencias_day_cod` (`day`, `cod_empleado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: users (System Administrators & Project Supervisors)
-- --------------------------------------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_empleado` varchar(250) NOT NULL,
  `user_email` varchar(250) NOT NULL DEFAULT '',
  `password` varchar(250) NOT NULL,
  `salt` varchar(250) NOT NULL DEFAULT 'attendancetrack_salt',
  `nivel` int(11) NOT NULL DEFAULT 1 COMMENT '1 = Project Supervisor, 2 = Global Administrator',
  PRIMARY KEY (`id`),
  KEY `idx_user_nombre` (`nombre_empleado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: herramientas (Equipment and Tools Inventory)
-- --------------------------------------------------------
DROP TABLE IF EXISTS `herramientas`;
CREATE TABLE `herramientas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `herramienta` varchar(250) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 0,
  `img` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: sub_herramientas (Serialized Tool Units)
-- --------------------------------------------------------
DROP TABLE IF EXISTS `sub_herramientas`;
CREATE TABLE `sub_herramientas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_herramienta` int(11) NOT NULL,
  `marca` varchar(250) NOT NULL,
  `num_serie` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: materiales (Consumables and Project Materials)
-- --------------------------------------------------------
DROP TABLE IF EXISTS `materiales`;
CREATE TABLE `materiales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 0,
  `cantidad_minima` int(11) NOT NULL DEFAULT 0,
  `cantidad_maxima` int(11) NOT NULL DEFAULT 0,
  `proyecto` varchar(250) NOT NULL DEFAULT '',
  `detalles` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
