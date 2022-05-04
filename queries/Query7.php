<html>

<head>
    <meta charset="utf-8">
    <title>Query 7</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container mt-3">
        <h1 class="mb-4">Query 7: Display all users who never posted a comment</h1>
        <ul class="list-group">
            <?php
            include('../Config.php');
            $query = "SELECT username FROM users WHERE user_id NOT IN (SELECT distinct user_id FROM comment)";
            $queryResult = mysqli_query($db, $query);
            foreach ($queryResult as $p) {
                echo '<li class="list-group-item">' . $p['username'] . '</li>';
            }
            ?>
        </ul>

        <a href="../welcome.php">
            <button class=" btn btn-md btn-primary mt-3" type="submit">Return to Home</button>
        </a>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

</body>

</html>