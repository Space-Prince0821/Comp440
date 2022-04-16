<?php
    session_start();
    include("Config.php");

    $sql = "SELECT * FROM blog";
    $query = mysqli_query($db, $sql);

    $user_id = $_SESSION['sessionId'];
    $date = date('Y-m-d');
    $counter = 0;
    $sql2 = "SELECT * FROM blog WHERE user_id = '$user_id'";
    $query2 = mysqli_query($db, $sql2);


    foreach($query2 as $q) {
        if($date == $q['date']) {
            $counter += 1;
        }
    }

    if (isset($_REQUEST["new_post"]) && $counter < 2) {
        $blog_title = $_REQUEST["blog_title"];
        $blog_desc = $_REQUEST["blog_desc"];
        $blog_tag = $_REQUEST["blog_tag"];

        $sql = "INSERT INTO blog(user_id, date, subject, description) VALUES('$user_id', '$date', '$blog_title', '$blog_desc')";
        mysqli_query($db, $sql);

        header("Location: welcome.php?success=newPost");
        exit();
    }
?>