<html>

<head>
    <meta charset="utf-8">
    <title>Query 1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-3">
        <h1>Query 1: Users who post at least two blogs with selected tags</h1>
        <form method="POST">
            <div class="form-floating mb-3">
                <select class="form-select-sm" id="floatingSelect1" aria-label="Floating label select example" name="tagForm">
                    <option selected>Select tag1</option>
                    <?php
                    include('../Config.php');
                    $query = "SELECT tag_name FROM tags";
                    $result = mysqli_query($db, $query);
                    foreach ($result as $r) {
                        $selTag1 = $r['tag_name'];
                        echo '<option value=' . $selTag1 . '>' . $selTag1 . '</option>';
                    }
                    ?>
                </select>

            </div>

            <div class="form-floating mb-3">
                <select class="form-select-sm" id="floatingSelect2" aria-label="Floating label select example" name="tagForm2">
                    <option selected>Select tag2</option>
                    <?php
                    include('../Config.php');
                    $query = "SELECT tag_name FROM tags";
                    $result = mysqli_query($db, $query);
                    foreach ($result as $r) {
                        $selTag2 = $r['tag_name'];
                        echo '<option value=' . $selTag2 . '>' . $selTag2 . '</option>';
                    }
                    ?>
                </select>

            </div>
            <button class=" btn btn-md btn-primary " type="submit">Search blog</button>

        </form>
        <ul class="list-group mb-3">
            <?php
            include("../Config.php");

            //These are the tags stores in variables once the user chooses from dropdown
            $tempArrForBlogId = array();
            $tempArrForUserId = array();
            $tempArrForAllUserIds = array();

            $selTag1Query = $_REQUEST["tagForm"];
            $selTag2Query = $_REQUEST["tagForm2"];

            //We get tag_id based on tag names chosen from dropdown
            $query1 = "SELECT tag_id FROM tags WHERE tag_name = '$selTag1Query'";
            $query1Res = mysqli_query($db, $query1);
            $tagID1 = $query1Res->fetch_array()[0] ?? '';
            $query2 = "SELECT tag_id FROM tags WHERE tag_name = '$selTag2Query'";
            $query2Res = mysqli_query($db, $query2);
            $tagID2 = $query2Res->fetch_array()[0] ?? '';

            //Putting all blog IDs that use the two tags in an array
            $blog_query = "SELECT blog_id FROM BlogTags WHERE tag_id = '$tagID1'";
            $blog_res = mysqli_query($db, $blog_query);
            foreach ($blog_res as $a) {
                $id = $a['blog_id'];
                array_push($tempArrForBlogId, $id);
            }
            $blog_query2 = "SELECT blog_id FROM BlogTags WHERE tag_id = '$tagID2'";
            $blog_res2 = mysqli_query($db, $blog_query2);
            foreach ($blog_res2 as $b) {
                $id2 = $b['blog_id'];
                array_push($tempArrForBlogId, $id2);
            }

            //Putting all user_ids using tags
            foreach ($tempArrForBlogId as $c) {
                $userID_query = "SELECT distinct user_id FROM blog WHERE blog_id = '$c'";
                $userID_res = mysqli_query($db, $userID_query);
                $curr_res = $userID_res->fetch_array()[0] ?? '';
                array_push($tempArrForUserId, $curr_res);
            }
            $tempArrForAllUserIds = array_unique($tempArrForUserId);

            //echo $tempArrForUserId[3];
            foreach ($tempArrForAllUserIds as $d) {
                if (count(array_keys($tempArrForUserId, $d)) > 1) {
                    $finalQ = "SELECT username FROM users WHERE user_id = '$d'";
                    $finalRes = mysqli_query($db, $finalQ);
                    $finalUserName = $finalRes->fetch_array()[0] ?? '';
                    echo '<li class="list-group-item">' . $finalUserName . '</li>';
                }
            }
            ?>
        </ul>
        <a href="../welcome.php">
            <button class=" btn btn-md btn-secondary " type="submit">Return to Home</button>
        </a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>