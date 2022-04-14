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
);

-- Add 5 users
INSERT INTO `user` (username, password, firstName, lastName, email)  VALUES 
    ('michael', 'password', 'Michael', 'Paul', 'michaelandrewpaul97@gmail.com'),
    ('prince', 'password', 'Prince', 'Chowdury', 'prince@gmail.com'),
    ('brandon', 'password', 'Brandon', 'Tong', 'brandon@gmail.com'),
    ('john', 'password', 'John', 'Appleseed', 'johna@gmail.com'),
    ('bob', 'pass1234', 'Bob', 'Johnson', 'bob9@gmail.com');

-- Create follows table
DROP TABLE IF EXISTS `follow`;
CREATE TABLE follow (
    `user_id` INT DEFAULT NULL,
    CONSTRAINT `user_id_fk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE SET NULL,
    `follows_user_id` INT DEFAULT NULL,
    CONSTRAINT `user_id_fk_4` FOREIGN KEY (`follows_user_id`) REFERENCES `user` (`user_id`) ON DELETE SET NULL
);

INSERT INTO `follow` VALUES
    -- user 1 follows user 2
    (1, 2),
    (1, 3),
    (2, 1),
    (3, 1),
    -- user 5 follows user 4
    (5, 4);

-- Create hobby table
DROP TABLE IF EXISTS `hobbies`;
CREATE TABLE hobbies (
    `hobby_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `hobby_name` varchar(20) COLLATE utf8mb4_general_ci NOT NULL
);

-- All hobbies: hiking, swimming, calligraphy, bowling, movie, cooking, and dancing

INSERT INTO `hobbies` (hobby_name) VALUES
    ('Hiking'),
    ('Swimming'),
    ('Calligraphy'),
    ('Bowling'),
    ('Movie'),
    ('Cooking'),
    ('Dancing');

-- Create user's hobbies table
DROP TABLE IF EXISTS `UserHobbies`;
CREATE TABLE UserHobbies (
    `hobby_id` INT DEFAULT NULL,
    CONSTRAINT `hobby_id_fk` FOREIGN KEY (`hobby_id`) REFERENCES `hobbies` (`hobby_id`) ON DELETE SET NULL,
    `user_id` INT DEFAULT NULL,
    CONSTRAINT `user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE SET NULL
);

INSERT INTO `UserHobbies` VALUES
    -- hiking hobby for user 1
    (1, 1),
    -- hiking hobby for user 5
    (1, 5),
    (2, 2),
    (3, 3),
    (5, 7);

-- Create blog table
DROP TABLE IF EXISTS `blog`;
CREATE TABLE blog (
    `blog_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT DEFAULT NULL,
    CONSTRAINT `user_id_fk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE SET NULL,
    `date` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
    `subject` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
    `description` varchar(1000) COLLATE utf8mb4_general_ci NOT NULL
);

INSERT INTO `blog` (user_id, date, subject, description) VALUES
    (1, CURDATE(), 'Soccer', "Association football, more commonly known as simply football or soccer,[a] is a team sport played with a spherical ball between two teams of 11 players. It is played by approximately 250 million players in over 200 countries and dependencies, making it the world's most popular sport."),
    (1, CURDATE(), 'Bitcoin', "Bitcoin (₿) is a decentralized digital currency, without a central bank or single administrator, that can be sent from user to user on the peer-to-peer bitcoin network without the need for intermediaries.[7] Transactions are verified by network nodes through cryptography and recorded in a public distributed ledger called a blockchain."),
    (2, CURDATE(), 'Video Games', "A video game[a] or computer game is an electronic game that involves interaction with a user interface or input device – such as a joystick, controller, keyboard, or motion sensing device – to generate visual feedback. This feedback is shown on a video display device, such as a TV set, monitor, touchscreen, or virtual reality headset."),
    (3, CURDATE(), 'Hiking', "Hiking is a long, vigorous walk, usually on trails or footpaths in the countryside. Walking for pleasure developed in Europe during the eighteenth century.[1] Religious pilgrimages have existed much longer but they involve walking long distances for a spiritual purpose associated with specific religions."),
    (5, CURDATE(), 'Rock Music', "Rock music is a broad genre of popular music that originated as 'rock and roll' in the United States in the late 1940s and early 1950s, developing into a range of different styles in the mid-1960s and later, particularly in the United States and the United Kingdom.[2] It has its roots in 1940s and 1950s rock and roll, a style that drew directly from the blues and rhythm and blues genres of African-American music and from country music.");


-- Create tags table
DROP TABLE IF EXISTS `tags`;
CREATE TABLE tags (
    `tag_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `tag_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
);

INSERT INTO `tags` (tag_name) VALUES
    ('Crypto'),
    ('Sports'),
    ('Exercise'),
    ('Video Games'),
    ('Music');

-- Create blog tags table
DROP TABLE IF EXISTS `BlogTags`;
CREATE TABLE BlogTags (
    `blog_id` INT DEFAULT NULL,
    CONSTRAINT `blog_id_fk_1` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`blog_id`) ON DELETE SET NULL,
    `tag_id` INT DEFAULT NULL,
    CONSTRAINT `tag_id_fk` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`tag_id`) ON DELETE SET NULL
);

INSERT INTO `BlogTags` VALUES
    -- soccer blog 1, sports tag
    (1, 2),
    (1, 3),
    -- bitcoin blog 2, crypto tag
    (2, 1),
    (3, 4),
    (4, 3),
    (5, 5);

-- Create comment table
DROP TABLE IF EXISTS `comment`;
CREATE TABLE comment (
    `comment_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `blog_id` INT DEFAULT NULL,
    CONSTRAINT `blog_id_fk_2` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`blog_id`) ON DELETE SET NULL,
    `user_id` INT DEFAULT NULL,
    CONSTRAINT `user_id_fk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE SET NULL,
    `date` varchar(20) COLLATE utf8mb4_general_ci NOT NULL, 
    `sentiment` BIT COLLATE utf8mb4_general_ci NOT NULL,
    `description` varchar(500) COLLATE utf8mb4_general_ci NOT NULL
);

INSERT INTO comment (blog_id, user_id, date, sentiment, description) VALUES
    -- sentiment bit -> 0:negative, 1:positive
    -- blog 1 comment by user 2
    (1, 2, CURDATE(), 0, 'Soccer is boring to watch.'),
    -- blog 1 comment by user 3
    (1, 3, CURDATE(), 1, 'I love soccer too.'),
    -- blog 2 comment by user 3
    (2, 3, CURDATE(), 0, 'Bitcoin is a scam.'),
    -- blog 5 comment by user 1
    (5, 1, CURDATE(), 0, "I don't enjoy rock music."),
    -- blog 4 comment by user 2
    (4, 2, CURDATE(), 1, "I love hiking too.");

SET FOREIGN_KEY_CHECKS = 1;