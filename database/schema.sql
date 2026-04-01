-- Sistema CRM de Molas Helicoidais Automotivas
-- Banco de dados MySQL completo com todas as tabelas e relacionamentos

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- --------------------------------------------------------
-- Database: molas_crm
-- --------------------------------------------------------
CREATE DATABASE IF NOT EXISTS `molas_crm` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `molas_crm`;

-- --------------------------------------------------------
-- Table `usuarios`
-- --------------------------------------------------------
CREATE TABLE `usuarios` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome_usuario` VARCHAR(50) NOT NULL UNIQUE,
  `senha_hash` VARCHAR(255) NOT NULL,
  `nome_exibicao` VARCHAR(100) NOT NULL,
  `perfil` ENUM('administrador', 'usuario') NOT NULL DEFAULT 'usuario',
  `tema_preferido` ENUM('claro', 'escuro') NOT NULL DEFAULT 'claro',
  `criado_em` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table `clientes`
-- --------------------------------------------------------
CREATE TABLE `clientes` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo_cliente` VARCHAR(20) NOT NULL UNIQUE,
  `nome` VARCHAR(150) NOT NULL,
  `aniversario_dia` TINYINT UNSIGNED NOT NULL,
  `aniversario_mes` TINYINT UNSIGNED NOT NULL,
  `cpf_cnpj` VARCHAR(20) NOT NULL UNIQUE,
  `cep` VARCHAR(10) NOT NULL,
  `endereco` VARCHAR(200) NOT NULL,
  `numero` VARCHAR(20) NOT NULL,
  `bairro` VARCHAR(100) NOT NULL,
  `cidade` VARCHAR(100) NOT NULL,
  `estado_uf` CHAR(2) NOT NULL,
  `telefone` VARCHAR(20) NOT NULL,
  `telefone2` VARCHAR(20) DEFAULT NULL,
  `email` VARCHAR(150) NOT NULL,
  `observacoes` TEXT DEFAULT NULL,
  `criado_em` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_nome` (`nome`),
  INDEX `idx_cidade` (`cidade`),
  INDEX `idx_aniversario` (`aniversario_mes`, `aniversario_dia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table `links_cadastro`
-- --------------------------------------------------------
CREATE TABLE `links_cadastro` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `token` VARCHAR(64) NOT NULL UNIQUE,
  `cliente_id` INT UNSIGNED DEFAULT NULL,
  `criado_em` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expira_em` DATETIME NOT NULL,
  `status` ENUM('ativo', 'usado', 'expirado') NOT NULL DEFAULT 'ativo',
  PRIMARY KEY (`id`),
  FOREIGN KEY (`cliente_id`) REFERENCES `clientes`(`id`) ON DELETE SET NULL,
  INDEX `idx_token` (`token`),
  INDEX `idx_status` (`status`),
  INDEX `idx_expira_em` (`expira_em`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table `veiculos`
-- --------------------------------------------------------
CREATE TABLE `veiculos` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `marca` VARCHAR(100) NOT NULL,
  `modelo` VARCHAR(100) NOT NULL,
  `ano` VARCHAR(10) NOT NULL,
  `observacoes` TEXT DEFAULT NULL,
  `criado_em` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_marca_modelo` (`marca`, `modelo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table `molas_originais`
-- --------------------------------------------------------
CREATE TABLE `molas_originais` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `veiculo_id` INT UNSIGNED NOT NULL,
  `posicao` ENUM('dianteira', 'traseira') NOT NULL,
  `quantidade` INT NOT NULL DEFAULT 2,
  `fio_mm` DECIMAL(6,2) NOT NULL,
  `altura_livre_mm` DECIMAL(7,2) NOT NULL,
  `diametro_interno_mm` DECIMAL(6,2) NOT NULL,
  `vao_entre_espiras_mm` DECIMAL(6,2) NOT NULL,
  `retifica` BOOLEAN NOT NULL DEFAULT FALSE,
  `olhal_cima_mm` DECIMAL(6,2) DEFAULT NULL,
  `olhal_baixo_mm` DECIMAL(6,2) DEFAULT NULL,
  `tipo_ponta` ENUM('aberta', 'fechada') NOT NULL,
  `medida_ponta_mm` DECIMAL(6,2) DEFAULT NULL,
  `entre_elo_mm` DECIMAL(6,2) DEFAULT NULL,
  `espiras_ativas` DECIMAL(5,2) DEFAULT NULL,
  `espiras_totais` DECIMAL(5,2) NOT NULL,
  `criado_em` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`veiculo_id`) REFERENCES `veiculos`(`id`) ON DELETE CASCADE,
  UNIQUE KEY `uk_veiculo_posicao` (`veiculo_id`, `posicao`),
  INDEX `idx_veiculo_id` (`veiculo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table `projetos`
-- --------------------------------------------------------
CREATE TABLE `projetos` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo_pedido` VARCHAR(20) NOT NULL UNIQUE,
  `cliente_id` INT UNSIGNED NOT NULL,
  `veiculo_id` INT UNSIGNED NOT NULL,
  `nome_projeto` VARCHAR(200) NOT NULL,
  `status_logistica` ENUM('fabricacao', 'pintura', 'transportadora', 'entregue') NOT NULL DEFAULT 'fabricacao',
  `status_pagamento` ENUM('pago', 'pendente', 'garantia') NOT NULL DEFAULT 'pendente',
  `status_frete` ENUM('pago', 'pendente', 'nao_optante', 'garantia') NOT NULL DEFAULT 'pendente',
  `valor_venda` DECIMAL(10,2) DEFAULT NULL,
  `desconto_aniversario_perc` DECIMAL(5,2) DEFAULT NULL,
  `valor_final` DECIMAL(10,2) DEFAULT NULL,
  `valor_entrada` DECIMAL(10,2) DEFAULT NULL,
  `saldo_restante` DECIMAL(10,2) DEFAULT NULL,
  `valor_frete` DECIMAL(10,2) DEFAULT NULL,
  `observacoes` TEXT DEFAULT NULL,
  `observacoes_garantia` TEXT DEFAULT NULL,
  `criado_em` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `concluido_em` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`cliente_id`) REFERENCES `clientes`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`veiculo_id`) REFERENCES `veiculos`(`id`) ON DELETE CASCADE,
  INDEX `idx_codigo_pedido` (`codigo_pedido`),
  INDEX `idx_cliente_id` (`cliente_id`),
  INDEX `idx_status_logistica` (`status_logistica`),
  INDEX `idx_status_pagamento` (`status_pagamento`),
  INDEX `idx_criado_em` (`criado_em`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table `molas_modificadas`
-- --------------------------------------------------------
CREATE TABLE `molas_modificadas` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `projeto_id` INT UNSIGNED NOT NULL,
  `mola_original_ref_id` INT UNSIGNED DEFAULT NULL,
  `posicao` ENUM('dianteira', 'traseira') NOT NULL,
  `quantidade` INT NOT NULL DEFAULT 2,
  `fio_mm` DECIMAL(6,2) NOT NULL,
  `altura_livre_mm` DECIMAL(7,2) NOT NULL,
  `diametro_interno_mm` DECIMAL(6,2) NOT NULL,
  `vao_entre_espiras_mm` DECIMAL(6,2) NOT NULL,
  `retifica` BOOLEAN NOT NULL DEFAULT FALSE,
  `olhal_cima_mm` DECIMAL(6,2) DEFAULT NULL,
  `olhal_baixo_mm` DECIMAL(6,2) DEFAULT NULL,
  `tipo_ponta` ENUM('aberta', 'fechada') NOT NULL,
  `medida_ponta_mm` DECIMAL(6,2) DEFAULT NULL,
  `entre_elo_mm` DECIMAL(6,2) DEFAULT NULL,
  `espiras_ativas` DECIMAL(5,2) DEFAULT NULL,
  `espiras_totais` DECIMAL(5,2) NOT NULL,
  `lift_mm` DECIMAL(7,2) DEFAULT NULL,
  `ganho_carga_kg` DECIMAL(7,2) DEFAULT NULL,
  `observacoes_tecnicas` TEXT DEFAULT NULL,
  `criado_em` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`projeto_id`) REFERENCES `projetos`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`mola_original_ref_id`) REFERENCES `molas_originais`(`id`) ON DELETE SET NULL,
  UNIQUE KEY `uk_projeto_posicao` (`projeto_id`, `posicao`),
  INDEX `idx_projeto_id` (`projeto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- INSERTS INICIAIS
-- --------------------------------------------------------

-- Usuário administrador padrão
INSERT INTO `usuarios` (`nome_usuario`, `senha_hash`, `nome_exibicao`, `perfil`, `tema_preferido`) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrador', 'administrador', 'claro');

-- Clientes de exemplo
INSERT INTO `clientes` (`codigo_cliente`, `nome`, `aniversario_dia`, `aniversario_mes`, `cpf_cnpj`, `cep`, `endereco`, `numero`, `bairro`, `cidade`, `estado_uf`, `telefone`, `email`, `observacoes`) VALUES
('AWK-0001', 'João Silva Santos', 15, 3, '12345678901', '01001000', 'Praça da Sé', '100', 'Sé', 'São Paulo', 'SP', '11999999999', 'joao@email.com', 'Cliente preferencial'),
('AWK-0002', 'Maria Oliveira Costa', 22, 7, '98765432100', '20040002', 'Rua Primeiro de Março', '25', 'Centro', 'Rio de Janeiro', 'RJ', '21988888888', 'maria@email.com', NULL),
('AWK-0003', 'Carlos Alberto Pereira', 5, 12, '11222333444455', '30130005', 'Avenida Afonso Pena', '1500', 'Centro', 'Belo Horizonte', 'MG', '31977777777', 'carlos@empresa.com.br', 'Cliente PJ');

-- Veículos de exemplo
INSERT INTO `veiculos` (`marca`, `modelo`, `ano`, `observacoes`) VALUES
('Toyota', 'Hilux', '2022', 'Versão SRX 4x4 Diesel'),
('Volkswagen', 'Amarok', '2021', 'Highline 3.0 V6'),
('Ford', 'Ranger', '2023', 'Wildtrak 2.0 Bi-Turbo');

-- Molas originais para os veículos
INSERT INTO `molas_originais` (`veiculo_id`, `posicao`, `quantidade`, `fio_mm`, `altura_livre_mm`, `diametro_interno_mm`, `vao_entre_espiras_mm`, `retifica`, `olhal_cima_mm`, `olhal_baixo_mm`, `tipo_ponta`, `medida_ponta_mm`, `entre_elo_mm`, `espiras_ativas`, `espiras_totais`) VALUES
(1, 'dianteira', 2, 14.50, 450.00, 120.00, 25.00, 0, 80.00, 80.00, 'fechada', NULL, 5.00, 6.50, 8.00),
(1, 'traseira', 2, 16.00, 380.00, 140.00, 30.00, 1, NULL, NULL, 'aberta', 15.00, 6.00, 5.50, 7.00),
(2, 'dianteira', 2, 13.80, 420.00, 115.00, 22.00, 0, 75.00, 75.00, 'fechada', NULL, 4.50, 7.00, 8.50),
(2, 'traseira', 2, 15.50, 360.00, 135.00, 28.00, 0, 85.00, 85.00, 'fechada', NULL, 5.50, 6.00, 7.50);

-- Projetos de exemplo
INSERT INTO `projetos` (`codigo_pedido`, `cliente_id`, `veiculo_id`, `nome_projeto`, `status_logistica`, `status_pagamento`, `status_frete`, `valor_venda`, `valor_final`, `valor_entrada`, `saldo_restante`, `valor_frete`, `observacoes`) VALUES
('OP-0001', 1, 1, 'Lift 2" Hilux 2022 do João', 'entregue', 'pago', 'pago', 2500.00, 2500.00, 1000.00, 1500.00, 150.00, 'Projeto concluído com sucesso'),
('OP-0002', 2, 2, 'Suspensão esportiva Amarok', 'pintura', 'pendente', 'pendente', 2800.00, 2800.00, 800.00, 2000.00, 180.00, 'Aguardando pintura');

-- Molas modificadas para os projetos
INSERT INTO `molas_modificadas` (`projeto_id`, `mola_original_ref_id`, `posicao`, `quantidade`, `fio_mm`, `altura_livre_mm`, `diametro_interno_mm`, `vao_entre_espiras_mm`, `retifica`, `olhal_cima_mm`, `olhal_baixo_mm`, `tipo_ponta`, `medida_ponta_mm`, `entre_elo_mm`, `espiras_ativas`, `espiras_totais`, `lift_mm`, `ganho_carga_kg`, `observacoes_tecnicas`) VALUES
(1, 1, 'dianteira', 2, 15.00, 480.00, 120.00, 28.00, 0, 85.00, 85.00, 'fechada', NULL, 5.00, 6.00, 7.50, 30.00, 150.00, 'Aumento de rigidez para off-road'),
(1, 2, 'traseira', 2, 17.00, 410.00, 140.00, 32.00, 1, NULL, NULL, 'aberta', 16.00, 6.00, 5.00, 6.50, 30.00, 200.00, 'Retífica para melhor acabamento'),
(2, 3, 'dianteira', 2, 14.50, 440.00, 115.00, 25.00, 0, 80.00, 80.00, 'fechada', NULL, 4.50, 6.50, 8.00, 20.00, 120.00, 'Configuração esportiva');

-- Links de cadastro de exemplo
INSERT INTO `links_cadastro` (`token`, `cliente_id`, `expira_em`, `status`) VALUES
('abc123def456ghi789jkl012mno345pqr678stu901', 1, DATE_ADD(NOW(), INTERVAL 24 HOUR), 'ativo'),
('xyz789uvw456rst123opq890lmn567ijk234def901', NULL, DATE_ADD(NOW(), INTERVAL 24 HOUR), 'ativo');

SET FOREIGN_KEY_CHECKS = 1;

-- --------------------------------------------------------
-- VIEWS ÚTEIS
-- --------------------------------------------------------

CREATE OR REPLACE VIEW vw_aniversariantes_mes AS
SELECT 
    c.id,
    c.codigo_cliente,
    c.nome,
    c.aniversario_dia,
    c.aniversario_mes,
    c.telefone,
    c.email,
    c.cidade,
    c.estado_uf
FROM clientes c
WHERE c.aniversario_mes = MONTH(CURDATE())
ORDER BY c.aniversario_dia;

CREATE OR REPLACE VIEW vw_projetos_resumo AS
SELECT 
    p.id,
    p.codigo_pedido,
    p.cliente_id,
    c.codigo_cliente,
    c.nome as cliente_nome,
    p.veiculo_id,
    v.marca,
    v.modelo,
    v.ano,
    p.nome_projeto,
    p.status_logistica,
    p.status_pagamento,
    p.status_frete,
    p.valor_final,
    p.criado_em,
    p.atualizado_em,
    p.concluido_em
FROM projetos p
JOIN clientes c ON p.cliente_id = c.id
JOIN veiculos v ON p.veiculo_id = v.id;

-- --------------------------------------------------------
-- PROCEDURES ÚTEIS
-- --------------------------------------------------------

DELIMITER //

CREATE PROCEDURE sp_gerar_codigo_cliente(OUT novo_codigo VARCHAR(20))
BEGIN
    DECLARE ultimo_numero INT;
    
    SELECT COALESCE(MAX(CAST(SUBSTRING(codigo_cliente, 5) AS UNSIGNED)), 0) + 1
    INTO ultimo_numero
    FROM clientes;
    
    SET novo_codigo = CONCAT('AWK-', LPAD(ultimo_numero, 4, '0'));
END //

CREATE PROCEDURE sp_gerar_codigo_pedido(OUT novo_codigo VARCHAR(20))
BEGIN
    DECLARE ultimo_numero INT;
    
    SELECT COALESCE(MAX(CAST(SUBSTRING(codigo_pedido, 4) AS UNSIGNED)), 0) + 1
    INTO ultimo_numero
    FROM projetos;
    
    SET novo_codigo = CONCAT('OP-', LPAD(ultimo_numero, 4, '0'));
END //

DELIMITER ;

-- --------------------------------------------------------
-- TRIGGERS
-- --------------------------------------------------------

DELIMITER //

-- Trigger para atualizar data de conclusão quando status muda para "entregue"
CREATE TRIGGER trg_projeto_entregue
BEFORE UPDATE ON projetos
FOR EACH ROW
BEGIN
    IF NEW.status_logistica = 'entregue' AND OLD.status_logistica != 'entregue' THEN
        SET NEW.concluido_em = NOW();
    END IF;
END //

DELIMITER ;

COMMIT;