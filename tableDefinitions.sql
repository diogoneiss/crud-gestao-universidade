CREATE DATABASE IF NOT EXISTS crud_project;

USE `crud_project`;
-- -----------------------------------------------------
-- Table `crud_project`.`Emails`
-- We need this table to store email addresses for students and instructors, 
-- so that we can enforce the UNIQUE constraint on the EmailAddress column.
-- -----------------------------------------------------


CREATE TABLE IF NOT EXISTS `crud_project`.`Emails` (
  `EmailID` INT NOT NULL AUTO_INCREMENT,
  `EmailAddress` VARCHAR(45) NOT NULL UNIQUE,
  PRIMARY KEY (`EmailID`))
AUTO_INCREMENT = 1;


-- -----------------------------------------------------
-- Table `crud_project`.`Student`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `crud_project`.`Student` (
  `StudentID` INT NOT NULL AUTO_INCREMENT,
  `EmailID` INT NOT NULL,
  `Cpf` CHAR(11) NOT NULL,
  `Major` VARCHAR(45) NOT NULL,
  `Year` YEAR NOT NULL,
  `FirstName` VARCHAR(45) NOT NULL,
  `LastName` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`StudentID`),
  FOREIGN KEY (`EmailID`)
    REFERENCES `crud_project`.`Emails` (`EmailID`))
AUTO_INCREMENT = 1;



-- -----------------------------------------------------
-- Table `crud_project`.`Department`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crud_project`.`Department` (
  `DepartmentID` INT NOT NULL AUTO_INCREMENT,
  `DepartmentName` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`DepartmentID`))
  AUTO_INCREMENT = 1;


-- -----------------------------------------------------
-- Table `crud_project`.`Course`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crud_project`.`Course` (
  `CourseID` INT NOT NULL AUTO_INCREMENT,
  `CourseName` VARCHAR(45) NOT NULL,
  `DepartmentID` INT NOT NULL,
  PRIMARY KEY (`CourseID`),
  FOREIGN KEY (`DepartmentID`)
    REFERENCES `crud_project`.`Department` (`DepartmentID`)
    ON UPDATE CASCADE
    ON DELETE CASCADE)
  AUTO_INCREMENT = 1;

-- -----------------------------------------------------
-- Table `crud_project`.`Instructor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crud_project`.`Instructor` (
  `InstructorID` INT NOT NULL AUTO_INCREMENT,
  `EmailID` INT NOT NULL,
  `DepartmentID` INT NOT NULL,
  `FirstName` VARCHAR(45) NOT NULL,
  `LastName` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`InstructorID`),
  FOREIGN KEY (`DepartmentID`)
    REFERENCES `crud_project`.`Department` (`DepartmentID`)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  FOREIGN KEY (`EmailID`)
    REFERENCES `crud_project`.`Emails` (`EmailID`)
)
AUTO_INCREMENT = 1;

-- -----------------------------------------------------
-- Table `crud_project`.`Building`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `crud_project`.`Building` (
  `BuildingID` INT NOT NULL AUTO_INCREMENT,
  `BuildingName` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`BuildingID`))
  AUTO_INCREMENT = 1;

  CREATE TABLE IF NOT EXISTS `crud_project`.`Classroom` (
  `ClassroomID` INT NOT NULL AUTO_INCREMENT,
  `BuildingID` INT NOT NULL,
  `RoomNum` INT NOT NULL,
  `Capacity` INT NOT NULL,
  PRIMARY KEY (`ClassroomID`),
  FOREIGN KEY (`BuildingID`)
    REFERENCES `crud_project`.`Building` (`BuildingID`)
    ON UPDATE CASCADE
    ON DELETE RESTRICT)
  AUTO_INCREMENT = 1;


-- -----------------------------------------------------
-- Table `crud_project`.`CourseOfferings`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crud_project`.`CourseOfferings` (
  `OfferingID` INT NOT NULL AUTO_INCREMENT,
  `CourseID` INT NOT NULL,
  `InstructorID` INT NOT NULL,
  `ClassroomID` INT NOT NULL,
  `Semester` ENUM('1', '2') NOT NULL,
  `Year` YEAR NOT NULL,
  PRIMARY KEY (`OfferingID`),
  FOREIGN KEY (`CourseID`)
    REFERENCES `crud_project`.`Course` (`CourseID`)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  FOREIGN KEY (`InstructorID`)
    REFERENCES `crud_project`.`Instructor` (`InstructorID`)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  FOREIGN KEY (`ClassroomID`)
    REFERENCES `crud_project`.`Classroom` (`ClassroomID`)
    ON UPDATE CASCADE
    ON DELETE CASCADE
  )
AUTO_INCREMENT = 1;
    

-- -----------------------------------------------------
-- Table `crud_project`.`Grade`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crud_project`.`Grade` (
  `GradeID` INT NOT NULL AUTO_INCREMENT,
  `GradeValue` DECIMAL(5,2) NOT NULL,
  `StudentID` INT NOT NULL,
  `OfferingID` INT NOT NULL,
  PRIMARY KEY (`GradeID`),
  FOREIGN KEY (`StudentID`)
    REFERENCES `crud_project`.`Student` (`StudentID`)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  FOREIGN KEY (`OfferingID`)
    REFERENCES `crud_project`.`CourseOfferings` (`OfferingID`)
    ON UPDATE CASCADE
    ON DELETE CASCADE)
    AUTO_INCREMENT = 1;

-- -----------------------------------------------------
-- Domain trigger for `crud_project`.`Grade`
-- -----------------------------------------------------


DELIMITER //
CREATE TRIGGER GradeValueCheckBeforeInsert BEFORE INSERT ON `crud_project`.`Grade`
FOR EACH ROW
BEGIN
  IF NEW.GradeValue < 0 OR NEW.GradeValue > 100 THEN 
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'GradeValue must be between 0 and 100';
  END IF;
END;//
DELIMITER ;

DELIMITER //
CREATE TRIGGER GradeValueCheckBeforeUpdate BEFORE UPDATE ON `crud_project`.`Grade`
FOR EACH ROW
BEGIN
  IF NEW.GradeValue < 0 OR NEW.GradeValue > 100 THEN 
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'GradeValue must be between 0 and 100';
  END IF;
END;//
DELIMITER ;



-- -----------------------------------------------------
-- Table `crud_project`.`AcademicCredits`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crud_project`.`AcademicCredits` (
  `CreditID` INT NOT NULL AUTO_INCREMENT,
  `OfferingID` INT NOT NULL,
  `Credits` INT NOT NULL,
  PRIMARY KEY (`CreditID`),
  FOREIGN KEY (`OfferingID`)
    REFERENCES `crud_project`.`CourseOfferings` (`OfferingID`)
    ON UPDATE CASCADE
    ON DELETE CASCADE)
    AUTO_INCREMENT = 1;
   
-- -----------------------------------------------------
-- Table `crud_project`.`Enrollments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crud_project`.`Enrollments` (
  `EnrollmentID` INT NOT NULL AUTO_INCREMENT,
  `StudentID` INT NOT NULL,
  `OfferingID` INT NOT NULL,
  PRIMARY KEY (`EnrollmentID`),
  FOREIGN KEY (`StudentID`)
    REFERENCES `crud_project`.`Student` (`StudentID`)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  FOREIGN KEY (`OfferingID`)
    REFERENCES `crud_project`.`CourseOfferings` (`OfferingID`)
    ON UPDATE CASCADE
    ON DELETE CASCADE)
    AUTO_INCREMENT = 1;