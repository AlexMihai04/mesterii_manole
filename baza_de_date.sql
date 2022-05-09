-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.17-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for mesterii_manole
CREATE DATABASE IF NOT EXISTS `mesterii_manole` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `mesterii_manole`;

-- Dumping structure for table mesterii_manole.anunturi
CREATE TABLE IF NOT EXISTS `anunturi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `added_by` int(11) DEFAULT NULL,
  `meserie` text DEFAULT NULL,
  `telefon` text DEFAULT NULL,
  `auto_judet` text DEFAULT NULL,
  `nume` text DEFAULT NULL,
  `prenume` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table mesterii_manole.conturi
CREATE TABLE IF NOT EXISTS `conturi` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `grad` varchar(12) NOT NULL DEFAULT 'membru',
  `rep` int(11) NOT NULL DEFAULT -1,
  `nume` text DEFAULT NULL,
  `prenume` text DEFAULT NULL,
  `tip` varchar(50) DEFAULT 'default',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table mesterii_manole.review
CREATE TABLE IF NOT EXISTS `review` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `de_la` int(11) DEFAULT NULL,
  `mesaj` text DEFAULT NULL,
  `stele` int(11) DEFAULT NULL,
  `pentru` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
