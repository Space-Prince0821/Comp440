<html>
    <head>
        <meta charset="utf-8">
        <title>Comment</title>
        <style>
            :root {
                --blue: #095877;
                --orange: #f64e20;
            }
            body {
                margin: 0 auto;
                background-color: var(--orange);
                text-align: center;
                color: white;
            }
            p {
                margin: 10px;
            }
            button {
                background-color: var(--blue);
                margin: 10px;
                padding: 5px 10px;
                border: 2px solid white;
                color: white;
            }
            button:hover {
                cursor: pointer;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <p>Display those users such that all the blogs they posted so far never received any negative comments.</p>
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

                while($users = $result->fetch_array()) {
                    echo "<p>" . $users['username'] . "</p>";
                }

            ?>
            <br>
            <a href="../welcome.php">
                <button>Return to Home</button>
            </a>
        </div>
    </body>
</html>