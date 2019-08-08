-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema buysell
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema buysell
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `buysell` DEFAULT CHARACTER SET utf8 ;
USE `buysell` ;

-- -----------------------------------------------------
-- Table `buysell`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `buysell`.`users` (
  `UserID` INT(11) NOT NULL AUTO_INCREMENT,
  `FirstName` VARCHAR(45) NOT NULL,
  `LastName` VARCHAR(45) NOT NULL,
  `Email` VARCHAR(45) NOT NULL,
  `Password` VARCHAR(45) NOT NULL,
  `Admin` TINYINT(1) NULL DEFAULT '0',
  `Status` TINYINT(1) NULL DEFAULT '1',
  PRIMARY KEY (`UserID`),
  UNIQUE INDEX `Email_UNIQUE` (`Email` ASC),
  UNIQUE INDEX `UserID_UNIQUE` (`UserID` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 14
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `buysell`.`market`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `buysell`.`market` (
  `ListingID` INT(11) NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(45) NOT NULL,
  `Price` DOUBLE NOT NULL,
  `AvailableStatus` TINYINT(4) NULL DEFAULT '0',
  `Image` VARCHAR(45) NOT NULL,
  `User_UserID` INT(11) NOT NULL,
  PRIMARY KEY (`ListingID`, `User_UserID`),
  INDEX `fk_Market_User_idx` (`User_UserID` ASC),
  CONSTRAINT `fk_Market_User`
    FOREIGN KEY (`User_UserID`)
    REFERENCES `buysell`.`users` (`UserID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
