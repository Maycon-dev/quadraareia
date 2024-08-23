-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 22/08/2024 às 23:18
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
-- Estrutura para tabela `configuracoes_intervalo`
--

DROP TABLE IF EXISTS `configuracoes_intervalo`;
CREATE TABLE IF NOT EXISTS `configuracoes_intervalo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `intervalo_dias` int NOT NULL,
  `data_ultima_atualizacao` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `penalidade`
--

DROP TABLE IF EXISTS `penalidade`;
CREATE TABLE IF NOT EXISTS `penalidade` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `faltas` int NOT NULL DEFAULT '0',
  `dias_bloqueio` int NOT NULL DEFAULT '0',
  `bloqueado_ate` date DEFAULT NULL,
  `statusRegistro` int NOT NULL,
  `criado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `reserva`
--

DROP TABLE IF EXISTS `reserva`;
CREATE TABLE IF NOT EXISTS `reserva` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int DEFAULT NULL,
  `cpf` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `local_id` int NOT NULL,
  `data_reserva` datetime NOT NULL,
  `data_hora_inicio` datetime NOT NULL,
  `data_hora_fim` datetime NOT NULL,
  `statusRegistro` int DEFAULT '1' COMMENT '1 - Ativo, 2 - Inativo',
  `status` int NOT NULL COMMENT '1=pendente, 2=confirmada, 3=cancelada',
  `valor_total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `local_id` (`local_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
