<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Initdb</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    </head>
    <body class="container my-3">
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
                        echo "<h1>Database created successfully.</h1>";
                    } else {
                        echo "<h1>Error creating database:" . $conn -> error . ".</h1>";
                    }

                    //Create comp440 user 
                    $initUser = "CREATE USER IF NOT EXISTS 'comp440'@'localhost' IDENTIFIED BY 'pass1234'";
                    $grantUser = "GRANT ALL PRIVILEGES ON *.* TO 'comp440'@'localhost' WITH GRANT OPTION";

                    if ($conn -> query($initUser) === TRUE) {
                        $conn -> query($grantUser);
                        echo "<h2>User comp440 created.</h2>";
                    } else {
                        echo "<h2>Error creating comp440 user:" . $conn -> error . ".</h2>";
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
        <a href="index.html">
            <button class=" btn btn-md btn-primary mt-3" type="submit">Return to Login</button>
        </a>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
</html>