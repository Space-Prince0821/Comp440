<html>
    <head>
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
            <h3 style="color: white;">Query 5: Users with common hobbies</h3>
            <br>
            <?php

                // select A.username, B.username
                // from users as A, users as B
                // where (A.user_id, B.user_id) in (
                // select A.user_id, B.user_id
                // from userhobbies as A, userhobbies as B
                // where A.user_id in (select user_id from userhobbies where hobby_id in (select hobby_id from userhobbies group by hobby_id having count(*) > 1))
                // and A.hobby_id = B.hobby_id
                // and A.user_id != B.user_id
                // and A.user_id < B.user_id);

                include("../Config.php");
                $tempArr = array();
                $query05 = "SELECT * from userhobbies
                            GROUP BY hobby_id having COUNT(hobby_id)>1";
                $result = mysqli_query($db, $query05);
                
                foreach($result as $resultRow) {
                    $hob = $resultRow['hobby_id'];
                    $sql = "SELECT username from users where user_id in
                            (SELECT user_id from userhobbies where hobby_id=$hob)";
                    $res = mysqli_query($db, $sql);
                    foreach($res as $row) {
                        echo "<p>Hobby " . $resultRow['hobby_id'] .": ". $row['username'] . "</p>";
                    }   
                }
            ?>
            <a href="../welcome.php">
                <button>Return to Home</button>
            </a>
        </div>
    </body>
</html>