-- Schema reverse-engineered from the application's SQL queries.
-- Column names keep their original French/accented spelling to stay
-- compatible with the existing PHP code; only the file layout and the
-- credentials handling were reorganized, not the data model.
--
-- Import with: mysql -u root -p < database/schema.sql
-- (or via phpMyAdmin: create the database, then import this file)

CREATE DATABASE IF NOT EXISTS `test` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `test`;

CREATE TABLE IF NOT EXISTS `user` (
  `id_user` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `prénom_user` VARCHAR(100) NOT NULL,
  `nom_user` VARCHAR(100) NOT NULL,
  `username` VARCHAR(100) NOT NULL UNIQUE,
  `email` VARCHAR(190) NOT NULL,
  `numéro_téléphone` VARCHAR(30) NOT NULL,
  `mot_de_passe` VARCHAR(255) NOT NULL COMMENT 'password_hash() output, never plain text'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `objet` (
  `id_objet` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `id_utilisateur` INT UNSIGNED NOT NULL,
  `type_objet` VARCHAR(50) NOT NULL,
  `état_objet` VARCHAR(20) NOT NULL,
  `prénom` VARCHAR(100) NULL,
  `nom` VARCHAR(100) NULL,
  `date_de_naissance` DATE NULL,
  `numéro_unique` VARCHAR(100) NULL,
  `nationalité` VARCHAR(100) NULL,
  `université` VARCHAR(150) NULL,
  `lieu` VARCHAR(150) NULL,
  `marque` VARCHAR(100) NULL,
  `couleur` VARCHAR(100) NULL,
  `dates` DATE NULL,
  CONSTRAINT `fk_objet_user` FOREIGN KEY (`id_utilisateur`) REFERENCES `user`(`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
