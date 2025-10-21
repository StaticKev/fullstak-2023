-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: localhost    Database: fullstack
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `akun`
--

DROP TABLE IF EXISTS `akun`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `akun` (
  `username` varchar(20) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `nrp_mahasiswa` char(9) DEFAULT NULL,
  `npk_dosen` char(6) DEFAULT NULL,
  `isadmin` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`username`),
  KEY `fk_akun_mahasiswa_idx` (`nrp_mahasiswa`),
  KEY `fk_akun_dosen1_idx` (`npk_dosen`),
  CONSTRAINT `fk_akun_dosen1` FOREIGN KEY (`npk_dosen`) REFERENCES `dosen` (`npk`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_akun_mahasiswa` FOREIGN KEY (`nrp_mahasiswa`) REFERENCES `mahasiswa` (`nrp`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `akun`
--

LOCK TABLES `akun` WRITE;
/*!40000 ALTER TABLE `akun` DISABLE KEYS */;
INSERT INTO `akun` VALUES ('D111111','hans111111',NULL,'111111',1),('D112233','sarah112233',NULL,'112233',0),('D123456','kenny123456',NULL,'123456',1),('D222222','rani222222',NULL,'222222',0),('D223344','eko223344',NULL,'223344',0),('D333333','michael333333',NULL,'333333',0),('D334455','fitri334455',NULL,'334455',0),('D444444','sinta444444',NULL,'444444',0),('D445566','dwi445566',NULL,'445566',0),('D555555','bambang555555',NULL,'555555',0),('D556677','tina556677',NULL,'556677',0),('D654321','kevin654321',NULL,'654321',1),('D666666','rudi666666',NULL,'666666',0),('D667788','andi667788',NULL,'667788',0),('D777777','agnes777777',NULL,'777777',0),('D778899','joko778899',NULL,'778899',0),('D888888','tegar888888',NULL,'888888',0),('D889900','nina889900',NULL,'889900',0),('D990011','indra990011',NULL,'990011',0),('D999999','nanda999999',NULL,'999999',0),('M000000001','budi1','000000001',NULL,0),('M000000002','anton2','000000002',NULL,0),('M000000003','citra3','000000003',NULL,0),('M000000004','yudi4','000000004',NULL,0),('M000000005','winda5','000000005',NULL,0),('M000000006','raka6','000000006',NULL,0),('M000000007','lina7','000000007',NULL,0),('M000000008','bayu8','000000008',NULL,0),('M000000009','dita9','000000009',NULL,0),('M000000010','andre10','000000010',NULL,0),('M000000011','susi11','000000011',NULL,0),('M000000012','reza12','000000012',NULL,0),('M000000013','mega13','000000013',NULL,0),('M000000014','rio14','000000014',NULL,0),('M000000015','ani15','000000015',NULL,0),('M000000016','james16','000000016',NULL,0),('M000000017','sari17','000000017',NULL,0),('M000000018','toni18','000000018',NULL,0),('M000000019','nisa19','000000019',NULL,0),('M000000020','aldi20','000000020',NULL,0);
/*!40000 ALTER TABLE `akun` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chat`
--

DROP TABLE IF EXISTS `chat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chat` (
  `idchat` int(11) NOT NULL AUTO_INCREMENT,
  `idthread` int(11) NOT NULL,
  `username_pembuat` varchar(20) NOT NULL,
  `isi` text DEFAULT NULL,
  `tanggal_pembuatan` datetime DEFAULT NULL,
  PRIMARY KEY (`idchat`),
  KEY `fk_chat_thread1_idx` (`idthread`),
  KEY `fk_chat_akun1_idx` (`username_pembuat`),
  CONSTRAINT `fk_chat_akun1` FOREIGN KEY (`username_pembuat`) REFERENCES `akun` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_chat_thread1` FOREIGN KEY (`idthread`) REFERENCES `thread` (`idthread`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat`
--

LOCK TABLES `chat` WRITE;
/*!40000 ALTER TABLE `chat` DISABLE KEYS */;
/*!40000 ALTER TABLE `chat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dosen`
--

DROP TABLE IF EXISTS `dosen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dosen` (
  `npk` char(6) NOT NULL,
  `nama` varchar(45) DEFAULT NULL,
  `foto_extension` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`npk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dosen`
--

LOCK TABLES `dosen` WRITE;
/*!40000 ALTER TABLE `dosen` DISABLE KEYS */;
INSERT INTO `dosen` VALUES ('111111','hans','png'),('112233','sarah','jpg'),('123456','kenny','jpg'),('222222','rani','jpg'),('223344','eko','jpg'),('333333','michael','jpeg'),('334455','fitri','jpg'),('444444','sinta','jpg'),('445566','dwi','jpg'),('555555','bambang','jpg'),('556677','tina','jpg'),('654321','kevin','jpg'),('666666','rudi','jpg'),('667788','andi','jpg'),('777777','agnes','jpg'),('778899','joko','jpg'),('888888','tegar','jpg'),('889900','nina','jpg'),('990011','indra','png'),('999999','nanda','jpg');
/*!40000 ALTER TABLE `dosen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event` (
  `idevent` int(11) NOT NULL AUTO_INCREMENT,
  `idgrup` int(11) NOT NULL,
  `judul` varchar(45) DEFAULT NULL,
  `judul-slug` varchar(45) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `jenis` enum('Privat','Publik') DEFAULT NULL,
  `poster_extension` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`idevent`),
  KEY `fk_event_grup1_idx` (`idgrup`),
  CONSTRAINT `fk_event_grup1` FOREIGN KEY (`idgrup`) REFERENCES `grup` (`idgrup`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event`
--

LOCK TABLES `event` WRITE;
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
/*!40000 ALTER TABLE `event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grup`
--

DROP TABLE IF EXISTS `grup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `grup` (
  `idgrup` int(11) NOT NULL AUTO_INCREMENT,
  `username_pembuat` varchar(20) NOT NULL,
  `nama` varchar(45) DEFAULT NULL,
  `deskripsi` varchar(45) DEFAULT NULL,
  `tanggal_pembentukan` datetime DEFAULT NULL,
  `jenis` enum('Privat','Publik') DEFAULT NULL,
  `kode_pendaftaran` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idgrup`),
  KEY `fk_grup_akun1_idx` (`username_pembuat`),
  CONSTRAINT `fk_grup_akun1` FOREIGN KEY (`username_pembuat`) REFERENCES `akun` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grup`
--

LOCK TABLES `grup` WRITE;
/*!40000 ALTER TABLE `grup` DISABLE KEYS */;
/*!40000 ALTER TABLE `grup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mahasiswa`
--

DROP TABLE IF EXISTS `mahasiswa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mahasiswa` (
  `nrp` char(9) NOT NULL,
  `nama` varchar(45) DEFAULT NULL,
  `gender` enum('Pria','Wanita') DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `angkatan` year(4) DEFAULT NULL,
  `foto_extention` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`nrp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mahasiswa`
--

LOCK TABLES `mahasiswa` WRITE;
/*!40000 ALTER TABLE `mahasiswa` DISABLE KEYS */;
INSERT INTO `mahasiswa` VALUES ('000000001','budi','Pria','2025-09-03',2023,'jpg'),('000000002','anton','Pria','2025-06-05',2025,'jpg'),('000000003','citra','Wanita','2004-01-12',2022,'jpg'),('000000004','yudi','Pria','2003-03-05',2021,'jpg'),('000000005','winda','Wanita','2005-05-09',2024,'jpg'),('000000006','raka','Pria','2004-07-11',2022,'jpg'),('000000007','lina','Wanita','2003-09-21',2021,'jpg'),('000000008','bayu','Pria','2005-10-03',2024,'jpg'),('000000009','dita','Wanita','2004-02-28',2023,'jpg'),('000000010','andre','Pria','2002-06-17',2020,'jpg'),('000000011','susi','Wanita','2003-08-08',2021,'jpg'),('000000012','reza','Pria','2004-11-15',2022,'jpg'),('000000013','mega','Wanita','2005-09-20',2024,'jpg'),('000000014','rio','Pria','2002-12-01',2020,'jpg'),('000000015','ani','Wanita','2003-04-10',2021,'jpg'),('000000016','james','Pria','2004-05-23',2022,'jpg'),('000000017','sari','Wanita','2005-02-05',2023,'jpg'),('000000018','toni','Pria','2003-03-30',2021,'jpg'),('000000019','nisa','Wanita','2004-07-14',2022,'jpg'),('000000020','aldi','Pria','2005-11-25',2024,'jpg');
/*!40000 ALTER TABLE `mahasiswa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member_grup`
--

DROP TABLE IF EXISTS `member_grup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `member_grup` (
  `idgrup` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  PRIMARY KEY (`idgrup`,`username`),
  KEY `fk_grup_has_akun_akun1_idx` (`username`),
  KEY `fk_grup_has_akun_grup1_idx` (`idgrup`),
  CONSTRAINT `fk_grup_has_akun_akun1` FOREIGN KEY (`username`) REFERENCES `akun` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_grup_has_akun_grup1` FOREIGN KEY (`idgrup`) REFERENCES `grup` (`idgrup`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member_grup`
--

LOCK TABLES `member_grup` WRITE;
/*!40000 ALTER TABLE `member_grup` DISABLE KEYS */;
/*!40000 ALTER TABLE `member_grup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `thread`
--

DROP TABLE IF EXISTS `thread`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `thread` (
  `idthread` int(11) NOT NULL AUTO_INCREMENT,
  `username_pembuat` varchar(20) NOT NULL,
  `idgrup` int(11) NOT NULL,
  `tanggal_pembuatan` datetime DEFAULT NULL,
  `status` enum('Open','Close') DEFAULT 'Open',
  PRIMARY KEY (`idthread`),
  KEY `fk_thread_akun1_idx` (`username_pembuat`),
  KEY `fk_thread_grup1_idx` (`idgrup`),
  CONSTRAINT `fk_thread_akun1` FOREIGN KEY (`username_pembuat`) REFERENCES `akun` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_thread_grup1` FOREIGN KEY (`idgrup`) REFERENCES `grup` (`idgrup`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `thread`
--

LOCK TABLES `thread` WRITE;
/*!40000 ALTER TABLE `thread` DISABLE KEYS */;
/*!40000 ALTER TABLE `thread` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-19 11:58:34
