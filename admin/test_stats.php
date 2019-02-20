<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Tests List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>
    <?php
        include('admin.php');
        include('../dbConnection.php');
        if(isset($_GET['test_id'])){
            $test_id = $_GET['test_id'];
            $sql = "SELECT * FROM user_tests WHERE test_id='$test_id' ORDER BY score ";
            $stats = $conn->query($sql);
            $err = "";
            if(!($stats && $stats->num_rows > 0)){
                $err = "No Stats available for this test"; 
            }
            $sql = "SELECT * FROM test WHERE test_id='$test_id' ";
            $test = $conn->query($sql);
            if(!($test && $test->num_rows > 0)){
                $err = "Test Not Found";
            }
            else
            $test = $test->fetch_assoc();
        }
        else{
            header("location: admin.php");
        }
    ?>
    <div class="body mr-4 mt-4">
        <span class="font-weight-bold"> Test Name: <?= $test['test_name'] ?></span>
        <?php
            if($err != ""){
                echo "<div class='text-center mx-auto'><h1>$err</h1></div>";
            }
            else{
        ?>
            <table class="table table-bordered table-hover">
                <tr>
                    <th>User_id</th>
                    <th>Score</th>
                    <th>Correct</th>
                    <th>Wrong</th>
                    <th>Time taken</th>
                    <th>Date</th>
                </tr>
                <?php while($stat = $stats->fetch_assoc()){ ?>
                    <tr><?= $stat['user_id'] ?></tr>
                    <tr><?= $stat['score'] ?></tr>
                    <tr><?= $stat['correct'] ?></tr>
                    <tr><?= $stat['wrong'] ?></tr>
                    <tr><?= $test['duration'] -  $stat['time_rem']  ?></tr>
                    <tr><?= date("Y/m/d", strtotime($stat['date']))?></tr>
            </table>


        <?php
                }
            }
        ?>

    </div>
</body>
</html>