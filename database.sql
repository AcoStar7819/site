CREATE DATABASE IF NOT EXISTS `site`;

CREATE TABLE IF NOT EXISTS `site`.`locales` (
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` CHAR(50) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
    PRIMARY KEY (`id`) USING BTREE
    )
    COLLATE='utf8_general_ci'
    ENGINE=InnoDB
;

CREATE TABLE IF NOT EXISTS `site`.`news` (
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`) USING BTREE
    )
    COLLATE='utf8_general_ci'
    ENGINE=InnoDB
;

CREATE TABLE IF NOT EXISTS `site`.`news_text` (
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `news_id` INT(10) UNSIGNED NOT NULL,
    `locale_id` INT(10) UNSIGNED NOT NULL DEFAULT '1',
    `title` TINYTEXT NOT NULL COLLATE 'utf8_general_ci',
    `text` TEXT NOT NULL COLLATE 'utf8_general_ci',
    PRIMARY KEY (`id`) USING BTREE,
    UNIQUE INDEX `news_id_locale_id` (`news_id`, `locale_id`) USING BTREE,
    INDEX `Locale id` (`locale_id`) USING BTREE,
    CONSTRAINT `Locale id` FOREIGN KEY (`locale_id`) REFERENCES `site`.`locales` (`id`) ON UPDATE NO ACTION ON DELETE CASCADE,
    CONSTRAINT `News id` FOREIGN KEY (`news_id`) REFERENCES `site`.`news` (`id`) ON UPDATE NO ACTION ON DELETE CASCADE
    )
    COLLATE='utf8_general_ci'
    ENGINE=InnoDB
;

CREATE TABLE IF NOT EXISTS `site`.`users` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`login` VARCHAR(32) NOT NULL DEFAULT '' COLLATE 'utf8_general_ci',
	`password` VARCHAR(60) NOT NULL DEFAULT '' COLLATE 'utf8_general_ci',
	PRIMARY KEY (`id`) USING BTREE,
	UNIQUE INDEX `login` (`login`) USING BTREE
)
COLLATE='utf8mb4_0900_ai_ci'
ENGINE=InnoDB
;