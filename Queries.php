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
            $tempArr = [];
            $query = "SELECT user_id COUNT(*) FROM blog GROUP BY blog_id HAVING COUNT(*) > 1";
            $result = mysqli_query($db, $query);  
            foreach($result as $resultRow) {	
                $tempArr[$resultRow] = $result;
            }

            $sql = "SELECT user_id FROM users";
            $resultant = mysqli_query($db, $sql);
            foreach($resultant as $resultantRow) {	
                if($resultant == $tempArr[$resultantRow]) {
                    $firstName = $resultantRow['firstName'];
                    $lastName = $resultantRow['lastName'];
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