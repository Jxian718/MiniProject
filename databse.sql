DROP DATABASE IF EXISTS bank_system;

CREATE DATABASE bank_system;

USE bank_system;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    role VARCHAR(20) NOT NULL,
    balance DECIMAL(10,2) DEFAULT 0.00
);

INSERT INTO users (name, email, password, role, balance)
VALUES
('Jinxian', 'jxian0718@gmail.com', 'jxian0718', 'user', 1000.00),
('Staff', 'staff@gmail.com', 'staff123', 'staff', 0.00),
('Admin ', 'admin@gmail.com', 'admin123', 'admin', 0.00),
('Marcus Ng', 'marcus@gmail.com', 'marcus0821', 'admin', 1000.00);