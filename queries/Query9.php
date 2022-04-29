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
        </style>
    </head>
    <body>
        <div class="container">
            <p>Display those users such that all the blogs they posted so far never received any negative comments.</p>
            <?php

                include "../Config.php";

                $query = "SELECT count(*) FROM users";

                $result = mysqli_query($db, $query);

                $users = $result->fetch_array()[0] ?? '';

                echo "<p>" . $users . "</p>";

            ?>
            <br>
            <a href="../welcome.php">
                <button>Return to Home</button>
            </a>
        </div>
    </body>
</html>