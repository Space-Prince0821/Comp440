<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Initdb</title>
        <style>
            body {
                margin: 0 auto;
            }
            div {
                width: 100%;
                text-align: center;
                margin-top: 50px;
            }
        </style>
    </head>
    <body>
        <div>
            <?php

                ini_set('display_errors', 'on');
                error_reporting(E_ALL);

                session_start();

                $dbServer = "localhost";
                $dbUsername = "root";
                $dbPassword = "root";

                if (isset($_GET['initdb'])) {

                    $conn = new mysqli($dbServer, $dbUsername);

                    if ($conn -> connect_error) {
                        die("Connection failed: " . $conn -> connect_error);
                    }

                    //Create database if does not exist
                    $initdb = "CREATE DATABASE IF NOT EXISTS COMP440";

                    if ($conn -> query($initdb) === TRUE) {
                        echo "<p>Database created successfully.</p>";
                    } else {
                        echo "<p>Error creating database:" . $conn -> error . ".</p>";
                    }

                    //Create comp440 user 
                    $initUser = "CREATE USER IF NOT EXISTS 'comp440'@'localhost' IDENTIFIED BY 'pass1234'";
                    $grantUser = "GRANT ALL PRIVILEGES ON *.* TO 'comp440'@'localhost' WITH GRANT OPTION";

                    if ($conn -> query($initUser) === TRUE) {
                        $conn -> query($grantUser);
                        echo "<p>User comp440 created.</p>";
                    } else {
                        echo "<p>Error creating comp440 user:" . $conn -> error . ".</p>";
                    }

                    $templine = '';
                    $lines = file('Initdb.sql');

                    foreach ($lines as $line) {
                        if (substr($line, 0, 2) == '--' || $line == '') {
                            continue;
                        }
                        $templine .= $line;
                        if (substr(trim($line), -1, 1) == ';') {
                            $conn -> query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysqli_error($conn) . '<br /><br />');
                            $templine = '';
                        }
                    }

                    echo "<p>Tables intialized.</p>";

                    $conn -> close();
            
                }
                
            ?>
        </div>
        <div>
            <a href="index.html">
                <button>Return to Login</button>
            </a>
        </div>
    </body>
</html>