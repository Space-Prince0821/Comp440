<?php
   include('BlogLogic.php');
?>
<html>
   <head>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
      <div class="row">

         <?php foreach($query as $q) {?>
            <div class="col-4 d-flex justify-content-center align-items-center">
               <div class="card text-white bg-dark mt-5">
                  <div class="card-body" style="width: 18rem;">
                     <h5 class="card-title"><?php echo $q['subject'];?></h5>
                     <p class="card-text"><?php echo $q['description'];?></p>
                  </div>
               </div>
            </div>
         <?php }?>
      </div>

      </div>
      <a href = "Blog.php"><button>Create blog</button></a>
      <br />
      <a href = "index.html"><button>Sign Out</button></a>
      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   </body>
</html>