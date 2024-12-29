-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 29-Dez-2024 às 02:26
-- Versão do servidor: 8.3.0
-- versão do PHP: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `detailingleiria`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` int DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `idx-auth_assignment-user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '1', 1735262648),
('client', '3', 1735262648),
('funcionario', '7', 1735262648),
('gestor', '8', 1735262648);

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `type` smallint NOT NULL,
  `description` text COLLATE utf8mb3_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('accessBackend', 2, 'Permite acesso ao backend do sistema', NULL, NULL, 1735262647, 1735262647),
('admin', 1, NULL, NULL, NULL, 1735262648, 1735262648),
('client', 1, NULL, NULL, NULL, 1735262648, 1735262648),
('createUserAccounts', 2, 'Permite criar contas de utilizadores e funcionários', NULL, NULL, 1735262648, 1735262648),
('deleteUserAccounts', 2, 'Permite deletar contas de utilizadores e funcionários', NULL, NULL, 1735262648, 1735262648),
('DescontosIndex', 2, 'Permite visualizar os descontos e gerir', NULL, NULL, 1735262647, 1735262647),
('FornecedorIndex', 2, 'Permite visualizar a lista de fornecedores', NULL, NULL, 1735262647, 1735262647),
('funcionario', 1, NULL, NULL, NULL, 1735262648, 1735262648),
('GestaoIndexCategorias', 2, 'Permite visualizar o Gestão de Categorias', NULL, NULL, 1735262647, 1735262647),
('GestaoIndexProdutos', 2, 'Permite visualizar o Gestão de Produtos', NULL, NULL, 1735262648, 1735262648),
('GestaoMetodosEntrega', 2, 'Permite visualizar o Gestão Métodos de Entrega', NULL, NULL, 1735262648, 1735262648),
('GestaoMetodosPagamentos', 2, 'Permite visualizar o Gestão de metodos de pagamentos', NULL, NULL, 1735262648, 1735262648),
('gestor', 1, NULL, NULL, NULL, 1735262648, 1735262648),
('ProdutoIndexCreate', 2, 'Permite criar produtos', NULL, NULL, 1735262648, 1735262648),
('ProdutoIndexDelete', 2, 'Permite deletar os produtos', NULL, NULL, 1735262648, 1735262648),
('ProdutoIndexUpdate', 2, 'Permite visualizar o Update dos produtos', NULL, NULL, 1735262648, 1735262648),
('ProdutoIndexView', 2, 'Permite visualizar a View dos produtos', NULL, NULL, 1735262648, 1735262648),
('updateUserAccounts', 2, 'Permite editar contas de utilizadores e funcionários', NULL, NULL, 1735262648, 1735262648),
('UserIndexAccounts', 2, 'Permite visualizar o index dos utilizadores', NULL, NULL, 1735262647, 1735262647),
('viewUser', 2, 'Permite ao usuário visualizar seu próprio perfil', NULL, NULL, 1735262647, 1735262647),
('viewUserAccounts', 2, 'Permite visualizar contas de utilizadores e funcionários', NULL, NULL, 1735262648, 1735262648);

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('admin', 'accessBackend'),
('funcionario', 'accessBackend'),
('admin', 'createUserAccounts'),
('admin', 'deleteUserAccounts'),
('funcionario', 'DescontosIndex'),
('gestor', 'DescontosIndex'),
('gestor', 'FornecedorIndex'),
('gestor', 'funcionario'),
('gestor', 'GestaoIndexCategorias'),
('funcionario', 'GestaoIndexProdutos'),
('funcionario', 'GestaoMetodosEntrega'),
('gestor', 'GestaoMetodosEntrega'),
('gestor', 'GestaoMetodosPagamentos'),
('admin', 'gestor'),
('gestor', 'ProdutoIndexCreate'),
('gestor', 'ProdutoIndexDelete'),
('gestor', 'ProdutoIndexUpdate'),
('gestor', 'ProdutoIndexView'),
('admin', 'updateUserAccounts'),
('admin', 'UserIndexAccounts'),
('admin', 'viewUser'),
('client', 'viewUser'),
('funcionario', 'viewUser'),
('admin', 'viewUserAccounts');

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliacao`
--

DROP TABLE IF EXISTS `avaliacao`;
CREATE TABLE IF NOT EXISTS `avaliacao` (
  `idavaliacao` int NOT NULL AUTO_INCREMENT,
  `comentario` varchar(256) DEFAULT NULL,
  `rating` decimal(5,0) NOT NULL,
  PRIMARY KEY (`idavaliacao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura da tabela `carrinho`
--

DROP TABLE IF EXISTS `carrinho`;
CREATE TABLE IF NOT EXISTS `carrinho` (
  `idCarrinho` int NOT NULL AUTO_INCREMENT,
  `total` decimal(10,0) DEFAULT NULL,
  `datavenda` datetime DEFAULT NULL,
  `idProfile` int NOT NULL,
  `idMetodoEntrega` int DEFAULT NULL,
  `idMetodoPagamento` int DEFAULT NULL,
  PRIMARY KEY (`idCarrinho`),
  KEY `idProfile` (`idProfile`),
  KEY `idMetodoEntrega` (`idMetodoEntrega`,`idMetodoPagamento`),
  KEY `idMetodoPagamento` (`idMetodoPagamento`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb3;

--
-- Extraindo dados da tabela `carrinho`
--

INSERT INTO `carrinho` (`idCarrinho`, `total`, `datavenda`, `idProfile`, `idMetodoEntrega`, `idMetodoPagamento`) VALUES
(18, NULL, NULL, 9, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
  `idCategoria` int NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idCategoria`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`idCategoria`, `designacao`) VALUES
(1, 'Liquidos'),
(2, 'Panos');

-- --------------------------------------------------------

--
-- Estrutura da tabela `desconto`
--

DROP TABLE IF EXISTS `desconto`;
CREATE TABLE IF NOT EXISTS `desconto` (
  `iddesconto` int NOT NULL AUTO_INCREMENT,
  `desconto` int NOT NULL,
  PRIMARY KEY (`iddesconto`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Extraindo dados da tabela `desconto`
--

INSERT INTO `desconto` (`iddesconto`, `desconto`) VALUES
(1, 10);

-- --------------------------------------------------------

--
-- Estrutura da tabela `favorito`
--

DROP TABLE IF EXISTS `favorito`;
CREATE TABLE IF NOT EXISTS `favorito` (
  `produto_id` int NOT NULL,
  `profile_id` int NOT NULL,
  `idfavorito` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idfavorito`),
  KEY `fk_favorito_produto1_idx` (`produto_id`),
  KEY `fk_favorito_profile1_idx` (`profile_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecedor`
--

DROP TABLE IF EXISTS `fornecedor`;
CREATE TABLE IF NOT EXISTS `fornecedor` (
  `idfornecedor` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idfornecedor`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Extraindo dados da tabela `fornecedor`
--

INSERT INTO `fornecedor` (`idfornecedor`, `nome`) VALUES
(1, '3M');

-- --------------------------------------------------------

--
-- Estrutura da tabela `imagem`
--

DROP TABLE IF EXISTS `imagem`;
CREATE TABLE IF NOT EXISTS `imagem` (
  `idimagem` int NOT NULL AUTO_INCREMENT,
  `fileName` varchar(45) DEFAULT NULL,
  `produtoId` int NOT NULL,
  PRIMARY KEY (`idimagem`),
  KEY `produtoId` (`produtoId`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb3;

--
-- Extraindo dados da tabela `imagem`
--

INSERT INTO `imagem` (`idimagem`, `fileName`, `produtoId`) VALUES
(26, 'VkLzOt2JkJ7NKDe_OPzLNAnGUYLnvLO5.png', 24),
(27, 'k5l4wyw_a66PCqwDruyxORW9YGn1RlNW.jpg', 25);

-- --------------------------------------------------------

--
-- Estrutura da tabela `linhascarrinho`
--

DROP TABLE IF EXISTS `linhascarrinho`;
CREATE TABLE IF NOT EXISTS `linhascarrinho` (
  `idLinhasCarrinho` int NOT NULL AUTO_INCREMENT,
  `quantidade` int DEFAULT NULL,
  `precounitario` decimal(10,0) DEFAULT NULL,
  `subtotal` decimal(10,0) DEFAULT NULL,
  `carrinho_id` int NOT NULL,
  `produtos_id` int NOT NULL,
  PRIMARY KEY (`idLinhasCarrinho`),
  KEY `fk_linhasCarrinho_carrinho1_idx` (`carrinho_id`),
  KEY `fk_linhasCarrinho_produtos1_idx` (`produtos_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura da tabela `linhasvenda`
--

DROP TABLE IF EXISTS `linhasvenda`;
CREATE TABLE IF NOT EXISTS `linhasvenda` (
  `idLinhasVenda` int NOT NULL AUTO_INCREMENT,
  `quantidade` smallint DEFAULT NULL,
  `precounitario` decimal(10,0) DEFAULT NULL,
  `subtotal` decimal(10,0) DEFAULT NULL,
  `idVendaFK` int NOT NULL,
  `idProdutoFK` int NOT NULL,
  `idAvaliacaoFK` int DEFAULT NULL,
  PRIMARY KEY (`idLinhasVenda`),
  KEY `fk_linhasvenda_vendas1_idx` (`idVendaFK`),
  KEY `fk_linhasvenda_produtos1_idx` (`idProdutoFK`),
  KEY `idAvaliacaoFK` (`idAvaliacaoFK`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura da tabela `metodoentrega`
--

DROP TABLE IF EXISTS `metodoentrega`;
CREATE TABLE IF NOT EXISTS `metodoentrega` (
  `idmetodoEntrega` int NOT NULL AUTO_INCREMENT,
  `designacao` varchar(75) DEFAULT NULL,
  PRIMARY KEY (`idmetodoEntrega`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Extraindo dados da tabela `metodoentrega`
--

INSERT INTO `metodoentrega` (`idmetodoEntrega`, `designacao`) VALUES
(1, 'CTT'),
(2, 'FedEx');

-- --------------------------------------------------------

--
-- Estrutura da tabela `metodopagamento`
--

DROP TABLE IF EXISTS `metodopagamento`;
CREATE TABLE IF NOT EXISTS `metodopagamento` (
  `idMetodoPagamento` int NOT NULL AUTO_INCREMENT,
  `designacao` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idMetodoPagamento`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Extraindo dados da tabela `metodopagamento`
--

INSERT INTO `metodopagamento` (`idMetodoPagamento`, `designacao`) VALUES
(1, 'MBWay'),
(2, 'visa');

-- --------------------------------------------------------

--
-- Estrutura da tabela `migration`
--

DROP TABLE IF EXISTS `migration`;
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Extraindo dados da tabela `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1730201654),
('m130524_201442_init', 1730201661),
('m190124_110200_add_verification_token_column_to_user_table', 1730201661),
('m140506_102106_rbac_init', 1731803075),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1731803076),
('m180523_151638_rbac_updates_indexes_without_prefix', 1731803076),
('m200409_110543_rbac_update_mssql_trigger', 1731803076);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

DROP TABLE IF EXISTS `produto`;
CREATE TABLE IF NOT EXISTS `produto` (
  `idProduto` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) DEFAULT NULL,
  `descricao` varchar(45) DEFAULT NULL,
  `preco` float DEFAULT NULL,
  `stock` int DEFAULT NULL,
  `idCategoria` int NOT NULL,
  `fornecedores_idfornecedores` int NOT NULL,
  `idDesconto` int DEFAULT NULL,
  PRIMARY KEY (`idProduto`),
  KEY `fk_produtos_Categorias_idx` (`idCategoria`),
  KEY `fk_produtos_furnecedores1_idx` (`fornecedores_idfornecedores`),
  KEY `idDesconto` (`idDesconto`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb3;

--
-- Extraindo dados da tabela `produto`
--

INSERT INTO `produto` (`idProduto`, `nome`, `descricao`, `preco`, `stock`, `idCategoria`, `fornecedores_idfornecedores`, `idDesconto`) VALUES
(24, 'Produto', 'produto teste ijasodijaosijd', 100, 5, 1, 1, NULL),
(25, 'Spray limpa-vidros', 'aoskdpaokspdokas', 10, 2, 2, 1, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `profile`
--

DROP TABLE IF EXISTS `profile`;
CREATE TABLE IF NOT EXISTS `profile` (
  `idprofile` int NOT NULL AUTO_INCREMENT,
  `morada` varchar(150) DEFAULT NULL,
  `ntelefone` int DEFAULT NULL,
  `userId` int NOT NULL,
  PRIMARY KEY (`idprofile`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3;

--
-- Extraindo dados da tabela `profile`
--

INSERT INTO `profile` (`idprofile`, `morada`, `ntelefone`, `userId`) VALUES
(9, 'rua lisboa 1', 123456789, 24),
(11, 'rua coimbra 1', 912123123, 26);

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8mb3_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` smallint NOT NULL DEFAULT '10',
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  `verification_token` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `verification_token`) VALUES
(1, 'admin', 'VhOSZK2O0x5plc0APurpqZrAFuij7-Jy', '$2y$13$I/0racfHKHiOj2Yn130NQelGjdS0bNk.YyFrGnsS1GTGkJoB3xhx.', NULL, 'admin@detailingleiria.com', 10, 1730204421, 1733359698, '_Rs4Jpt8PCpprMdb4bpWVNMhOiL_QGxc_1733359698'),
(24, 'cliente2', 'yK0-qBCddtrAaT03jfnI6BLaJBzcYvuZ', '$2y$13$mpIEIROKqW1AmGqefrYuQO0FWIH1RR30lfJHGA/w8IpaHIcNFbpdu', NULL, 'cliente2@detailingleiria.pt', 10, 1733874704, 1734832136, 'Dwpjwiec7-QpQvsYhzreZpUPv18h7EWF_1734832136'),
(26, 'gestor', 'h_3VhnxVuXI5fjXbzFfWbV8D_wWFuZj5', '$2y$13$Xqg8QPqJSxOtqOF.QbZ1AOLuXoRAKQ7UT.t0w4t10RfSzbc4tU3Im', NULL, 'gestor@detailing.leiria.pt', 10, 1734657301, 1734806132, 'oIDLKQ7XtMNQI4NJxsqz0Tyc86d1R3Sv_1734806132');

-- --------------------------------------------------------

--
-- Estrutura da tabela `venda`
--

DROP TABLE IF EXISTS `venda`;
CREATE TABLE IF NOT EXISTS `venda` (
  `idVenda` int NOT NULL AUTO_INCREMENT,
  `total` decimal(10,0) DEFAULT NULL,
  `datavenda` datetime DEFAULT NULL,
  `metodoPagamento_id` int NOT NULL,
  `metodoEntrega_id` int NOT NULL,
  `idCarrinhoFK` int NOT NULL,
  `idProfileFK` int NOT NULL,
  PRIMARY KEY (`idVenda`),
  KEY `fk_vendas_metodoPagamento1_idx` (`metodoPagamento_id`),
  KEY `fk_vendas_metodoEntrega1_idx` (`metodoEntrega_id`),
  KEY `idCarrinhoFK` (`idCarrinhoFK`),
  KEY `idProfileFK` (`idProfileFK`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb3;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limitadores para a tabela `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `carrinho`
--
ALTER TABLE `carrinho`
  ADD CONSTRAINT `carrinho_ibfk_1` FOREIGN KEY (`idMetodoEntrega`) REFERENCES `metodoentrega` (`idmetodoEntrega`),
  ADD CONSTRAINT `carrinho_ibfk_2` FOREIGN KEY (`idMetodoPagamento`) REFERENCES `metodopagamento` (`idMetodoPagamento`),
  ADD CONSTRAINT `carrinho_ibfk_3` FOREIGN KEY (`idProfile`) REFERENCES `profile` (`idprofile`);

--
-- Limitadores para a tabela `favorito`
--
ALTER TABLE `favorito`
  ADD CONSTRAINT `fk_favorito_produto1` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`idProduto`),
  ADD CONSTRAINT `fk_favorito_profile1` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`idprofile`);

--
-- Limitadores para a tabela `imagem`
--
ALTER TABLE `imagem`
  ADD CONSTRAINT `imagem_ibfk_1` FOREIGN KEY (`produtoId`) REFERENCES `produto` (`idProduto`);

--
-- Limitadores para a tabela `linhascarrinho`
--
ALTER TABLE `linhascarrinho`
  ADD CONSTRAINT `fk_linhasCarrinho_produtos1` FOREIGN KEY (`produtos_id`) REFERENCES `produto` (`idProduto`),
  ADD CONSTRAINT `linhascarrinho_ibfk_1` FOREIGN KEY (`carrinho_id`) REFERENCES `carrinho` (`idCarrinho`);

--
-- Limitadores para a tabela `linhasvenda`
--
ALTER TABLE `linhasvenda`
  ADD CONSTRAINT `fk_linhasvenda_produtos1` FOREIGN KEY (`idProdutoFK`) REFERENCES `produto` (`idProduto`),
  ADD CONSTRAINT `fk_linhasvenda_vendas1` FOREIGN KEY (`idVendaFK`) REFERENCES `venda` (`idVenda`),
  ADD CONSTRAINT `linhasvenda_ibfk_1` FOREIGN KEY (`idAvaliacaoFK`) REFERENCES `avaliacao` (`idavaliacao`);

--
-- Limitadores para a tabela `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `fk_produtos_Categorias` FOREIGN KEY (`idCategoria`) REFERENCES `categoria` (`idCategoria`),
  ADD CONSTRAINT `fk_produtos_furnecedores1` FOREIGN KEY (`fornecedores_idfornecedores`) REFERENCES `fornecedor` (`idfornecedor`),
  ADD CONSTRAINT `produto_ibfk_1` FOREIGN KEY (`idDesconto`) REFERENCES `desconto` (`iddesconto`);

--
-- Limitadores para a tabela `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `profile_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`);

--
-- Limitadores para a tabela `venda`
--
ALTER TABLE `venda`
  ADD CONSTRAINT `fk_vendas_metodoEntrega1` FOREIGN KEY (`metodoEntrega_id`) REFERENCES `metodoentrega` (`idmetodoEntrega`),
  ADD CONSTRAINT `fk_vendas_metodoPagamento1` FOREIGN KEY (`metodoPagamento_id`) REFERENCES `metodopagamento` (`idMetodoPagamento`),
  ADD CONSTRAINT `venda_ibfk_1` FOREIGN KEY (`idProfileFK`) REFERENCES `profile` (`idprofile`),
  ADD CONSTRAINT `venda_ibfk_2` FOREIGN KEY (`idCarrinhoFK`) REFERENCES `carrinho` (`idCarrinho`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
