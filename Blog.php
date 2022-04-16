<?php
    session_start();
    include("BlogLogic.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <title>Blog home page</title>
    </head>
    <body>
        <div class="container mt-5">
            <form method="POST">
                <input type="text" placeholder="Blog Subject" class="form-control bg-dark text-white my-3
                text-center" name="blog_title">
                <textarea class="form-control bg-dark text-white my-3" placeholder="Blog Description" 
                name="blog_desc"></textarea>
                <input type="text" placeholder="Blog tags" class="form-control bg-dark text-white my-3" 
                name="blog_tag"> 
                <button class="btn btn-dark" name="new_post">Post Blog</button>
            </form>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>