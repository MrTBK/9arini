-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 03 déc. 2024 à 22:35
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `9arini`
--

-- --------------------------------------------------------

--
-- Structure de la table `cours`
--

CREATE TABLE `cours` (
  `id` int(11) UNSIGNED NOT NULL,  -- Made UNSIGNED for foreign key reference
  `subject` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `cours`
--

INSERT INTO `cours` (`id`, `subject`, `title`, `description`, `file`) VALUES
(1, 'info', 'Introduction to Informatics', 'Learn the basics of informatics.', 'intro_to_informatics.pdf'),
(2, 'info', 'Advanced Programming', 'Dive into advanced programming concepts.', 'advanced_programming.pdf'),
(3, 'math', 'Linear Algebra', 'Understand the concepts of linear algebra.', 'linear_algebra.pdf'),
(4, 'fr', 'chapitre 1', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,  -- Made UNSIGNED for foreign key reference
  `name` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `section` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `lastname`, `email`, `section`, `password`, `created_at`) VALUES
(6, 'aziz', 'tabakh', 'aziz.tabakh@gmail.com', 'info', '$2y$10$9bAMiDtCK3Lzbq302xm0VuA6hg7apiwFSl13Jx5SiuGOo7cvOF6Je', '2024-11-16 18:22:03'),
(7, 'sc', 'sc', 'sc@sc.sc', 'science', '$2y$10$8Hqokosvv4lX/RKTr6agguakzJ2fZc5R7UWvRhKfMqJAjkx4FE.U.', '2024-12-03 21:28:26');

-- --------------------------------------------------------

--
-- Creating `user_cours` table with foreign key relationships
--

CREATE TABLE `user_cours` (
  `user_id` INT UNSIGNED,  -- Matches the users(id) column
  `cours_id` INT UNSIGNED,  -- Matches the cours(id) column
  `purchased_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`, `cours_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`cours_id`) REFERENCES `cours`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Index pour les tables déchargées

-- AUTO_INCREMENT pour la table `cours`
ALTER TABLE `cours`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

-- AUTO_INCREMENT pour la table `users`
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
