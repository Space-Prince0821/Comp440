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

                    $conn = new mysqli($dbServer, $dbUsername, $dbPassword);

                    if ($conn -> connect_error) {
                        die("Connection failed: " . $conn -> connect_error);
                    }

                    //Create database if does not exist
                    $initdb = "CREATE DATABASE IF NOT EXISTS COMP440";

                    if ($conn -> query($initdb) === TRUE) {
                        echo "Database create successfully \n";
                    } else {
                        echo "Error creating database: " . $conn -> error;
                    }

                    include("Config.php");

                    $templine = '';
                    $lines = file('Initdb.sql');

                    foreach ($lines as $line) {
                        if (substr($line, 0, 2) == '--' || $line == '') {
                        continue;
                        }
                        $templine .= $line;
                        if (substr(trim($line), -1, 1) == ';') {
                        $conn -> query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysqli_error() . '<br /><br />');
                        $templine = '';
                        }
                    }

                    echo "Table imported";

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
