-- MySQL dump 10.13  Distrib 5.5.35, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: dev_dbkm
-- ------------------------------------------------------
-- Server version	5.5.35-1ubuntu1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES latin1 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `acceso`
--

DROP TABLE IF EXISTS `acceso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acceso` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del acceso',
  `usuario_id` int(11) NOT NULL COMMENT 'Identificador del usuario que accede',
  `tipo_acceso` int(1) NOT NULL DEFAULT '1' COMMENT 'Tipo de acceso (entrata o salida)',
  `ip` varchar(45) DEFAULT NULL COMMENT 'Direcci贸n IP del usuario que ingresa',
  `acceso_at` datetime DEFAULT NULL COMMENT 'Fecha de registro del acceso',
  PRIMARY KEY (`id`),
  KEY `fk_acceso_usuario_idx` (`usuario_id`),
  CONSTRAINT `fk_acceso_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='Tabla que registra los accesos de los usuarios al sistema';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `backup`
--

DROP TABLE IF EXISTS `backup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `denominacion` varchar(200) NOT NULL,
  `tamano` varchar(45) DEFAULT NULL,
  `archivo` varchar(45) NOT NULL,
  `backup_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_backup_usuario_idx` (`usuario_id`),
  CONSTRAINT `fk_backup_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Tabla que contiene las copias de seguridad del sistema';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backup`
--

LOCK TABLES `backup` WRITE;
/*!40000 ALTER TABLE `backup` DISABLE KEYS */;
INSERT INTO `backup` VALUES (1,2,'DBKM Inicial','3,44 KB','backup-1.sql.gz','2014-01-01 00:00:01');
/*!40000 ALTER TABLE `backup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estado_usuario`
--

DROP TABLE IF EXISTS `estado_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estado_usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del estado del usuario',
  `usuario_id` int(11) NOT NULL COMMENT 'Identificador del usuario',
  `estado_usuario` int(11) NOT NULL COMMENT 'C贸digo del estado del usuario',
  `descripcion` varchar(100) NOT NULL COMMENT 'Motivo del cambio de estado',
  `estado_usuario_at` datetime DEFAULT NULL COMMENT 'Fecha del cambio de estado',
  PRIMARY KEY (`id`),
  KEY `fk_estado_usuario_usuario_idx` (`usuario_id`),
  CONSTRAINT `fk_estado_usuario_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Tabla que contiene los estados de los usuarios';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado_usuario`
--

LOCK TABLES `estado_usuario` WRITE;
/*!40000 ALTER TABLE `estado_usuario` DISABLE KEYS */;
INSERT INTO `estado_usuario` VALUES (1,1,2,'Bloqueado por ser un usuario sin privilegios','2014-01-01 00:00:01'),(2,2,1,'Activo por ser el Super Usuario del sistema','2014-01-01 00:00:01');
/*!40000 ALTER TABLE `estado_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del men煤',
  `menu_id` int(11) DEFAULT NULL COMMENT 'Identificador del men煤 padre',
  `recurso_id` int(11) DEFAULT NULL COMMENT 'Identificador del recurso',
  `menu` varchar(45) NOT NULL COMMENT 'Texto a mostrar del men煤',
  `url` varchar(60) DEFAULT NULL COMMENT 'Url del men煤',
  `posicion` int(11) DEFAULT '0' COMMENT 'Posisi贸n dentro de otros items',
  `icono` varchar(45) DEFAULT NULL COMMENT 'Icono a mostrar ',
  `activo` int(1) NOT NULL DEFAULT '1' COMMENT 'Men煤 activo o inactivo',
  `visibilidad` int(1) NOT NULL DEFAULT '1' COMMENT 'Indica si el men煤 se muestra en el backend o en el frontend',
  `custom` int(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_menu_recurso_idx` (`recurso_id`),
  KEY `fk_menu_menu_idx` (`menu_id`),
  CONSTRAINT `fk_menu_menu` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_menu_recurso` FOREIGN KEY (`recurso_id`) REFERENCES `recurso` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='Tabla que contiene los men煤 para los usuarios';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES (1,NULL,NULL,'Dashboard','#',10,'fa-home',1,1,NULL),(2,1,2,'Dashboard','dashboard/',11,'fa-home',1,1,NULL),(3,NULL,NULL,'Sistema','#',900,'fa-cogs',1,1,NULL),(4,3,4,'Accesos','sistema/accesos/listar/',901,'fa-exchange',1,1,NULL),(5,3,5,'Auditor韆s','sistema/auditorias/',902,'fa-eye',1,1,NULL),(6,3,6,'Backups','sistema/backups/listar/',903,'fa-hdd-o',1,1,NULL),(7,3,7,'Mantenimiento','sistema/mantenimiento/',904,'fa-bolt',1,1,NULL),(8,3,8,'Men鷖','sistema/menus/listar/',905,'fa-list',1,1,NULL),(9,3,9,'Perfiles','sistema/perfiles/listar/',906,'fa-group',1,1,NULL),(10,3,10,'Permisos','sistema/permisos/listar/',907,'fa-magic',1,1,NULL),(11,3,11,'Recursos','sistema/recursos/listar/',908,'fa-lock',1,1,NULL),(12,3,12,'Usuarios','sistema/usuarios/listar/',909,'fa-user',1,1,NULL),(13,3,13,'Visor de sucesos','sistema/sucesos/listar/',910,'fa-filter',1,1,NULL),(14,3,14,'Sistema','sistema/configuracion/',911,'fa-wrench',1,1,NULL);
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perfil`
--

DROP TABLE IF EXISTS `perfil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `perfil` (
  `id` int(2) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del perfil',
  `perfil` varchar(45) NOT NULL COMMENT 'Nombre del perfil',
  `estado` int(1) NOT NULL DEFAULT '1' COMMENT 'Indica si el perfil esta activo o inactivo',
  `plantilla` varchar(45) DEFAULT 'default' COMMENT 'Plantilla para usar en el sitema',
  `perfil_at` datetime DEFAULT NULL COMMENT 'Fecha de registro del perfil',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Tabla que contiene los grupos de los usuarios';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perfil`
--

LOCK TABLES `perfil` WRITE;
/*!40000 ALTER TABLE `perfil` DISABLE KEYS */;
INSERT INTO `perfil` VALUES (1,'Super Usuario',1,'default','2014-01-01 00:00:01');
/*!40000 ALTER TABLE `perfil` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recurso`
--

DROP TABLE IF EXISTS `recurso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recurso` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del recurso',
  `modulo` varchar(45) DEFAULT NULL COMMENT 'Nombre del m贸dulo',
  `controlador` varchar(45) DEFAULT NULL COMMENT 'Nombre del controlador',
  `accion` varchar(45) DEFAULT NULL COMMENT 'Nombre de la acci贸n',
  `recurso` varchar(100) DEFAULT NULL COMMENT 'Nombre del recurso',
  `descripcion` text NOT NULL COMMENT 'Descripci贸n del recurso',
  `activo` int(1) NOT NULL DEFAULT '1' COMMENT 'Estado del recurso',
  `custom` int(1) DEFAULT '1',
  `recurso_at` datetime DEFAULT NULL COMMENT 'Fecha de registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='Tabla que contiene los recursos a los que acceden los usuarios';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recurso`
--

LOCK TABLES `recurso` WRITE;
/*!40000 ALTER TABLE `recurso` DISABLE KEYS */;
INSERT INTO `recurso` VALUES (1,'*','NULL','NULL','*','Comod韓 para la administraci髇 total (usar con cuidado)',1,NULL,'2014-01-01 00:00:01'),(2,'dashboard','*','*','dashboard/*/*','P醙ina principal del sistema',1,NULL,'2014-01-01 00:00:01'),(3,'sistema','mi_cuenta','*','sistema/mi_cuenta/*','Gesti髇 de la cuenta del usuario logueado',1,NULL,'2014-01-01 00:00:01'),(4,'sistema','accesos','*','sistema/accesos/*','Subm骴ulo para la gesti髇 de ingresos al sistema',1,NULL,'2014-01-01 00:00:01'),(5,'sistema','auditorias','*','sistema/auditorias/*','Subm骴ulo para el control de las acciones de los usuarios',1,NULL,'2014-01-01 00:00:01'),(6,'sistema','backups','*','sistema/backups/*','Subm骴ulo para la gesti髇 de las copias de seguridad',1,NULL,'2014-01-01 00:00:01'),(7,'sistema','mantenimiento','*','sistema/mantenimiento/*','Subm骴ulo para el mantenimiento de las tablas',1,NULL,'2014-01-01 00:00:01'),(8,'sistema','menus','*','sistema/menus/*','Subm骴ulo del sistema para la creaci髇 de men鷖',1,NULL,'2014-01-01 00:00:01'),(9,'sistema','perfiles','*','sistema/perfiles/*','Subm骴ulo del sistema para los perfiles de usuarios',1,NULL,'2014-01-01 00:00:01'),(10,'sistema','permisos','*','sistema/permisos/*','Subm骴ulo del sistema para asignar recursos a los perfiles',1,NULL,'2014-01-01 00:00:01'),(11,'sistema','recursos','*','sistema/recursos/*','Subm骴ulo del sistema para la gesti髇 de los recursos',1,NULL,'2014-01-01 00:00:01'),(12,'sistema','usuarios','*','sistema/usuarios/*','Subm骴ulo para la administraci髇 de los usuarios del sistema',1,NULL,'2014-01-01 00:00:01'),(13,'sistema','sucesos','*','sistema/sucesos/*','Subm骴ulo para el listado de los logs del sistema',1,NULL,'2014-01-01 00:00:01'),(14,'sistema','configuracion','*','sistema/configuracion/*','Subm骴ulo para la configuraci髇 de la aplicaci髇 (.ini)',1,NULL,'2014-01-01 00:00:01');
/*!40000 ALTER TABLE `recurso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recurso_perfil`
--

DROP TABLE IF EXISTS `recurso_perfil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recurso_perfil` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recurso_id` int(11) NOT NULL,
  `perfil_id` int(11) NOT NULL,
  `recurso_perfil_at` datetime DEFAULT NULL,
  `recurso_perfil_in` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_recurso_perfil_recurso_idx` (`recurso_id`),
  KEY `fk_recurso_perfil_perfil_idx` (`perfil_id`),
  CONSTRAINT `fk_recurso_perfil_perfil` FOREIGN KEY (`perfil_id`) REFERENCES `perfil` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_recurso_perfil_recurso` FOREIGN KEY (`recurso_id`) REFERENCES `recurso` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='Tabla que contiene los recursos del usuario en el sistema segun su perfl';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recurso_perfil`
--

LOCK TABLES `recurso_perfil` WRITE;
/*!40000 ALTER TABLE `recurso_perfil` DISABLE KEYS */;
INSERT INTO `recurso_perfil` VALUES (1,1,1,'2014-01-01 00:00:01',NULL),(2,2,2,'2014-03-31 23:35:39',NULL),(3,2,3,'2014-03-31 23:39:29',NULL),(4,3,3,'2014-03-31 23:39:29',NULL),(5,3,2,'2014-03-31 23:45:17',NULL),(6,2,4,'2014-03-31 23:59:48',NULL),(7,3,4,'2014-03-31 23:59:48',NULL),(8,2,5,'2014-04-01 00:01:25',NULL),(9,3,5,'2014-04-01 00:01:25',NULL),(10,2,6,'2014-04-01 00:01:44',NULL),(11,3,6,'2014-04-01 00:01:44',NULL),(12,2,7,'2014-04-01 00:02:28',NULL),(13,3,7,'2014-04-01 00:02:28',NULL),(14,2,8,'2014-04-01 00:02:56',NULL),(15,3,8,'2014-04-01 00:02:56',NULL),(16,2,9,'2014-04-01 00:03:33',NULL),(17,3,9,'2014-04-01 00:03:33',NULL),(18,2,10,'2014-04-01 00:10:55',NULL),(19,3,10,'2014-04-01 00:10:55',NULL),(20,2,11,'2014-04-01 00:12:48',NULL),(21,3,11,'2014-04-01 00:12:48',NULL);
/*!40000 ALTER TABLE `recurso_perfil` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del usuario',
  `nombre` varchar(70) NOT NULL COMMENT 'Nombre del Usuario',
  `apellido` varchar(70) NOT NULL COMMENT 'Apellido del usuario',
  `login` varchar(45) NOT NULL COMMENT 'Nombre de usuario',
  `password` varchar(45) NOT NULL COMMENT 'Contrase帽a de acceso al sistea',
  `perfil_id` int(2) NOT NULL COMMENT 'Identificador del perfil',
  `email` varchar(45) DEFAULT NULL COMMENT 'Direcci贸n del correo elect贸nico',
  `tema` varchar(45) DEFAULT 'default' COMMENT 'Tema aplicable para la interfaz',
  `app_ajax` int(1) DEFAULT '1' COMMENT 'Indica si la app se trabaja con ajax o peticiones normales',
  `datagrid` int(11) DEFAULT '30' COMMENT 'Datos por p谩gina en los datagrid',
  `fotografia` varchar(45) DEFAULT 'default.png',
  `pool` varchar(45) DEFAULT NULL,
  `usuario_at` datetime DEFAULT NULL COMMENT 'Fecha de registro',
  `usuario_in` datetime DEFAULT NULL COMMENT 'Fecha de la 煤ltima modificaci贸n',
  PRIMARY KEY (`id`),
  KEY `fk_usuario_perfil_idx` (`perfil_id`),
  CONSTRAINT `fk_usuario_perfil` FOREIGN KEY (`perfil_id`) REFERENCES `perfil` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Tabla que contiene los usuarios';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'Cronjob','System','cronjob','963db57a0088931e0e3627b1e73e6eb5',1,NULL,'default',1,30,'default.png',NULL,'2013-01-01 00:00:01',NULL),(2,'S鷓er','Admin','admin','7c4a8d09ca3762af61e59520943dc26494f8941b',1,NULL,'default',1,30,'default.png',NULL,'2013-01-01 00:00:01',NULL);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-04-05 13:34:33
