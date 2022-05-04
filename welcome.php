<?php
include('BlogLogic.php');
?>
<html>

<head>
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
   <title>Welcome </title>
   <style>

   </style>
</head>

<body>
   <div class="header mt-3">
      <nav class="navbar  navbar-expand-lg navbar-light bg-light fixed-top">
         <div class="container-fluid">
            <a class="navbar-brand">Welcome <?php echo $_SESSION['sessionUser'] ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
               <div class="navbar-nav">
                  <a class="nav-link active" aria-current="page" href="Blog.php">Create Blog</a>
                  <a class="nav-link" href="index.html">Sign Out</a>
               </div>
            </div>
         </div>
      </nav>
      <?php
      // session_start();
      if (isset($_SESSION['sessionId'])) {
         // echo "You are logged in as '$_SESSION[sessionUser]' <br />";
      } else {
         // echo "Home";
      }
      ?>
   </div>
   <div class="container-fluid d-flex flex-wrap justify-content-center pt-5">
      <?php foreach ($query as $q) { ?>
         <div class=" ">
            <div class="card m-3">
               <div class="card-body" style="width: 18rem;">
                  <h5 class="card-title"><strong><?php echo $q['subject']; ?></strong></h5>
                  <h6 class="card-subtitle mb-2 text-muted">
                     <?php
                     //Get username of commenter
                     $userId = $q['user_id'];
                     $usernameQuery = "SELECT username FROM users WHERE user_id=$userId";
                     $result = mysqli_query($db, $usernameQuery);

                     $username = $result->fetch_array()[0] ?? '';

                     echo $username;

                     ?>
                  </h6>

                  <!-- Description -->
                  <div class="accordion" id="accordionExample">
                     <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                           <button class=" btn btn-outline-primary accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="  <?php
                                                                                                                                                $blogID = $q['blog_id'];
                                                                                                                                                echo '#collapse' . $blogID;
                                                                                                                                                ?>" aria-expanded="true" aria-controls="<?php
                                                                                                                                                                                          $blogID = $q['blog_id'];
                                                                                                                                                                                          echo 'collapse' . $blogID;
                                                                                                                                                                                          ?>">
                              <i class="bi bi-chevron-down"></i> Description
                           </button>
                        </h2>
                        <div id="<?php
                                 $blogID = $q['blog_id'];
                                 echo 'collapse' . $blogID;
                                 ?>" class="accordion-collapse collapse hide" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                           <div class="accordion-body card-text">
                              <?php echo $q['description']; ?>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- Comments -->
                  <div class="comments">

                     <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                           <h2 class="accordion-header" id="headingOne">
                              <button class=" btn btn-outline-secondary accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="  <?php
                                                                                                                                                      $blogID = $q['blog_id'];
                                                                                                                                                      echo '#collapseComment' . $blogID;
                                                                                                                                                      ?>" aria-expanded="true" aria-controls="<?php
                                                                                                                                                                                                $blogID = $q['blog_id'];
                                                                                                                                                                                                echo 'collapseComment' . $blogID;
                                                                                                                                                                                                ?>">
                                 <i class="bi bi-chevron-down"></i> Comments
                              </button>
                           </h2>
                           <div id="<?php
                                    $blogID = $q['blog_id'];
                                    echo 'collapseComment' . $blogID;
                                    ?>" class="accordion-collapse collapse hide" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                              <div class="accordion-body card-text">
                                 <?php

                                 $blogId = $q['blog_id'];

                                 $comments = "SELECT * FROM comment WHERE blog_id=$blogId";
                                 $query1 = mysqli_query($db, $comments);

                                 foreach ($query1 as $q1) {

                                    $sentiment = ($q1['sentiment'] == 0 ? 'Negative' : 'Positive');
                                    $description = $q1['description'];

                                    // Get username of commenter
                                    $userId = $q1['user_id'];
                                    $usernameQuery = "SELECT username FROM users WHERE user_id=$userId";
                                    $result = mysqli_query($db, $usernameQuery);
                                    $username = $result->fetch_array()[0] ?? '';

                                    echo '<div class="d-flex">';
                                    echo '<h6 class="my-1">' . $username . '&nbsp;</h6>';
                                    echo $sentiment == 'Negative' ? ' <i class="bi bi-emoji-frown text-danger my-1">  </i>' : '<i class="bi bi-emoji-smile text-success my-1">  </i>';
                                    echo '<p >&nbsp;' . $description . '</p>';
                                    echo '</div>';
                                 }
                                 ?>
                              </div>
                           </div>
                        </div>
                     </div>

                  </div>
                  <form name="comment-form" action="Comment.php" method="post" style="margin: 10px auto;">
                     <input type="hidden" name="blog_id" id="blog_id" value=<?php echo $q['blog_id']; ?>></input>
                     <input class="btn btn-outline-success" type="submit" value="Add comment"></input>
                  </form>
               </div>


               <!-- Tags in footer -->
               <div class="card-footer bg-transparent border-success">Tags: <?php
                                                                              $blog_identification = $q['blog_id'];

                                                                              $tag_identification = "SELECT tag_id FROM BlogTags WHERE blog_id=$blog_identification";
                                                                              $sqlquery = mysqli_query($db, $tag_identification);
                                                                              $tags = '';
                                                                              $tag_blog_name = '';

                                                                              foreach ($sqlquery as $p) {
                                                                                 $s = $p['tag_id'];
                                                                                 $tag_query = "SELECT tag_name FROM tags WHERE tag_id=$s";
                                                                                 $result2 = mysqli_query($db, $tag_query);
                                                                                 $tag_blog_name = $result2->fetch_array()[0] ?? '';

                                                                                 $tags .= $tag_blog_name . ", ";
                                                                              }
                                                                              echo substr($tags, 0, strlen($tags) - 2);
                                                                              ?></div>

            </div>
         </div>
      <?php } ?>
   </div>

   </div>
   <footer class="py-3 my-4">
      <ul class="nav justify-content-center border-top pt-3 ">
         <li class="nav-item"><a href="queries/Query1.php" class="nav-link px-2 text-muted">Query 1</a></li>
         <li class="nav-item"><a href="queries/Query2.php" class="nav-link px-2 text-muted">Query 2</a></li>
         <li class="nav-item"><a href="queries/Query3.php" class="nav-link px-2 text-muted">Query 3</a></li>
         <li class="nav-item"><a href="queries/Query4.php" class="nav-link px-2 text-muted">Query 4</a></li>
         <li class="nav-item"><a href="queries/Query5.php" class="nav-link px-2 text-muted">Query 5</a></li>
         <li class="nav-item"><a href="queries/Query6.php" class="nav-link px-2 text-muted">Query 6</a></li>
         <li class="nav-item"><a href="queries/Query7.php" class="nav-link px-2 text-muted">Query 7</a></li>
         <li class="nav-item"><a href="queries/Query8.php" class="nav-link px-2 text-muted">Query 8</a></li>
         <li class="nav-item"><a href="queries/Query9.php" class="nav-link px-2 text-muted">Query 9</a></li>
      </ul>
   </footer>
   <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
</body>

</html>