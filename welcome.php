<?php
   include('BlogLogic.php');
?>
<html>
   <head>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
      <title>Welcome </title>
      <style>
         :root {
            --blue: #095877;
            --orange: #f64e20;
         }
         body {
            margin: 0;
            background-color: var(--blue);
            color: white;
            text-align: left;
         }
         .header {
            background-color: var(--orange);
            padding-bottom: 20px;
            border-bottom: 3px solid white;
         }
         h1 {
            padding: 20px;
         }
         .container {
            min-width: fit-content;
            padding: 20px;
            margin-top: -30px;
         }
         .card {
            min-width: 300px;
            background-color: var(--orange);
         }
         .comments {
            border-top: 2px solid white;
         }
         .comments-container {
            border-bottom: 2px solid white;
            padding: 0px 20px;
            padding-bottom: 5px;
         }
         .comments-container p {
            padding: 0;
            margin: 0;
         }
         .comments-container .username {
            font-size: 20px;
            text-decoration: underline;
         }
         .comments-container .sentiment {
            font-size: 12px;
            color: white;
            opacity: 0.6;
         }
         .tags {
            border-top: 2px solid white;
            text-align: center;
            padding-top: 10px;
         }
         .button {
            border-radius: 10px;
            color: white;
         }
         input[type="submit"] {
            background-color: var(--blue);
            padding: 5px 10px;
            border: 2px solid white;
         }
         button {
            background-color: var(--orange);
            margin: 10px;
            padding: 5px 10px;
            border: 2px solid white;
            color: white;
         }
         .footer {
            border-top: 3px solid white;
            margin-top: 10px;
            padding-top: 10px;
            background-color: var(--orange);
            padding-bottom: 2px;
            margin-bottom: -16px;
         }
         ul {
            list-style-type: none;
         }
         li {
            display: inline-block;
         }
         li button {
            width: 100px;
            background-color: var(--blue);
            border-radius: 10px;
         }
        </style>
   </head>
   <body>
      <div class="header">
         <h1>Welcome</h1> 
        <?php
           // session_start();
           if (isset($_SESSION['sessionId'])) {
              echo "You are logged in as '$_SESSION[sessionUser]' <br />";
           } else {
              echo "Home";
           }
        ?>
        <a href = "Queries.php"><button>Search Blog</button></a>
      </div>
  
      <div class="row">
         <?php foreach($query as $q) {?>
            <div class="col-4 d-flex justify-content-center align-items-center container">
               <div class="card text-white mt-5">
                  <div class="card-body" style="width: 18rem;">
                     <h5 class="card-title"><strong><?php echo $q['subject'];?></strong></h5>
                     <p class="card-text" style="font-size: 12px;">
                        <?php
                           //Get username of commenter
                           $userId = $q['user_id'];
                           $usernameQuery = "SELECT username FROM users WHERE user_id=$userId";
                           $result = mysqli_query($db, $usernameQuery);

                           $username = $result->fetch_array()[0] ?? '';

                           echo $username;

                        ?>
                     </p>
                     <p class="card-text"><?php echo $q['description'];?></p>
                  </div>
                  <!-- Inserting tags for posts-->  
                  <?php 
                     $blog_identification = $q['blog_id'];

                     $tag_identification = "SELECT tag_id FROM BlogTags WHERE blog_id=$blog_identification";
                     $sqlquery = mysqli_query($db, $tag_identification);

                     $tags = '';

                     foreach($sqlquery as $p) {
                        $s = $p['tag_id'];
                        $tag_query = "SELECT tag_name FROM tags WHERE tag_id=$s";
                        $result2 = mysqli_query($db, $tag_query);
                        $tag_blog_name = $result2->fetch_array()[0] ?? '';

                        $tags .= $tag_blog_name . " ";
                        
                        // echo '<div class="tags">';
                        // echo '<p><strong>' . $tag_blog_name . '</strong></p>';
                        // echo '</div>';

                        //echo $tag_blog_name;
                     }
                     echo '<div class="tags">';
                     echo '<p><strong>' . $tags . '</strong></p>';
                     echo '</div>';
                  ?>
                  <div class="comments">
                     <?php

                        $blogId = $q['blog_id'];

                        $comments = "SELECT * FROM comment WHERE blog_id=$blogId";
                        $query1 = mysqli_query($db, $comments);

                        foreach($query1 as $q1) {

                           $sentiment = ($q1['sentiment'] == 0 ? 'Negative' : 'Positive');
                           $description = $q1['description'];

                           // Get username of commenter
                           $userId = $q1['user_id'];
                           $usernameQuery = "SELECT username FROM users WHERE user_id=$userId";
                           $result = mysqli_query($db, $usernameQuery);

                           $username = $result->fetch_array()[0] ?? '';

                           echo '<div class="comments-container">';
                           echo '<p class="username"><strong>' . $username . '</strong></p>';
                           echo '<p class="sentiment">' . $sentiment . '</p>';
                           echo '<p class="desc">' . $description . '</p>';
                           echo '</div>';

                        }

                     ?>
                  </div>
                  <form name="comment-form" action="Comment.php" method="post" style="margin: 10px auto;">
                     <input type="hidden" name="blog_id" id="blog_id" value=<?php echo $q['blog_id'];?>></input>
                     <input class="button" type="submit" value="Add comment"></input>
                  </form>
               </div>
            </div>
         <?php }?>
      </div>

      </div>
      <a href = "Blog.php"><button class="button">Create blog</button></a>
      <br />
      <a href = "index.html"><button class="button signout">Sign Out</button></a>
      <div class="footer">
         <ul>
            <li><a href="queries/Query1.php"><button>Query 1</button></a></li>
            <li><a href="queries/Query2.php"><button>Query 2</button></a></li>
            <li><a href="queries/Query3.php"><button>Query 3</button></a></li>
            <li><a href="queries/Query4.php"><button>Query 4</button></a></li>
            <li><a href="queries/Query5.php"><button>Query 5</button></a></li>
            <li><a href="queries/Query6.php"><button>Query 6</button></a></li>
            <li><a href="queries/Query7.php"><button>Query 7</button></a></li>
            <li><a href="queries/Query8.php"><button>Query 8</button></a></li>
            <li><a href="queries/Query9.php"><button>Query 9</button></a></li>
         </ul>
      </div>
      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   </body>
</html>