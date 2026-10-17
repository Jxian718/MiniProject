DROP DATABASE IF EXISTS bank_system;

CREATE DATABASE bank_system CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE bank_system;


CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'staff', 'admin') NOT NULL DEFAULT 'user',
    balance DECIMAL(14,2) NOT NULL DEFAULT 0.00
);


CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    account_number VARCHAR(20) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(30) NOT NULL,
    status ENUM('Active', 'Inactive') NOT NULL DEFAULT 'Active',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);


CREATE TABLE manage_staff (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    status ENUM('Active', 'Inactive') NOT NULL DEFAULT 'Active'
);


CREATE TABLE user_transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    type ENUM('Transfer', 'Received') NOT NULL,
    description VARCHAR(150) NOT NULL,
    amount DECIMAL(14,2) NOT NULL,
    status ENUM('Successful', 'Failed') NOT NULL DEFAULT 'Successful',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

INSERT INTO users (name, email, password, role, balance) VALUES
('Jinxian',   'jxian0718@gmail.com', 'jxian0718',  'user',  967489334.00),
('Staff',     'staff@gmail.com',     'staff123',   'staff', 0.00),
('Admin',     'admin@gmail.com',     'admin123',   'admin', 0.00),
('Marcus Ng', 'marcus@gmail.com',    'marcus0821', 'admin', 0.00);

INSERT INTO customers (user_id, name, account_number, email, phone, status) VALUES
(1,    'Jinxian',     '1234567890', 'jxian0718@gmail.com',  '010-7915138', 'Active'),
(4,    'Marcus Ng',   '3035297750', 'marcus@gmail.com',     '012-3975321', 'Inactive'),
(NULL, 'Daniel Tham', '2024303952', 'daniel@gmail.com',     '012-3456789', 'Inactive'),
(NULL, 'Wilfred',     '3321509870', 'wilfred@gmail.com',    '010-7915138', 'Active'),
(NULL, 'Joan Lim',    '6677232490', 'joanlim@gmail.com',    '014-7934223', 'Active'),
(NULL, 'Julina',      '3234562190', 'julina@gmail.com',     '012-9036772', 'Inactive'),
(NULL, 'Bryan',       '2246334560', 'bryan@gmail.com',      '019-9435332', 'Active'),
(NULL, 'Queenie',     '1226334780', 'queenie@gmail.com',    '012-3734550', 'Active'),
(NULL, 'Christine',   '9006727346', 'christine@gmail.com',  '016-6245033', 'Inactive');

INSERT INTO manage_staff (name, username, status) VALUES
('Edmond',  'ED01', 'Active'),
('Oscar',   'ED02', 'Inactive'),
('Desmond', 'ED03', 'Active'),
('Jinxian', 'ED04', 'Inactive');

INSERT INTO user_transactions (user_id, type, description, amount, status, created_at) VALUES
(1, 'Transfer', 'Transfer to Daniel',                 5000.00,   'Successful', '2026-10-05 10:00:00'),
(1, 'Transfer', 'Transfer to Marcus',                 25000.00,  'Successful', '2026-10-03 10:00:00'),
(1, 'Received', 'Received From Mohamad Ahmad',        20000.00,  'Successful', '2026-10-01 10:00:00'),
(1, 'Transfer', 'Transfer to Daniel',                 2000.00,   'Successful', '2026-09-30 10:00:00'),
(1, 'Received', 'Received From JX Supplies Sdn. Bhd.', 250600.00, 'Successful', '2026-09-27 10:00:00'),
(1, 'Transfer', 'Transfer to Wilfred',                7500.00,   'Successful', '2026-09-20 10:00:00'),
(1, 'Transfer', 'Transfer to Car Sales Sdn. Bhd.',    20000.00,  'Successful', '2026-09-15 10:00:00'),
(1, 'Received', 'Received From JX Supplies Sdn. Bhd.', 200000.00, 'Successful', '2026-09-12 10:00:00'),
(1, 'Received', 'Received From JX Supplies Sdn. Bhd.', 75000.00,  'Successful', '2026-09-05 10:00:00'),
(1, 'Transfer', 'Transfer to Wilfred',                8000.00,   'Failed',     '2026-10-08 10:00:00'),
(4, 'Transfer', 'Transfer to Daniel',                 2500.00,   'Successful', '2026-10-08 11:00:00');s