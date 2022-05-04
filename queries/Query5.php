<html>

<head>
    <meta charset="utf-8">
    <title>Query 5</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container mt-3">
        <h1 >Query 5: Users with common hobbies</h1>
        <?php
        include("../Config.php");
        $query05 = "SELECT * from UserHobbies
                            GROUP BY hobby_id having COUNT(hobby_id)>1";
        $result = mysqli_query($db, $query05);

        foreach ($result as $resultRow) {
            $hob = $resultRow['hobby_id'];
            $sql = "SELECT username from users where user_id in
                            (SELECT user_id from UserHobbies where hobby_id=$hob)";
            $res = mysqli_query($db, $sql);
            foreach ($res as $row) {
                echo '<li class="list-group-item">Hobby ' . $resultRow['hobby_id'] . ": " . $row['username'] . "</li>";
            }
        }
        ?>
        <a href="../welcome.php">
            <button class=" btn btn-md btn-primary mt-3" type="submit">Return to Home</button>
        </a>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

</body>

</html>