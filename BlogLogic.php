<?php
    session_start();
    include("Config.php");

    //To view all posts in home page
    $sql = "SELECT * FROM blog";
    $query = mysqli_query($db, $sql);

    //Global variables to insert into blog 
    $user_id = $_SESSION['sessionId'];
    $date = date('Y-m-d');
    $counter = 0;
    $sql2 = "SELECT * FROM blog WHERE user_id = '$user_id'";
    $query2 = mysqli_query($db, $sql2);

    //Setting limit of 2 posts per user per day
    foreach($query2 as $q) {
        if($date == $q['date']) {
            $counter += 1;
        }
    }

    if (isset($_REQUEST["new_post"]) && $counter < 2) {
        //Getting params from user submission
        $blog_title = $_REQUEST["blog_title"];
        $blog_desc = $_REQUEST["blog_desc"];
        $blog_tag = $_REQUEST["blog_tag"];

        //Insert post info into blog table
        $sql = "INSERT INTO blog(user_id, date, subject, description) VALUES('$user_id', '$date', '$blog_title', '$blog_desc')";
        mysqli_query($db, $sql);

        //Insert tag name in tags table
        $sql2 = "INSERT INTO tags(tag_name) VALUES('$blog_tag')";
        mysqli_query($db, $sql2);

        //Get current blog id
        $sql4 = "SELECT * FROM blog";
        $query3 = mysqli_query($db, $sql4);
        $blog_id_number = '';
        foreach($query3 as $q) {
            if($blog_title == $q['subject'] && $blog_desc == $q['description']) {
                $blog_id_number = $q['blog_id'];
            }
        }

        //Get current tag id
        $sql5 = "SELECT * FROM tags";
        $query4 = mysqli_query($db, $sql5);
        $tag_id_number = '';
        foreach($query4 as $q2) {
            if($blog_tag == $q2['tag_name']) {
                $tag_id_number = $q2['tag_id'];
            }
        }

        //Inserting blog_id and tag_id for BlogTags table
        $sql3 = "INSERT INTO BlogTags(blog_id, tag_id) VALUES('$blog_id_number', '$tag_id_number')";
        mysqli_query($db, $sql3);

        header("Location: welcome.php?success=newPost");
        exit();
    }
?>