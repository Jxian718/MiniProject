DROP DATABASE IF EXISTS bank_system;

CREATE DATABASE bank_system;

USE bank_system;

CREATE TABLE if not exists users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    role VARCHAR(20) NOT NULL
);

CREATE TABLE if not exists usertransactions (
	 id INT auto_increment PRIMARY KEY,
     name VARCHAR(100) NOT NULL,
     amount VARCHAR(100) NOT NULL UNIQUE,
     received VARCHAR(100) NOT NULL,
     success VARCHAR(20) NOT NULL
);

CREATE TABLE if not exists managestaff (
       id INT auto_increment PRIMARY KEY,
       name VARCHAR(100) NOT NULL,
       username VARCHAR(100) NOT NULL UNIQUE,
       status VARCHAR(20) NOT NULL
);

CREATE TABLE if not exists customers (
     id INT auto_increment PRIMARY KEY,
     name VARCHAR(100) NOT NULL,
     accouuntnumber VARCHAR(100) NOT NULL UNIQUE,
     email VARCHAR(100) NOT NULL UNIQUE,
     phone VARCHAR(100) NOT NULL,
     status VARCHAR(20) NOT NULL
);

INSERT INTO users(name, email, password, role)
VALUES
('Jinxian', 'jxian0718@gmail.com', 'jxian0718','user'),
('Staff', 'staff@gmail.com', 'staff123', 'staff'),
('Admin', 'admin@gmail.com', 'admin123', 'admin'),
('Marcus Ng', 'marcus@gmail.com', 'marcus0821', 'admin');



       
     
	
     
     






