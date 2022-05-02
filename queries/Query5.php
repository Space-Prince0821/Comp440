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
                include("../Config.php");
                $tempArr = array();
                $query05 = "SELECT * from userhobbies
                            GROUP BY hobby_id having COUNT(hobby_id)>1";
                $result = mysqli_query($db, $query05);
                
                foreach($result as $resultRow) {
                    $hob = $resultRow['hobby_id'];
                    $sql = "SELECT username from users where user_id in
                            (SELECT * from userhobbies where hobby_id=$hob)";
                    $res = mysqli_query($db, $sql);
                    foreach($res as $resRow) { 
                        echo "<p>Hobby " . $resultRow['hobby_id'] .": ". $resRow['username'] . "</p>";
                    }   
                }
            ?>
            <a href="../welcome.php">
                <button>Return to Home</button>
            </a>
        </div>
    </body>
</html>