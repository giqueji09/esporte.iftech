-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11/08/2026 às 16:29
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `reservai`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `quadras`
--

CREATE TABLE `quadras` (
  `idQuadra` int(11) NOT NULL,
  `fotoQuadra` varchar(200) NOT NULL,
  `nomeQuadra` varchar(100) NOT NULL,
  `esportes` varchar(100) NOT NULL,
  `localizacao` varchar(100) NOT NULL,
  `horarioAbertura` time NOT NULL,
  `horarioFechamento` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `quadras`
--

INSERT INTO `quadras` (`idQuadra`, `fotoQuadra`, `nomeQuadra`, `esportes`, `localizacao`, `horarioAbertura`, `horarioFechamento`) VALUES
(1, 'assets/img/interiorQuadraIF2.jpg', 'Quadra IFPR', 'poliesportiva', 'PR-160, km 19,5 Jardim Bandeirantes, Telêmaco Borba - PR', '07:30:00', '22:00:00'),
(2, 'assets/img/interiorQuadraIF2.jpg', 'Quadra Teste', 'Teste', 'Teste Teste Teste', '08:00:00', '21:00:00'),
(3, 'assets/img/furtadao.jpg', 'Furtadão', 'poliesportivo', 'Avenida das Nações, s/n - Centro, Telêmaco Borba', '09:00:00', '23:00:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `reservas`
--

CREATE TABLE `reservas` (
  `idReserva` int(11) NOT NULL,
  `idReservante` int(11) NOT NULL,
  `idQuadraReservada` int(11) NOT NULL,
  `dataReserva` date NOT NULL,
  `horarioInicio` time NOT NULL,
  `horarioFim` time NOT NULL,
  `statusReserva` varchar(50) NOT NULL DEFAULT 'agendado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `reservas`
--

INSERT INTO `reservas` (`idReserva`, `idReservante`, `idQuadraReservada`, `dataReserva`, `horarioInicio`, `horarioFim`, `statusReserva`) VALUES
(2, 1, 2, '2026-08-24', '21:00:00', '23:00:00', 'agendado'),
(4, 7, 1, '2026-09-09', '11:00:00', '13:00:00', 'agendado'),
(6, 1, 1, '2026-09-09', '14:00:00', '16:00:00', 'cancelada'),
(7, 7, 1, '2026-08-08', '10:00:00', '11:00:00', 'concluída'),
(9, 7, 1, '2026-08-31', '12:00:00', '13:00:00', 'agendado');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `cpfUsuario` char(11) NOT NULL,
  `nomeUsuario` varchar(100) NOT NULL,
  `dataNascimentoUsuario` date NOT NULL,
  `telefoneUsuario` char(11) NOT NULL,
  `emailUsuario` varchar(100) NOT NULL,
  `senhaUsuario` varchar(100) NOT NULL,
  `nivelUsuario` varchar(15) NOT NULL DEFAULT 'usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `cpfUsuario`, `nomeUsuario`, `dataNascimentoUsuario`, `telefoneUsuario`, `emailUsuario`, `senhaUsuario`, `nivelUsuario`) VALUES
(1, '13300080900', 'Cesar Augusto', '2008-05-02', '42998069904', '20241tbor0020025@estudantes.ifpr.edu.br', '281d5cbef8ded4e9bee409e3b9c67ab2', 'administrador'),
(3, '48260112965', 'Miguel Gustavo', '2009-04-02', '42998643553', 'miguelgustavovm27@gmail.com', 'a5aad544b38a088b35b395645efe0d61', 'usuario'),
(4, '36528291900', 'Alan de Souza Vanes', '2008-06-06', '66996309666', 'baixinhodesouzaa@gmail.com', '564f4bcd11273b8ea6b49fbe2dc2ad1c', 'usuario'),
(5, '97194506904', 'Fulano', '2001-11-07', '42900000000', 'fulano@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'usuario'),
(6, '60533326907', 'ciclano', '1998-02-21', '42933333333', 'ciclano@gmail.com', '4a7d1ed414474e4033ac29ccb8653d9b', 'usuario'),
(7, '04533601901', 'Júlio', '2004-10-08', '42987654321', 'julio@gmail.com', '113180fa10fcf7a118ecdbcd21c4cd24', 'usuario');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `quadras`
--
ALTER TABLE `quadras`
  ADD PRIMARY KEY (`idQuadra`);

--
-- Índices de tabela `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`idReserva`),
  ADD KEY `idReservante` (`idReservante`),
  ADD KEY `idQuadraReservada` (`idQuadraReservada`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `cpfUsuario` (`cpfUsuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `quadras`
--
ALTER TABLE `quadras`
  MODIFY `idQuadra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `reservas`
--
ALTER TABLE `reservas`
  MODIFY `idReserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`idReservante`) REFERENCES `usuarios` (`idUsuario`),
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`idQuadraReservada`) REFERENCES `quadras` (`idQuadra`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
