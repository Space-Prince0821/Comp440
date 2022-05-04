<html>

<head>
    <meta charset="utf-8">
    <title>Query 3</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container mt-3">
        <h1>Query 3: Listing users who posted the most blogs on 05/01/2022 </h1>

        <?php
        include('../Config.php');

        $currDate = "2022-05-01";
        $countArr = array();
        $query = "SELECT distinct user_id FROM blog WHERE date = '$currDate'";
        $result = mysqli_query($db, $query);
        foreach ($result as $t) {
            $curr_id = $t['user_id'];
            $query2 = "SELECT COUNT(user_id) FROM blog WHERE user_id = '$curr_id'";
            $result2 = mysqli_query($db, $query2);
            $currCount = $result2->fetch_array()[0] ?? '';
            array_push($countArr, $currCount);
        }
        $max = max($countArr);
        $query3 = "SELECT distinct user_id FROM blog WHERE date = '$currDate' GROUP BY user_id HAVING COUNT(date) = $max";
        $query3Result = mysqli_query($db, $query3);
        $test = $query3Result->fetch_array()[0] ?? '';
        $finalQuery = "SELECT username FROM users WHERE user_id = '$test'";
        $finalResult = mysqli_query($db, $finalQuery);
        $finalAnswer = $finalResult->fetch_array()[0] ?? '';
        echo '<h4>' . $finalAnswer . ' posted the most blogs on 2022-05-01 </h4>';
        ?>
        <a href="../welcome.php">
            <button class=" btn btn-md btn-primary my-2" type="submit">Return to Home</button>
        </a>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
</body>

</html>