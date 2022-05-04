<?php
// session_start(); -> keeps throwing a warning
include("BlogLogic.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog home page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body class="container mt-3">
    <h1>Create blog post</h1>

    <form method="POST">
        <div class="mb-3">
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Subject" name="blog_title">
        </div>
        <div class="mb-3">
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Description" name="blog_desc">
        </div>
        <div class="mb-3">
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Tags" name="blog_tag"></textarea>
        </div>
        <button class=" btn btn-md btn-primary mb-3" name="new_post" type="submit">Create Blog</button>

    </form>
    <a href="welcome.php">
        <button class=" btn btn-md btn-secondary  " type="submit">Return to Home</button>
    </a>
    <!-- </div> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>