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
            button {
                background-color: var(--blue);
                margin: 10px;
                padding: 5px 10px;
                border: 2px solid white;
                color: white;
            }
            button:hover {
                cursor: pointer;
                opacity: 0.8;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h3>Query 7: Display all users who never posted a comment</h3>
            <br>
            <?php
                include('../Config.php');
                $query = "SELECT username FROM users WHERE user_id NOT IN (SELECT distinct user_id FROM comment)";
                $queryResult = mysqli_query($db, $query);
                foreach($queryResult as $p) {
                    echo '<p>' . $p['username'] . '</p>';
                }
            ?>
            <br>
            <a href="../welcome.php">
                <button>Return to Home</button>
            </a>
        </div>
    </body>
</html>