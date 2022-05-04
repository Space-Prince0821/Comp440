<html>

<head>
    <meta charset="utf-8">
    <meta charset="utf-8">
    <title>Query 6</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-3">
        <h1>Query 6: Users with no blogs posted</h1>
        <?php
        include("../Config.php");
        $numHobbies = 7;

        $query06 = "SELECT * FROM users
                            WHERE user_id NOT IN (SELECT user_id FROM blog)";

        $result06 = mysqli_query($db, $query06);

        foreach ($result06 as $resultRow) {
            echo '<li class="list-group-item">' . $resultRow['username'] . "</li>";
        }

        ?>
        <a href="../welcome.php">
            <button class=" btn btn-md btn-primary mt-3" type="submit">Return to Home</button>
        </a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>