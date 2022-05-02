<?php
    session_start();
    include('Config.php');
?>
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
                background-color: var(--blue);
                color: white;
            }
            div {
                width: 100%;
                text-align: center;
                margin-top: 20px;
            }
            h5 {
                font-size: 20px;
                margin-bottom: 0px;
            }
            p {
                padding: 0px 50px;
            }
            .container {
                margin-top: 20px;
                padding-top: 20px;
                border-top: 5px solid white;
                min-width: 400px;
            }
            .form-element {
                margin: 10px;
                background-color: var(--orange);
                color: white;
            }
            .description {
                width: 400px;
                height: 100px;
            }
            #btn {  
                color: white;  
                background: var(--orange);  
                padding: 7px 10px; 
                font-size: 16px;
            }
            #btn:hover {
                cursor: pointer;
                opacity: 0.8;
            }
        </style>
    </head>
    <body>
        <div>
            <?php
            if (isset($_POST['addComment'])) {

                if ($_SERVER["REQUEST_METHOD"] == "POST") {

                    $sentiment = $_POST['sentiment'];
                    $desc = htmlspecialchars($_POST['description']);
                    $blogId = $_POST['blogId'];
                    $blogUserId = $_POST['blogUserId'];

                    $userId = $_SESSION['sessionId'];

                    $currDate = date('Y-m-d');

                    // Check comments on current date
                    $dayCommentsQuery = "SELECT count(*) FROM comment WHERE user_id=$userId AND date='$currDate'";
                    $result1 = mysqli_query($db, $dayCommentsQuery);

                    $dayComments = $result1->fetch_array()[0] ?? '';

                    // Check comments on current blog
                    $blogCommentsQuery = "SELECT count(*) FROM comment WHERE user_id=$userId AND blog_id=$blogId";
                    $result2 = mysqli_query($db, $blogCommentsQuery);

                    $blogComments = $result2->fetch_array()[0] ?? '';

                    // at most 3 comments, 1 comment per blog, not own blog
                    if ($dayComments < 3) {

                        if ($blogComments == 0) {

                            if ($userId != $blogUserId) {

                                $sentimentBit = ($sentiment == "Positive" ? 1 : 0);

                                $addQuery = "INSERT INTO comment (blog_id, user_id, date, sentiment, description)
                                            VALUES ($blogId, $userId, '$currDate', $sentimentBit, '$desc')";

                                mysqli_query($db, $addQuery);

                                echo "Comment added!<br><br>";

                            } else {

                                echo "Cannot comment on own blog.<br><br>";

                            }

                        } else {

                            echo "Only 1 comment is allowed per blog.<br><br>";

                        }
                    } else {

                        echo "Daily comments limit reached.<br><br>";

                    }

                }

            } else {
            ?>
                <?php

                $blogId = "";              
                $blogUserId = "";

                // Display blog to add comment to
                if (isset($_POST['blog_id'])) {

                    $blogId = $_POST['blog_id'];
                    $blogQuery = "SELECT * FROM blog WHERE blog_id=$blogId";
                    $result = mysqli_query($db, $blogQuery);

                    $blog = $result->fetch_array() ?? '';
                    
                    echo "<h5>" . $blog['subject'] . "</h5>";
                    echo "<p>" . $blog['description'] . "</p>";

                    $blogUserId = $blog['user_id'];

                }
                ?>
                <div class="container comment">
                    <form name="comment-form" action="" method="post">
                        <select name="sentiment" class="form-element sentiment-option">
                            <option value="Positive" selected>Positive</option>
                            <option value="Negative">Negative</option>
                        </select>
                        <br />
                        <textarea name="description" class="form-element description"></textarea>
                        <br />
                        <input id="btn" type="submit" name="addComment" class="form-element" value="Add comment"></input>
                        <input type="hidden" name="blogId" value=<?php echo $blogId ?>></input>
                        <input type="hidden" name="blogUserId" value=<?php echo $blogUserId ?>></input>
                    </form>
                </div>
            <?php
            }
            ?>
            <a href="welcome.php">
                <button id="btn">Return to Home</button>
            </a>
        </div>
    </body>
</html>