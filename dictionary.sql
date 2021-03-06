-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  sam. 21 sep. 2019 à 22:25
-- Version du serveur :  10.4.6-MariaDB
-- Version de PHP :  7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `dictionary`
--

-- --------------------------------------------------------

--
-- Structure de la table `languages`
--

CREATE TABLE `languages` (
  `id_language` int(11) NOT NULL,
  `language` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `languages`
--

INSERT INTO `languages` (`id_language`, `language`) VALUES
(1, 'Polonais'),
(2, 'Français'),
(3, 'Anglais'),
(4, 'Allemand'),
(5, 'Italien'),
(6, 'Russe'),
(7, 'Portugais'),
(8, 'Espagnol'),
(9, 'Espéranto');

-- --------------------------------------------------------

--
-- Structure de la table `tags`
--

CREATE TABLE `tags` (
  `id_tag` int(11) NOT NULL,
  `tag_name` varchar(255) NOT NULL,
  `tag_name2` varchar(255) NOT NULL,
  `id_user` int(11) NOT NULL,
  `language_1` varchar(255) NOT NULL,
  `language_2` varchar(255) NOT NULL,
  `add_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_activation_code` varchar(255) NOT NULL,
  `email_verify` varchar(4) NOT NULL,
  `registration_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `email`, `user_activation_code`, `email_verify`, `registration_date`) VALUES
(3, 'jonatan', '$2y$10$B524wuvxTG187ueXNbXjZeK6DidMUJpRtWMViA.ljHuG9KvS2KSIy', 'wallasdu44@hotmail.Com', '4fb4b69f577efa90683d05e75eb0cb19', 'no', '2019-09-21 22:06:36');

-- --------------------------------------------------------

--
-- Structure de la table `words`
--

CREATE TABLE `words` (
  `id_word` int(11) NOT NULL,
  `word` varchar(255) NOT NULL,
  `translation` varchar(255) NOT NULL,
  `id_language_word` int(11) NOT NULL,
  `id_language_translation` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `add_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id_language`);

--
-- Index pour la table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id_tag`),
  ADD UNIQUE KEY `tag_name2` (`tag_name2`,`id_user`),
  ADD KEY `fk_id_user_tags` (`id_user`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `words`
--
ALTER TABLE `words`
  ADD PRIMARY KEY (`id_word`),
  ADD UNIQUE KEY `word` (`word`,`translation`,`id_language_word`,`id_language_translation`,`id_user`),
  ADD KEY `fk_id_language_word_words` (`id_language_word`),
  ADD KEY `fk_id_language_translation_words` (`id_language_translation`),
  ADD KEY `fk_id_user_words` (`id_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `languages`
--
ALTER TABLE `languages`
  MODIFY `id_language` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `tags`
--
ALTER TABLE `tags`
  MODIFY `id_tag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `words`
--
ALTER TABLE `words`
  MODIFY `id_word` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `tags`
--
ALTER TABLE `tags`
  ADD CONSTRAINT `fk_id_user_tags` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Contraintes pour la table `words`
--
ALTER TABLE `words`
  ADD CONSTRAINT `fk_id_language_translation_words` FOREIGN KEY (`id_language_translation`) REFERENCES `languages` (`id_language`),
  ADD CONSTRAINT `fk_id_language_word_words` FOREIGN KEY (`id_language_word`) REFERENCES `languages` (`id_language`),
  ADD CONSTRAINT `fk_id_user_words` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
