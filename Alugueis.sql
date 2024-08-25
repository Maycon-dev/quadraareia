-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 25/08/2024 às 14:46
-- Versão do servidor: 8.3.0
-- Versão do PHP: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `marcacao_locais`
--
CREATE DATABASE IF NOT EXISTS `marcacao_locais` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `marcacao_locais`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `avaliacao`
--

DROP TABLE IF EXISTS `avaliacao`;
CREATE TABLE IF NOT EXISTS `avaliacao` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `local_id` int NOT NULL,
  `nota` int NOT NULL,
  `comentario` text,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `local_id` (`local_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `configuracao`
--

DROP TABLE IF EXISTS `configuracao`;
CREATE TABLE IF NOT EXISTS `configuracao` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome_configuracao` varchar(255) NOT NULL,
  `valor` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `horario_disponivel`
--

DROP TABLE IF EXISTS `horario_disponivel`;
CREATE TABLE IF NOT EXISTS `horario_disponivel` (
  `id` int NOT NULL AUTO_INCREMENT,
  `local_id` int NOT NULL,
  `dia_semana` int NOT NULL COMMENT '1=domingo, 2=segunda, 3=terça, 4=quarta, 5=quinta, 6=sexta, 7=sábado',
  `hora_inicio` time NOT NULL,
  `hora_fim` time NOT NULL,
  `statusRegistro` int NOT NULL DEFAULT '1' COMMENT '1 - Ativo, 2 - Inativo',
  PRIMARY KEY (`id`),
  KEY `local_id` (`local_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `horario_disponivel`
--

INSERT INTO `horario_disponivel` (`id`, `local_id`, `dia_semana`, `hora_inicio`, `hora_fim`, `statusRegistro`) VALUES
(1, 2, 4, '08:00:00', '20:00:00', 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `local`
--

DROP TABLE IF EXISTS `local`;
CREATE TABLE IF NOT EXISTS `local` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome_local` varchar(255) NOT NULL,
  `tipo_local` int NOT NULL COMMENT '1=quadra_de_areia, 2=campo, 3=salao_de_festas, 4=outro',
  `capacidade` int NOT NULL,
  `descricao` text,
  `preco_hora` decimal(10,2) NOT NULL,
  `statusRegistro` int DEFAULT '1' COMMENT '1 - Ativo, 2 - Inativo',
  PRIMARY KEY (`id`),
  KEY `tipo_local` (`tipo_local`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `local`
--

INSERT INTO `local` (`id`, `nome_local`, `tipo_local`, `capacidade`, `descricao`, `preco_hora`, `statusRegistro`) VALUES
(2, 'Quadra de Areia', 2, 20, 'Quadra de Areia C3', 15.00, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `metodo_pagamento`
--

DROP TABLE IF EXISTS `metodo_pagamento`;
CREATE TABLE IF NOT EXISTS `metodo_pagamento` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descricao` text,
  `statusRegistro` int DEFAULT '1' COMMENT '1 - Ativo, 2 - Inativo',
  `criado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `metodo_pagamento`
--

INSERT INTO `metodo_pagamento` (`id`, `nome`, `descricao`, `statusRegistro`, `criado_em`, `atualizado_em`) VALUES
(1, 'Dinheiro', 'Dinheiro', 1, '2024-08-24 17:30:54', '2024-08-24 17:30:54');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pagamento`
--

DROP TABLE IF EXISTS `pagamento`;
CREATE TABLE IF NOT EXISTS `pagamento` (
  `id` int NOT NULL AUTO_INCREMENT,
  `reserva_id` int NOT NULL,
  `data_pagamento` datetime NOT NULL,
  `valor_pago` decimal(10,2) NOT NULL,
  `metodo_pagamento` int NOT NULL COMMENT '1=cartao, 2=transferencia, 3=boleto, 4=outro',
  `status_pagamento` int NOT NULL COMMENT '1=pago, 2=pendente',
  PRIMARY KEY (`id`),
  KEY `reserva_id` (`reserva_id`),
  KEY `fk_metodo_pagamento` (`metodo_pagamento`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `pagamento`
--

INSERT INTO `pagamento` (`id`, `reserva_id`, `data_pagamento`, `valor_pago`, `metodo_pagamento`, `status_pagamento`) VALUES
(1, 1, '0000-00-00 00:00:00', 15.00, 1, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `penalidade`
--

DROP TABLE IF EXISTS `penalidade`;
CREATE TABLE IF NOT EXISTS `penalidade` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `statusRegistro` int NOT NULL,
  `inicio` date NOT NULL DEFAULT (now()),
  `fim` date NOT NULL,
  `motivo` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `penalidade`
--

INSERT INTO `penalidade` (`id`, `usuario_id`, `statusRegistro`, `inicio`, `fim`, `motivo`) VALUES
(3, 3, 1, '2024-08-22', '2024-08-23', 'ryjhyhy'),
(4, 3, 1, '2024-08-24', '2024-08-30', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `reserva`
--

DROP TABLE IF EXISTS `reserva`;
CREATE TABLE IF NOT EXISTS `reserva` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `local_id` int NOT NULL,
  `data_reserva` datetime NOT NULL,
  `data_hora_inicio` datetime NOT NULL,
  `data_hora_fim` datetime NOT NULL,
  `statusRegistro` int DEFAULT '1' COMMENT '1 - Ativo, 2 - Inativo',
  `status` int NOT NULL COMMENT '1=pendente, 2=confirmada, 3=cancelada',
  `valor` decimal(10,2) NOT NULL,
  `cpf` varchar(50) NOT NULL,
  `telefone` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `local_id` (`local_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `reserva`
--

INSERT INTO `reserva` (`id`, `usuario_id`, `local_id`, `data_reserva`, `data_hora_inicio`, `data_hora_fim`, `statusRegistro`, `status`, `valor`, `cpf`, `telefone`) VALUES
(1, 2, 2, '0000-00-00 00:00:00', '2008-00-00 00:00:00', '2020-00-00 00:00:00', 1, 1, 15.00, '09068884689', '32984924071');

-- --------------------------------------------------------

--
-- Estrutura para tabela `reserva_servico`
--

DROP TABLE IF EXISTS `reserva_servico`;
CREATE TABLE IF NOT EXISTS `reserva_servico` (
  `id` int NOT NULL AUTO_INCREMENT,
  `reserva_id` int NOT NULL,
  `servico_id` int NOT NULL,
  `statusRegistro` int DEFAULT '1' COMMENT '1 - Ativo, 2 - Inativo',
  PRIMARY KEY (`id`),
  KEY `reserva_id` (`reserva_id`),
  KEY `servico_id` (`servico_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `servico_adicional`
--

DROP TABLE IF EXISTS `servico_adicional`;
CREATE TABLE IF NOT EXISTS `servico_adicional` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome_servico` varchar(255) NOT NULL,
  `descricao` text,
  `statusRegistro` int DEFAULT '1' COMMENT '1 - Ativo, 2 - Inativo',
  `preco` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tipo_local`
--

DROP TABLE IF EXISTS `tipo_local`;
CREATE TABLE IF NOT EXISTS `tipo_local` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descricao` text,
  `statusRegistro` int DEFAULT '1' COMMENT '1 - Ativo, 2 - Inativo',
  `criado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `tipo_local`
--

INSERT INTO `tipo_local` (`id`, `nome`, `descricao`, `statusRegistro`, `criado_em`, `atualizado_em`) VALUES
(2, 'Quadra', 'Quadra', 1, '2024-08-24 17:02:33', '2024-08-24 17:36:39'),
(3, 'myrian aa', 'gdred', 1, '2024-08-24 22:00:46', '2024-08-24 22:00:46');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `email` varchar(191) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `statusRegistro` int DEFAULT '1' COMMENT '1 - Ativo, 2 - Inativo',
  `tipo_usuario` int NOT NULL COMMENT '1=admin, 2=cliente',
  `cpf` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `email`, `senha`, `telefone`, `statusRegistro`, `tipo_usuario`, `cpf`) VALUES
(2, 'Administrador', 'sistemaagenda@gmail.com', '$2y$10$zW2j.Z8MstGc/rZEILmkbOCCli6PksVJOArnBl2bTtivE3WotL5Na', '09068489512', 1, 1, '09068884689'),
(3, 'HUDSON CAIO', 'hudsoncaio123@gmail.com', '$2y$10$6o9arTkzQcOnAp4jDOhnLOdxMb5uckg.g9c7Rem.QZFpM/4rFp1yW', NULL, 1, 1, '173.173.007-13');

-- --------------------------------------------------------

--
-- Estrutura stand-in para view `usuario_formatado`
-- (Veja abaixo para a visão atual)
--
DROP VIEW IF EXISTS `usuario_formatado`;
CREATE TABLE IF NOT EXISTS `usuario_formatado` (
`id` int
,`nome` varchar(255)
,`email` varchar(191)
,`senha` varchar(255)
,`telefone` varchar(20)
,`statusRegistro` int
,`tipo_usuario` int
,`cpf` varchar(20)
,`usu` varchar(283)
);

-- --------------------------------------------------------

--
-- Estrutura para view `usuario_formatado`
--
DROP TABLE IF EXISTS `usuario_formatado`;

DROP VIEW IF EXISTS `usuario_formatado`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `usuario_formatado`  AS SELECT `usuario`.`id` AS `id`, `usuario`.`nome` AS `nome`, `usuario`.`email` AS `email`, `usuario`.`senha` AS `senha`, `usuario`.`telefone` AS `telefone`, `usuario`.`statusRegistro` AS `statusRegistro`, `usuario`.`tipo_usuario` AS `tipo_usuario`, `usuario`.`cpf` AS `cpf`, concat(`usuario`.`nome`,' - ',(case when (length(`usuario`.`cpf`) = 11) then concat(substr(`usuario`.`cpf`,1,3),'.',substr(`usuario`.`cpf`,4,3),'.',substr(`usuario`.`cpf`,7,3),'-',substr(`usuario`.`cpf`,10,2)) when (length(`usuario`.`cpf`) = 14) then concat(substr(`usuario`.`cpf`,1,2),'.',substr(`usuario`.`cpf`,3,5),'.',substr(`usuario`.`cpf`,6,8),'/',substr(`usuario`.`cpf`,9,4),'-',substr(`usuario`.`cpf`,13,2)) end)) AS `usu` FROM `usuario` WHERE (`usuario`.`statusRegistro` = 1) ORDER BY `usuario`.`nome` ASC ;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `horario_disponivel`
--
ALTER TABLE `horario_disponivel`
  ADD CONSTRAINT `horario_disponivel_ibfk_1` FOREIGN KEY (`local_id`) REFERENCES `local` (`id`);

--
-- Restrições para tabelas `local`
--
ALTER TABLE `local`
  ADD CONSTRAINT `fk_tipo_local` FOREIGN KEY (`tipo_local`) REFERENCES `tipo_local` (`id`);

--
-- Restrições para tabelas `pagamento`
--
ALTER TABLE `pagamento`
  ADD CONSTRAINT `fk_metodo_pagamento` FOREIGN KEY (`metodo_pagamento`) REFERENCES `metodo_pagamento` (`id`),
  ADD CONSTRAINT `pagamento_ibfk_1` FOREIGN KEY (`reserva_id`) REFERENCES `reserva` (`id`);

--
-- Restrições para tabelas `penalidade`
--
ALTER TABLE `penalidade`
  ADD CONSTRAINT `penalidade_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `reserva_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `reserva_ibfk_2` FOREIGN KEY (`local_id`) REFERENCES `local` (`id`);

--
-- Restrições para tabelas `reserva_servico`
--
ALTER TABLE `reserva_servico`
  ADD CONSTRAINT `reserva_servico_ibfk_1` FOREIGN KEY (`reserva_id`) REFERENCES `reserva` (`id`),
  ADD CONSTRAINT `reserva_servico_ibfk_2` FOREIGN KEY (`servico_id`) REFERENCES `servico_adicional` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
