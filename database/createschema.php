<?php

include("../dbConnection.php");

$sql ="CREATE  SCHEMA IF NOT EXISTS `portal` DEFAULT CHARACTER SET utf8 ";
$conn->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS `portal`.`admin` (
    `admin_id` INT NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(45) NOT NULL,
    `password` VARCHAR(45) NOT NULL,
    PRIMARY KEY (`admin_id`),
    UNIQUE INDEX `admin_id_UNIQUE` (`admin_id` ASC))
  ENGINE = InnoDB";
$conn->query($sql);


$sql = "CREATE TABLE IF NOT EXISTS `portal`.`user` (
    `name` VARCHAR(45) NOT NULL,
    `email` VARCHAR(45) NOT NULL,
    `password` VARCHAR(45) NOT NULL,
    `mobile` BIGINT(20) NOT NULL,
    `college` VARCHAR(100) NOT NULL,
    `user_id` INT NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (`user_id`),
    UNIQUE INDEX `user_id_UNIQUE` (`user_id` ASC))
  ENGINE = InnoDB";
$conn->query($sql);


$sql = "CREATE TABLE IF NOT EXISTS `portal`.`test` (
    `test_id` INT NOT NULL AUTO_INCREMENT,
    `test_name` VARCHAR(45) NOT NULL,
    `duration` INT NOT NULL,
    `ques_count` INT NULL,
    `marks` INT NULL,    
    `date_added` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`test_id`))
  ENGINE = InnoDB";
$conn->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS `portal`.`questions` (
    `que_id` INT NOT NULL AUTO_INCREMENT,
    `que` VARCHAR(100) NOT NULL,
    `opt1` VARCHAR(45) NOT NULL,
    `opt2` VARCHAR(45) NULL,
    `opt3` VARCHAR(45) NULL,
    `opt4` VARCHAR(45) NULL,
    `ans` INT NOT NULL,
    `type` VARCHAR(45) NULL,
    `test_id` INT NOT NULL,
    `mark` INT NULL DEFAULT 1,
    PRIMARY KEY (`que_id`, `test_id`),
    INDEX `fk_questions_test1_idx` (`test_id` ASC),
    CONSTRAINT `fk_questions_test1`
      FOREIGN KEY (`test_id`)
      REFERENCES `portal`.`test` (`test_id`)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION)
  ENGINE = InnoDB";
$conn->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS `portal`.`user_tests` (
    `sess_id` VARCHAR(30) NOT NULL,
    `user_id` INT NOT NULL,
    `test_id` INT NOT NULL,
    `score` INT NULL,
    `correct` INT NULL,
    `wrong` INT NULL,
    `time_rem` INT NOT NULL,
    `date` DATETIME NOT NULL,
    INDEX `fk_quiz_user1_idx` (`user_id` ASC),
    INDEX `fk_quiz_test1_idx` (`test_id` ASC),
    PRIMARY KEY (`sess_id`),
    UNIQUE INDEX `sess_id_UNIQUE` (`sess_id` ASC),
    CONSTRAINT `fk_quiz_user1`
      FOREIGN KEY (`user_id`)
      REFERENCES `portal`.`user` (`user_id`)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
    CONSTRAINT `fk_quiz_test1`
      FOREIGN KEY (`test_id`)
      REFERENCES `portal`.`test` (`test_id`)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION)
  ENGINE = InnoDB";
$conn->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS `portal`.`user_answers` (
    `sess_id` VARCHAR(30) NOT NULL,
    `ans_entered` VARCHAR(45) NULL,
    `que_id` INT NOT NULL,
    `test_id` INT NOT NULL,
    INDEX `fk_user_answers_user_tests1_idx` (`sess_id` ASC),
    INDEX `fk_user_answers_questions1_idx` (`que_id` ASC, `test_id` ASC),
    CONSTRAINT `fk_user_answers_user_tests1`
      FOREIGN KEY (`sess_id`)
      REFERENCES `portal`.`user_tests` (`sess_id`)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
    CONSTRAINT `fk_user_answers_questions1`
      FOREIGN KEY (`que_id` , `test_id`)
      REFERENCES `portal`.`questions` (`que_id` , `test_id`)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION)
  ENGINE = InnoDB";
$conn->query($sql);

?>