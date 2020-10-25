-- Adminer 4.7.7 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `answers`;
CREATE TABLE `answers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `rank` int(11) NOT NULL,
  `question_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `question_id` (`question_id`),
  CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

INSERT INTO `answers` (`id`, `description`, `rank`, `question_id`) VALUES
(1,	'5',	1,	1),
(2,	'7',	2,	1),
(3,	'11',	3,	1),
(4,	'235',	4,	1),
(5,	'15 secondes',	1,	2),
(6,	'8 minutes',	2,	2),
(7,	'2 heures',	3,	2),
(8,	'3 mois',	4,	2),
(9,	'Janvier',	1,	3),
(10,	'Février',	2,	3),
(11,	'Mars',	3,	3),
(12,	'Avril',	4,	3),
(13,	'Le Verseau',	1,	4),
(14,	'Le Cancer',	2,	4),
(15,	'Le Scorpion',	3,	4),
(16,	'Les Poissons',	4,	4),
(17,	'2',	1,	5),
(18,	'3',	2,	5),
(19,	'4',	3,	5),
(20,	'5, comme tout le monde',	4,	5),
(21,	'L\'eflque',	1,	15),
(22,	'Le Valyrien',	2,	15),
(23,	'Le Klingon',	3,	15),
(24,	'Le Serpentard',	4,	15),
(25,	'Kaley Cuoco',	1,	16),
(26,	'Mayim Bialik',	2,	16),
(27,	'Johnny Galecki',	3,	16),
(28,	'Jim Parsons',	4,	16),
(29,	'3A',	1,	17),
(30,	'3B',	2,	17),
(31,	'4A',	3,	17),
(32,	'4B',	4,	17),
(33,	'Une',	1,	18),
(34,	'Deux',	2,	18),
(35,	'Trois',	3,	18),
(36,	'Quatre',	4,	18),
(37,	'Barenaked Ladies',	1,	19),
(38,	'Static in Stereo',	2,	19),
(39,	'Brundlefly',	3,	19);

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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

INSERT INTO `questions` (`id`, `description`, `rank`, `right_answer_id`, `quiz_id`) VALUES
(1,	'Combien de joueurs y a-t-il dans une équipe de football?',	1,	3,	1),
(2,	'Combien de temps la lumière du soleil met-elle pour nous parvenir?',	2,	6,	1),
(3,	'En 1582, le pape Grégoire XIII a décidé de réformer le calendrier instauré par Jules César. Mais quel était le premier mois du calendrier julien?',	3,	11,	1),
(4,	'Lequel de ces signes du zodiaque n\'est pas un signe d\'Eau?',	4,	13,	1),
(5,	'Combien de doigts ai-je dans mon dos?',	5,	20,	1),
(15,	'Quel langage fictif Howard parle-t-il?',	1,	23,	2),
(16,	'Quel est le seul acteur de la série qui possède un doctorat dans la vraie vie?',	2,	26,	2),
(17,	'Dans quel appartement Penny et Leonard vivent-ils?',	3,	31,	2),
(18,	'Combien de fois Sheldon doit-il frapper à une porte et dire le nom d\'une personne avant d\'entrer?',	4,	35,	2),
(19,	'Quel groupe de rock alternatif canadien a créé le générique musical de The Big Bang Theory?',	5,	37,	2);

DROP TABLE IF EXISTS `quizzes`;
CREATE TABLE `quizzes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO `quizzes` (`id`, `title`, `description`) VALUES
(1,	'Divers faits étonnants',	'Etonnez-vous avec ces petites choses de la vie quotidienne que vous ignorez probablement!'),
(2,	'The Big Bang Theory',	'Êtes-vous un vrai fan de The Big Bang Theory? Pour le savoir, un seul moyen: répondez à ce quiz ultime sur la série!');

-- 2020-10-25 21:07:24