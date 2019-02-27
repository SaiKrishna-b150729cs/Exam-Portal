<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Test History</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>
    <?php
        include('user.php');
        include('../dbConnection.php');
    ?>
    <div class="body mr-4 mt-4">
    <?php
        $email = $_SESSION['email'];
        $sql = "SELECT user_id FROM user WHERE email='$email'";
        $result = $conn->query($sql);
        $user_id = $result->fetch_assoc()['user_id'];
        
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

        // echo "<script>console.log('". timeConvert(70) ."')</script>";

        

        $sql = "SELECT * FROM user_tests WHERE user_id='$user_id'";
        $result = $conn->query($sql);
        
        if($result->num_rows>0){
            echo "<table class='table table-bordered table-hover'>";
            echo "<tr>";
            echo "<th>Test name</th>".
                 "<th>Score</th>".
                 "<th>Correct</th>".
                 "<th>Wrong</th>".
                 "<th>Time Taken</th>".
                 "<th>Test Date</th>".
                 "<th></th>";
            echo "</tr>";
            while($row=$result->fetch_assoc()){
                $sql = "SELECT * FROM test WHERE test_id=".$row['test_id']." ";
                $test = $conn->query($sql);
                $test = $test->fetch_assoc();
                // echo "<script>console.log(". $row['test_id'] .")</script>";
                // echo "<script>console.log(". $test['duration'] .")</script>";
                // echo "<script>console.log(". $row['time_rem'] / 60 .")</script>";

                $time = timeConvert($test['duration'] * 60 - $row['time_rem']);
                
                echo "<tr>";
                echo "<td>".$test['test_name']."</td>".
                     "<td>".$row['score']." / ". $test['marks'] ."</td>".
                     "<td>".$row['correct']." </td>".
                     "<td>".$row['wrong']."</td>".
                     "<td>".$time."</td>".
                     "<td>".date("Y/m/d h:i", strtotime($row['date']))."</td>".
                     "<td>
                        <a href='view_test.php?sess_id=".$row['sess_id']."' style='text-decoration:none; color: white;' class='btn btn-warning mr-3'>
                        View Test
                        <i class='far fa-share-square'></i>
                        </a>
                     </td>";
                echo "</tr>";
            }            
        }
        ?>
    </div>
</body>
</html>