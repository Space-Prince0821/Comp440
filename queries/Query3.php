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
            p{
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
                $countArr = array();
                $query = "SELECT distinct user_id FROM blog WHERE date = '$currDate'";
                $result = mysqli_query($db, $query);
                foreach($result as $t) {
                    $curr_id = $t['user_id'];
                    $query2 = "SELECT COUNT(user_id) FROM blog WHERE user_id = '$curr_id'";
                    $result2 = mysqli_query($db, $query2);
                    $currCount = $result2->fetch_array()[0] ?? '';
                    array_push($countArr, $currCount);
                }
                $max = max($countArr);
                $query3 = "SELECT distinct user_id FROM blog WHERE date = '$currDate' GROUP BY user_id HAVING COUNT(date) = $max";
                $query3Result = mysqli_query($db, $query3);
                $test = $query3Result->fetch_array()[0] ?? '';
                $finalQuery = "SELECT username FROM users WHERE user_id = '$test'";
                $finalResult = mysqli_query($db, $finalQuery);
                $finalAnswer = $finalResult->fetch_array()[0] ?? '';
                echo '<p>' . $finalAnswer . ' posted the most blogs on 2022-05-01 </p>';
            ?>
            <a href="../welcome.php">
                <button>Return to Home</button>
            </a>
        </div>
    </body>
</html>