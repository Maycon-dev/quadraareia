-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 01/09/2024 às 14:34
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

DELIMITER $$
--
-- Procedimentos
--
DROP PROCEDURE IF EXISTS `AtualizarHorarios`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `AtualizarHorarios` ()   BEGIN
    DECLARE data_atual DATE;
    DECLARE data_futura DATE;
    DECLARE intervalo_dias INT;

    -- Criação de uma tabela temporária para depuração
    CREATE TEMPORARY TABLE IF NOT EXISTS debug_log (
        id INT AUTO_INCREMENT PRIMARY KEY,
        intervalo_dias INT
    );
    
    -- Obter o intervalo de dias da tabela de configuração
    SELECT intervalo_dias
    INTO intervalo_dias
    FROM configuracoes_intervalo
    LIMIT 1;

    -- Verificar o valor de intervalo_dias
    SELECT intervalo_dias AS intervalo_dias_debug;

    -- Se intervalo_dias for NULL, definir um valor padrão (por exemplo, 7)
    SET intervalo_dias = COALESCE(intervalo_dias, 7);

    -- Inserir o valor na tabela temporária
    INSERT INTO debug_log (intervalo_dias) VALUES (intervalo_dias);

    -- Definir a data atual
    SET data_atual = CURDATE();
    
    -- Definir a data futura (baseada no intervalo de dias)
    SET data_futura = DATE_ADD(data_atual, INTERVAL intervalo_dias DAY);
    
    -- Atualizar o status dos horários fora do intervalo de 7 dias para inativo
    UPDATE horario_disponivel
    SET statusRegistro = 2
    WHERE hora_inicio < data_atual AND statusRegistro = 1;
    
    -- Atualizar o status dos horários dentro do intervalo de 7 dias e sem reservas para ativo
    UPDATE horario_disponivel hd
    LEFT JOIN reserva r ON hd.id = r.horario_id
    SET hd.statusRegistro = 1
    WHERE hd.hora_inicio >= data_atual 
      AND hd.hora_inicio <= data_futura
      AND r.id IS NULL;
    
    -- Atualizar o status dos horários que já passaram, mas têm reservas (mantendo inativo)
    UPDATE horario_disponivel hd
    JOIN reserva r ON hd.id = r.horario_id
    SET hd.statusRegistro = 2
    WHERE hd.hora_inicio < data_atual 
      AND r.id IS NOT NULL;

    -- Para depuração, selecione o conteúdo da tabela temporária
    SELECT * FROM debug_log;
    
END$$

DELIMITER ;

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
  `intervalo_dias` int NOT NULL COMMENT 'Número de dias para manter o status ativo',
  `data_inicio` datetime NOT NULL COMMENT 'Data e hora de início do intervalo',
  `data_fim` datetime NOT NULL COMMENT 'Data e hora de fim do intervalo',
  `hora_inicio_intervalo` time DEFAULT NULL COMMENT 'Hora de início do intervalo',
  `hora_fim_intervalo` time DEFAULT NULL COMMENT 'Hora de fim do intervalo',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_data_inicio` (`data_inicio`),
  KEY `idx_data_fim` (`data_fim`)
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
  `hora_inicio` datetime NOT NULL,
  `hora_fim` datetime NOT NULL,
  `statusRegistro` int NOT NULL DEFAULT '1' COMMENT '1 - Ativo, 2 - Inativo',
  `configuracao_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `local_id` (`local_id`),
  KEY `idx_hora_inicio` (`hora_inicio`),
  KEY `idx_hora_fim` (`hora_fim`),
  KEY `horario_disponivel_ibfk_2` (`configuracao_id`)
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
  `id_reserva` int NOT NULL,
  `valor_total` decimal(10,2) NOT NULL,
  `valor_pago` decimal(10,2) NOT NULL,
  `valor_restante` decimal(10,2) NOT NULL,
  `status` int NOT NULL COMMENT '1 = Aberto, 2 = Parcialmente, 3 = Baixado',
  `data_emissao` date NOT NULL,
  `data_vencimento` date NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `fk_reserva` (`id_reserva`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pagamento_item`
--

DROP TABLE IF EXISTS `pagamento_item`;
CREATE TABLE IF NOT EXISTS `pagamento_item` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pagamento` int NOT NULL,
  `id_metodo_pagamento` int NOT NULL,
  `valor` decimal(10,2) NOT NULL DEFAULT '0.00',
  `data` date NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `fk_pagamento` (`id_pagamento`) USING BTREE,
  KEY `fk_metodo_pagamento` (`id_metodo_pagamento`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `reserva`
--

DROP TABLE IF EXISTS `reserva`;
CREATE TABLE IF NOT EXISTS `reserva` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `local_id` int NOT NULL,
  `horario_id` int NOT NULL,
  `data_reserva` datetime NOT NULL,
  `data_hora_inicio` datetime NOT NULL,
  `data_hora_fim` datetime NOT NULL,
  `statusRegistro` int DEFAULT '1' COMMENT '1 - Ativo, 2 - Inativo',
  `status` int NOT NULL COMMENT '1=pendente, 2=confirmada, 3=cancelada',
  `valor_total` decimal(10,2) NOT NULL,
  `cpf` varchar(50) NOT NULL,
  `telefone` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `local_id` (`local_id`),
  KEY `reserva_ibfk_3` (`horario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Acionadores `reserva`
--
DROP TRIGGER IF EXISTS `tg_geraPagamento`;
DELIMITER $$
CREATE TRIGGER `tg_geraPagamento` AFTER INSERT ON `reserva` FOR EACH ROW BEGIN
    INSERT INTO pagamento (id_reserva, valor_total, valor_pago, valor_restante, status, data_emissao, vencimento)
    VALUES (NEW.id, NEW.valor_total, 0, NEW.valor_total, 1, CURRENT_DATE, NEW.data_reserva);
END
$$
DELIMITER ;

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
  `cpf` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  ADD CONSTRAINT `horario_disponivel_ibfk_1` FOREIGN KEY (`local_id`) REFERENCES `local` (`id`),
  ADD CONSTRAINT `horario_disponivel_ibfk_2` FOREIGN KEY (`configuracao_id`) REFERENCES `configuracoes_intervalo` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Restrições para tabelas `local`
--
ALTER TABLE `local`
  ADD CONSTRAINT `fk_tipo_local` FOREIGN KEY (`tipo_local`) REFERENCES `tipo_local` (`id`);

--
-- Restrições para tabelas `pagamento`
--
ALTER TABLE `pagamento`
  ADD CONSTRAINT `fk_reserva` FOREIGN KEY (`id_reserva`) REFERENCES `reserva` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `pagamento_item`
--
ALTER TABLE `pagamento_item`
  ADD CONSTRAINT `fk_metodo_pagamento` FOREIGN KEY (`id_metodo_pagamento`) REFERENCES `metodo_pagamento` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_pagamento` FOREIGN KEY (`id_pagamento`) REFERENCES `pagamento` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

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
  ADD CONSTRAINT `reserva_ibfk_2` FOREIGN KEY (`local_id`) REFERENCES `local` (`id`),
  ADD CONSTRAINT `reserva_ibfk_3` FOREIGN KEY (`horario_id`) REFERENCES `horario_disponivel` (`id`);

--
-- Restrições para tabelas `reserva_servico`
--
ALTER TABLE `reserva_servico`
  ADD CONSTRAINT `reserva_servico_ibfk_1` FOREIGN KEY (`reserva_id`) REFERENCES `reserva` (`id`),
  ADD CONSTRAINT `reserva_servico_ibfk_2` FOREIGN KEY (`servico_id`) REFERENCES `servico_adicional` (`id`);

DELIMITER $$
--
-- Eventos
--
DROP EVENT IF EXISTS `AtualizarStatusDiariamente`$$
CREATE DEFINER=`root`@`localhost` EVENT `AtualizarStatusDiariamente` ON SCHEDULE EVERY 1 DAY STARTS '2024-08-01 06:00:00' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    CALL AtualizarStatus();
END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
