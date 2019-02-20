<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Add Test</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="../scripts.js"></script>
</head>
<body>
    
    <?php
        include('admin.php');
        include('../dbConnection.php');
        $test_name = "";
        $duration = "";
        $ques_count = "";
        if(isset($_POST['add_test'])){
            $test_name = $_POST['name'];
            $duration = $_POST['duration'];
            $ques_count = $_POST['count'];
            $sql = "INSERT INTO test (test_name, duration, ques_count) VALUES('".$test_name."', '".$duration."', '".$ques_count."')";
            $result=$conn->query($sql);
            if ($result) {
                $test_id = $conn->insert_id;
                $_SESSION['test_id'] = $test_id;
                header("location: add_test.php");
            }
        }
    ?>
    <div class="body">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onSubmit="return validateaddtestForm()" method="POST" name="addtest_form">
            <div class="form-group">
                <label for="name">Test Name: </label>
                <input type="text"  id="name" name="name" placeholder="Enter Test Name" class="form-control" value="<?= $test_name; ?>" autofocus>
            </div>
            <div class="form-group">
                <label for="duration">Test Duration: </label>
                <input type="text"  id="duration" name="duration" placeholder="Enter Test Duration(in min.)" class="form-control" value="<?= $duration; ?>" autofocus>
            </div>
            <div class="form-group">
                <label for="count">Number of Questions: </label>
                <input type="number"  id="count" name="count" placeholder="Enter no. of questions" class="form-control" value="<?= $ques_count; ?>" autofocus>
            </div>
            <button type="submit" name="add_test" class="btn btn-success"> Add Test</button>
        </form>
    </div>
</body>
</html>