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
            $sql = "SELECT * FROM user WHERE email='$email'";
            $user = $conn->query($sql);
            if($user){
                $user = $user->fetch_assoc();
                $user_id = $user['user_id'];
                $sql = "SELECT * FROM user_tests WHERE user_id='$user_id' ORDER BY score ";
                $stats = $conn->query($sql);
                if(!($stats && $stats->num_rows > 0)){
                    $err = "No Stats available for this user"; 
                }
            }
            else
                $err= "User not Found";
        }
        else{
            header("location: admin.php");
        }
    ?>
    <div class="body mr-4 mt-4">
        <span class="font-weight-bold"> User: <?= $user['name'] ?></span>
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
                </tr>
                <?php while($stat = $stats->fetch_assoc()){
                        $test_id = $stat['test_id'];
                        $sql = "SELECT * FROM test WHERE test_id='$test_id' ";
                        $test = $conn->query($sql);
                        $test=$result->fetch_assoc();?>
                    <tr><?= $test['test_name'] ?></tr>
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