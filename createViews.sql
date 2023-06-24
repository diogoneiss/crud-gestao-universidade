DROP VIEW IF EXISTS `crud_project`.`CourseOfferingsView`;

CREATE VIEW `crud_project`.`CourseOfferingsView` AS
SELECT co.OfferingID as OfferingID, co.Semester, co.Year, c.CourseName as CourseName, CONCAT(i.FirstName, ' ', i.LastName) as InstructorName, cl.RoomNum as ClassroomName, d.DepartmentName as DepartmentName, b.BuildingName as BuildingName
FROM `crud_project`.`CourseOfferings` AS co
JOIN `crud_project`.`Course` AS c ON co.CourseID = c.CourseID
JOIN `crud_project`.`Instructor` AS i ON co.InstructorID = i.InstructorID
JOIN `crud_project`.`Classroom` AS cl ON co.ClassroomID = cl.ClassroomID
JOIN `crud_project`.`Department` AS d ON c.DepartmentID = d.DepartmentID
JOIN `crud_project`.`Building` AS b ON cl.BuildingID = b.BuildingID;

DROP VIEW IF EXISTS `crud_project`.`StudentView`;

CREATE VIEW `crud_project`.`StudentView` AS
SELECT s.StudentID, s.Cpf, e.EmailAddress, s.Major, s.Year, CONCAT(s.FirstName, ' ', s.LastName) AS StudentName
FROM `crud_project`.`Student` AS s
JOIN `crud_project`.`Emails` AS e ON s.EmailID = e.EmailID;


DROP VIEW IF EXISTS `crud_project`.`CourseView`;

CREATE VIEW `crud_project`.`CourseView` AS
SELECT c.CourseID as CourseID, c.CourseName as CourseName, d.DepartmentName
FROM `crud_project`.`Course` AS c
JOIN `crud_project`.`Department` AS d ON c.DepartmentID = d.DepartmentID;


DROP VIEW IF EXISTS `crud_project`.`InstructorView`;

CREATE VIEW `crud_project`.`InstructorView` AS
SELECT i.InstructorID as InstructorID, CONCAT(i.FirstName, ' ', i.LastName) as InstructorName, e.EmailAddress, d.DepartmentName
FROM `crud_project`.`Instructor` AS i
JOIN `crud_project`.`Department` AS d ON i.DepartmentID = d.DepartmentID
JOIN `crud_project`.`Emails` AS e ON i.EmailID = e.EmailID;


DROP VIEW IF EXISTS `crud_project`.`ClassroomView`;

CREATE VIEW `crud_project`.`ClassroomView` AS
SELECT cl.ClassroomID as ClassroomID, b.BuildingName, cl.RoomNum, cl.Capacity
FROM `crud_project`.`Classroom` AS cl
JOIN `crud_project`.`Building` AS b ON cl.BuildingID = b.BuildingID;

DROP VIEW IF EXISTS `crud_project`.`GradeView`;

CREATE VIEW `crud_project`.`GradeView` AS
SELECT g.GradeID, g.GradeValue, s.StudentID, CONCAT(s.FirstName, ' ', s.LastName) AS StudentName, 
co.OfferingID, co.CourseName, co.InstructorName, co.DepartmentName
FROM `crud_project`.`Grade` AS g
JOIN `crud_project`.`Student` AS s ON g.StudentID = s.StudentID
JOIN `crud_project`.`CourseOfferingsView` AS co ON g.OfferingID = co.OfferingID;

DROP VIEW IF EXISTS `crud_project`.`AcademicCreditsView`;

CREATE VIEW `crud_project`.`AcademicCreditsView` AS
SELECT ac.CreditID, ac.Credits, co.OfferingID, co.CourseName, co.InstructorName, co.DepartmentName
FROM `crud_project`.`AcademicCredits` AS ac
JOIN `crud_project`.`CourseOfferingsView` AS co ON ac.OfferingID = co.OfferingID;

DROP VIEW IF EXISTS `crud_project`.`EnrollmentsView`;

CREATE VIEW `crud_project`.`EnrollmentsView` AS
SELECT e.EnrollmentID, CONCAT(s.FirstName, ' ', s.LastName) AS StudentName, s.StudentID, co.OfferingID, co.CourseName, co.InstructorName, co.DepartmentName, co.Semester, co.Year
FROM `crud_project`.`Enrollments` AS e
JOIN `crud_project`.`Student` AS s ON e.StudentID = s.StudentID
JOIN `crud_project`.`CourseOfferingsView` AS co ON e.OfferingID = co.OfferingID;

