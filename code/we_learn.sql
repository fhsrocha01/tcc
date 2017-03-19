-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Tempo de geração: 26/07/2016 às 22:50
-- Versão do servidor: 10.1.13-MariaDB
-- Versão do PHP: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `hellow`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `classes`
--

CREATE TABLE `classes` (
  `id_class` int(10) UNSIGNED NOT NULL,
  `courses_users_id_user` int(10) UNSIGNED NOT NULL,
  `courses_id_course` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `about` varchar(300) DEFAULT NULL,
  `link` text NOT NULL,
  `pdf` varchar(18) DEFAULT NULL,
  `tags` varchar(140) DEFAULT NULL,
  `published` char(1) NOT NULL,
  `creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `complaint`
--

CREATE TABLE `complaint` (
  `id_complaint` int(10) UNSIGNED NOT NULL,
  `users_id_user` int(10) UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `message` text NOT NULL,
  `id_user_denounced` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `courses`
--

CREATE TABLE `courses` (
  `id_course` int(10) UNSIGNED NOT NULL,
  `users_id_user` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `about` varchar(300) NOT NULL,
  `level` int(1) NOT NULL,
  `creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tags` varchar(140) DEFAULT NULL,
  `published` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `favorite`
--

CREATE TABLE `favorite` (
  `id` int(11) NOT NULL,
  `users_id_user` int(10) UNSIGNED NOT NULL,
  `id_favorite` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `inscription`
--

CREATE TABLE `inscription` (
  `users_id_user` int(10) UNSIGNED NOT NULL,
  `courses_users_id_user` int(10) UNSIGNED NOT NULL,
  `courses_id_course` int(10) UNSIGNED NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `reviews`
--

CREATE TABLE `reviews` (
  `id_review` int(11) NOT NULL,
  `id_teacher` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `message` varchar(300) DEFAULT NULL,
  `review_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id_user` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(32) NOT NULL,
  `photo` varchar(18) DEFAULT NULL,
  `type` char(1) NOT NULL,
  `level` int(11) DEFAULT NULL,
  `skype` varchar(32) DEFAULT NULL,
  `lesson_price` varchar(9) DEFAULT NULL,
  `lessons_skype` char(1) DEFAULT NULL,
  `registration_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id_class`,`courses_users_id_user`,`courses_id_course`),
  ADD KEY `classes_FKIndex1` (`courses_id_course`,`courses_users_id_user`);

--
-- Índices de tabela `complaint`
--
ALTER TABLE `complaint`
  ADD PRIMARY KEY (`id_complaint`),
  ADD KEY `complaint_FKIndex1` (`users_id_user`);

--
-- Índices de tabela `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id_course`,`users_id_user`),
  ADD KEY `courses_FKIndex1` (`users_id_user`);

--
-- Índices de tabela `favorite`
--
ALTER TABLE `favorite`
  ADD PRIMARY KEY (`id`),
  ADD KEY `favorite_FKIndex1` (`users_id_user`);

--
-- Índices de tabela `inscription`
--
ALTER TABLE `inscription`
  ADD PRIMARY KEY (`users_id_user`,`courses_users_id_user`,`courses_id_course`),
  ADD KEY `users_has_courses_FKIndex1` (`users_id_user`),
  ADD KEY `users_has_courses_FKIndex2` (`courses_id_course`,`courses_users_id_user`);

--
-- Índices de tabela `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id_review`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `classes`
--
ALTER TABLE `classes`
  MODIFY `id_class` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `complaint`
--
ALTER TABLE `complaint`
  MODIFY `id_complaint` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `courses`
--
ALTER TABLE `courses`
  MODIFY `id_course` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `favorite`
--
ALTER TABLE `favorite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id_review` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `inscription`
--
ALTER TABLE `inscription`
  ADD CONSTRAINT `inscription_ibfk_1` FOREIGN KEY (`users_id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
