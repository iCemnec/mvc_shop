-- MySQL dump 10.13  Distrib 8.0.19, for Linux (x86_64)
--
-- Host: localhost    Database: ishop
-- ------------------------------------------------------
-- Server version	8.0.19

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
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `books` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `isbn` varchar(30) NOT NULL,
  `title` varchar(255) NOT NULL,
  `pub_year` int NOT NULL,
  `description` text,
  `quantity` int unsigned NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `user_id` int unsigned NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_books_user_id` (`user_id`),
  CONSTRAINT `fk_books_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `books`
--

LOCK TABLES `books` WRITE;
/*!40000 ALTER TABLE `books` DISABLE KEYS */;
INSERT INTO `books` VALUES (1,'978-0802412706','The 5 Love Languages: The Secret to Love that Lasts',2015,'- Over 11 million copies sold\n\n- #1 New York Times Bestseller for 8 years running\n\n- Now celebrating its 25th anniversary\n\n \n\nSimple ideas, lasting love\n\nFalling in love is easy. Staying in love—that’s the challenge. How can you keep your relationship fresh and growing amid the demands, conflicts, and just plain boredom of everyday life?\n\nIn the #1 New York Times bestseller The 5 Love Languages, you’ll discover the secret that has transformed millions of relationships worldwide. Whether your relationship is flourishing or failing, Dr. Gary Chapman’s proven approach to showing and receiving love will help you experience deeper and richer levels of intimacy with your partner—starting today.',30,'the_5_love_languages.jpg',1,'2020-01-13 19:53:57','2020-01-13 19:54:00'),(2,'978-1501194290','Howard Stern Comes Again',2019,'Rock stars and rap gods. Comedy legends and A-list actors. Supermodels and centerfolds. Moguls and mobsters. A president.\n\nOver his unrivaled four-decade career in radio, Howard Stern has interviewed thousands of personalities—discussing sex, relationships, money, fame, spirituality, and success with the boldest of bold-faced names. But which interviews are his favorites? It’s one of the questions he gets asked most frequently. Howard Stern Comes Again delivers his answer.',4,'howard_stern_comes_again.jpg',1,'2020-01-13 20:10:28','2020-01-13 20:10:30'),(3,'978-1111306892','Milady Standard Esthetics: Fundamentals 11th Edition',2012,'Milady Standard Esthetics Fundamentals, 11th edition, is the essential source for basic esthetics training. This new edition builds upon Milady\'s strong tradition of providing students and instructors with the best beauty and wellness education tools for their future. The rapidly expanding field of esthetics has taken a dramatic leap forward in the past decade, and this up-to-date text plays a critical role in creating a strong foundation for the esthetics student. Focusing on introductory topics, including history and opportunities in skin care, anatomy and physiology, and infection control and disorders, it lays the groundwork for the future professional to build their knowledge. The reader can then explore the practical skills of a skin care professional, introducing them to the treatment environment, basic facial treatments, hair removal, and the technology likely to be performed in the salon or spa setting.',20,'milady_standard_esthetics.jpg',1,'2020-01-14 07:22:54','2020-01-14 07:22:57');
/*!40000 ALTER TABLE `books` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-01-16 19:14:42
