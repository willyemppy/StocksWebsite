CREATE DATABASE IF NOT EXISTS Stocks_Website;

USE Stocks_Website;

CREATE TABLE IF NOT EXISTS Users (
    userID INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    Securepassword VARCHAR(50),
    lastlogin DATE,
    permissions INT(3)
);
INSERT INTO Users (username, Securepassword, permissions)
VALUES 
/* Admin has permission level 3 and customer has permissio level 2 */
    ('admin', 'password', 3),    
    ('customer', 'password', 2);