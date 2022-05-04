<html>

<head>
    <meta charset="utf-8">
    <title>Query 9</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container mt-3">
        <h1>Display those users such that all the blogs they posted so far never received any negative comments.</h1>
        <?php

        include "../Config.php";

        // testing
        // select distinct user_id
        // from blog
        // where (blog_id in (select blog_id from comment group by blog_id having max(sentiment = 0) = 0)
        // and user_id not in (select user_id from blog where blog_id in (select blog_id from comment where sentiment = 0)))
        // or blog_id not in (select blog_id from comment);

        $query = "select username 
                          from users 
                          where user_id in (select distinct user_id 
                                            from blog 
                                            where user_id not in (select user_id 
                                                                  from blog 
                                                                  where blog_id in (select blog_id 
                                                                                    from comment 
                                                                                    where sentiment = 0)) 
                                                                                    or blog_id not in (select blog_id 
                                                                                                       from comment))";

        $result = mysqli_query($db, $query);

        while ($users = $result->fetch_array()) {
            echo '<li class="list-group-item">' . $users['username'] . "</li>";
        }

        ?>
        <a href="../welcome.php">
            <button class=" btn btn-md btn-primary mt-3" type="submit">Return to Home</button>
        </a>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

</body>

</html>