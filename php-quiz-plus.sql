-- Adminer 4.7.7 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `answers`;
CREATE TABLE `answers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `question_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `question_id` (`question_id`),
  CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

INSERT INTO `answers` (`id`, `description`, `question_id`) VALUES
(1,	'5',	1),
(2,	'7',	1),
(3,	'11',	1),
(4,	'235',	1),
(5,	'15 secondes',	2),
(6,	'8 minutes',	2),
(7,	'2 heures',	2),
(8,	'3 mois',	2),
(9,	'Janvier',	3),
(10,	'Février',	3),
(11,	'Mars',	3),
(12,	'Avril',	3),
(13,	'Le Verseau',	4),
(14,	'Le Cancer',	4),
(15,	'Le Scorpion',	4),
(16,	'Les Poissons',	4),
(17,	'2',	5),
(18,	'3',	5),
(19,	'4',	5),
(20,	'5, comme tout le monde',	5);

DROP TABLE IF EXISTS `questions`;
CREATE TABLE `questions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `rank` int(11) NOT NULL,
  `right_answer_id` int(10) unsigned NOT NULL,
  `quiz_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `right_answer_id` (`right_answer_id`),
  KEY `quiz_id` (`quiz_id`),
  CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`right_answer_id`) REFERENCES `answers` (`id`),
  CONSTRAINT `questions_ibfk_2` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

INSERT INTO `questions` (`id`, `description`, `rank`, `right_answer_id`, `quiz_id`) VALUES
(1,	'Combien de joueurs y a-t-il dans une équipe de football?',	1,	3,	1),
(2,	'Combien de temps la lumière du soleil met-elle pour nous parvenir?',	2,	6,	1),
(3,	'En 1582, le pape Grégoire XIII a décidé de réformer le calendrier instauré par Jules César. Mais quel était le premier mois du calendrier julien?',	3,	11,	1),
(4,	'Lequel de ces signes du zodiaque n\'est pas un signe d\'Eau?',	4,	13,	1),
(5,	'Combien de doigts ai-je dans mon dos?',	5,	20,	1);

DROP TABLE IF EXISTS `quizzes`;
CREATE TABLE `quizzes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `quizzes` (`id`, `title`, `description`) VALUES
(1,	'Divers faits étonnants',	'Etonnez-vous avec ces petites choses de la vie quotidienne que vous ignorez probablement!');

-- 2020-10-25 20:31:35