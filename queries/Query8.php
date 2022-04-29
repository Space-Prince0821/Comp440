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
            <p>Display all the users who posted some comments, but each of them is negative.</p>
            <?php

                include "../Config.php";

                $query = "select username\n"
                        . "from users\n"
                        . "where user_id in (select user_id from comment where sentiment = 0)\n"
                        . "and user_id not in (select user_id from comment where sentiment = 1);";

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