<html>

<head>
    <meta charset="utf-8">
    <title>Query 3</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-3">
        <h1>Query 3: Listing users who posted the most blogs on 05/04/2022 </h1>

        <?php
        include('../Config.php');

        $currDate = "2022-05-04";
        $countArr = array();
        $query = "SELECT distinct user_id FROM blog WHERE date = '$currDate'";
        $result = mysqli_query($db, $query);
        foreach ($result as $t) {
            $curr_id = $t['user_id'];
            $query2 = "SELECT COUNT(user_id) FROM blog WHERE user_id = '$curr_id' AND date = '$currDate'";
            $result2 = mysqli_query($db, $query2);
            $currCount = $result2->fetch_array()[0] ?? '';
            array_push($countArr, $currCount);
        }
        $max = max($countArr);
        $query3 = "SELECT distinct user_id FROM blog WHERE date = '$currDate' GROUP BY user_id HAVING COUNT(date) = $max";
        $query3Result = mysqli_query($db, $query3);
        foreach($query3Result as $z) {
            $userID = $z['user_id'];
            $finalQuery = "SELECT username FROM users WHERE user_id = '$userID'";
            $finalResult = mysqli_query($db, $finalQuery);
            $finalAnswer = $finalResult->fetch_array()[0] ?? '';
            echo '<h4>' . $finalAnswer . ' posted the most blogs on 2022-05-04 </h4>';
        }
        ?>
        <a href="../welcome.php">
            <button class=" btn btn-md btn-primary my-2" type="submit">Return to Home</button>
        </a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>