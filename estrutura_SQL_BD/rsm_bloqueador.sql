-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 24-Abr-2019 às 22:59
-- Versão do servidor: 5.7.24-0ubuntu0.16.04.1
-- PHP Version: 7.0.32-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rsm_bloqueador`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `app_registered`
--

CREATE TABLE `app_registered` (
  `id` int(11) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `imei` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `app_registered`
--

INSERT INTO `app_registered` (`id`, `phone`, `imei`) VALUES
(1, '021972857979', '868683021260356'),
(2, '021995737420', '864180036470751'),
(4, '021999771730', '868683027055594'),
(5, '021996488190', '888888888888888'),
(6, '021999669740', '777777777777777'),
(8, '021972752990', '868683029203325'),
(9, '021997344680', '864893031254828'),
(10, '021967627076', '864893031253163');

-- --------------------------------------------------------

--
-- Estrutura da tabela `app_users`
--

CREATE TABLE `app_users` (
  `id` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `lastupdate` varchar(128) NOT NULL,
  `token` varchar(128) NOT NULL,
  `session` varchar(128) NOT NULL,
  `platformtoken` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `app_users`
--

INSERT INTO `app_users` (`id`, `iduser`, `lastupdate`, `token`, `session`, `platformtoken`) VALUES
(1, 1, '1553383217', '57430bed3e4aece0833a9d893bf1973a', 'faa9afea49ef2ff029a833cccc778fd0', 'w6m7W4XoPAiF66qxqNG1elRSupLgkvBh'),
(2, 2, '1548115678', 'b7ce7174cac730ca074bef44cb8ca48a', '3e89ebdb49f712c7d90d1b39e348bbbf', 'QpVVFljnqWPCuXeTANyoXg10Z4exs9UR'),
(4, 4, '1549284056', '27702ac6a7226627d22326ecb30e524f', 'b2eb7349035754953b57a32e2841bda5', 'vh0VavB41tBJHPpwlSGBtML8qxHizA7I'),
(5, 5, '1549274722', '20cf75fe85660cc9ff19a476a9f00af4', 'a597e50502f5ff68e3e25b9114205d4a', 'qGLvLcHh4mcl3I1KydSSfnRIKIcWTvz7');

-- --------------------------------------------------------

--
-- Estrutura da tabela `app_vehicles`
--

CREATE TABLE `app_vehicles` (
  `id` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `idregistered` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `model` varchar(50) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `app_vehicles`
--

INSERT INTO `app_vehicles` (`id`, `iduser`, `idregistered`, `name`, `password`, `model`, `category`, `date`, `status`) VALUES
(6, 2, 4, 'Cinza', '123456', ' ', ' ', '2019-01-21 23:55:05', 1),
(7, 2, 1, 'Titan', '123456', ' ', ' ', '2019-01-21 23:56:05', 1),
(8, 2, 5, 'Gm', '123456', ' ', ' ', '2019-01-21 23:58:56', 1),
(9, 2, 6, 'Azulão', '123456', ' ', ' ', '2019-01-22 00:02:33', 1),
(10, 1, 1, 'Moto', '123456', ' ', ' ', '2019-01-22 00:59:31', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `platform`
--

CREATE TABLE `platform` (
  `id` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `idplatform` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `registro_vendas`
--

CREATE TABLE `registro_vendas` (
  `id` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idveiculo` int(11) NOT NULL,
  `plano` int(11) NOT NULL,
  `valortotal` decimal(6,2) NOT NULL,
  `valorunitario` decimal(6,2) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `formapagamento` int(11) NOT NULL,
  `datavenda` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `statusdata` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tokens`
--

CREATE TABLE `tokens` (
  `id` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `token` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `datebirth` varchar(10) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `email` varchar(128) NOT NULL,
  `login` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `cellphone` varchar(20) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `zipcode` varchar(10) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `neighborhood` varchar(50) DEFAULT NULL,
  `address` text,
  `addressnumber` varchar(20) DEFAULT NULL,
  `complement` varchar(128) DEFAULT NULL,
  `serviceterms` tinyint(1) NOT NULL,
  `expirationtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `datebirth`, `cpf`, `email`, `login`, `password`, `cellphone`, `phone`, `zipcode`, `state`, `city`, `neighborhood`, `address`, `addressnumber`, `complement`, `serviceterms`, `expirationtime`, `admin`, `date`, `status`) VALUES
(1, 'Filipe Martin Gomes de Loiola', '', '14243945760', 'filipe_rsm@hotmail.com', 'filipe', '$2y$10$3avAeWdbzes9uBqOBUJkfOxjBYsbAavA/nQ6xv0U399vB5kBzzlDm', '(21) 99639-6896', '', '', '', '', '', '', '', '', 1, '2022-01-01 02:00:00', 1, '2019-01-15 00:13:33', 1),
(2, 'Paulo Cesar Gomes de Loiola', '', '07555845730', 'paulo_rsm@hotmail.com', 'paulo', '$2y$10$dUCwabjkkueiMdk.eZrcTeUvdlDrTDA70MgCbx43C7tu0d2XxGywW', '(21) 99825-9540', '', '', '', '', '', '', '', '', 1, '2022-01-01 02:00:00', 1, '2019-01-19 17:15:35', 1),
(4, 'Reinaldo Souza de Jesus', '', '08490507730', 'reinaldo_rsm@hotmail.com', 'reinaldo jesus', '$2y$10$QWrxWZ7adC3HOq9XRKUr5uOgGgfeCtMjXhVqCZmSPK.Lv/DKK/wO6', '(21) 99693-4020', '', '', '', '', '', '', '', '', 1, '2020-01-10 02:00:00', 0, '2019-01-22 23:51:08', 1),
(5, 'Jorge Barros Júnior', '', '83790691853', 'jorge_rsm@hotmail.com', 'magda jorge', '$2y$10$22KmM421y8oSOc/SAZxvm.HlgqLFgeOLBm4gr1enOwb0BMWztncH6', '(21) 97620-9896', '', '', '', '', '', '', '', '', 1, '2020-01-10 02:00:00', 0, '2019-01-23 00:17:23', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_registered`
--
ALTER TABLE `app_registered`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `imei` (`imei`);

--
-- Indexes for table `app_users`
--
ALTER TABLE `app_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `iduser` (`iduser`),
  ADD UNIQUE KEY `token` (`token`),
  ADD UNIQUE KEY `platformtoken` (`platformtoken`);

--
-- Indexes for table `app_vehicles`
--
ALTER TABLE `app_vehicles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_vehicle_user` (`iduser`),
  ADD KEY `fk_vehicle_registered` (`idregistered`);

--
-- Indexes for table `platform`
--
ALTER TABLE `platform`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `iduser` (`iduser`);

--
-- Indexes for table `registro_vendas`
--
ALTER TABLE `registro_vendas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_registrovenda_usuario` (`idusuario`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_token_user` (`iduser`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_registered`
--
ALTER TABLE `app_registered`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;
--
-- AUTO_INCREMENT for table `app_users`
--
ALTER TABLE `app_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `app_vehicles`
--
ALTER TABLE `app_vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
--
-- AUTO_INCREMENT for table `platform`
--
ALTER TABLE `platform`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `registro_vendas`
--
ALTER TABLE `registro_vendas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `app_users`
--
ALTER TABLE `app_users`
  ADD CONSTRAINT `fk_app_user` FOREIGN KEY (`iduser`) REFERENCES `users` (`id`);

--
-- Limitadores para a tabela `app_vehicles`
--
ALTER TABLE `app_vehicles`
  ADD CONSTRAINT `fk_vehicle_registered` FOREIGN KEY (`idregistered`) REFERENCES `app_registered` (`id`),
  ADD CONSTRAINT `fk_vehicle_user` FOREIGN KEY (`iduser`) REFERENCES `app_users` (`iduser`);

--
-- Limitadores para a tabela `platform`
--
ALTER TABLE `platform`
  ADD CONSTRAINT `fk_platform_user` FOREIGN KEY (`iduser`) REFERENCES `users` (`id`);

--
-- Limitadores para a tabela `registro_vendas`
--
ALTER TABLE `registro_vendas`
  ADD CONSTRAINT `fk_registrovenda_usuario` FOREIGN KEY (`idusuario`) REFERENCES `users` (`id`);

--
-- Limitadores para a tabela `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `fk_token_user` FOREIGN KEY (`iduser`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
