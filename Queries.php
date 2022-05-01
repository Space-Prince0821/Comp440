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
            $query = "SELECT user_id COUNT(*) FROM blog 
                      GROUP BY user_id HAVING COUNT(*) > 1
                      INNER JOIN SELECT users 
                      ON users.user_id, users.firstName, users.lastName";
            $result = mysqli_query($db, $query);  
            //$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            // $sql = "SELECT * FROM users
            //         WHERE user_id in 
            //         (SELECT user_id COUNT(*) FROM blog GROUP BY blog_id HAVING COUNT(*) > 1)";
            // $resultant = mysqli_query($db, $sql);

            while($row = mysqli_fetch_array($result))
            {
                echo $tableData = "<tr><td>$result['firstName']</td> <td>$result['lastName']</td></tr>";
            }
            // foreach($result as $resultRow) {
            //     $user_id = $resultantRow['user_id'];
            //     $firstName = $resultantRow['firstName'];
            //     $lastName = $resultantRow['lastName'];
 
            //     print("<tr><td>$firstName</td>" . "<td>$lastName</td></tr>");
                
            // }

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