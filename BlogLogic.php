<?php
    session_start();
    include("Config.php");

    $sql = "SELECT * FROM blog";
    $query = mysqli_query($db, $sql);

    if (isset($_REQUEST["new_post"])) {
        $blog_title = $_REQUEST["blog_title"];
        $blog_desc = $_REQUEST["blog_desc"];
        $blog_tag = $_REQUEST["blog_tag"];
        $user_id = $_SESSION['sessionId'];
        $date = date('Y-m-d');
        //$current_date = CURDATE();

        $sql = "INSERT INTO blog(user_id, date, subject, description) VALUES('$user_id', '$date', '$blog_title', '$blog_desc')";
        mysqli_query($db, $sql);

        header("Location: welcome.php?success=newPost");
        exit();
    }
?>