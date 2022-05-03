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
            ul {
                list-style-type: none;
                background-color: var(--blue);
                width: 40%;
                margin: 10px auto;
                padding: 10px;
            }
            li {
                display: inline-block;
                padding-right: 15px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <br>
            <h3 style="color: white;">Query 1: Users who post at least two blogs with selected tags</h3>
            <form method="POST">  
                <div>  
                    <label for="tagForm">Select tag 1: </label>  
                    <select name="tagForm">
                        <?php
                            include('../Config.php');
                            $query = "SELECT tag_name FROM tags";
                            $result = mysqli_query($db, $query);
                            foreach($result as $r){
                                $selTag1 = $r['tag_name'];
                                echo '<option>' . $selTag1 . '</option>';
                            }
                        ?>
                    </select>   
                </div>  
                <br>
                <div>  
                    <label for="tagForm2">Select tag 2: </label>  
                    <select name="tagForm2">
                        <?php
                            include('../Config.php');
                            $query = "SELECT tag_name FROM tags";
                            $result = mysqli_query($db, $query);
                            foreach($result as $r) {
                                $selTag2 = $r['tag_name'];
                                echo '<option>' . $selTag2 . '</option>';
                            }
                        ?>
                    </select>   
                </div>
                <p>     
                    <button name="search_tag">Click to search blog</button>  
                </p>  
            </form>
            <?php
                include("../Config.php");

                //These are the tags stores in variables once the user chooses from dropdown
                $selTag1Query = $_REQUEST["tagForm"]; 
                $selTag2Query = $_REQUEST["tagForm2"];
                echo '<p> Tag 1 Name: ' . $selTag1Query . '</p>';   
                echo '<p> Tag 2 Name: ' . $selTag2Query . '</p>';

                //We get tag_id based on tag names chosen from dropdown
                $query1 = "SELECT tag_id FROM tags WHERE tag_name = '$selTag1Query'";
                $query1Res = mysqli_query($db, $query1);
                $tagID1 = $query1Res->fetch_array()[0] ?? '';
                $query2 = "SELECT tag_id FROM tags WHERE tag_name = '$selTag2Query'";
                $query2Res = mysqli_query($db, $query2);
                $tagID2 = $query2Res->fetch_array()[0] ?? '';
                
                echo '<p> Tag 1 ID: ' . $tagID1 . '</p>';
                echo '<p> Tag 2 ID: ' . $tagID2 . '</p>';

                //Then I dont know what to do...
            ?>
            <a href="../welcome.php">
                <button>Return to Home</button>
            </a>
        </div>
    </body>
</html>