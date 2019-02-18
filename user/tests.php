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
                        <a href='take_test.php?test_id=".$test['test_id']."' style='text-decoration:none; color: white;' class='btn btn-warning mr-3'>
                        Start
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