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
    ?>
    <div class="body mr-4">
    <button type="button" class="btn btn-info mb-4 mt-4">
        <a href="addtest_form.php" style="text-decoration:none; color: white;">
        Add Test
        </a>
    </button>
    <?php
        $sql = "SELECT * FROM test";
        $result=$conn->query($sql);
        if($result->num_rows>0){
            echo "<table class='table table-bordered table-hover'>";
            echo "<tr>";
            echo "<th>Test id</th>".
                 "<th>Test name</th>".
                 "<th>Duration</th>".
                 "<th>Questions</th>".
                 "<th>Marks</th>".
                 "<th>Test Added</th>".
                 "<th></th>";
            echo "</tr>";
            while($test=$result->fetch_assoc()){
                echo "<tr>";
                echo "<td>".$test['test_id']."</td>".
                     "<td>".
                     "<a href='test_stats.php?test_id=".$test['test_id']."' >"
                     .$test['test_name'].
                     "</a></td>".
                     "<td>".$test['duration']."</td>".
                     "<td>".$test['ques_count']."</td>".
                     "<td>".$test['marks']."</td>".
                     "<td>".date("Y/m/d", strtotime($test['date_added']))."</td>".
                     "<td>
                        <a href='delete_test.php?test_id=".$test['test_id']."' style='text-decoration:none; color: white;' class='btn btn-danger mr-3'>
                            Delete <i class='far fa-trash-alt'></i>
                        </a>
                        <a href='modify_ques.php?test_id=".$test['test_id']."' style='text-decoration:none; color: white;' class='btn btn-primary mr-3'>
                            Modify <i class='far fa-edit'></i>
                        </a>
                        <a href='test_stats.php?test_id=".$test['test_id']."' style='text-decoration:none; color: white;' class='btn btn-warning'>
                            Stats <i class='far fa-chart-bar'></i>
                        </a>
                     </td>";
                echo "</tr>";
            }            
        }
        ?>
    </div>
</body>
</html>