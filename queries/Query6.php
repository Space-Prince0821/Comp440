<html>
    <head>
        <meta charset="utf-8">
        <meta charset="utf-8">
        <title>Query1</title>
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
            <h3 style="color: white;">Query 6: Users with no blogs posted</h3>
            <br>
            <?php 
                include("../Config.php");
                $numHobbies = 7;

                $query06 = "SELECT * FROM users
                            WHERE user_id NOT IN (SELECT user_id FROM blog)";

                $result06 = mysqli_query($db, $query06);
                
                foreach($result06 as $resultRow) {
                    echo "<p>" . $resultRow['username'] . "</p>";
                }
                
            ?>
            <a href="../welcome.php">
                <button>Return to Home</button>
            </a>
        </div>
    </body>
</html>