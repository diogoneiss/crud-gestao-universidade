USE crud_project;

INSERT INTO Emails (EmailAddress) 
VALUES ('john.doe@example.com'), ('jane.smith@example.com'), ('michael.brown@example.com'), ('sarah.jones@example.com'),
    ('prof.miller@example.com'), ('prof.davis@example.com'), ('prof.garcia@example.com'), ('prof.wilson@example.com');

-- Insert data into Department table
INSERT INTO Department (DepartmentName)
VALUES ('Computer Science'), ('Mathematics'), ('Physics'), ('Chemistry');

-- Insert data into Student table
INSERT INTO Student (Cpf, EmailID, Major, Year, FirstName, LastName)
VALUES ('12345678901', 1, 'Computer Science', '2024', 'John', 'Doe'),
       ('23456789012', 2, 'Mathematics', '2023', 'Jane', 'Smith'),
       ('34567890123', 3, 'Physics', '2022', 'Michael', 'Brown'),
       ('45678901234', 4, 'Chemistry', '2025', 'Sarah', 'Jones');


-- Insert data into Course table
INSERT INTO Course (CourseName, DepartmentID)
VALUES ('Algorithms', 1), ('Calculus', 2), ('Quantum Mechanics', 3), ('Organic Chemistry', 4);

-- Insert data into Instructor table
INSERT INTO Instructor (DepartmentID, EmailID, FirstName, LastName)
VALUES (1, 5, 'Alice', 'Miller'),
       (2, 6, 'Bob', 'Davis'),
       (3, 7, 'Charlie', 'Garcia'),
       (4, 8, 'David', 'Wilson');

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
VALUES (10, 1, 1), (100, 2, 2), (95.3, 3, 3), (66.64, 4, 4);

-- Insert data into AcademicCredits table
INSERT INTO AcademicCredits (OfferingID, Credits)
VALUES (1, 4), (2, 4), (3, 3), (4, 3);

-- Insert data into Enrollments table
INSERT INTO Enrollments (StudentID, OfferingID)
VALUES (1, 1), (2, 2), (3, 3), (4, 4);
