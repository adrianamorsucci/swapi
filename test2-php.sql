-- MySQL Script generated by MySQL Workbench
-- 06/02/22 09:13:14
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema test
-- -----------------------------------------------------
-- -----------------------------------------------------
USE `test` ;


-- -----------------------------------------------------
-- Table `test`.`starship_inventory`
-- -----------------------------------------------------
CREATE TABLE  `test`.`starship_inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `starship_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- -----------------------------------------------------
-- Table `test`.`vehicle_inventory`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `test`.`vehicle_inventory`;
CREATE TABLE  `test`.`vehicle_inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vehicle_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
