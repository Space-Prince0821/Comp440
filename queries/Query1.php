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
            <h3 style="color: white;">Query 1: Users who post at least two blogs</h3>
            <br>
            <?php 
                include("../Login.php");
                include("../Config.php");

                $query01 = "SELECT user_id FROM blog GROUP BY user_id HAVING COUNT(user_id) > 1";
                //For userID and username with 2 or more posts
                //Will have user IDs (1, 2, 3...)
                $result01 = mysqli_query($db, $query01);

                //For each user with 2 or more posts
                foreach($result01 as $p0) {
                    //Used to get username using user_id
                   $user_id0 = $p0['user_id'];

                   //Getting all blog_ids of users from blog table in order 
                   //to get tag_id from BlogTags table
                   //May contain more than one tag_id
                   $tags = "SELECT blog_id FROM blog WHERE user_id = $user_id0";
                   $tagsQuery = mysqli_query($db, $tags);

                   //For each blog_id, find tag_ids (Each blog may have one or more tags, may also have 0 tags)
                   foreach($tagsQuery as $p1) {
                    //Saving blog_id as param
                    $blog_id0 = $p1['blog_id'];
                    //get tag_ids from BlogTags table based on blog_id
                    $res = "SELECT tag_id FROM BlogTags WHERE blog_id = $blog_id0";
                    $resQuery = mysqli_query($db, $res);

                    //For each tag_id from the blog post, get tag name
                    foreach($resQuery as $p2) {
                        $tag_id0 = $p2['tag_id'];
                        $tagName = "SELECT tag_name FROM tags WHERE tag_id = $tag_id0";
                        $tagQuery2 = mysqli_query($db, $tagName);
                        $tagName2 = $tagQuery2->fetch_array()[0] ?? '';
                        echo '<button>' . $tagName2 . '</button>';
                    }
                   }
                   $userQuery = "SELECT username FROM users WHERE user_id = $user_id0";
                   $result02 = mysqli_query($db, $userQuery);
                   
                   $username_from_blog = $result02->fetch_array()[0] ?? '';
                   echo '<p><strong>' . $username_from_blog . '</strong></p>';
                }
            ?>
            <a href="../welcome.php">
                <button>Return to Home</button>
            </a>
        </div>
    </body>
</html>