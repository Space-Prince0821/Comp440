use `COMP440`;

SET FOREIGN_KEY_CHECKS = 0;

-- Create user table
DROP TABLE IF EXISTS `user`;
CREATE TABLE user (
    `user_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `username` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
    `password` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
    `firstName` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
    `lastName` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
    `email` varchar(100) COLLATE utf8mb4_general_ci UNIQUE
    -- PRIMARY KEY (`username`)
);

-- Add 5 users
INSERT INTO `user` (username, password, firstName, lastName, email)  VALUES 
    ('michael', 'password', 'Michael', 'Paul', 'michaelandrewpaul97@gmail.com'),
    ('prince', 'password', 'Prince', 'Chowdury', 'prince@gmail.com'),
    ('brandon', 'password', 'Brandon', 'Tong', 'brandon@gmail.com'),
    ('john', 'password', 'John', 'Appleseed', 'johna@gmail.com'),
    ('bob', 'pass1234', 'Bob', 'Johnson', 'bob9@gmail.com');

-- Create hobby table
DROP TABLE IF EXISTS `hobbies`;
CREATE TABLE hobbies (
    `hobby_id` INT COLLATE utf8mb4_general_ci NOT NULL,
    `user_id` INT COLLATE utf8mb4_general_ci NOT NULL
);

INSERT INTO `hobbies` VALUES
    (1, 4),
    (1, 6),
    (3, 4),
    (2, 5),
    (4, 1);

-- Create blog table
DROP TABLE IF EXISTS `blog`;
CREATE TABLE blog (
    `blog_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `subject` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
    `description` varchar(200) COLLATE utf8mb4_general_ci NOT NULL
);

INSERT INTO `blog` (subject, description) VALUES
    ('soccer', 'dhfshdfhsdh  dfsdfds'),
    ('bitcoin', 'djdfsjdfj dfs dfs'),
    ('soccer', 'dhfshdfhsdh  dfsdfds'),
    ('bitcoin', 'djdfsjdfj dfs dfs'),
    ('swimmming', 'ddfhds dj dsdf fjdjfdjjfs sdfjdfjsjd fhdsf dsdjf');

-- Create tags table
DROP TABLE IF EXISTS `tags`;
CREATE TABLE tags (
    `tag_id` INT COLLATE utf8mb4_general_ci NOT NULL,
    `blog_id` INT COLLATE utf8mb4_general_ci NOT NULL
);

INSERT INTO `tags` VALUES
    (1, 5),
    (1, 2),
    (4, 8),
    (2, 3),
    (2, 5);

-- Create comment table
DROP TABLE IF EXISTS `comment`;
CREATE TABLE comment (
    `comment_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `sentiment` BIT COLLATE utf8mb4_general_ci NOT NULL,
    `description` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
    `blog_id` INT DEFAULT NULL,
    KEY `blog_id` (`blog_id`),
    CONSTRAINT `blog_id_fk` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`blog_id`) ON DELETE SET NULL
);

INSERT INTO `comment` (sentiment, description, blog_id) VALUES
    (1, 'djfksdfksdjf dksdfj sdk fjs', 1),
    (1, 'dfsdkfskhgfgh fkghdfgkdhfg', 1),
    (0, 'dfsdhghfghfhgh fghfhgfh fgh fhgd', 3),
    (1, 'fhgdfhgdfhgdghfhgh fghfhgfh fgh fhgd', 2),
    (0, 'jdjdfjdjdjdjdjdj jjjj j j ds dj', 4);

SET FOREIGN_KEY_CHECKS = 1;