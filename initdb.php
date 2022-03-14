<html>
  <head>
    <meta charset="utf-8">
    <title>Initialize Database</title>
    <style>
      body {
        text-align: center;
      }

      .form {
        margin-top: 200px;
      }

      .form input {
        font-size: 30px;
        padding: 5px 10px;
      }
    </style>
  </head>
  <body>
    <?php

      ini_set('display_errors', 'on');
      error_reporting(E_ALL);

      session_start();

      $dbServer = "localhost";
      $dbUsername = "root";

      if (isset($_GET['initdb'])) {

        $conn = new mysqli($dbServer, $dbUsername);

        if ($conn -> connect_error) {
          die("Connection failed: " . $conn -> connect_error);
        }

        $initdb = "CREATE DATABASE IF NOT EXISTS projdb";

        if ($conn -> query($initdb) === TRUE) {
          echo "Database create successfully \n";
        } else {
          echo "Error creating database: " . $conn -> error;
        }

        //Drop/create user table
        $useProjDb = "use `projdb`";
        $dropUserTable = "DROP TABLE IF EXISTS `user`";
        $initUserTable = "CREATE TABLE user (
          `username` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
          `password` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
          `firstName` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
          `lastName` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
          `email` varchar(100) COLLATE utf8mb4_general_ci UNIQUE,
          PRIMARY KEY (`username`)
        )";

        $insertUser = "INSERT INTO `user` VALUES ('comp440', 'pass1234', NULL, NULL, NULL)";

        $conn -> query($useProjDb);
        $conn -> query($dropUserTable);
        $conn -> query($initUserTable);
        $conn -> query($insertUser);

        $disableForeign = "SET FOREIGN_KEY_CHECKS = 0";
        $conn -> query($disableForeign);

        $templine = '';
        $lines = file('university.sql');

        foreach ($lines as $line) {
            if (substr($line, 0, 2) == '--' || $line == '') {
              continue;
            }
            $templine .= $line;
            if (substr(trim($line), -1, 1) == ';') {
              $conn -> query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
              $templine = '';
            }
        }

        $enableForeign = "SET FOREIGN_KEY_CHECKS = 1";
        $conn -> query($enableForeign);

        echo "Table imported";

        $conn -> close();

      }
    ?>
    <form class="form" action="">
      <input type="submit" value="Initialize Database" name="initdb"/>
    </form>
  </body>
</html>
