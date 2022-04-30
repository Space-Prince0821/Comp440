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

            <form name="form" action="" method="get">
                <input type="text" name="userX" id="userX" value="">
                <input type="text" name="userY" id="userY" value="">
                <br>
                <input type="submit" name="submit" />
            

            <?php 
                // $userX = $_REQUEST['userX'];
                // $userY = $_REQUEST['userY'];
                // $id_X='';
                // $id_Y='';

                // $getUlist = "SELECT * FROM users 
                // WHERE username=$userX AND username=$userY";
                // $uResult = mysqli_query($db, $getUlist);
            
                if(isset($_POST['submit']) && isset($_GET["userX"]) && 
                         $_GET["userX"] != "" && isset($_GET["userY"]) && 
                         $_GET["userY"] != "") {
                    echo 'works';

                    $userX = $_REQUEST['userX'];
                    $userY = $_REQUEST['userY'];
                    $id_X='';
                    $id_Y='';

                    $getUlist = "SELECT * FROM users 
                    WHERE username=$userX AND username=$userY";
                    $uResult = mysqli_query($db, $getUlist);
                    
                    foreach($uResult as $uResultRow) {
                        $temp_id = $uResultRow['user_id'];
                        if($uResultRow['username'] == $userX) {
                            $id_X = $uResultRow['user_id'];
                        }
                        if($uResultRow['username'] == $userY) {
                            $id_Y = $uResultRow['user_id'];
                        }

                        $sql = "SELECT * FROM follow GROUP BY user_id 
                        HAVING COUNT(user_id) > 1 
                        AND follows_user_id=$id_X OR follows_user_id=$id_Y";
                        $result = mysqli_query($db, $sql);
    
                        foreach($result as $resultRow) {
                            echo $userX . ' and ' . $userY . ' follow: ' . 
                            '<button>' . $resultRow['username'] . '</button>';
                        }
                        
                    }
                }

                
            ?>
            </form>
            <a href="../welcome.php">
                <button>Return to Home</button>
            </a>
        </div>
    </body>
</html>