<html>

<head>
    <meta charset="utf-8">
    <title>Query 2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
</head>

<body>
    <div class="container mt-3">
        <h1>Query 2: Find all blogs of user X with only positive comments</h1>
        <form method="POST" class="mt-3">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Search username" aria-label="Search username" aria-describedby="basic-addon" name="user00">
                <button class=" btn btn-md btn-outline-primary " id="button-addon" name="new_search">Search</button>

            </div>
        </form>
        <a href="../welcome.php">
            <button class=" btn btn-md btn-primary " type="submit">Return to Home</button>
        </a>
    </div>
    <div class="container-fluid d-flex flex-wrap justify-content-center">
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

        foreach ($getBlogQuery as $g) {
            $blogID = $g['blog_id'];
            $mood = 1;

            $senQuery = "SELECT sentiment FROM comment WHERE blog_id='$blogID'";
            $senResult = mysqli_query($db, $senQuery);
            //check for negative comments
            foreach ($senResult as $z) {
                if ($z['sentiment'] == 0) {
                    $mood = 0;
                }

                if ($mood != 0) {
                    $sqlStmt2 = "SELECT * FROM blog WHERE blog_id = '$blogID'";
                    $sqlStmtQuery2 = mysqli_query($db, $sqlStmt2);

                    foreach ($sqlStmtQuery2 as $g2) { ?>
                        <div class="card m-3">
                            <div class="card-body" style="width: 20rem;">
                                <h5 class="card-title"><strong><?php echo $g2['subject']; ?></strong></h5>
                                <h6 class="card-subtitle mb-2 text-muted">
                                    <?php
                                    //Get username of commenter`
                                    $userId = $g2['user_id'];
                                    $usernameQuery = "SELECT username FROM users WHERE user_id=$userId";
                                    $result = mysqli_query($db, $usernameQuery);

                                    $username = $result->fetch_array()[0] ?? '';

                                    echo $username;

                                    ?>
                                </h6>

                                <!-- Description -->
                                <div class="accordion accordion-flush mb-2" id="accordionExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class=" btn btn-outline-primary accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="  <?php
                                                                                                                                                                $blogID = $g2['blog_id'];
                                                                                                                                                                echo '#collapse' . $blogID;
                                                                                                                                                                ?>" aria-expanded="true" aria-controls="<?php
                                                                                                                                                                                                        $blogID = $g2['blog_id'];
                                                                                                                                                                                                        echo 'collapse' . $blogID;
                                                                                                                                                                                                        ?>">
                                                Description
                                            </button>
                                        </h2>
                                        <div id="<?php
                                                    $blogID = $g2['blog_id'];
                                                    echo 'collapse' . $blogID;
                                                    ?>" class="accordion-collapse collapse hide" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body card-text">
                                                <?php echo $g2['description']; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Comments -->
                                <div class="comments">

                                    <div class="accordion accordion-flush" id="accordionExample">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingOne">
                                                <button class=" btn btn-outline-secondary accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="  <?php

                                                                                                                                                                        echo '#collapseComment' . $blogID;
                                                                                                                                                                        ?>" aria-expanded="true" aria-controls="<?php

                                                                                                                                                                                                                echo 'collapseComment' . $blogID;
                                                                                                                                                                                                                ?>">
                                                    Comments
                                                </button>
                                            </h2>
                                            <div id="<?php

                                                        echo 'collapseComment' . $blogID;
                                                        ?>" class="accordion-collapse collapse hide" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                <div class="accordion-body card-text">
                                                    <?php

                                                    $blogId = $g2['blog_id'];

                                                    $comments = "SELECT * FROM comment WHERE blog_id=$blogId";
                                                    $query1 = mysqli_query($db, $comments);

                                                    foreach ($query1 as $q1) {

                                                        $sentiment = ($q1['sentiment'] == 0 ? 'Negative' : 'Positive');
                                                        $description = $q1['description'];

                                                        // Get username of commenter
                                                        $userId = $q1['user_id'];
                                                        $usernameQuery = "SELECT username FROM users WHERE user_id=$userId";
                                                        $result = mysqli_query($db, $usernameQuery);
                                                        $username = $result->fetch_array()[0] ?? '';

                                                        echo '<div class="d-flex">';
                                                        echo '<h6 class="my-1">' . $username . '&nbsp;</h6>';
                                                        echo $sentiment == 'Negative' ? ' <i class="bi bi-emoji-frown text-danger my-1">  </i>' : '<i class="bi bi-emoji-smile text-success my-1">  </i>';
                                                        echo '<p >&nbsp;' . $description . '</p>';
                                                        echo '</div>';
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <!-- Tags in footer -->
                            <div class="card-footer bg-transparent border-success">Tags:
                                <?php
                                $blog_identification = $blogId;

                                $tag_identification = "SELECT tag_id FROM BlogTags WHERE blog_id=$blog_identification";
                                $sqlquery = mysqli_query($db, $tag_identification);
                                $tags = '';
                                $tag_blog_name = '';

                                foreach ($sqlquery as $p) {
                                    $s = $p['tag_id'];
                                    $tag_query = "SELECT tag_name FROM tags WHERE tag_id=$s";
                                    $result2 = mysqli_query($db, $tag_query);
                                    $tag_blog_name = $result2->fetch_array()[0] ?? '';

                                    $tags .= $tag_blog_name . ", ";
                                }
                                echo substr($tags, 0, strlen($tags) - 2);
                                ?></div>
                        </div>
    </div>
<?php
                    }
                }
            }
        }
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</div>
</body>

</html>