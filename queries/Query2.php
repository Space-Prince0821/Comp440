<html>
    <head>
        <meta charset="utf-8">
        <title>Query2</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
            :root {
                --blue: #095877;
                --orange: #f64e20;
            }
            body {
                margin: 0;
                background-color: var(--blue);
                color: white;
                text-align: left;
            }
            .header {
                background-color: var(--orange);
                padding-bottom: 20px;
                border-bottom: 3px solid white;
            }
            h1 {
                padding: 20px;
            }
            .container {
                min-width: fit-content;
                padding: 20px;
                margin-top: -30px;
            }
            .card {
                min-width: 300px;
                background-color: var(--orange);
            }
            .comments {
                border-top: 2px solid white;
            }
            .comments-container {
                border-bottom: 2px solid white;
                padding: 0px 20px;
                padding-bottom: 5px;
            }
            .comments-container p {
                padding: 0;
                margin: 0;
            }
            .comments-container .username {
                font-size: 20px;
                text-decoration: underline;
            }
            .comments-container .sentiment {
                font-size: 12px;
                color: white;
                opacity: 0.6;
            }
            .tags {
                border-top: 2px solid white;
                text-align: center;
                padding-top: 10px;
            }
            .button {
                border-radius: 10px;
                color: white;
            }
            input[type="submit"] {
                background-color: var(--blue);
                padding: 5px 10px;
                border: 2px solid white;
            }
            button {
                background-color: var(--orange);
                margin: 10px;
                padding: 5px 10px;
                border: 2px solid white;
                color: white;
            }
            .footer {
                border-top: 3px solid white;
                margin-top: 10px;
                padding-top: 10px;
                background-color: var(--orange);
                padding-bottom: 2px;
                margin-bottom: -16px;
            }
            ul {
                list-style-type: none;
            }
            li {
                display: inline-block;
            }
            li button {
                width: 100px;
                background-color: var(--blue);
                border-radius: 10px;
            }
            button:hover {
                cursor: pointer;
                opacity: 0.8;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <br>
            <h3 style="color: white;">Query 2: Find all blogs of user X with only positive comments</h3>
            <form method="POST">  
                <p>  
                    <label>Enter username: </label>  
                    <input type="text" name="user00"/>  
                </p>  
                <p>     
                    <button name="new_search">Search</button>  
                </p>  
            </form>
            <a href="../welcome.php">
                <button>Return to Home</button>
            </a>
            <?php
                include('../Config.php');
                $inputName = $_REQUEST["user00"];
                $sqlStmt = "SELECT user_id FROM users WHERE username='$inputName'";
                $sqlStmtQuery = mysqli_query($db, $sqlStmt);
                $sqlStmtQueryResult = $sqlStmtQuery->fetch_array()[0] ?? '';

                //get blog ids for each user
                $getBlog = "SELECT blog_id FROM blog WHERE user_id = $sqlStmtQueryResult";
                $getBlogQuery = mysqli_query($db, $getBlog);
                $getBlogQueryResult = $getBlogQuery->fetch_array()[0] ?? '';

                foreach($getBlogQuery as $g){
                    $blogID = $g['blog_id'];
                    $mood = 1;

                    $senQuery = "SELECT sentiment FROM comment WHERE blog_id='$blogID'";
                    $senResult = mysqli_query($db, $senQuery);
                    //check for negative comments
                    foreach($senResult as $z){
                        if($z['sentiment'] == 0) {
                            $mood = 0; 
                        }
                    }
                    if($mood != 0) {
                        $sqlStmt2 = "SELECT * FROM blog WHERE blog_id = '$blogID'";
                        $sqlStmtQuery2 = mysqli_query($db, $sqlStmt2);
                        foreach($sqlStmtQuery2 as $g2) {
                            echo '<div class=row>';
                            echo '<div class="col-4 d-flex justify-content-center align-items-center container">';
                            echo '<div class="card text-white mt-5">';
                            echo '<div class="card-body" style="width: 18rem;">';
                            echo '<h5 class="card-title"><strong>' . $g2['subject'] . '</strong></h5>';
                            echo '<p class="card-text" style="font-size: 12px;">' . $inputName . '</p>';
                            echo '<p class="card-text">' . $g2['description'] . '</p>';
                            $tag_identification = "SELECT tag_id FROM BlogTags WHERE blog_id=$blogID";
                            $sqlquery = mysqli_query($db, $tag_identification);
                            $tags = '';

                            foreach($sqlquery as $p) {
                                $s = $p['tag_id'];
                                $tag_query = "SELECT tag_name FROM tags WHERE tag_id=$s";
                                $result2 = mysqli_query($db, $tag_query);
                                $tag_blog_name = $result2->fetch_array()[0] ?? '';

                                $tags .= $tag_blog_name . " ";
                            }
                            echo '<div class="tags">';
                            echo '<p><strong>' . $tags . '</strong></p>';
                            echo '</div>';
                            echo '<div class="comments">';
                            $comments = "SELECT * FROM comment WHERE blog_id=$blogID";
                            $query1 = mysqli_query($db, $comments);

                            foreach($query1 as $q1) {
                            $sentiment = ($q1['sentiment'] == 0 ? 'Negative' : 'Positive');
                            $description = $q1['description'];

                            // Get username of commenter
                            $userId = $q1['user_id'];
                            $usernameQuery = "SELECT username FROM users WHERE user_id=$userId";
                            $result = mysqli_query($db, $usernameQuery);

                            $username = $result->fetch_array()[0] ?? '';

                            echo '<div class="comments-container">';
                            echo '<p class="username"><strong>' . $username . '</strong></p>';
                            echo '<p class="sentiment">' . $sentiment . '</p>';
                            echo '<p class="desc">' . $description . '</p>';
                            echo '</div>';
                            }
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                }
            ?>
            <br>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>