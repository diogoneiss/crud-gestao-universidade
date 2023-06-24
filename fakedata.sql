USE crud_project;

-- Insert data into Department table
INSERT INTO Department (DepartmentName)
VALUES ('Computer Science'), ('Mathematics'), ('Physics'), ('Chemistry');

-- Insert data into Student table
INSERT INTO Student (Cpf, Email, Major, Year, FirstName, LastName)
VALUES ('12345678901', 'john.doe@example.com', 'Computer Science', '2024', 'John', 'Doe'),
       ('23456789012', 'jane.smith@example.com', 'Mathematics', '2023', 'Jane', 'Smith'),
       ('34567890123', 'michael.brown@example.com', 'Physics', '2022', 'Michael', 'Brown'),
       ('45678901234', 'sarah.jones@example.com', 'Chemistry', '2025', 'Sarah', 'Jones');


-- Insert data into Course table
INSERT INTO Course (CourseName, DepartmentID)
VALUES ('Algorithms', 1), ('Calculus', 2), ('Quantum Mechanics', 3), ('Organic Chemistry', 4);

-- Insert data into Instructor table
INSERT INTO Instructor (DepartmentID, Email, FirstName, LastName)
VALUES (1, 'prof.miller@example.com', 'Alice', 'Miller'),
       (2, 'prof.davis@example.com', 'Bob', 'Davis'),
       (3, 'prof.garcia@example.com', 'Charlie', 'Garcia'),
       (4, 'prof.wilson@example.com', 'David', 'Wilson');

-- Insert data into Building table
INSERT INTO Building (BuildingName)
VALUES ('Science Hall'), ('Math Building');

-- Insert data into Classroom table
INSERT INTO Classroom (BuildingID, RoomNum, Capacity)
VALUES (1, 101, 50), (1, 102, 50), (2, 201, 30), (2, 202, 30);

-- Insert data into CourseOfferings table
INSERT INTO CourseOfferings (CourseID, InstructorID, ClassroomID, Semester, Year)
VALUES (1, 1, 1, 1, '2023'), (2, 2, 2, 2, '2023'), (3, 3, 3, 2, '2024'), (4, 4, 4, 1, '2024');

-- Insert data into Grade table
INSERT INTO Grade (GradeValue, StudentID, OfferingID)
VALUES ('A', 1, 1), ('B+', 2, 2), ('A-', 3, 3), ('B', 4, 4);

-- Insert data into AcademicCredits table
INSERT INTO AcademicCredits (OfferingID, Credits)
VALUES (1, 4), (2, 4), (3, 3), (4, 3);

-- Insert data into Enrollments table
INSERT INTO Enrollments (StudentID, OfferingID)
VALUES (1, 1), (2, 2), (3, 3), (4, 4);
