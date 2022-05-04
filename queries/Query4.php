<html>
<?php
include("../Config.php");
?>

<head>
    <meta charset="utf-8">
    <title>Query 4</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1 class="my-3">Query 4: Users who are followed by user X and user Y</h1>
        <form method="post" action="">
            <input type="text" name="userx" class="form-control mb-3" placeholder="User X">
            <input type="text" name="usery" class="form-control" placeholder="User Y">
            <button type="submit" class="btn btn-primary mt-3" name="submit">Submit</button>
        </form>
        <ul class="list-group">

            <?php

            if (isset($_POST['submit'])) {

                $userx = $_POST['userx'];
                $usery = $_POST['usery'];

                $sql = "SELECT username from users
                            WHERE user_id in (SELECT follows_user_id
                                FROM follow
                                WHERE user_id in (select user_id from users where username=\"$userx\")
                                OR user_id in (select user_id from users where username=\"$usery\")
                                GROUP BY follows_user_id
                                HAVING count(*) > 1)";


                $result = mysqli_query($db, $sql);
                while ($users = $result->fetch_array()) {
                    echo '<li class="list-group-item">' . $users['username'] . "</li>";
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