
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Banco de Dados: `simplewapp`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `prioridades`
--

CREATE TABLE IF NOT EXISTS `prioridades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `nivel` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dados da tabela `prioridades`
--

INSERT INTO `prioridades` (`id`, `nome`, `nivel`) VALUES
(1, 'Baixa', 1),
(2, 'Normal', 2),
(3, 'Alta', 3),
(4, 'Urgente', 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `situacoes`
--

CREATE TABLE IF NOT EXISTS `situacoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dados da tabela `situacoes`
--

INSERT INTO `situacoes` (`id`, `nome`) VALUES
(1, 'Tarefa para fazer'),
(2, 'Tarefa feita');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tarefas`
--

CREATE TABLE IF NOT EXISTS `tarefas` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `removido` tinyint(1) NOT NULL DEFAULT '0',
  `titulo` varchar(255) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `situacao_id` int(11) NOT NULL,
  `prioridade_id` int(11) NOT NULL,
  `ordem` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fktarefassituacoes` (`situacao_id`) USING BTREE,
  KEY `fktarefasprioridades` (`prioridade_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Restrições para a tabela `tarefas`
--
ALTER TABLE `tarefas`
  ADD CONSTRAINT `fktarefasprioridades` FOREIGN KEY (`prioridade_id`) REFERENCES `prioridades` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fktarefassituacoes` FOREIGN KEY (`situacao_id`) REFERENCES `situacoes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;