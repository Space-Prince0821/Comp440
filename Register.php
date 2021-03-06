<html>
    <head>
        <title>Register</title>
        <style>
            :root {
                --blue: #095877;
                --orange: #f64e20;
            }
            body {
                margin: 0 auto;
                text-align: center;
                background-color: var(--blue);
                color: white;
            }
            div {
                margin-top: 50px;
            }
            button {
                color: white;  
                background: var(--orange);
                padding: 7px 10px; 
                font-size: 18px;
            }
            button:hover {
                cursor: pointer;
                opacity: 0.8;
            }
            p {
                font-size: 20px;
            }
        </style>
    <head>
    <body>
        <div>
            <?php   
                include("Config.php");

                function displayReturn() {
                    echo "<a href = \"index.html\"><button>Return to Login</button></a>";
                }

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
                                echo "<p>Username already taken!</p>";
                                displayReturn();
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
                        echo "<p>Password did not match!</p>";
                        displayReturn();
                        die();
                    };

                    if (strpos($email, '@') == false) {
                        echo "<p>Email not valid.</p>";
                        displayReturn();
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
                            echo "<p>Registeration Complete!</p>";

                            // Hobbies
                            $query = "SELECT user_id FROM users WHERE username = \"$param_username\"";

                            $result = mysqli_query($db, $query);

                            $newUserId = $result->fetch_array()[0] ?? '';

                            if (isset($_POST['hobby'])) {
                                foreach($_POST['hobby'] as $hobby) {

                                    $query1 = "SELECT hobby_id FROM hobbies WHERE hobby_name = \"$hobby\"";
                                    $result1 = mysqli_query($db, $query1);

                                    $hobbyId = $result1->fetch_array()[0] ?? '';

                                    $query2 = "INSERT INTO userhobbies (hobby_id, user_id) VALUES (?, ?)";

                                    if ($stmt = mysqli_prepare($db, $query2)) {
                                        mysqli_stmt_bind_param($stmt, "ss", $hobbyId, $newUserId);
                                        mysqli_stmt_execute($stmt);
                                    }

                                }
                            };

                            displayReturn();

                        }
                        else {
                            echo "Oops! Something went wrong!";
                            displayReturn();
                            die();
                        }

                        mysqli_stmt_close($stmt);
                    }

                    // Close connection
                    mysqli_close($db);
                }
            ?>
        </div>
    </body>
</html>