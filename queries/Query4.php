<html>
    <?php
        include("../Config.php");
    ?>
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
            }
            button {
                background-color: var(--blue);
                margin: 10px;
                padding: 5px 10px;
                border: 2px solid white;
                color: white;
            }
        </style>
    </head>
    <body>
    <div class="container">
            <br>
            <h3 style="color: white;">Query 4: Users who are followed by user X  and user Y</h3>
            <br>
            <?php 
                $sql = "SELECT username from users
                        WHERE user_id in (SELECT follows_user_id
                            FROM follow
                            WHERE user_id in (select user_id from users where username='brandon')
                            OR user_id in (select user_id from users where username='prince')
                            GROUP BY follows_user_id
                            HAVING count(*) > 1)";


                $result = mysqli_query($db, $sql);

                while($users = $result->fetch_array()) {
                    echo "<p>" . $users['username'] . "</p>";
                }
            ?>
            <a href="../welcome.php">
                <button>Return to Home</button>
            </a>
        </div>
    </body>
</html>