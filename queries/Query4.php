<html>
<?php
include("../Config.php");
?>

<head>
    <meta charset="utf-8">
    <title>Query 4</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <h1 class="my-3">Query 4: Users who are followed by user X and user Y</h1>
        <form method="post" action="">
            <label class="form-label">User X</label>
            <input type="text" name="userx" class="form-control">
            <label class="form-label mt-3">User Y</label>
            <input type="text" name="usery" class="form-control">
            <button type="submit" class="btn btn-primary mt-3" name="submit">Submit</button>
        </form>
        <ul class="list-group mb-3">

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
            <button class=" btn btn-md btn-primary " type="submit">Return to Home</button>
        </a>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

</body>

</html>