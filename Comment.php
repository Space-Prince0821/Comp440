<?php
session_start();
include('Config.php');
?>
<html>

<head>
    <meta charset="utf-8">
    <title>Comment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body class="container my-3 ">
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

                echo "<h1 class='mb-2'>Daily comment limit reached.</h1";
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

            echo "<h1 class='text-center'>" . $blog['subject'] . "</h1>";
            echo "<p>" . $blog['description'] . "</p>";

            $blogUserId = $blog['user_id'];
        } ?>

        <div>
            <form name="comment-form" action="" method="post">
                <div class="form-floating mb-3">
                    <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="sentiment">
                        <option value="Positive" selected>Positive</option>
                        <option value="Negative">Negative</option>
                    </select>
                    <label for="floatingSelect">Select sentiment</label>
                </div>
                <div class="form-floating">
                    <textarea class="form-control" placeholder="Comment description" id="floatingTextarea2" style="height: 100px" name="description"></textarea>
                    <label for="floatingTextarea2">Comment description</label>
                </div>
                <button class=" btn btn-md btn-primary my-3" type="submit" value="Add comment" id="btn" name="addComment">Add comment</button>

                <input type="hidden" name="blogId" value=<?php echo $blogId ?>></input>
                <input type="hidden" name="blogUserId" value=<?php echo $blogUserId ?>></input>
            </form>
        </div>
    <?php
    }
    ?>
    <a href="welcome.php">
        <button class=" btn btn-md btn-secondary my-3 " type="submit">Return to Home</button>
    </a>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>