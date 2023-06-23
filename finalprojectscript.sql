CREATE DATABASE IF NOT EXISTS crud_project;

-- -----------------------------------------------------
-- Table `crud_project`.`Student`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `crud_project`.`Student` (
  `StudentID` INT NOT NULL AUTO_INCREMENT,
  `Email` VARCHAR(45) NOT NULL,
  `Major` VARCHAR(45) NOT NULL,
  `Year` YEAR NOT NULL,
  `FirstName` VARCHAR(45) NOT NULL,
  `LastName` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`StudentID`))
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
  `DepartmentID` INT NOT NULL,
  `Email` VARCHAR(45) NOT NULL,
  `FirstName` VARCHAR(45) NOT NULL,
  `LastName` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`InstructorID`),
  FOREIGN KEY (`DepartmentID`)
    REFERENCES `crud_project`.`Department` (`DepartmentID`)
    ON UPDATE CASCADE
    ON DELETE CASCADE)
  AUTO_INCREMENT = 1;



-- -----------------------------------------------------
-- Table `crud_project`.`Classroom`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crud_project`.`Classroom` (
  `ClassroomID` INT NOT NULL AUTO_INCREMENT,
  `Building` VARCHAR(45) NOT NULL,
  `RoomNum` INT NOT NULL,
  `Capacity` INT NOT NULL,
  PRIMARY KEY (`ClassroomID`))
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
  `GradeValue` VARCHAR(5) NOT NULL,
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






CREATE VIEW CourseOfferingsView AS
SELECT co.OfferingID as ID, co.Semester, co.Year, c.CourseName as CourseName, CONCAT(i.FirstName, ' ', i.LastName) as InstructorName, cl.RoomNum as ClassroomName
FROM CourseOfferings AS co
JOIN Course AS c ON co.CourseID = c.CourseID
JOIN Instructor AS i ON co.InstructorID = i.InstructorID
JOIN Classroom AS cl ON co.ClassroomID = cl.ClassroomID;
