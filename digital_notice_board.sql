CREATE DATABASE IF NOT EXISTS digital_notice_board;
USE digital_notice_board;

CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

INSERT INTO admin (username, password)
SELECT 'admin', 'admin123'
WHERE NOT EXISTS (SELECT 1 FROM admin WHERE username='admin');

CREATE TABLE IF NOT EXISTS notices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    department VARCHAR(50) NOT NULL,
    notice_date DATE NOT NULL,
    urgency VARCHAR(20) NOT NULL,
    details TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO notices (title, department, notice_date, urgency, details)
SELECT 'Internal Assessment Examination', 'CSE', '2026-10-06', 'High',
'Internal Assessment examination will be conducted from 10 October 2026. Students are requested to prepare according to the examination schedule.'
WHERE NOT EXISTS (SELECT 1 FROM notices);

INSERT INTO notices (title, department, notice_date, urgency, details)
SELECT 'Department Symposium', 'ECE', '2026-10-08', 'Medium',
'The ECE Department is organizing a technical symposium. Interested students can register through the department.'
WHERE (SELECT COUNT(*) FROM notices) = 1;

INSERT INTO notices (title, department, notice_date, urgency, details)
SELECT 'Library Book Return Notice', 'ALL', '2026-10-05', 'Low',
'All students are requested to return overdue library books before the due date.'
WHERE (SELECT COUNT(*) FROM notices) = 2;