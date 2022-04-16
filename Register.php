<?php   
    include("Config.php");

    // Define variables and initialize with empty values
    $new_username = $new_password = $new_password2 = $first_name = $last_name = $email = "";

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        // SQL statement
        $sql = "SELECT username FROM users WHERE username = ?";	

        if ($stmt = mysqli_prepare($db, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = trim($_POST["ruser"]);

            // Execute statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    echo "Username already taken!";
                    die();
                }
                else {
                    $new_username = trim($_POST["ruser"]);
                }
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }

        $new_password = trim($_POST["pass1"]);
        $new_password2 = trim($_POST["pass2"]);
        $first_name = trim($_POST["fname"]);
        $last_name = trim($_POST["lname"]);
        $email = trim($_POST["email"]);

        if ($new_password != $new_password2) {
            echo "Password did not match!";
            die();
        }

        // Insert into users table, new user info
        $sql2 = "INSERT INTO users (username, password, firstName, lastName, email) VALUES(?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($db, $sql2)) {
            mysqli_stmt_bind_param($stmt, "sssss", $param_username, 
            $param_password, $param_first, $param_last, $param_email);

            $param_first = $first_name;
            $param_username = $new_username;
            $param_password = $new_password;
            $param_email = $email;
            $param_last = $last_name;

            if (mysqli_stmt_execute($stmt)) {
                echo "Registeration Complete!";

                // Redirect  to login if registeration is complete
                header("location: index.html");
            }
            else {
                echo "Oops! Something went wrong!";
            }

            mysqli_stmt_close($stmt);
        }
        // Close connection
        mysqli_close($db);
    }
?> 