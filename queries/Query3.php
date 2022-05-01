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
            <button>Query 3: Listing users who posted the most blogs on 05/01/2022 </button>
            <br>
            <?php
                include('../Config.php');
                $currDate = "2022-05-01";
                $dateStmt = "SELECT user_id FROM blog WHERE date = '$currDate'";
                $resultStmt = mysqli_query($db, $dateStmt);
                foreach($resultStmt as $z) {
                    echo '<p>' . $z['user_id'] . '</p>';
                }
            ?>
            <a href="../welcome.php">
                <button>Return to Home</button>
            </a>
        </div>
    </body>
</html>