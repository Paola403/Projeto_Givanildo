-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11/11/2025 às 19:41
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `givanildo`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_categoria`
--

CREATE TABLE `tb_categoria` (
  `CATE_ID` int(11) NOT NULL,
  `CATE_DESCRICAO` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_cliente`
--

CREATE TABLE `tb_cliente` (
  `CLI_ID` int(11) NOT NULL,
  `CLI_LOGIN` varchar(250) NOT NULL,
  `CLI_SENHA` varchar(250) NOT NULL,
  `CLI_NOME` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_tarefa`
--

CREATE TABLE `tb_tarefa` (
  `TAREFA_ID` int(11) NOT NULL,
  `TAREFA_TITULO` varchar(100) DEFAULT NULL,
  `TAREFA_DESCRICAO` varchar(250) DEFAULT NULL,
  `TAREFA_DATA_INICIO` datetime DEFAULT NULL,
  `TAREFA_DATA_FIM` datetime DEFAULT NULL,
  `TAREFA_DATA_FINALIZADA` datetime DEFAULT NULL,
  `TAREFA_STATUS` char(1) DEFAULT NULL,
  `TAREFA_FINALIZADA` tinyint(1) DEFAULT NULL,
  `TAREFA_CLIENTE` int(11) DEFAULT NULL,
  `TAREFA_CATEGORIA` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tb_categoria`
--
ALTER TABLE `tb_categoria`
  ADD PRIMARY KEY (`CATE_ID`);

--
-- Índices de tabela `tb_cliente`
--
ALTER TABLE `tb_cliente`
  ADD PRIMARY KEY (`CLI_ID`),
  ADD UNIQUE KEY `CLI_SENHA` (`CLI_SENHA`);

--
-- Índices de tabela `tb_tarefa`
--
ALTER TABLE `tb_tarefa`
  ADD PRIMARY KEY (`TAREFA_ID`),
  ADD KEY `FK_CLIENTE_TAREFA` (`TAREFA_CLIENTE`),
  ADD KEY `FK_CATEGORIA_TAREFA` (`TAREFA_CATEGORIA`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_categoria`
--
ALTER TABLE `tb_categoria`
  MODIFY `CATE_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_cliente`
--
ALTER TABLE `tb_cliente`
  MODIFY `CLI_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_tarefa`
--
ALTER TABLE `tb_tarefa`
  MODIFY `TAREFA_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `tb_tarefa`
--
ALTER TABLE `tb_tarefa`
  ADD CONSTRAINT `FK_CATEGORIA_TAREFA` FOREIGN KEY (`TAREFA_CATEGORIA`) REFERENCES `tb_categoria` (`CATE_ID`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_CLIENTE_TAREFA` FOREIGN KEY (`TAREFA_CLIENTE`) REFERENCES `tb_cliente` (`CLI_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
