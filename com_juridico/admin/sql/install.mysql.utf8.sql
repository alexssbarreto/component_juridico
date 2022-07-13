DROP TABLE IF EXISTS `#__processo`;

CREATE TABLE `#__processo` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`cpf` VARCHAR(11) NOT NULL,
	`nome_acao` VARCHAR(255) NOT NULL,
	`numero_acao` VARCHAR(255) NOT NULL,
	`valor_executado` DECIMAL(20,2) NOT NULL DEFAULT 0,
	`valor_honorario` DECIMAL(20,2) NOT NULL DEFAULT 0,
	`valor_beneficiario` DECIMAL(20,2) NOT NULL DEFAULT 0,
	`publicado_em` DATETIME NOT NULL DEFAULT 0,
	`ativo` INT NOT NULL DEFAULT 0,
	PRIMARY KEY (`id`)
)
    AUTO_INCREMENT =0;
