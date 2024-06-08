-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 04-Jun-2024 às 15:55
-- Versão do servidor: 10.4.28-MariaDB
-- versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `feedback_system`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `contato`
--

CREATE TABLE `contato` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `categoria` varchar(20) NOT NULL DEFAULT 'Sem cadastro',
  `telefone` int(11) NOT NULL,
  `mensagem` text NOT NULL,
  `criado` timestamp NULL DEFAULT current_timestamp(),
  `resposta` text DEFAULT NULL,
  `data_resposta` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Extraindo dados da tabela `contato`
--

INSERT INTO `contato` (`id`, `nome`, `email`, `categoria`, `telefone`, `mensagem`, `criado`, `resposta`, `data_resposta`) VALUES
(2, 'Henrique de Oliveira', 'henrique@henrique.com', 'Sem cadastro', 2147483647, 'Python Ã© uma linguagem de programaÃ§Ã£o de alto nÃ­vel, interpretada de script, imperativa, orientada a objetos, funcional, de tipagem dinÃ¢mica e forte. Foi lanÃ§ada por Guido van Rossum em 1991.', '2024-06-04 13:44:08', NULL, NULL),
(3, 'Teste', 'teste@teste.com', 'Sem cadastro', 2147483647, 'teste', '2024-06-04 13:53:59', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT 0,
  `categoria` varchar(20) DEFAULT 'Professor',
  `token` varchar(50) DEFAULT NULL,
  `token_expira` varchar(50) DEFAULT NULL,
  `criado` datetime DEFAULT NULL,
  `ultima_atualizacao` timestamp NULL DEFAULT current_timestamp(),
  `ultimo_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `email`, `senha`, `status`, `categoria`, `token`, `token_expira`, `criado`, `ultima_atualizacao`, `ultimo_login`) VALUES
(7, 'Teste', 'teste@teste.com', '$2y$10$TazoretLYaJ8g8RYZcwGZ.Ce9yMF8LpojlCKDM6Yj5BIMjea.ay2W', 1, 'Professor', NULL, NULL, '2024-06-04 09:22:41', '2024-06-04 12:22:41', '2024-06-04 09:42:14'),
(8, 'Henrique de Oliveira', 'henrique@henrique.com', '$2y$10$H3BGiZ5jCtzhyl1aQCwj0ehrlnO3Rn0DB4TQ82QoTvkFXSVA/cfk2', 1, 'Administrador', NULL, NULL, '2024-06-04 09:23:36', '2024-06-04 12:23:36', '2024-06-04 10:54:10'),
(11, 'admin', 'admin@admin.com', '$2y$10$DqAiQaMLl5f5T7H7tXxWMesI4PfjjOhpr4E1cESZJiRh.s1adL6Hi', 1, 'Administrador', NULL, NULL, '2024-06-04 10:19:35', '2024-06-04 13:19:35', '2024-06-04 10:44:16'),
(12, 'marli', 'marli@gmail.com', '$2y$10$64OLOBtXslYWarg6KUULw.oJ8.Zi3aV5Kq1wch4Ny1g5ZMCqyXKry', 1, 'Professor', NULL, NULL, '2024-06-04 10:25:41', '2024-06-04 13:25:41', '2024-06-04 10:50:12');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `contato`
--
ALTER TABLE `contato`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `contato`
--
ALTER TABLE `contato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
