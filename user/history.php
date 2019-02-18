<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Tests List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" 
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" 
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" 
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" 
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

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
                $sql = "SELECT * FROM test WHERE test_id='".$row['test_id']."' ";
                $test = $conn->query($sql);
                $test = $test->fetch_assoc();
                echo "<tr>";
                echo "<td>".$row['test_name']."</td>".
                     "<td>".$row['score']."</td>".
                     "<td>".$row['correct']." / ". $test['marks'] ."</td>".
                     "<td>".$row['wrong']."</td>".
                     "<td>".$test['duration'] - $row['time_rem']."</td>".
                     "<td>".date("Y/m/d", strtotime($row['date_added']))."</td>".
                     "<td>
                        <a href='view_test.php?test_id=".$test['test_id']."' style='text-decoration:none; color: white;' class='btn btn-warning mr-3'>
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