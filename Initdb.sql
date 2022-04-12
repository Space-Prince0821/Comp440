use 'COMP440';

-- Create user table
DROP TABLE IF EXISTS 'user';
CREATE TABLE user (
    'username' varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
    'password' varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
    'firstName' varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
    'lastName' varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
    'email' varchar(100) COLLATE utf8mb4_general_ci UNIQUE,
    PRIMARY KEY ('username')
);