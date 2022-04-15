<html>
   <head>
      <title>Welcome </title>
   </head>
   <body>
      <h1>Welcome</h1> 
      <?php
         session_start();
         if (isset($_SESSION['sessionId'])) {
            echo "You are logged in as '$_SESSION[sessionUser]' <br />";
         } else {
            echo "Home";
         }
      ?>
      <a href = "Blog.php"><button>Create blog</button></a>
      <br />
      <a href = "index.html"><button>Sign Out</button></a>
   </body>
</html>