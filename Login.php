<?php   
    include("Config.php");
    session_start();

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        //username and password from form
        $username = mysqli_real_escape_string($db, $_POST['user']);
        $password = mysqli_real_escape_string($db, $_POST['pass']); 
        
        $sql = "SELECT * FROM users where username = '$username' and password = '$password'";  
        $result = mysqli_query($db, $sql);  
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
        $count = mysqli_num_rows($result);  
            
        if ($count == 1) {  
            session_start();
            $_SESSION['sessionId'] = $row['user_id'];
            $_SESSION['sessionUser'] = $row['username'];
            header("Location: welcome.php?success=loggedin");
            exit();
        }  
        else {  
            echo "<h1> Login failed. Invalid username or password.</h1>";  
        } 
    }
?>  