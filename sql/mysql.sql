CREATE DATABASE disaster_management;

USE disaster_management;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE disasters (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    location VARCHAR(100) NOT NULL,
    type ENUM('earthquake', 'flood', 'hurricane', 'wildfire', 'tsunami', 'other') NOT NULL,
    severity ENUM('low', 'medium', 'high', 'extreme') NOT NULL,
    reported_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('reported', 'verified', 'resolved') DEFAULT 'reported',
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE emergency_contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100),
    organization VARCHAR(100) NOT NULL,
    region VARCHAR(100) NOT NULL
);
