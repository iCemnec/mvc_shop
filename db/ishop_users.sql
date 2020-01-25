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
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int unsigned NOT NULL,
  `first_name` varchar(60) NOT NULL,
  `last_name` varchar(60) DEFAULT NULL,
  `email` varchar(30) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `auth_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `fk_users_role_id` (`role_id`),
  CONSTRAINT `fk_users_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,1,'Irina','Petrushkina','icemnec@gmail.com','0888888888','12345','','2020-01-13 19:36:43','2020-01-13 19:36:47'),(2,3,'client_1',NULL,'ffgg@fff.yy',NULL,'$2y$10$/kJW/fqiu/2qa6QroJVBKuB6vUE2qdiLiaNK7nLgPs21VQtK8TYGq','','2020-01-23 11:25:20','2020-01-23 11:25:20'),(6,3,'cli',NULL,'ffgg2@fff.yy',NULL,'$2y$10$o7k7yoWreUPSDSnpnan7TuMIhXzE.N6n9/AWvDOtRe5rfaIeQ8Yp.','af267ec36cbba6af8fee0a3842cce6ec3d9a3cc5f58816bb5c9100371403d8bbfbf6c1fbef031e58','2020-01-23 14:35:10','2020-01-23 14:35:10'),(7,3,'client_2',NULL,'ffgg3@fff.yy',NULL,'$2y$10$poBO9YMwEs.bZLa6DdyjJelHjcrui84FhLTAMcLREPfoVLlv8dMdS','e08d28f1114aef32b2875bfd032aacaf85bb95c135425662736e94f7fce86027db0eb2ed6b9003b9','2020-01-23 14:42:17','2020-01-23 14:42:17'),(8,3,'client_2',NULL,'mail2@mail.com',NULL,'$2y$10$92sU.D36/uOCxfThk0ePd.I2tcPI3a8eTPkn4NQ92ne87kKBJGXOS','b9f998f1595d2a525821a9946f1e3c72bb6268c3f4e7a24b8c5ba90dd188885e88684f72295b3f8b','2020-01-23 14:52:58','2020-01-23 14:52:58'),(9,3,'client_3',NULL,'mail3@mail.com',NULL,'$2y$10$On//AuICPgi6gb5IlAHSqeanGAvwaSa9iSyOnhk55TYuK6Cc5gkOm','71f314c0119732a634d2cea6a2dbcae86ffd83d1654626cc32d79b462d459a9a7d59c3118e46e798','2020-01-23 14:53:51','2020-01-23 14:53:51'),(10,3,'client_44','','mail4@mail.com','','$2y$10$Y1JkZk8v4rndNBjXKuB6leqiI/pZlcrS.59qrlUgBBxLXKZebodGa','e4a9d61cb9f0e3c5a62254f9cd9c2f331ffde4d1dcce7698f9657f242d5119a92d2e812af9bb12db','2020-01-23 22:49:02','2020-01-24 21:53:23');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-01-25 18:36:03
