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
        $err = "";
        if(isset($_GET['email'])){
            $email = $_GET['email'];
            // echo "<script> console.log(". json_encode($sql) .")</script>";

            $sql = "SELECT * FROM user WHERE email='$email'";        
            echo "<script> console.log(". json_encode($sql) .")</script>";
            $result = $conn->query($sql);
            if($result){
                echo "<script> console.log(". json_encode($result) .")</script>";
                $user_id = $result->fetch_assoc()['user_id'];
                $sql = "SELECT * FROM user_tests WHERE user_id='$user_id' ORDER BY score ";
                $stats = $conn->query($sql);
                if(!($stats && $stats->num_rows > 0)){
                    $err = "No Stats available for this user"; 
                }
                echo "<script> console.log(". json_encode($user_id) .")</script>";
                echo "<script> console.log(". json_encode($stats->fetch_assoc()) .")</script>";
            }
            else
                $err= "User not Found";
        }
        else{
            header("location: users.php");
        }
    ?>
    <div class="body mr-4 mt-4">
        <span class="font-weight-bold"> User: <?= $email ?></span>
        <?php
            if($err != ""){
                echo "<div class='text-center mx-auto'><h1>$err</h1></div>";
            }
            else{
        ?>
            <table class="table table-bordered table-hover">
                <tr>
                    <th>Test id</th>
                    <th>Score</th>
                    <th>Correct</th>
                    <th>Wrong</th>
                    <th>Time taken</th>
                    <th>Date</th>
                    <th></th>
                </tr>
                <?php while($stat = $stats->fetch_assoc()){
                        $test_id = $stat['test_id'];
                        $sql = "SELECT * FROM test WHERE test_id='$test_id' ";
                        $test = $conn->query($sql);
                        $test=$test->fetch_assoc();?>
                    <tr>
                    <td><?= $test['test_name'] ?></td>
                    <td><?= $stat['score'] ?></td>
                    <td><?= $stat['correct'] ?></td>
                    <td><?= $stat['wrong'] ?></td>
                    <td><?= timeConvert($test['duration'] * 60   -  $stat['time_rem'])  ?></td>
                    <td><?= date("Y/m/d h:i", strtotime($stat['date']))?></td>
                    <td>
                        <a href=<?= 'view_test.php?sess_id='.$stat['sess_id']?> style='text-decoration:none; color: white;' class='btn btn-warning mr-3'>
                            View Test<i class='far fa-share-square'></i>
                        </a>
                     </td>
                    </tr>
            </table>
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

    </div>
</body>
</html>