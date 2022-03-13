<!DOCTYPE html>
<html>
	<head>
		<title>proj1</title>
	</head>
	<body>
		<h1>Goofy Goobers</h1><br>
		<hl>
		<script>
			var toggle = false;
			var visible = true;
			function buttonPressed()
			{
				if(toggle == false && visible)
				{
					document.body.style.backgroundColor="greenyellow";
					toggle = true;
				}
				else
				{
					document.body.style.backgroundColor="lightblue";
					toggle=false;
				}
			}
		</script>

<?php
//==================CONNECTION TO DATABASE================================================================
	$user = 'root';
	$password = 'root';
	$db = 'lab2';
	$host = 'localhost';
	$port = 3306;

	$linkdb = new mysqli(
	   $host, 
	   $user, 
	   $password,
	   $db,
	   $port
	);
	if($linkdb->connect_error)
	{
		echo 'Errno: '.$linkdb->connect_erno;
		echo '<br>';
		echo 'Error: '.$linkdb->connect_error;
	}
//===============================FORMS AND PAGES==========================================================
	//Appends a page with an integer value to the url
	$pageNum = 0;
	if( isset($_REQUEST["page"]) ) 		//if page from innerHTML is null php will request "page" and set its 							     //type to integer
	{
		$pageNum = $_REQUEST["page"];
		settype($pageNum, "integer");
	}
	else  						   		//else set pageNum to 1 and display html with value "1"
	{
		$pageNum = 1;
	}

	if($pageNum > 2 || $pageNum < 1)    //If someone tries to redirect through url and change page to 										//values greather than 2 or less than 1 error will output and
										//terminate current script through die()
	{
		echo("<strong>Error...this page does not exist!</strong></body></html>");
		die();
	}

	echo ("<br><strong>This is page# $pageNum</strong>");
	if($pageNum == 1)
	{
?>
			<!--Uses php contained script as well as superglobal $_SERVER to allow user to retrieve variables from the html, can be retrieved using $_GET, $_POST, and $_REQUEST -->
			<br><br><h2>Login here</h2>
            <form method="get" 
				action="<?php echo $_SERVER['PHP_SELF']; ?>">
				
				<input type="hidden" name="page" value="2">
				<p><label>Username: 
					<input type="text" name="username">
				</label></p>
				<p><label>Password:
					<input type="text" name="password">
				</label></p>
				<p><input type="submit" value="LOGIN"></p>
			</form>

			<!--Uses php contained script as well as superglobal $_SERVER to allow user to retrieve variables from the html, can be retrieved using $_GET, $_POST, and $_REQUEST -->
			<br><br><h2>Register here</h2>
			<form method="get" 
				action="<?php echo $_SERVER['PHP_SELF']; ?>">
				
				<input type="hidden" name="page" value="2">
				<p><label>Desired Username: 
					<input type="text" name="newUser">
				</label></p>
				<p><label>Desired Password:
					<input type="text" name="newPass">
				</label></p>
				<p><input type="submit" value="Register"></p>
			</form>

			<!--Once either of the forms have been submitted through html value of page changes to 2 and procedurally progresses php script -->
<?php
	} 
//=======================RETURNING USER LOGIN=============================================================
	else if ($pageNum == 2)
	{	
		//Checks that input value in form is not null and does not cotain simply a empty char
		if (isset($_REQUEST["username"]) 
			&& $_REQUEST["username"] != ""
			&& isset($_REQUEST["password"])
			&& $_REQUEST["password"] != "")
		{
			$username=$password="";					//Set variables to "" to create a starting point for 										 //storage
			$username = $_REQUEST["username"];		//Provides script similar to $_GET and $_POST
			$password = $_REQUEST["password"];		//to retrive from html and store in php var
			$adminU = "Administrator";				//Manually created string for Administrator aspect
			$adminP = "1Password";

			//Query stored as a php string
			$query = "SELECT * FROM users WHERE username=? and password=?";
			$stmt = $linkdb->prepare($query);					//Prepares a statement for execution
			$stmt->bind_param('ss',$username, $password);		//Binds variables to prepared query ?
			$stmt->execute();									//executes statement
			$result = $stmt->get_result();						//Stores result from prepared statement

//=======================ADMINISTRATOR LOG IN=============================================================
			foreach($result as $resultRow)	//Iterates through columns username and password and checks 								//for manually prepared adminstrator credentials
			{
				$tempU = $resultRow["username"];
				$tempP = $resultRow["password"];
				if($tempU == $adminU && $tempP == $adminP)
				{
					echo("<p>Welcome Administrator! Below is the database...</p>");
?>
			<table border="1">
				<thead>
					<tr>
						<td>User ID</td>
						<td>Username</td>
						<td>Password</td>
					</tr>
				</thead>
				<tbody>
<?php
					$aTable = "SELECT * FROM users";			//Query stored as a php string
					$stmt2 = $linkdb->prepare($aTable);			//Prepares a statement for execution
					$stmt2->execute();							//executes statement
					$resultTable = $stmt2->get_result();		//Stores result from prepared statement
					foreach($resultTable as $resultTableRow)
					{
						//Stores values of each column at current row into temporary statements to be //printed
						$userId = $resultTableRow["userId"];
						$username = $resultTableRow["username"];
						$password = $resultTableRow["password"];
						print("<tr><td>$userId</td>" . "<td>$username</td>" . "<td>$password</td></tr>");
					}
?>
				</tbody>
			</table>
<?php	
//========================================================================================================
					break;
				}
				else if($result)
				{
					echo("<p>Welcome back $username!</p></body></html>");
					break;
				}
				else
				{
					echo("<p>Incorrect Username/Password please try again</p></body></html>");
					die();
				}
			}	
		}
//================================NEW USER REGISTRATION===================================================
		//Checks that input value in form is not null and does not cotain simply a empty char
		elseif (isset($_REQUEST["newUser"]) 
			&& $_REQUEST["newUser"] != ""
			&& isset($_REQUEST["newPass"])
			&& $_REQUEST["newPass"] != "")
		{
			$newUser=$newPass="";					//Set variables to "" to create a starting point
			$newUser = $_REQUEST["newUser"];		//Provides script similar to $_GET and $_POST
			$newPass = $_REQUEST["newPass"];		//to retrive from html and store in php var

			$query = "SELECT username FROM users";	//Query stored as a php string
			$stmt = $linkdb->prepare($query);		//Prepares a statement for execution
			$stmt->execute();						//executes statement
			$result = $stmt->get_result();			//Stores result from prepared statement

			//Stores values of each column at current row into temporary statements to be //printed
			foreach($result as $resultRow)
			{
				$tempU = $resultRow["username"];
				if($newUser == "Administrator")
				{
					echo("<p>Cannot register as Administrator!</p></body></html>");
					die();
				}	
				if($tempU == $newUser)
				{
					echo("<p>Username already taken please try another one</p></body></html>");
					die();
				}				
			}
			$query2 = "INSERT INTO users (username, password) VALUES(?,?)";
			$stmt2 = $linkdb->prepare($query2);
			$stmt2->bind_param('ss',$newUser, $newPass);
			$stmt2->execute();
			$result2 = $stmt2->get_result();
			echo("<p>Registration completed! Welcome!</p></body></html>");
		}
        ?>
            <form method="get" 
				action="<?php echo $_SERVER['PHP_SELF']; ?>">
				
				<input type="hidden" name="page" value="1">
				<p><input type="submit" value="LOGOUT"></p>
				<input type="button" onclick="buttonPressed()" value="Toggle Color">
			</form>
        <?php

		else
		{
			echo("<p><strong>Error...need both username and password!</strong></p></body></html>");
			die();
		}
//=======================BUTTONS AND DB CLOSE=============================================================
?>		
			<form method="get" 
				action="<?php echo $_SERVER['PHP_SELF']; ?>">
				
				<input type="hidden" name="page" value="1">
				<p><input type="submit" value="LOGOUT"></p>
				<input type="button" onclick="buttonPressed()" value="Toggle Color">
			</form>
<?php
	}
	// exec("mysqldump -h localhost -u htdocs -pPassword lab2> lab2.mysql");
	$linkdb->close();
?>
	</body>
</html>