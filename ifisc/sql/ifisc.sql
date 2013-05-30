CREATE DATABASE  IF NOT EXISTS `adminifisc` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `adminifisc`;
-- MySQL dump 10.13  Distrib 5.5.16, for Win32 (x86)
--
-- Host: localhost    Database: adminifisc
-- ------------------------------------------------------
-- Server version	5.5.24-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `carrera`
--

DROP TABLE IF EXISTS `carrera`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `carrera` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Codigo` bigint(20) NOT NULL,
  `Nombre` varchar(45) DEFAULT NULL,
  `SemestresDuracion` int(10) unsigned zerofill DEFAULT NULL,
  `PlanEstudio` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Codigo_UNIQUE` (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COMMENT='Almacenará todas las carreras de los estudiantes.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carrera`
--

LOCK TABLES `carrera` WRITE;
/*!40000 ALTER TABLE `carrera` DISABLE KEYS */;
INSERT INTO `carrera` VALUES (5,1,'Lic. en Desarrollo de Software',NULL,NULL),(6,2,'Lic. en Informática Aplicada a la Educación',NULL,NULL),(7,3,'Lic. en Ing. de Sistemas y Computación',NULL,NULL),(8,4,'Lic. en Redes Informáticas',NULL,NULL);
/*!40000 ALTER TABLE `carrera` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) DEFAULT NULL,
  `Descripcion` varchar(45) DEFAULT NULL,
  `Codigo` bigint(20) unsigned zerofill DEFAULT NULL,
  `IsEstatico` bit(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `Nombre_UNIQUE` (`Nombre`),
  UNIQUE KEY `Codigo_UNIQUE` (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1 COMMENT='Categorias indicadas para cada publicación.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (1,'Evento','Eventos programados',00000000000000000001,'\0'),(2,'Actividad','Actividades dentro de la facultad',00000000000000000002,'\0'),(3,'Noticia','Noticias varias',00000000000000000003,'\0'),(4,'Oferta de Beca','Promoción de becas',00000000000000000004,'\0'),(5,'Ofertas de Trabajo','Divulgación de Empleos',00000000000000000005,'\0'),(6,'Ofertas de Prácticas Profesionales','Ofertas de Prácticas Profesionales',00000000000000000006,'\0'),(7,'Publicación Estatica','Publicación No Editable',00000000000000000007,''),(8,'Información FISC','Información acerca de la Facultad de Ingenier',00000000000000000008,''),(9,'Información Carrera','Información de las carreras de la facultad y ',00000000000000000009,''),(10,'Información TIC','Información de las diferentes Tecnologías de ',00000000000000000010,''),(11,'Información de Contacto','Información de contacto con las distintas ent',00000000000000000011,'');
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `correlativo`
--

DROP TABLE IF EXISTS `correlativo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `correlativo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Tipo` int(11) NOT NULL,
  `Valor` int(10) unsigned zerofill DEFAULT NULL,
  `Descripcion` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `tipo_UNIQUE` (`Tipo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `correlativo`
--

LOCK TABLES `correlativo` WRITE;
/*!40000 ALTER TABLE `correlativo` DISABLE KEYS */;
INSERT INTO `correlativo` VALUES (1,1,0000000001,'Correlativo de codigo de publicación');
/*!40000 ALTER TABLE `correlativo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `datosusuario`
--

DROP TABLE IF EXISTS `datosusuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `datosusuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre1` varchar(45) DEFAULT NULL,
  `Nombre2` varchar(45) DEFAULT NULL,
  `Apellido1` varchar(45) DEFAULT NULL,
  `Apellido2` varchar(45) DEFAULT NULL,
  `Cedula` varchar(45) DEFAULT NULL,
  `FechaNac` date DEFAULT NULL,
  `Codigo` varchar(45) DEFAULT NULL,
  `FechaMatr` date DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_carrera` int(11) DEFAULT NULL,
  `FechaInscrip` date DEFAULT NULL,
  `esHombre` bit(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `id_Usuario_idx` (`id_usuario`),
  KEY `usuario_carreraFK_idx` (`id_carrera`),
  CONSTRAINT `id_UsuarioFK` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `usuario_carreraFK` FOREIGN KEY (`id_carrera`) REFERENCES `carrera` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1 COMMENT='Datos detallados de los usuarios.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `datosusuario`
--

LOCK TABLES `datosusuario` WRITE;
/*!40000 ALTER TABLE `datosusuario` DISABLE KEYS */;
/*!40000 ALTER TABLE `datosusuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `display`
--

DROP TABLE IF EXISTS `display`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `display` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_enlace` int(10) unsigned zerofill NOT NULL,
  `isCategoria` bit(1) DEFAULT NULL,
  `Nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COMMENT='contiene la informacion del menu';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `display`
--

LOCK TABLES `display` WRITE;
/*!40000 ALTER TABLE `display` DISABLE KEYS */;
INSERT INTO `display` VALUES (1,0000000000,'\0','La FISC'),(2,0000000000,'\0','Oferta Académica'),(3,0000000000,'\0','Mundo TIC'),(4,0000000000,'\0','Calendario Académico '),(5,0000000000,'\0','Enlaces de Interés'),(6,0000000000,'\0','Contacto');
/*!40000 ALTER TABLE `display` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permisos`
--

DROP TABLE IF EXISTS `permisos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permisos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CrearPublicaciones` bit(1) DEFAULT NULL,
  `EditarPublicaciones` bit(1) DEFAULT NULL,
  `BorrarPublicaciones` bit(1) DEFAULT NULL,
  `AprobarPublicaciones` bit(1) DEFAULT NULL,
  `CrearUsuario` bit(1) DEFAULT NULL,
  `AprobarUsuario` bit(1) DEFAULT NULL,
  `EliminarUsuario` bit(1) DEFAULT NULL,
  `EditarUsuario` bit(1) DEFAULT NULL,
  `BorrarPublicacionesPropias` bit(1) DEFAULT NULL,
  `EditarPublicacionesPropias` bit(1) DEFAULT NULL,
  `CrearPublicacionesEstaticas` bit(1) DEFAULT NULL,
  `EditarMiUsuario` bit(1) DEFAULT NULL,
  `CambiarNICK` bit(1) DEFAULT NULL,
  `ResetearPassword` bit(1) DEFAULT NULL,
  `CambiarRol` bit(1) DEFAULT NULL,
  `EditarPermisos` bit(1) DEFAULT NULL,
  `EditarMenuArt` bit(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COMMENT='Detalle de todos los permisos y privilegios a lo largo del sistema.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permisos`
--

LOCK TABLES `permisos` WRITE;
/*!40000 ALTER TABLE `permisos` DISABLE KEYS */;
INSERT INTO `permisos` VALUES (1,'','','','','','','','','','','','','','','','',''),(2,'','\0','\0','\0','','\0','\0','','\0','\0','\0','\0','','\0','\0','\0',''),(3,'\0','\0','\0','\0','\0','\0','\0','','\0','\0','\0','','\0','\0','\0','\0','\0'),(4,'','','','\0','\0','\0','\0','\0','','','\0','','\0','\0','\0','\0','\0'),(5,'','','','','\0','\0','\0','\0','','','\0','','\0','\0','\0','\0','\0');
/*!40000 ALTER TABLE `permisos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `preferencias`
--

DROP TABLE IF EXISTS `preferencias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `preferencias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_categoria` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `role_visibilidad_FK_idx` (`id_usuario`),
  KEY `publicacion_visibilidadFK_idx` (`id_categoria`),
  CONSTRAINT `categoria_visibilidadFK` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `usuario_visibilidad_FK` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=latin1 COMMENT='Detalle de la visibilidad al momento de mostrar una noticia a un usuario en concreto.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `preferencias`
--

LOCK TABLES `preferencias` WRITE;
/*!40000 ALTER TABLE `preferencias` DISABLE KEYS */;
/*!40000 ALTER TABLE `preferencias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `publicacion`
--

DROP TABLE IF EXISTS `publicacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `publicacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `Titulo` varchar(100) DEFAULT NULL,
  `Cuerpo` varchar(645) DEFAULT NULL,
  `Fecha` date DEFAULT NULL,
  `Estado` int(11) NOT NULL,
  `Codigo` int(11) DEFAULT NULL,
  `Destino` int(10) unsigned zerofill DEFAULT '0000000000',
  `FechaMod` date DEFAULT NULL,
  `Hora` time DEFAULT NULL,
  `Lugar` varchar(45) DEFAULT NULL,
  `Organizadores` varchar(45) DEFAULT NULL,
  `Contacto` varchar(45) DEFAULT NULL,
  `Telefono` varchar(45) DEFAULT NULL,
  `Image` varchar(45) DEFAULT NULL,
  `URLWeb` varchar(45) DEFAULT NULL,
  `FechaCaduca` date DEFAULT NULL,
  `Correo` varchar(45) DEFAULT NULL,
  `Puesto` varchar(45) DEFAULT NULL,
  `Requisitos` varchar(45) DEFAULT NULL,
  `Salario` varchar(45) DEFAULT NULL,
  `Perfil_egresado` varchar(45) DEFAULT NULL,
  `Costo` varchar(45) DEFAULT NULL,
  `Campo_laboral` varchar(45) DEFAULT NULL,
  `Duracion` varchar(45) DEFAULT NULL,
  `URLPlan` varchar(45) DEFAULT NULL,
  `Titulo_profesional` varchar(45) DEFAULT NULL,
  `Fax` varchar(45) DEFAULT NULL,
  `Apartado_P` varchar(45) DEFAULT NULL,
  `Horario` varchar(45) DEFAULT NULL,
  `Nivel_academico` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `Codigo_UNIQUE` (`Codigo`),
  KEY `usuario_publicacionFK_idx` (`id_usuario`),
  KEY `categoria_publicacionFK_idx` (`id_categoria`),
  CONSTRAINT `categoria_publicacionFK` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `usuario_publicacionFK` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1 COMMENT='Almacenara todos los datos de cada una de las publicaciones.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `publicacion`
--

LOCK TABLES `publicacion` WRITE;
/*!40000 ALTER TABLE `publicacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `publicacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) DEFAULT NULL,
  `Descripcion` varchar(45) DEFAULT NULL,
  `id_permiso` int(11) DEFAULT NULL,
  `PublicCreation` bit(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `Nombre_UNIQUE` (`Nombre`),
  KEY `permiso_roleFK_idx` (`id_permiso`),
  CONSTRAINT `permiso_roleFK` FOREIGN KEY (`id_permiso`) REFERENCES `permisos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COMMENT='Tabla que almacena los roles de los diferentes usuarios del sistema.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES (1,'Coordinador','Coordinador del sistema',1,'\0'),(2,'Profesor','Profersor de la facultad',2,''),(3,'Estudiante','Estudiante de la facultad',3,''),(4,'Estudiante Publicador','Estudiante con privilegios de publicación',4,'\0'),(5,'Profesor Publicador','Profesorcon privilegios de publicación',5,'\0');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) NOT NULL DEFAULT 'NaN',
  `Password` varchar(45) NOT NULL,
  `Estado` int(1) unsigned zerofill DEFAULT NULL,
  `id_role` int(11) DEFAULT NULL,
  `mail` varchar(45) DEFAULT NULL,
  `Feed` bit(1) DEFAULT NULL,
  `AlertaPendiente` bit(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idUsuario_UNIQUE` (`id`),
  UNIQUE KEY `Nombre_UNIQUE` (`Nombre`),
  KEY `role_usuarioFK_idx` (`id_role`),
  CONSTRAINT `role_usuarioFK` FOREIGN KEY (`id_role`) REFERENCES `role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1 COMMENT='Tabla para almacenar los datos de acceso al usuario.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'admin','21232f297a57a5a743894a0e4a801fc3',1,1,'admin@gmail.com','','\0');
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

-- Dump completed on 2013-05-29 15:27:18
