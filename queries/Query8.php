<html>

<head>
    <meta charset="utf-8">
    <title>Query 8</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container mt-3">
        <h1>Display all the users who posted some comments, but each of them is negative.</h1>
        <ul class="list-group">

            <?php

            include "../Config.php";

            $query = "select username\n"
                . "from users\n"
                . "where user_id in (select user_id from comment where sentiment = 0)\n"
                . "and user_id not in (select user_id from comment where sentiment = 1);";

            $result = mysqli_query($db, $query);

            while ($users = $result->fetch_array()) {
                echo "<li class='list-group-item'>" . $users['username'] . "</li>";
            }

            ?>
        </ul>
        <a href="../welcome.php">
            <button class=" btn btn-md btn-primary my-2" type="submit">Return to Home</button>
        </a>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

</body>

</html>