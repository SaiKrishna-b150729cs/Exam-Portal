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
            if(!($test && $test->num_rows > 0))
                $err = "Test Not Found";
            else
                $test = $test->fetch_assoc();
        }
        else{
            header("location: tests.php");
        }
    ?>
    <div class="body mr-4 mt-4">
        <span class="font-weight-bold"> Test Name: <?= $test['test_name'] ?></span><br>
        <span class="font-weight-bold"> Total score: <?= $test['marks'] ?></span>

        <?php
            if($err != ""){
                echo "<div class='text-center mx-auto'><h1>$err</h1></div>";
            }
            else{
        ?>
            <table class="table table-bordered table-hover">
                <tr>
                    <th>User</th>
                    <th>Score</th>
                    <th>Correct</th>
                    <th>Wrong</th>
                    <th>Time taken</th>
                    <th>Date</th>
                </tr>
                <?php while($stat = $stats->fetch_assoc()){ 
                    $user_id = $stat['user_id'];
                    $sql = "SELECT * FROM USER WHERE user_id='$user_id'";
                    $result = $conn->query($sql);
                    $user_name = $result->fetch_assoc()['name'] 
                    
                ?>
                    <tr>
                    <td><?= $user_name ?></td>
                    <td><?= $stat['score'] ?></td>
                    <td><?= $stat['correct'] ?></td>
                    <td><?= $stat['wrong'] ?></td>
                    <td><?= timeConvert($test['duration'] * 60 -  $stat['time_rem'])  ?></td>
                    <td><?= date("Y/m/d h:i", strtotime($stat['date']))?></td>
                    </tr>
        <?php
                }
            }

            function timeConvert($d){
                $d = (int)$d;
                $h = (int)($d / 3600);
                $m = (int)($d % 3600 / 60);
                $s = (int)($d % 3600 % 60);
                
                $hDisplay = $h > 0 ? ($h >= 10 ? $h : "0". $h ) . ":" : "";
                $mDisplay = ($m >= 10 ? $m : "0" . $m ) . ":";
                $sDisplay = ($s >= 10 ? $s : "0" . $s );
    
                return $hDisplay . $mDisplay . $sDisplay;
            }
        ?>            
            </table>


    </div>
</body>
</html>