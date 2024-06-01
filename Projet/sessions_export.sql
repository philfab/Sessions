/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE IF NOT EXISTS `sessions` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `sessions`;

CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `categorie` DISABLE KEYS */;
INSERT INTO `categorie` (`id`, `nom`) VALUES
	(1, 'Informatique'),
	(2, 'Bureautique'),
	(3, 'Design'),
	(4, 'Langues');
/*!40000 ALTER TABLE `categorie` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `formateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `formateur` DISABLE KEYS */;
INSERT INTO `formateur` (`id`, `nom`, `prenom`, `email`) VALUES
	(1, 'mur', 'mika', 'mur.mika@example.com'),
	(2, 'steph', 'smail', 'steph.smail@example.com'),
	(3, 'quentin', 'thebest', 'quentin.thebest@example.com'),
	(4, 'moi', 'lenul', 'moi.lenul@example.com');
/*!40000 ALTER TABLE `formateur` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `inscrire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` int(11) NOT NULL,
  `stagiaire_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_84CA37A8613FECDF` (`session_id`),
  KEY `IDX_84CA37A8BBA93DD6` (`stagiaire_id`),
  CONSTRAINT `FK_84CA37A8613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`),
  CONSTRAINT `FK_84CA37A8BBA93DD6` FOREIGN KEY (`stagiaire_id`) REFERENCES `stagiaire` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `inscrire` DISABLE KEYS */;
INSERT INTO `inscrire` (`id`, `session_id`, `stagiaire_id`) VALUES
	(1, 1, 1),
	(2, 1, 2),
	(3, 2, 3),
	(4, 3, 4),
	(5, 4, 1);
/*!40000 ALTER TABLE `inscrire` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `messenger_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messenger_messages` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categorie_id` int(11) NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C242628BCF5E72D` (`categorie_id`),
  CONSTRAINT `FK_C242628BCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `module` DISABLE KEYS */;
INSERT INTO `module` (`id`, `categorie_id`, `titre`) VALUES
	(1, 1, 'PHP'),
	(2, 1, 'C#'),
	(3, 1, 'HTML'),
	(4, 1, 'CSS'),
	(5, 2, 'Word'),
	(6, 2, 'Excel'),
	(7, 2, 'PowerPoint'),
	(8, 2, 'Outlook'),
	(9, 3, 'Photoshop'),
	(10, 3, 'Illustrator'),
	(11, 3, 'InDesign'),
	(12, 3, 'After Effects'),
	(13, 4, 'Anglais'),
	(14, 4, 'Espagnol'),
	(15, 4, 'Allemand'),
	(16, 4, 'Français');
/*!40000 ALTER TABLE `module` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `programme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `nb_jours` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3DDCB9FF613FECDF` (`session_id`),
  KEY `IDX_3DDCB9FFAFC2B591` (`module_id`),
  CONSTRAINT `FK_3DDCB9FF613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`),
  CONSTRAINT `FK_3DDCB9FFAFC2B591` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `programme` DISABLE KEYS */;
INSERT INTO `programme` (`id`, `session_id`, `module_id`, `nb_jours`) VALUES
	(1, 1, 1, 5),
	(2, 1, 2, 4),
	(3, 1, 3, 3),
	(4, 1, 4, 2),
	(5, 2, 5, 5),
	(6, 2, 6, 4),
	(7, 2, 7, 3),
	(8, 2, 8, 2),
	(9, 3, 9, 5),
	(10, 3, 10, 4),
	(11, 3, 11, 3),
	(12, 3, 12, 2),
	(13, 4, 13, 5),
	(14, 4, 14, 4),
	(15, 4, 15, 3),
	(16, 4, 16, 2);
/*!40000 ALTER TABLE `programme` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `formateur_id` int(11) NOT NULL,
  `intitule` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `nb_places_totales` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D044D5D4155D8F51` (`formateur_id`),
  CONSTRAINT `FK_D044D5D4155D8F51` FOREIGN KEY (`formateur_id`) REFERENCES `formateur` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `session` DISABLE KEYS */;
INSERT INTO `session` (`id`, `formateur_id`, `intitule`, `date_debut`, `date_fin`, `nb_places_totales`) VALUES
	(1, 1, 'Session Informatique', '2024-06-01', '2024-06-15', 20),
	(2, 2, 'Session Bureautique', '2024-07-01', '2024-07-15', 15),
	(3, 3, 'Session Design', '2024-08-01', '2024-08-15', 10),
	(4, 4, 'Session Langues', '2024-09-01', '2024-09-15', 25);
/*!40000 ALTER TABLE `session` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `stagiaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_naissance` date NOT NULL,
  `sexe` tinyint(1) NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `stagiaire` DISABLE KEYS */;
INSERT INTO `stagiaire` (`id`, `nom`, `prenom`, `date_naissance`, `sexe`, `email`, `ville`, `telephone`) VALUES
	(1, 'Lemmy', 'Killmister', '1945-12-24', 1, 'lemmy.killmister@example.com', 'Burslem', '0102030405'),
	(2, 'John', 'Bonham', '1948-05-31', 1, 'john.bonham@example.com', 'Redditch', '0607080910'),
	(3, 'Eddie', 'Van_Halen', '1955-01-26', 1, 'eddie.van_halen@example.com', 'Amsterdam', '0203040506'),
	(4, 'Iggy', 'Pop', '1947-04-21', 1, 'iggy.pop@example.com', 'Muskegen', '0708091011');
/*!40000 ALTER TABLE `stagiaire` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `pseudo`, `email`, `password`, `roles`) VALUES
	(1, 'phil_admin', 'phil_admin@gmail.com', '$2y$10$pLIQ9qY4GMCQCd5Pbi5ZLueAp5051y5H7BWeBuTpsBBixHgXbZovK', 'ROLE_ADMIN');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
