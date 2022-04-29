<?php
    session_start();
    include("Config.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Blog search</title>
        <link rel="stylesheet" type="text/css" href="style.css">

        <script> type="text/javascript"
  
        </script>

        <style>

        </style>
	</head>
	<body>
        <h1>Blog Search</h1> 

        <table border="1">
			<thead>
				<tr>
					<td>First Name</td>
					<td>Last Name</td>
				</tr>
			</thead>
			<tbody>
        <?php 
            $query = "SELECT user_id COUNT(*) FROM blog GROUP BY blog_id HAVING COUNT(*) > 1";
            $result = mysqli_query($db, $query);  

            $sql = "SELECT * FROM users
                    WHERE user_id in 
                    (SELECT user_id COUNT(*) FROM blog GROUP BY blog_id HAVING COUNT(*) > 1)";
            $resultant = mysqli_query($db, $sql);

            foreach($resultant as $resultantRow) {
                $user_id = $resultantRow['user_id'];
                $firstName = $resultantRow['firstName'];
                $lastName = $resultantRow['lastName'];
 
                if($resultantRow['user_id'] == $user_id) {
                    print("<tr><td>$firstName</td>" . "<td>$lastName</td></tr>");
                }
            }

        ?>
        </tbody>
    </table>
        <br /><br />
        <a href = "welcome.php"><button>Browse blog</button></a>
        <br />
        <a href = "Blog.php"><button>Create blog</button></a>
        <br />
        <a href = "index.html"><button>Sign Out</button></a>

    </body>
</html>