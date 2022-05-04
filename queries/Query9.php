<html>

<head>
    <meta charset="utf-8">
    <title>Query 9</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <ul class="container mt-3">
        <h1>Display the users such that all the blogs they posted so far never received any negative comments.</h1>
        <ul class="list-group">
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
    </ul>
        <a href="../welcome.php">
            <button class=" btn btn-md btn-primary mt-3" type="submit">Return to Home</button>
        </a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>