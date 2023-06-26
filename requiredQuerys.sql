--1: Consulta de seleção e projeção:
SELECT s.FirstName, s.LastName
FROM `crud_project`.`Student` AS s;
--1.2
SELECT
  s.FirstName, s.LastName
FROM `crud_project`.`Student` AS s
WHERE EXISTS (SELECT 1 FROM `crud_project`.`Student`);

--2: Consulta de seleção e projeção:
SELECT c.CourseName, c.DepartmentID
FROM `crud_project`.`Course` AS c;
--2.2
SELECT c.CourseName, c.DepartmentID
FROM `crud_project`.`Course` AS c, `crud_project`.`Department` AS d
WHERE c.DepartmentID = d.DepartmentID;

--3: Junção de duas relações:
SELECT s.FirstName, s.LastName, g.GradeValue
FROM `crud_project`.`Student` AS s
JOIN `crud_project`.`Grade` AS g ON s.StudentID = g.StudentID;
--3.2
SELECT s.FirstName, s.LastName, g.GradeValue
FROM `crud_project`.`Student` AS s
JOIN (SELECT StudentID, GradeValue FROM `crud_project`.`Grade`) AS g ON s.StudentID = g.StudentID;

--4: Junção de duas relações:
SELECT c.CourseName, d.DepartmentName
FROM `crud_project`.`Course` AS c
JOIN `crud_project`.`Department` AS d ON c.DepartmentID = d.DepartmentID;
--4.2:
SELECT c.CourseName, 
       (SELECT d.DepartmentName FROM `crud_project`.`Department` AS d WHERE c.DepartmentID = d.DepartmentID) AS DepartmentName
FROM `crud_project`.`Course` AS c;



--5: Junção de duas relações:
SELECT  c.RoomNum, b.BuildingName, c.Capacity as 'Room Capacity'
FROM `crud_project`.`Classroom` AS c
JOIN `crud_project`.`Building` AS b ON b.BuildingID = c.BuildingID;
--5.2:
SELECT c.RoomNum, 
       (SELECT b.BuildingName FROM `crud_project`.`Building` AS b WHERE b.BuildingID = c.BuildingID) AS 'BuildingName', 
       c.Capacity AS 'Room Capacity'
FROM `crud_project`.`Classroom` AS c;


--6: Junção de três relações:
SELECT s.FirstName, s.LastName, c.CourseName, g.GradeValue
FROM `crud_project`.`Student` AS s
JOIN `crud_project`.`Course` AS c ON s.StudentID = c.StudentID
JOIN `crud_project`.`Grade` AS g ON c.CourseID = g.CourseID;
--6.2:
SELECT s.FirstName, s.LastName, c.CourseName, g.GradeValue
FROM `crud_project`.`Student` AS s
JOIN `crud_project`.`Enrollments` AS e ON s.StudentID = e.StudentID
JOIN `crud_project`.`CourseOfferings` AS co ON e.OfferingID = co.OfferingID
JOIN `crud_project`.`Course` AS c ON co.CourseID = c.CourseID
JOIN `crud_project`.`Grade` AS g ON e.OfferingID = g.OfferingID;

--7: Junção de três relações:
SELECT d.DepartmentName, i.FirstName, i.LastName, co.Semester, co.Year, c.CourseName
FROM `crud_project`.`Department` AS d
JOIN `crud_project`.`Instructor` AS i ON d.DepartmentID = i.DepartmentID
JOIN `crud_project`.`CourseOfferings` AS co ON i.InstructorID = co.InstructorID
JOIN `crud_project`.`Course` AS c ON co.CourseID = c.CourseID;
--7.2
SELECT d.DepartmentName, i.FirstName, i.LastName, co.Semester, co.Year, c.CourseName
FROM(SELECT InstructorID, CourseID, Semester, Year
FROM `crud_project`.`CourseOfferings`) AS co
JOIN `crud_project`.`Course` AS c ON co.CourseID = c.CourseID
JOIN(SELECT DepartmentID, InstructorID, FirstName, LastName
FROM `crud_project`.`Instructor`) AS i ON co.InstructorID = i.InstructorID
JOIN (SELECT DepartmentID, DepartmentName
FROM `crud_project`.`Department`) AS d ON i.DepartmentID = d.DepartmentID;

--8: Junção de quatro relações:
SELECT i.InstructorID, i.FirstName, i.LastName, COUNT(DISTINCT e.StudentID) AS TotalStudents
FROM `crud_project`.`Instructor` AS i
JOIN `crud_project`.`CourseOfferings` AS co ON i.InstructorID = co.InstructorID
JOIN `crud_project`.`Enrollments` AS e ON co.OfferingID = e.OfferingID
GROUP BY i.InstructorID, i.FirstName, i.LastName
ORDER BY TotalStudents DESC
--8.2:
SELECT i.InstructorID, i.FirstName, i.LastName, (SELECT COUNT(DISTINCT e.StudentID)
FROM `crud_project`.`Enrollments` AS e
JOIN `crud_project`.`CourseOfferings` AS co ON e.OfferingID = co.OfferingID
WHERE co.InstructorID = i.InstructorID) AS TotalStudents
FROM `crud_project`.`Instructor` AS i
ORDER BY TotalStudents DESC;

--9: Agregação sobre o resultado da junção de pelo menos duas relações:
SELECT c.CourseID, c.CourseName, AVG(g.GradeValue) AS AverageGrade
FROM `crud_project`.`CourseOfferings` AS co
JOIN `crud_project`.`Grade` AS g ON co.OfferingID = g.OfferingID
JOIN `crud_project`.`Course` AS c ON co.CourseID = c.CourseID
GROUP BY c.CourseID, c.CourseName;
--9.2:
SELECT c.CourseID, c.CourseName, (SELECT AVG(g.GradeValue) FROM `crud_project`.`Grade` AS g
WHERE g.OfferingID IN (
SELECT co.OfferingID
FROM `crud_project`.`CourseOfferings` AS co
WHERE co.CourseID = c.CourseID)) AS AverageGrade
FROM `crud_project`.`Course` AS c;

--10: Agregação sobre o resultado da junção de pelo menos duas relações:
SELECT d.DepartmentName, COUNT(DISTINCT i.InstructorID) AS TotalInstructors
FROM `crud_project`.`Department` AS d
JOIN `crud_project`.`Instructor` AS i ON d.DepartmentID = i.DepartmentID
GROUP BY d.DepartmentID;
--10.2
SELECT d.DepartmentName, (SELECT COUNT(DISTINCT i.InstructorID) FROM `crud_project`.`Instructor` AS i 
WHERE i.DepartmentID = d.DepartmentID) AS TotalInstructors
FROM `crud_project`.`Department` AS d;