<?php
    //Database credentials
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'comp440');
    define('DB_PASSWORD', 'King1998*');
    define('DB_NAME', 'COMP440');

    //Connecting to MySQL
    $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    // Check connection
    if ($db === false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    else {
        echo "Connection Successful!";
    }
?>