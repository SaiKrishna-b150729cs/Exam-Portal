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
        include('user.php');
        include('../dbConnection.php');
    ?>
    <div class="body mr-4 mt-4">
    <?php
        $sql = "SELECT * FROM test";
        $result=$conn->query($sql);
        if($result->num_rows>0){
            echo "<table class='table table-bordered table-hover'>";
            echo "<tr>";
            echo "<th>Test name</th>".
                 "<th>Duration</th>".
                 "<th>Questions</th>".
                 "<th>Marks</th>".
                 "<th>Test Added</th>".
                 "<th></th>";
            echo "</tr>";
            while($test=$result->fetch_assoc()){
                echo "<tr>";
                echo "<td>".$test['test_name']."</td>".
                     "<td>".$test['duration']."</td>".
                     "<td>".$test['ques_count']."</td>".
                     "<td>".$test['marks']."</td>".
                     "<td>".date("Y/m/d", strtotime($test['date_added']))."</td>".
                     "<td>
                        <a href='take_test.php?test_id=".$test['test_id']."' style='text-decoration:none;' class='btn btn-warning mr-3 text-white'>
                            Start<i class='far fa-share-square'></i>
                        </a>
                     </td>";
                echo "</tr>";
            }            
        }
        ?>
    </div>
</body>
</html>