<?php   
    include("Config.php");

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        //username and password from form
        $username = mysqli_real_escape_string($db, $_POST['user']);
        $password = mysqli_real_escape_string($db, $_POST['pass']); 
        
        $sql = "SELECT * FROM users where username = '$username' and password = '$password'";  
        $result = mysqli_query($db, $sql);  
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
        $count = mysqli_num_rows($result);  
            
        if ($count == 1) {  
            header("Location: welcome.php");
        }  
        else {  
            echo "<h1> Login failed. Invalid username or password.</h1>";  
        } 
    }
?>  