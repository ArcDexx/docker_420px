-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 19 Mai 2016 à 15:36
-- Version du serveur :  5.7.11
-- Version de PHP :  5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `db-420px`
--

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `image` varchar(512) NOT NULL,
  `user_id` int(11) NOT NULL,
  `main_color` varchar(7) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `images`
--

INSERT INTO `images` (`id`, `image`, `user_id`, `main_color`) VALUES
(27, 'uploads/573cb6ff59287thib_flat-walalpaper-plane.jpg', 16, '#3C8BB5'),
(28, 'uploads/573cb704bfe99thib_futurama_doctor_zoidberg_69273_1920x1080.jpg', 16, '#EF5C60'),
(29, 'uploads/573cb9ce92804thib_Mr-Potato-Head-Cartoon-Wallpaper.jpg', 16, '#593E31'),
(30, 'uploads/573cba4b00c82thib_GdC5HVU.png', 16, '#8ABBAA'),
(31, 'uploads/573cd31c5018cthib_south-park.jpg', 16, '#99BB9C'),
(32, 'uploads/573cd453260f6thib_portal_00346368.jpg', 16, '#7E7E7E'),
(33, 'uploads/573cd5ae93bfethib_terence-and-philip-south-park_00447770.jpg', 16, '#747471'),
(34, 'uploads/573ce6c4d4fc0wida_hd-spongebob-wallpaper.jpg', 19, '#B4B4B4'),
(35, 'uploads/573ce6cd87bc7wida_futurama_doctor_zoidberg_69273_1920x1080.jpg', 19, '#EF5C60'),
(36, 'uploads/573ce6d2634eewida_400623.jpg', 19, '#FBD225');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `login` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `login`, `password`) VALUES
(16, 'thib', 'thib'),
(15, 'plop', 'plop'),
(14, 'yo', 'yo'),
(17, 'rss', 'rss'),
(18, 'lea', 'lea'),
(19, 'wida', 'wida');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
