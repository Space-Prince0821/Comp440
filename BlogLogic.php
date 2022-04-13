<?php
    include("Config.php");

    if (isset($_REQUEST["new_post"])) {
        $blog_title = $_REQUEST["blog_title"];
        $blog_desc = $_REQUEST["blog_desc"];
        $blog_tag = $_REQUEST["blog_tag"];

        $sql = "INSERT INTO blog(subject, description) VALUES('$blog_title', '$blog_desc')";
        mysqli_query($db, $sql);

        header("Location: welcome.php");
        exit();
    }
?>