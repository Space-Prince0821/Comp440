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
                $dateStmt = "SELECT distinct user_id FROM blog WHERE date = '$currDate'";
                $resultStmt = mysqli_query($db, $dateStmt);
                $countArr = array();
                foreach($resultStmt as $z) {
                    $currUser = $z['user_id'];
                    $getUsername = "SELECT username FROM users WHERE user_id = '$currUser'";
                    $getUsernameQuery = mysqli_query($db, $getUsername);
                    $actualUsername = $getUsernameQuery->fetch_array()[0] ?? '';
                    $count = 0;
                    $prepQuery = "SELECT blog_id FROM blog WHERE user_id = '$currUser'";
                    $resQuery = mysqli_query($db, $prepQuery);
                    foreach($resQuery as $r) {
                        $count = $count + 1;
                    }
                    array_push($countArr, $count);
                    echo '<p>' . $actualUsername . ' posted ' . $count . ' blogs on ' . $currDate . '</p>';
                }
                $maxBlogNum = max($countArr);
                $prep = "SELECT user_id FROM blog GROUP BY user_id HAVING COUNT(blog_id) = $maxBlogNum";
                $res = mysqli_query($db, $prep);
                $showRes = $res->fetch_array()[0] ?? '';
                $userWithMostPostsQueryStmt = "SELECT username FROM users WHERE user_id='$showRes'";
                $userWithMostPostsQueryStmtQuery = mysqli_query($db, $userWithMostPostsQueryStmt);
                $userWithMostPostsQueryStmtQueryResult = $userWithMostPostsQueryStmtQuery->fetch_array()[0] ?? '';
                echo '<p><strong> User "' . $userWithMostPostsQueryStmtQueryResult . '" has posted the most blogs on ' . $currDate . '</strong></p>'; 
            ?>
            <a href="../welcome.php">
                <button>Return to Home</button>
            </a>
        </div>
    </body>
</html>